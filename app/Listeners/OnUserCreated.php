<?php

namespace App\Listeners;

use App\Events\UserCreated;
use App\Mail\WelcomeMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class OnUserCreated
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserCreated $event): void
    {
        Mail::to($event->user->email)->queue(new WelcomeMail(
            $event->user,
            'Hoşgeldiniz',
            '',
        ));

        //send password link

        $status = Password::sendResetLink(
            ['email' => $event->user->email]
        );

        if ($status == Password::RESET_LINK_SENT) {
            activity()->causedBy(auth()->user())->performedOn($event->user)->log('Mail');

        }

        //email verification link

        $event->user->sendEmailVerificationNotification();

    }
}
