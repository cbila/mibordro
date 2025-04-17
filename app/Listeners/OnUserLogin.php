<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Str;
use ReflectionClass;

class OnUserLogin
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
        $type = Str::of((new ReflectionClass($event))->getShortName())->kebab();

        if ($event->user) {
            activity()
                ->causedBy($event->user)
                ->performedOn($event->user)
                ->event($type)
                ->log($type);
        }
        // dd($event);
    }
}
