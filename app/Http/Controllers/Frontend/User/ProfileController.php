<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use App\Repositories\Frontend\Auth\UserRepository;
use App\Http\Requests\Frontend\User\UpdateProfileRequest;
use Illuminate\Http\Request;
use App\Models\Auth\User;

/**
 * Class ProfileController.
 */
class ProfileController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * ProfileController constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param UpdateProfileRequest $request
     *
     * @return mixed
     */
    public function update(UpdateProfileRequest $request)
    {
        $output = $this->userRepository->update(
            $request->user()->id,
            $request->only('first_name', 'last_name', 'email', 'avatar_type', 'avatar_location','enroller_id','sponsor_id','dob',
                    'pan_no','phone','gender','marital_status','receive_email','address1','address2','city','state','postal_code',
                    'nominee_name','nominee_relation','account_no','account_title','bank_name','branch_name','ifcs','swift_code'),
            $request->has('avatar_location') ? $request->file('avatar_location') : false
        );

        // E-mail address was updated, user has to reconfirm
        if (is_array($output) && $output['email_changed']) {
            auth()->logout();

            return redirect()->route('frontend.auth.login')->withFlashInfo(__('strings.frontend.user.email_changed_notice'));
        }

        return redirect()->route('frontend.user.account')->withFlashSuccess(__('strings.frontend.user.profile_updated'));
    }
    
     public function checkLevels($enroller_id, $sponsor_id){
        $level=1;
        do{
            $user=User::where('referral_code',$sponsor_id)->first();
            $sponsor_id=$user->sponsor_id;
            if($level==17)
                break;
            $level++;
        }
        while($user->referral_code!=$enroller_id); 
       return $level;
    }
    
    public function newCode(User $user) {
        $curr_user=$this->userRepository->getUser(auth()->user()->referral_code);
        $duplicateuser=$curr_user->toArray()[0];
        $duplicateuser['enroller_id']=auth()->user()->referral_code;
        $duplicateuser['sponsor_id']=$user->referral_code;
        $duplicateuser['isUser']=false;
        if(User::where('referral_code',$duplicateuser['enroller_id'])->count() == 0){
            return redirect()->back()->withFlashDanger('Enroller id is invalid. Please check and try agin');
        }
        if(User::where('referral_code',$duplicateuser['sponsor_id'])->count() == 0){
            return redirect()->back()->withFlashDanger('Sponser id is invalid. Please check and try agin');
        }
        if(User::where('sponsor_id',$duplicateuser['sponsor_id'])->count() >= 3){
            return redirect()->back()->withFlashDanger('Sponser already has 3 direct downlines. Please try with other sponser');
        }
        if($this->checkLevels($duplicateuser['enroller_id'],$duplicateuser['sponsor_id'])>16){
            return redirect()->back()->withFlashDanger('Enroller already completed 15 level. Please try with other enroller id.');
        }
        $res=$this->userRepository->create($duplicateuser);
        return redirect()->route('frontend.user.dashboard')->withFlashSuccess(__('strings.frontend.user.code_created'));
    }
    
     public function directCode(Request $request) {
        $curr_user=$this->userRepository->getUser(auth()->user()->referral_code);
        $duplicateuser=$curr_user->toArray()[0];
        $ref_code=auth()->user()->referral_code;
        $duplicateuser['enroller_id']=$ref_code;
        $duplicateuser['sponsor_id']=$ref_code;
        $duplicateuser['isUser']=false;
        if(User::where('referral_code',$duplicateuser['enroller_id'])->count() == 0){
            return redirect()->back()->withFlashDanger('Enroller id is invalid. Please check and try agin');
        }
        if(User::where('referral_code',$duplicateuser['sponsor_id'])->count() == 0){
            return redirect()->back()->withFlashDanger('Sponser id is invalid. Please check and try agin');
        }
        if(User::where('sponsor_id',$duplicateuser['sponsor_id'])->count() >= 3){
            return redirect()->back()->withFlashDanger('You already have 3 direct downlines. Please try with other sponser');
        }
        if($this->checkLevels($duplicateuser['enroller_id'],$duplicateuser['sponsor_id'])>16){
            return redirect()->back()->withFlashDanger('You already completed 15 level. Please try with new account.');
        }
        $res=$this->userRepository->create($duplicateuser);
        return redirect()->route('frontend.user.dashboard')->withFlashSuccess(__('strings.frontend.user.code_created'));
    }
}
