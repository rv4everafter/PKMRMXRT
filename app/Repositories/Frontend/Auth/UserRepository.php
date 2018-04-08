<?php

namespace App\Repositories\Frontend\Auth;

use Carbon\Carbon;
use App\Models\Auth\User;
use App\Models\Auth\Transection;
use Illuminate\Http\UploadedFile;
use App\Models\Auth\SocialAccount;
use Illuminate\Support\Facades\DB;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Events\Frontend\Auth\UserConfirmed;
use App\Events\Frontend\Auth\UserProviderRegistered;
use App\Notifications\Frontend\Auth\UserNeedsConfirmation;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class UserRepository.
 */
class UserRepository extends BaseRepository
{
    public  $userList=['nodes'=>[],'edges'=>[],'list'=>[]],$level=1,$prev=0,$treeid=1;
    /**
     * @return string
     */
    public function model()
    {
        return User::class;
    }

    /**
     * @param $token
     *
     * @return bool|\Illuminate\Database\Eloquent\Model
     */
    public function findByPasswordResetToken($token)
    {
        foreach (DB::table(config('auth.passwords.users.table'))->get() as $row) {
            if (password_verify($token, $row->token)) {
                return $this->getByColumn($row->email, 'email');
            }
        }

        return false;
    }

    /**
     * @param $uuid
     *
     * @return mixed
     * @throws GeneralException
     */
    public function findByUuid($uuid)
    {
        $user = $this->model
            ->uuid($uuid)
            ->first();

        if ($user instanceof $this->model) {
            return $user;
        }

        throw new GeneralException(__('exceptions.backend.access.users.not_found'));
    }

    /**
     * @param $code
     *
     * @return mixed
     * @throws GeneralException
     */
    public function findByConfirmationCode($code)
    {
        $user = $this->model
            ->where('confirmation_code', $code)
            ->first();

        if ($user instanceof $this->model) {
            return $user;
        }

        throw new GeneralException(__('exceptions.backend.access.users.not_found'));
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
    public static function getCredit($referral_code) : float
    {
        return Transection::where('type','credit')
                ->where('transection_to',$referral_code)
            ->sum('amount');
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
        return $this->model->where('sponsor_id','!=',null)
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
     * @return mixed
     */
    public function getActiveUserTreePaginated($paged = 25, $orderBy = 'created_at', $sort = 'desc')
    {
       $user_referral_code=auth()->user()->referral_code;
       $this->userList['nodes'][]=['id'=>0,'label'=>$user_referral_code];
       $this->userLevels($user_referral_code, $user_referral_code, 1, 0);
       if(isset($this->userList['list']) && count($this->userList['list'])>0){
           usort($this->userList['list'], function($a, $b) {
                return $a['level'] - $b['level'];
            });
       }
               $this->userList['nodes']=json_encode($this->userList['nodes']);
               $this->userList['edges']=json_encode($this->userList['edges']);

       return $this->userList;
    }
    
    public function userLevels($enroller_id, $sponsor_id, $level, $prev_tree_id=-1){
       $users=User::where('sponsor_id',$sponsor_id);
       if($level<=15){
           if($users->count()){
               foreach ($users->get() as $user) {
                    $user->level=$level;
                    $tree_id=$this->treeid;
                    $this->userList['list'][]=$user->toArray();
                        $this->userList['nodes'][]=array('id'=>$tree_id,'label'=>$user->referral_code);
                        if($tree_id && $prev_tree_id > -1){
                            $this->userList['edges'][]=array('from'=>$prev_tree_id,'to'=>$tree_id);
                        }
                    $this->prev=$tree_id;
                    $this->treeid++;
                    $this->userLevels($enroller_id,$user->referral_code,$level+1,$tree_id);
               }
           }
       }
    }
    /**
     * @param array $data
     *
     * @return \Illuminate\Database\Eloquent\Model|mixed
     * @throws \Exception
     * @throws \Throwable
     */
    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            $user = parent::create([
                'enroller_id'       => $data['enroller_id']?$data['enroller_id']:null,
                'sponsor_id'        => $data['sponsor_id']?$data['sponsor_id']:null,
                'marital_status'    => $data['marital_status']?$data['marital_status']:null,
                'gender'            => $data['gender']?$data['gender']:null,
                'dob'               => $data['dob']?date('Y-m-d',  strtotime($data['dob'])):null,
                'pan_no'            => $data['pan_no']?$data['pan_no']:null,
                'phone'             => $data['phone']?$data['phone']:null,
                'receive_email'     => $data['receive_email']?true:false,
                'first_name'        => $data['first_name'],
                'last_name'         => $data['last_name'],
                'email'             => $data['email'],
                'confirmation_code' => md5(uniqid(mt_rand(), true)),
                'active'            => 0,
                'password'          => bcrypt($data['password']),
                                    // If users require approval or needs to confirm email
                'confirmed'         => config('access.users.requires_approval') || config('access.users.confirm_email') ? 0 : 1,
            ]);

            if ($user) {
                /*
                 * Add the default site role to the new user
                 */
                $user->assignRole(config('access.users.default_role'));
            }

            /*
             * If users have to confirm their email and this is not a social account,
             * and the account does not require admin approval
             * send the confirmation email
             *
             * If this is a social account they are confirmed through the social provider by default
             */
            if (config('access.users.confirm_email')) {
                // Pretty much only if account approval is off, confirm email is on, and this isn't a social account.
                $user->notify(new UserNeedsConfirmation($user->confirmation_code));
            }

            /*
             * Return the user object
             */
            return $user;
        });
    }

    /**
     * @param       $id
     * @param array $input
     * @param bool|UploadedFile  $image
     *
     * @return array|bool
     * @throws GeneralException
     */
    public function update($id, array $input, $image = false)
    {
        $user = $this->getById($id);
//        dd('$input',$input);
        $user->first_name = $input['first_name'];
        $user->last_name = $input['last_name'];
        $user->avatar_type = $input['avatar_type'];
        $user->dob = date('Y-m-d',strtotime($input['dob']));
        $user->pan_no = $input['pan_no'];
        $user->gender = $input['gender'];
        $user->marital_status = $input['marital_status'];
//        $user->phone = $input['phone'];
        $user->nominee_name = $input['nominee_name'];
        $user->nominee_relation = $input['nominee_relation'];
        $user->address1 = $input['address1'];
        $user->address2 = $input['address2'];
        $user->city = $input['city'];
        $user->state = $input['state'];
        $user->postal_code = $input['postal_code'];
        $user->account_no = $input['account_no'];
        $user->account_title = $input['account_title'];
        $user->bank_name = $input['bank_name'];
        $user->branch_name = $input['branch_name'];
        $user->ifcs = $input['ifcs'];
        $user->swift_code = $input['swift_code'];

        // Upload profile image if necessary
        if ($image) {
            $user->avatar_location = $image->store('/avatars', 'public');
        } else {
            // No image being passed
            if ($input['avatar_type'] == 'storage') {
                // If there is no existing image
                if (! strlen(auth()->user()->avatar_location)) {
                    throw new GeneralException('You must supply a profile image.');
                }
            } else {
                // If there is a current image, and they are not using it anymore, get rid of it
                if (strlen(auth()->user()->avatar_location)) {
                    Storage::disk('public')->delete(auth()->user()->avatar_location);
                }

                $user->avatar_location = null;
            }
        }

        if ($user->canChangeEmail()) {
            //Address is not current address so they need to reconfirm
            if ($user->email != $input['email']) {
                //Emails have to be unique
                if ($this->getByColumn($input['email'], 'email')) {
                    throw new GeneralException(__('exceptions.frontend.auth.email_taken'));
                }

                // Force the user to re-verify his email address if config is set
                if (config('access.users.confirm_email')) {
                    $user->confirmation_code = md5(uniqid(mt_rand(), true));
                    $user->confirmed = 0;
                    $user->notify(new UserNeedsConfirmation($user->confirmation_code));
                }
                $user->email = $input['email'];
                $updated = $user->save();

                // Send the new confirmation e-mail

                return [
                    'success' => $updated,
                    'email_changed' => true,
                ];
            }
        }

        return $user->save();
    }

    /**
     * @param      $input
     * @param bool $expired
     *
     * @return bool
     * @throws GeneralException
     */
    public function updatePassword($input, $expired = false)
    {
        $user = $this->getById(auth()->id());

        if (Hash::check($input['old_password'], $user->password)) {
            $user->password = bcrypt($input['password']);

            if ($expired) {
                $user->password_changed_at = Carbon::now()->toDateTimeString();
            }

            return $user->save();
        }

        throw new GeneralException(__('exceptions.frontend.auth.password.change_mismatch'));
    }

    /**
     * @param $code
     *
     * @return bool
     * @throws GeneralException
     */
    public function confirm($code)
    {
        $user = $this->findByConfirmationCode($code);

        if ($user->confirmed == 1) {
            throw new GeneralException(__('exceptions.frontend.auth.confirmation.already_confirmed'));
        }

        if ($user->confirmation_code == $code) {
            $user->confirmed = 1;

            event(new UserConfirmed($user));

            return $user->save();
        }

        throw new GeneralException(__('exceptions.frontend.auth.confirmation.mismatch'));
    }

    /**
     * @param $data
     * @param $provider
     *
     * @return mixed
     * @throws GeneralException
     */
    public function findOrCreateProvider($data, $provider)
    {
        // User email may not provided.
        $user_email = $data->email ?: "{$data->id}@{$provider}.com";

        // Check to see if there is a user with this email first.
        $user = $this->getByColumn($user_email, 'email');

        /*
         * If the user does not exist create them
         * The true flag indicate that it is a social account
         * Which triggers the script to use some default values in the create method
         */
        if (! $user) {
            // Registration is not enabled
            if (! config('access.registration')) {
                throw new GeneralException(__('exceptions.frontend.auth.registration_disabled'));
            }

            // Get users first name and last name from their full name
            $nameParts = $this->getNameParts($data->getName());

            $user = parent::create([
                'first_name'  => $nameParts['first_name'],
                'last_name'  => $nameParts['last_name'],
                'email' => $user_email,
                'active' => 1,
                'confirmed' => 1,
                'password' => null,
                'avatar_type' => $provider,
            ]);

            event(new UserProviderRegistered($user));
        }

        // See if the user has logged in with this social account before
        if (! $user->hasProvider($provider)) {
            // Gather the provider data for saving and associate it with the user
            $user->providers()->save(new SocialAccount([
                'provider'    => $provider,
                'provider_id' => $data->id,
                'token'       => $data->token,
                'avatar'      => $data->avatar,
            ]));
        } else {
            // Update the users information, token and avatar can be updated.
            $user->providers()->update([
                'token'       => $data->token,
                'avatar'      => $data->avatar,
            ]);

            $user->avatar_type = $provider;
            $user->update();
        }

        // Return the user object
        return $user;
    }

    /**
     * @param $fullName
     *
     * @return array
     */
    protected function getNameParts($fullName)
    {
        $parts = array_values(array_filter(explode(' ', $fullName)));
        $size = count($parts);
        $result = [];

        if (empty($parts)) {
            $result['first_name'] = null;
            $result['last_name'] = null;
        }

        if (! empty($parts) && $size == 1) {
            $result['first_name'] = $parts[0];
            $result['last_name'] = null;
        }

        if (! empty($parts) && $size >= 2) {
            $result['first_name'] = $parts[0];
            $result['last_name'] = $parts[1];
        }

        return $result;
    }
}
