<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\User; // Import the User model

class ForgotPasswordMail extends Mailable
{
    use SerializesModels;

    protected $user;

    /**
     * Create a new message instance.
     *
     * @param \App\User $user
     * @return void
     */
    public function __construct(User $user) // Adjust the constructor to type-hint User
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
        return $this->view('emails.forgot_password')
            ->with([
                'userName' => $this->user->name,
                // Add more data as needed...
            ]);
    }
}
