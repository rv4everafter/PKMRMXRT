<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\Frontend\Contact\SendContact;
use App\Mail\Frontend\Contact\SendGrievance;
use App\Http\Requests\Frontend\Contact\SendContactRequest;
use App\Http\Requests\Frontend\Contact\SendGrievanceRequest;

/**
 * Class ContactController.
 */
class ContactController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('frontend.contact');
    }
    public function grievance()
    {
        return view('frontend.grievance');
    }

    /**
     * @param SendContactRequest $request
     *
     * @return mixed
     */
    public function send(SendContactRequest $request)
    {
        Mail::send(new SendContact($request));

        return redirect()->back()->withFlashSuccess(__('alerts.frontend.contact.sent'));
    }
    
    public function sendgrievance(SendGrievanceRequest $request)
    {
        Mail::send(new SendGrievance($request));
        return redirect()->back()->withFlashSuccess(__('alerts.frontend.contact.sentgrievance'));
    }
}
