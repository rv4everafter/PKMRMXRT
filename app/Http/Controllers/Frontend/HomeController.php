<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Auth\User;
/**
 * Class HomeController.
 */
class HomeController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('frontend.index');
    }
    
    public function getEnroller(Request $request) {
        $enroller=$request->only('d');
        return  response()->json(['enroller'=>User::where('referral_code',$enroller['d'])->get(['first_name','last_name'])->first()]);
    }
}
