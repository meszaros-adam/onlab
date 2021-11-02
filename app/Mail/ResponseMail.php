<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Registration;
use App\Models\User;

class ResponseMail extends Mailable
{
    use Queueable, SerializesModels;

    public $registration;
    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, Registration $registration)
    {
        $this->user=$user;
        $this->registration=$registration;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Eseménynaptár visszaigazolás')
                    ->view('emails.registration');
    }
}
