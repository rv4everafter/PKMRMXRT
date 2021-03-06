<?php

namespace App\Repositories\Backend\Auth;

use App\Models\Auth\User;
use App\Models\Auth\Transection;
use App\Models\Auth\Settings;
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
 * Class UserRepository.
 */
class UserRepository extends BaseRepository
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
    public function getInactiveCount() : int
    {
        return $this->model->where('sponsor_id','!=',null)
            ->where('active', 0)
            ->count();
    }
    /**
     * @return mixed
     */
    public function getActiveCount() : int
    {
        return $this->model->where('sponsor_id','!=',null)
            ->where('active', 1)
            ->count();
    }
    /**
     * @return mixed
     */
    public function getDeletedCount() : int
    {
        return $this->model->where('sponsor_id','!=',null)
            ->onlyTrashed()
            ->count();
    }
    
    
    
    /**
     * @return mixed
     */
    public function getUnconfirmedCount() : int
    {
        return $this->model->where('sponsor_id','!=',null)
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
        return $this->model->where('sponsor_id','!=',null)->where("isUser",1)
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
        return $this->model->where('sponsor_id','!=',null)
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
        return $this->model->where('sponsor_id','!=',null)
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
        $data['roles']=[3];
        return DB::transaction(function () use ($data) {
            $user = parent::create([
                'enroller_id'       => $data['enroller_id']?$data['enroller_id']:null,
                'sponsor_id'        => $data['sponsor_id']?$data['sponsor_id']:null,
                'marital_status'    => $data['marital_status']?$data['marital_status']:null,
                'gender'            => $data['gender']?$data['gender']:null,
                'dob'               => $data['dob']?date('Y-m-d',strtotime($data['dob'])):null,
                'pan_no'            => $data['pan_no']?$data['pan_no']:null,
                'phone'             => $data['phone']?$data['phone']:null,
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
//                'timezone' => $data['timezone'],
                'password' => bcrypt($data['password']),
                'gender' => $data['gender']?$data['gender']:null,
                'marital_status' => $data['marital_status']?$data['marital_status']:null,
                'address1' => $data['address1']?$data['address1']:null,
                'address2' => $data['address2']?$data['address2']:null,
                'city' => $data['city']?$data['city']:null,
                'state' => $data['state']?$data['state']:null,
                'postal_code' => $data['postal_code']?$data['postal_code']:null,
                'nominee_name' => $data['nominee_name']?$data['nominee_name']:null,
                'nominee_relation' => $data['nominee_relation']?$data['nominee_relation']:null,
                'account_no' => $data['account_no']?$data['account_no']:null,
                'account_title' => $data['account_title']?$data['account_title']:null,
                'bank_name' => $data['bank_name']?$data['bank_name']:null,
                'branch_name' => $data['branch_name']?$data['branch_name']:null,
                'ifcs' => $data['ifcs']?$data['ifcs']:null,
                'swift_code' => $data['swift_code']?$data['swift_code']:null,
                'active' => isset($data['active']) && $data['active'] == '1' ? 1 : 0,
                'confirmation_code' => md5(uniqid(mt_rand(), true)),
                'confirmed' => isset($data['confirmed']) && $data['confirmed'] == '1' ? 1 : 0,
                'confirmation_email' => isset($data['confirmation_email'])?1:0,
            ]);

            // See if adding any additional permissions
            if (! isset($data['permissions']) || ! count($data['permissions'])) {
                $data['permissions'] = [];
            }

            if ($user) {
                // User must have at least one role
                if (! count($data['roles'])) {
                    throw new GeneralException(__('exceptions.backend.access.users.role_needed_create'));
                }

                // Add selected roles/permissions
                $user->syncRoles($data['roles']);
                $user->syncPermissions($data['permissions']);

                //Send confirmation email if requested and account approval is off
                if (isset($data['confirmation_email']) && $user->confirmed == 0 && ! config('access.users.requires_approval')) {
                    $user->notify(new UserNeedsConfirmation($user->confirmation_code));
                }

                event(new UserCreated($user));

                return $user;
            }

            throw new GeneralException(__('exceptions.backend.access.users.create_error'));
        });
    }

    /**
     * @param User  $user
     * @param array $data
     *
     * @return User
     */
    public function update(User $user, array $data) : User
    {
        $this->checkUserByEmail($user, $data['email']);
        $data['roles']=[3];
        // See if adding any additional permissions
        if (! isset($data['permissions']) || ! count($data['permissions'])) {
            $data['permissions'] = [];
        }
        return DB::transaction(function () use ($user, $data) {
        $email=$user->email;
            if ($user->update([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'dob'  => $data['dob']?date('Y-m-d',strtotime($data['dob'])):null,
                'phone' => $data['phone']?$data['phone']:null,
                'enroller_id' => $data['enroller_id'],
                'sponsor_id'  => $data['sponsor_id'],
                'pan_no' => $data['pan_no']?$data['pan_no']:null,
                'phone' => $data['phone'],
                'gender' => $data['gender']?$data['gender']:null,
                'marital_status' => $data['marital_status']?$data['marital_status']:null,
                'address1' => $data['address1']?$data['address1']:null,
                'address2' => $data['address2']?$data['address2']:null,
                'city' => $data['city']?$data['city']:null,
                'state' => $data['state']?$data['state']:null,
                'postal_code' => $data['postal_code']?$data['postal_code']:null,
                'nominee_name' => $data['nominee_name']?$data['nominee_name']:null,
                'nominee_relation' => $data['nominee_relation']?$data['nominee_relation']:null,
                'account_no' => $data['account_no']?$data['account_no']:null,
                'account_title' => $data['account_title']?$data['account_title']:null,
                'bank_name' => $data['bank_name']?$data['bank_name']:null,
                'branch_name' => $data['branch_name']?$data['branch_name']:null,
                'ifcs' => $data['ifcs']?$data['ifcs']:null,
                'swift_code' => $data['swift_code']?$data['swift_code']:null,
                'active' => isset($data['active'])?1:0,
                'confirmed' => isset($data['confirmed'])?1:0,
                'confirmation_email' => isset($data['confirmation_email'])?1:0,
            ])) {
                // Add selected roles/permissions
                $user->syncRoles($data['roles']);
                $user->syncPermissions($data['permissions']);
                if (isset($data['confirmation_email']) && !isset($data['confirmed']) && $data['email']!=$email) {
                    $user->notify(new UserNeedsConfirmation($user->confirmation_code));
                }
                event(new UserUpdated($user));

                return $user;
            }

            throw new GeneralException(__('exceptions.backend.access.users.update_error'));
        });
    }

    /**
     * @param User $user
     * @param      $input
     *
     * @return User
     * @throws GeneralException
     */
    public function updatePassword(User $user, $input) : User
    {
        $user->password = bcrypt($input['password']);

        if ($user->save()) {
            event(new UserPasswordChanged($user));

            return $user;
        }

        throw new GeneralException(__('exceptions.backend.access.users.update_password_error'));
    }

    /**
     * @param User $user
     * @param      $status
     *
     * @return User
     * @throws GeneralException
     */
    public function mark(User $user, $status) : User
    {
        if (auth()->id() == $user->id && $status == 0) {
            throw new GeneralException(__('exceptions.backend.access.users.cant_deactivate_self'));
        }

        $user->active = $status;

        switch ($status) {
            case 0:
                event(new UserDeactivated($user));
            break;

            case 1:
                if($user->first_time == 1 && $user->isUser){
                    $user->first_time = 0;
                    $this->sendCommition($user);
                }else if ($user->first_time == 1 && !$user->isUser){
                    $user->first_time = 0;
                    $this->setCommitionSchedule($user);
                }                    
                event(new UserReactivated($user));
            break;
        }

        if ($user->save()) {
            return $user;
        }

        throw new GeneralException(__('exceptions.backend.access.users.mark_error'));
    }
    
    public function commissionByLevels($enroller_id, $sponsor_id, $referral_code, $downline_income){
        $level=1;
        do{
            $user=User::where('referral_code',$sponsor_id)->first();
            if($user && $user->isUser && $level<16){
                $transection = Transection::create([
                            'transection_to'        => $sponsor_id?$sponsor_id:null,
                            'transection_by'        => $referral_code?$referral_code:null,
                            'previous_bal'          => 0,
                            'type'                  => 'credit',
                            'commission_type'       => 'downline',
                            'amount'                => $downline_income,
                            'other'                => $user->isUser,
                        ]);

                $sponsor_id=$user->sponsor_id;
                $level++;
            }else if($user && !$user->isUser && $level<16){
                $transection = Transection::create([
                            'transection_to'        => $user->enroller_id?$user->enroller_id:null,
                            'transection_by'        => $referral_code?$referral_code:null,
                            'previous_bal'          => 0,
                            'type'                  => 'credit',
                            'commission_type'       => 'downline',
                            'amount'                => $downline_income,
                            'other'                => $user->isUser,
                        ]);

                $sponsor_id=$user->sponsor_id;
                $level++;
            } else{
                    break;
            } 
        }
        while(1); 
       return $level;
    }
    
    public function sendCommition($user){
        $downline_income=Settings::where('code','downline_income')->first(['value']);
        //income of downline for each level till enroller
        $this->commissionByLevels($user->enroller_id, $user->sponsor_id, $user->referral_code, $downline_income['value']);
        $enroller_income=Settings::where('code','enroller_income')->first(['value']);
        //enroller income
        if($user && $user->enroller_id && $user->enroller_id!='eroller1'){
            $transection = Transection::create([
                            'transection_to'        => $user->enroller_id?$user->enroller_id:null,
                            'transection_by'        => $user->referral_code?$user->referral_code:null,
                            'previous_bal'          => 0,
                            'type'                  => 'credit',
                            'commission_type'       => 'enroller',
                            'amount'                => $enroller_income['value'],
                            'other'                => $user->isUser,
                        ]);
        }
    }
    
    public function setCommitionSchedule($user){
        $downline_income=Settings::where('code','downline_income')->first(['value']);
        //income of downline for each level till enroller
        $this->commissionByLevels($user->enroller_id, $user->sponsor_id, $user->referral_code, $downline_income['value']);
        $enroller_income=Settings::where('code','virtual_code')->first(['value']);
        //enroller income
        if($user && $user->enroller_id && $user->enroller_id!='eroller1'){
            $v_user_main=User::where("referral_code",$user->enroller_id)->first();
            $v_user_main->virtual_payment_count+=1;
            $v_user_main->save();
            $last_transection = Transection::where("transection_to",$user->enroller_id)
                    ->where("commission_type", "virtual")->where("transection_by", $user->referral_code)
                    ->orderBy("created_at","desc")->limit(1)->first(["times"]);
//            dd($last_transection);
            $count=  isset($last_transection) && isset($last_transection["times"])?$last_transection["times"]:0;
            $transection = Transection::create([
                            'transection_to'        => $user->enroller_id?$user->enroller_id:null,
                            'transection_by'        => $user->referral_code?$user->referral_code:null,
                            'previous_bal'          => 0,
                            'times'                 => $count+1,
                            'type'                  => 'credit',
                            'commission_type'       => 'virtual',
                            'amount'                => $enroller_income['value'],
                        ]);
            
        }
    }

    /**
     * @param User $user
     *
     * @return User
     * @throws GeneralExceptioncode
     */
    public function confirm(User $user) : User
    {
        if ($user->confirmed == 1) {
            throw new GeneralException(__('exceptions.backend.access.users.already_confirmed'));
        }

        $user->confirmed = 1;
        $confirmed = $user->save();

        if ($confirmed) {
            event(new UserConfirmed($user));

            // Let user know their account was approved
            if (config('access.users.requires_approval')) {
                $user->notify(new UserAccountActive);
            }

            return $user;
        }

        throw new GeneralException(__('exceptions.backend.access.users.cant_confirm'));
    }

    /**
     * @param User $user
     *
     * @return User
     * @throws GeneralException
     */
    public function unconfirm(User $user) : User
    {
        if ($user->confirmed == 0) {
            throw new GeneralException(__('exceptions.backend.access.users.not_confirmed'));
        }

        if ($user->id == 1) {
            // Cant un-confirm admin
            throw new GeneralException(__('exceptions.backend.access.users.cant_unconfirm_admin'));
        }

        if ($user->id == auth()->id()) {
            // Cant un-confirm self
            throw new GeneralException(__('exceptions.backend.access.users.cant_unconfirm_self'));
        }

        $user->confirmed = 0;
        $unconfirmed = $user->save();

        if ($unconfirmed) {
            event(new UserUnconfirmed($user));

            return $user;
        }

        throw new GeneralException(__('exceptions.backend.access.users.cant_unconfirm'));
    }

    /**
     * @param User $user
     *
     * @return User
     * @throws GeneralException
     */
    public function forceDelete(User $user) : User
    {
        if (is_null($user->deleted_at)) {
            throw new GeneralException(__('exceptions.backend.access.users.delete_first'));
        }

        return DB::transaction(function () use ($user) {
            // Delete associated relationships
            $user->providers()->delete();

            if ($user->forceDelete()) {
                event(new UserPermanentlyDeleted($user));

                return $user;
            }

            throw new GeneralException(__('exceptions.backend.access.users.delete_error'));
        });
    }

    /**
     * @param User $user
     *
     * @return User
     * @throws GeneralException
     */
    public function restore(User $user) : User
    {
        if (is_null($user->deleted_at)) {
            throw new GeneralException(__('exceptions.backend.access.users.cant_restore'));
        }

        if ($user->restore()) {
            event(new UserRestored($user));

            return $user;
        }

        throw new GeneralException(__('exceptions.backend.access.users.restore_error'));
    }

    /**
     * @param User $user
     * @param      $email
     *
     * @throws GeneralException
     */
    protected function checkUserByEmail(User $user, $email)
    {
        //Figure out if email is not the same
        if ($user->email != $email) {
            //Check to see if email exists
            if ($this->model->where('email', '=', $email)->first()) {
                throw new GeneralException(trans('exceptions.backend.access.users.email_error'));
            }
        }
    }
}
