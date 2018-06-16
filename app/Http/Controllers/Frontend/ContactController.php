<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\Frontend\Contact\SendContact;
use App\Mail\Frontend\Contact\SendGrievance;
use App\Mail\Frontend\Contact\SendAutoReply;
use App\Http\Requests\Frontend\Contact\SendContactRequest;
use App\Http\Requests\Frontend\Contact\SendGrievanceRequest;
use App\Models\Auth\Grievance;

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
        $request['type']='contact';
        $request['full_name']=$request->name;
        $contact=Grievance::create($request->all());
        Mail::send(new SendContact($request));

        return redirect()->back()->withFlashSuccess(__('alerts.frontend.contact.sent'));
    }
    
    public function sendgrievance(SendGrievanceRequest $request)
    {
        $grievance=Grievance::create($request->all());
        $request['id']=$grievance->id;
        Mail::send(new SendGrievance($request));
        Mail::send(new SendAutoReply($request));
        return redirect()->back()->withFlashSuccess(__('alerts.frontend.contact.sent'));
    }
}
