<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendMailRequest;
use App\Mail\CustomMail;
use App\Mail\WelcomeMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class MailController extends Controller
{
    public function store(SendMailRequest $request)
    {

        $user = User::findorFail($request->user_id);

        switch($request->mailType) {
            // case('welcome'):
            //     $mail = Mail::to($user->email)->queue(new WelcomeMail(
            //         $user,
            //         'Hoşgeldiniz',
            //         '',
            //     )); // welcome

            //     //send password link

            //     $status = Password::sendResetLink(
            //         ['email' => $user->email]
            //     );

            //     if ($status == Password::RESET_LINK_SENT) {
            //         activity()->causedBy(auth()->user)->performedOn($user)->log('Mail');

            //         return back()->with('status', __($status))
            //         ->with('success', 'Hoşgeldiniz mesajı başarıyla gönderildi.');
            //         ;

            //     }

                // throw ValidationException::withMessages([
                //     'email' => [trans($status)],
                // ]);


                // break;

            case('reset'):

                $status = Password::sendResetLink(
                    ['email' => $user->email]
                );

                if ($status == Password::RESET_LINK_SENT) {
                    activity()->causedBy(auth()->user)->performedOn($user)->log('Mail');

                    return back()->with('status', __($status))
                    ->with('success', 'Şifre yenileme mesajı başarıyla gönderildi.');
                }

                throw ValidationException::withMessages([
                    'email' => [trans($status)],
                ]);

                break;

            case('custom'):
                $mail = Mail::to($user->email)->queue(new CustomMail(
                    $user,
                    $request->subject,
                    $request->message,
                )); // welcome
                activity()->causedBy(auth()->user())->performedOn($user)->log('Mail');

                return back()->with('success', 'Özel e-posta mesajı başarıyla gönderildi.');

                break;

            default:
                $msg = 'Bir sorun oluştu.';
        }

    }
}
