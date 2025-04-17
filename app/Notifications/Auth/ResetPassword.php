<?php

namespace App\Notifications\Auth;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPassword extends Notification implements ShouldQueue
{
    use Queueable;
    public $token;
    /**
     * Create a new notification instance.
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage())
                    ->subject('Şifre sıfırlama')
                    ->line('Giriş şifrenizi sıfırlama talebinde bulundunuz.')
                    ->line('Aşağıdaki linke tıklayarak yeni şifre belirleyebilirsiniz.')
                    ->line('Şifrenizi belirleme talebinde bulunmadıysanız bu e-postayı dikkate almayınız.')
                    ->action('Şifremi Yenile', url('reset-password', $this->token))
                    ->line('Bu bağlantı 1 saat sonra geçerliliğini yitirecektir.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
