<?php

namespace App\Mail;

use App\Models\Invitations;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class InvitationMail extends Mailable
{
    use SerializesModels;

    public Invitations $invitation;

    /**
     * Create a new message instance.
     */
    public function __construct(Invitations $invitation)
    {
        $this->invitation = $invitation;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Vous êtes invité à rejoindre EasyColoc')
                    ->view('emails.invitation')
                    ->with([
                        'invitation' => $this->invitation,
                        // send recipients straight to registration (with token)
                        // so they can create an account and be auto-joined
                        'joinUrl' => route('register', ['token' => $this->invitation->token]),
                    ]);
    }
}
