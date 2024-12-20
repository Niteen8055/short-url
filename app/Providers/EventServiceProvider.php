<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Events\PostCreated;
use App\Listeners\NotifyUser;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */

     protected $listen = [
        'App\Events\ShortURLVisited' => [
            'App\Listeners\UpdateVisitCount',
        ],
    ];
    
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
       
    }
}
