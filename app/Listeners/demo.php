<?php

namespace App\Listeners;

use App\Events\ShortURLVisited;
use App\Models\ShortURLVisitCount;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class demo
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
        // $userId = $event->shortURL->user_id;
        // $shortURLId = $event->shortURL->id;

        
        // $visitCount = ShortURLVisitCount::firstOrCreate(
        //     ['short_url_id' => $shortURLId, 'user_id' => $userId],
        //     ['count' => 0]
        // );

        // // Increment the count
        // $visitCount->increment('count');

        
    }
}
