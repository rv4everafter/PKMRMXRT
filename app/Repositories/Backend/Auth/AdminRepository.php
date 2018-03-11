<?php

namespace App\Repositories\Backend\Auth;

use App\Models\Auth\User;
use Illuminate\Support\Facades\DB;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use App\Events\Frontend\Auth\UserConfirmed;
use App\Events\Backend\Auth\User\UserCreated;
use App\Events\Backend\Auth\User\UserUpdated;
use App\Events\Backend\Auth\User\UserRestored;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Events\Backend\Auth\User\UserDeactivated;
use App\Events\Backend\Auth\User\UserReactivated;
use App\Events\Backend\Auth\User\UserUnconfirmed;
use App\Events\Backend\Auth\User\UserPasswordChanged;
use App\Notifications\Backend\Auth\UserAccountActive;
use App\Events\Backend\Auth\User\UserPermanentlyDeleted;
use App\Notifications\Frontend\Auth\UserNeedsConfirmation;

/**
 * Class AdminRepository.
 */
class AdminRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return User::class;
    }

    /**
     * @return mixed
     */
    public function getUnconfirmedCount() : int
    {
        return $this->model
            ->where('confirmed', 0)
            ->count();
    }

    /**
     * @param int    $paged
     * @param string $orderBy
     * @param string $sort
     *
     * @return mixed
     */
    public function getActivePaginated($paged = 25, $orderBy = 'created_at', $sort = 'desc') : LengthAwarePaginator
    {
        return $this->model->where('sponsor_id',null)
            ->with('roles', 'permissions', 'providers')
            ->active()
            ->orderBy($orderBy, $sort)
            ->paginate($paged);
    }

    /**
     * @param int    $paged
     * @param string $orderBy
     * @param string $sort
     *
     * @return LengthAwarePaginator
     */
    public function getInactivePaginated($paged = 25, $orderBy = 'created_at', $sort = 'desc') : LengthAwarePaginator
    {
        return $this->model->where('sponsor_id',null)
            ->with('roles', 'permissions', 'providers')
            ->active(false)
            ->orderBy($orderBy, $sort)
            ->paginate($paged);
    }

    /**
     * @param int    $paged
     * @param string $orderBy
     * @param string $sort
     *
     * @return LengthAwarePaginator
     */
    public function getDeletedPaginated($paged = 25, $orderBy = 'created_at', $sort = 'desc') : LengthAwarePaginator
    {
        return $this->model->where('sponsor_id',null)
            ->with('roles', 'permissions', 'providers')
            ->onlyTrashed()
            ->orderBy($orderBy, $sort)
            ->paginate($paged);
    }

    /**
     * @param array $data
     *
     * @return User
     */
    public function create(array $data) : User
    {
        return DB::transaction(function () use ($data) {
            $admin = parent::create([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'timezone' => $data['timezone'],
                'password' => bcrypt($data['password']),
                'active' => isset($data['active']) && $data['active'] == '1' ? 1 : 0,
                'confirmation_code' => md5(uniqid(mt_rand(), true)),
                'confirmed' => isset($data['confirmed']) && $data['confirmed'] == '1' ? 1 : 0,
            ]);

            // See if adding any additional permissions
            if (! isset($data['permissions']) || ! count($data['permissions'])) {
                $data['permissions'] = [];
            }

            if ($admin) {
                // Admin must have at least one role
                if (! count($data['roles'])) {
                    throw new GeneralException(__('exceptions.backend.access.admins.role_needed_create'));
                }

                // Add selected roles/permissions
                $admin->syncRoles($data['roles']);
                $admin->syncPermissions($data['permissions']);

                //Send confirmation email if requested and account approval is off
                if (isset($data['confirmation_email']) && $admin->confirmed == 0 && ! config('access.admins.requires_approval')) {
                    $admin->notify(new UserNeedsConfirmation($admin->confirmation_code));
                }

                event(new UserCreated($admin));

                return $admin;
            }

            throw new GeneralException(__('exceptions.backend.access.admins.create_error'));
        });
    }

    /**
     * @param User  $admin
     * @param array $data
     *
     * @return User
     */
    public function update(User $admin, array $data) : User
    {
        $this->checkAdminByEmail($admin, $data['email']);

        // See if adding any additional permissions
        if (! isset($data['permissions']) || ! count($data['permissions'])) {
            $data['permissions'] = [];
        }

        return DB::transaction(function () use ($admin, $data) {
            if ($admin->update([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'timezone' => $data['timezone'],
            ])) {
                // Add selected roles/permissions
                $admin->syncRoles($data['roles']);
                $admin->syncPermissions($data['permissions']);

                event(new UserUpdated($admin));

                return $admin;
            }

            throw new GeneralException(__('exceptions.backend.access.admins.update_error'));
        });
    }

    /**
     * @param User $admin
     * @param      $input
     *
     * @return User
     * @throws GeneralException
     */
    public function updatePassword(User $admin, $input) : User
    {
        $admin->password = bcrypt($input['password']);

        if ($admin->save()) {
            event(new UserPasswordChanged($admin));

            return $admin;
        }

        throw new GeneralException(__('exceptions.backend.access.admins.update_password_error'));
    }

    /**
     * @param User $admin
     * @param      $status
     *
     * @return User
     * @throws GeneralException
     */
    public function mark(User $admin, $status) : User
    {
        if (auth()->id() == $admin->id && $status == 0) {
            throw new GeneralException(__('exceptions.backend.access.admins.cant_deactivate_self'));
        }

        $admin->active = $status;

        switch ($status) {
            case 0:
                event(new UserDeactivated($admin));
            break;

            case 1:
                event(new UserReactivated($admin));
            break;
        }

        if ($admin->save()) {
            return $admin;
        }

        throw new GeneralException(__('exceptions.backend.access.admins.mark_error'));
    }

    /**
     * @param User $admin
     *
     * @return User
     * @throws GeneralException
     */
    public function confirm(User $admin) : User
    {
        if ($admin->confirmed == 1) {
            throw new GeneralException(__('exceptions.backend.access.admins.already_confirmed'));
        }

        $admin->confirmed = 1;
        $confirmed = $admin->save();

        if ($confirmed) {
            event(new UserConfirmed($admin));

            // Let admin know their account was approved
            if (config('access.admins.requires_approval')) {
                $admin->notify(new UserAccountActive);
            }

            return $admin;
        }

        throw new GeneralException(__('exceptions.backend.access.admins.cant_confirm'));
    }

    /**
     * @param User $admin
     *
     * @return User
     * @throws GeneralException
     */
    public function unconfirm(User $admin) : User
    {
        if ($admin->confirmed == 0) {
            throw new GeneralException(__('exceptions.backend.access.admins.not_confirmed'));
        }

        if ($admin->id == 1) {
            // Cant un-confirm admin
            throw new GeneralException(__('exceptions.backend.access.admins.cant_unconfirm_admin'));
        }

        if ($admin->id == auth()->id()) {
            // Cant un-confirm self
            throw new GeneralException(__('exceptions.backend.access.admins.cant_unconfirm_self'));
        }

        $admin->confirmed = 0;
        $unconfirmed = $admin->save();

        if ($unconfirmed) {
            event(new UserUnconfirmed($admin));

            return $admin;
        }

        throw new GeneralException(__('exceptions.backend.access.admins.cant_unconfirm'));
    }

    /**
     * @param User $admin
     *
     * @return User
     * @throws GeneralException
     */
    public function forceDelete(User $admin) : User
    {
        if (is_null($admin->deleted_at)) {
            throw new GeneralException(__('exceptions.backend.access.admins.delete_first'));
        }

        return DB::transaction(function () use ($admin) {
            // Delete associated relationships
            $admin->providers()->delete();

            if ($admin->forceDelete()) {
                event(new UserPermanentlyDeleted($admin));

                return $admin;
            }

            throw new GeneralException(__('exceptions.backend.access.admins.delete_error'));
        });
    }

    /**
     * @param User $admin
     *
     * @return User
     * @throws GeneralException
     */
    public function restore(User $admin) : User
    {
        if (is_null($admin->deleted_at)) {
            throw new GeneralException(__('exceptions.backend.access.admins.cant_restore'));
        }

        if ($admin->restore()) {
            event(new UserRestored($admin));

            return $admin;
        }

        throw new GeneralException(__('exceptions.backend.access.admins.restore_error'));
    }

    /**
     * @param User $admin
     * @param      $email
     *
     * @throws GeneralException
     */
    protected function checkAdminByEmail(User $admin, $email)
    {
        //Figure out if email is not the same
        if ($admin->email != $email) {
            //Check to see if email exists
            if ($this->model->where('email', '=', $email)->first()) {
                throw new GeneralException(trans('exceptions.backend.access.admins.email_error'));
            }
        }
    }
}
