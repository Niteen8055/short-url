<?php

namespace App\Listeners;

use App\Events\ShortURLVisited;
use App\Models\ShortURLVisitCount;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Jobs\UpdateVisitCountJob;


class UpdateVisitCount  
{
    /**
     * Create the event listener.
     */
    use InteractsWithQueue;

    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ShortURLVisited $event)
    {
        Log::info('listener ShortURLVisited event triggered for ShortURL ID: ' .  $event->shortURL->id);

        UpdateVisitCountJob::dispatch($event->shortURL, $event->shortURLVisit);

        
    }
}
