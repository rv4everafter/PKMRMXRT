<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use App\Repositories\Frontend\Auth\UserRepository;


/**
 * Class DashboardController.
 */
class DashboardController extends Controller
{
     public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('frontend.user.dashboard')->withUsers($this->userRepository->getActiveUserTreePaginated(25, 'id', 'asc'))->with("direct",$this->userRepository->getDirectDownline(auth()->user()->referral_code));
    }
}
