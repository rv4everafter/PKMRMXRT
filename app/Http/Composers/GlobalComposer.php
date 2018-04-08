<?php

namespace App\Http\Composers;

use Illuminate\View\View;
use App\Repositories\Frontend\Auth\UserRepository;

/**
 * Class GlobalComposer.
 */
class GlobalComposer
{
    /**
     * Bind data to the view.
     *
     * @param View $view
     *
     * @return void
     */
    public function compose(View $view)
    {
        if(auth()->id()){
             $view->with('logged_in_user', auth()->user())
                ->with('user_credit', UserRepository::getCredit(auth()->user()->referral_code)); 
        }else{
            $view->with('logged_in_user', auth()->user());            
        }
                
    }
}
