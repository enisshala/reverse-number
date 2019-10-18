<?php

namespace App\Mail\Frontend;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Class SendRequestApproved.
 */
class WelcomeUser extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    /**
     * SendRequestApproved constructor.
     *
     * @param Request $request
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(config('app.name') . ' - Welcome')->markdown('frontend.mail.welcome-user', [$this->user]);
    }
}
