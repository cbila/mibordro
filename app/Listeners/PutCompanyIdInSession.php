<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Session;

class PutCompanyIdInSession
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
    public function handle(object $event): void
    {
        // session(['sites_count' => $event->user->sites->count()]);

        if ($event->user->company) {
            $company = $event->user->company;

        Session::put('company', [
            'id'   => $company->id,
            'name' => $company->name,
        ]);
        }
    }
}
