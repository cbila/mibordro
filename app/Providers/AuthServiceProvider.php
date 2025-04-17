<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // User::class => UserPolicy::class,
        // Profile::class => ProfilePolicy::class,
        // Document::class => DocumentPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // $this->registerPolicies();
        // VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
        //     return (new MailMessage())
        //         ->subject('E-posta Doğrulama')
        //         ->line('E-postanızı doğrulamak için aşağıdaki butona basınız.')
        //         ->action('E-postamı doğrula', $url);
        // });

    }
}
