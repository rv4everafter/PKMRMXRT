<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Helpers\Frontend\Auth\Socialite;
use App\Events\Frontend\Auth\UserRegistered;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Repositories\Frontend\Auth\UserRepository;
use App\Models\Auth\User;

/**
 * Class RegisterController.
 */
class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * RegisterController constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Where to redirect users after login.
     *
     * @return string
     */
    public function redirectPath()
    {
        return route(home_route());
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        abort_unless(config('access.registration'), 404);

        return view('frontend.auth.register')
            ->withSocialiteLinks((new Socialite)->getSocialLinks());
    }

    public function checkLevels($enroller_id, $sponsor_id){
        $level=1;
        do{
            $user=User::where('referral_code',$sponsor_id)->first();
            $level++;
        }
        while($user->sponsor_id==$enroller_id);
       return $level;
    }
    /**
     * @param RegisterRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function register(RegisterRequest $request)
    {
        if($this->checkLevels($request['enroller_id'],$request['sponsor_id'])>15){
            return redirect(route('frontend.auth.register'))->withFlashDanger('Enroller already completed 15 level. Please try with other enroller id.');
        }
        if(User::where('referral_code',$request['enroller_id'])->count() == 0){
              return redirect(route('frontend.auth.register'))->withFlashDanger('Enroller id is invalid. Please check and try agin');
        }
        if(User::where('referral_code',$request['sponsor_id'])->count() == 0){
              return redirect(route('frontend.auth.register'))->withFlashDanger('Sponser id is invalid. Please check and try agin');
        }
        if(User::where('sponsor_id',$request['sponsor_id'])->count() > 3){
              return redirect(route('frontend.auth.register'))->withFlashDanger('Sponser already has 3 direct downlines. Please try with other sponser');
        }
        $user = $this->userRepository->create($request->only('enroller_id','sponsor_id','dob','pan_no','phone','gender','marital_status','receive_email',
                'first_name', 'last_name', 'email', 'password'));

        // If the user must confirm their email or their account requires approval,
        // create the account but don't log them in.
        if (config('access.users.confirm_email') || config('access.users.requires_approval')) {
            event(new UserRegistered($user));

            return redirect($this->redirectPath())->withFlashSuccess(
                config('access.users.requires_approval') ?
                    __('exceptions.frontend.auth.confirmation.created_pending') :
                    __('exceptions.frontend.auth.confirmation.created_confirm')
            );
        } else {
            auth()->login($user);

            event(new UserRegistered($user));

            return redirect($this->redirectPath());
        }
    }
}
