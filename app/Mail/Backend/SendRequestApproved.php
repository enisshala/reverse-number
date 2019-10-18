<?php

namespace App\Mail\Backend;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Class SendRequestApproved.
 */
class SendRequestApproved extends Mailable
{
    use Queueable, SerializesModels;

    public $cancel_request;

    /**
     * SendRequestApproved constructor.
     *
     * @param Request $request
     */
    public function __construct($cancel_request)
    {
        $this->cancel_request = $cancel_request;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(config('app.name') . ' - Send Request Approved')->markdown('frontend.mail.send-request-approved', [$this->cancel_request]);
    }
}
