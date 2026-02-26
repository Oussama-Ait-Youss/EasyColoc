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
                        'joinUrl' => url('/invitations/join?token='.$this->invitation->token),
                    ]);
    }
}
