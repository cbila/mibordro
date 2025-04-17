<?php

namespace App\Providers;

use App\Events\UserCreated;
use App\Listeners\OnUserCreated;
use App\Listeners\OnUserLogin;
use App\Listeners\OnVerified;
use App\Listeners\PutCompanyIdInSession;
use App\Auth\Notifications\VerifyEmailQueued;
use App\Listeners\OnPasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Verified;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        UserCreated::class => [
            OnUserCreated::class,
        ],
        Login::class => [
            PutCompanyIdInSession::class,
            OnUserLogin::class,
        ],
        PasswordReset::class => [
            OnPasswordReset::class,
        ],
        // Verified::class => [
        //     OnVerified::class,
        // ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
