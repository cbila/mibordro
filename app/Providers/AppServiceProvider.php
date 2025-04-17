<?php

namespace App\Providers;

use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {


        Activity::saving(function (Activity $activity) {
            $activity->properties = $activity->properties->put('props', [
                'ip' => request()->ip(),
                'agent' => request()->userAgent()
            ]);
        });
        // Activity::saving(function (Activity $activity) {
        //     $activity->properties = $activity->properties->put('ip', request()->ip());
        // });


    }

}
