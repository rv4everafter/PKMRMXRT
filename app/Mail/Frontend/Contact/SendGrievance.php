<?php

namespace App\Mail\Frontend\Contact;

use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Class SendGrievance.
 */
class SendGrievance extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Request
     */
    public $request;

    /**
     * SendGrievance constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to(config('mail.from.address'), config('mail.from.name'))
            ->view('frontend.mail.grievance')
            ->text('frontend.mail.grievance-text')
            ->subject(__('strings.emails.grievance.subject', ['app_name' => app_name()]))
            ->from($this->request->email, $this->request->full_name)
            ->replyTo($this->request->email, $this->request->full_name);
    }
}
