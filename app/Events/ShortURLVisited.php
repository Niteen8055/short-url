<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel; 
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\ShortURL;
use App\Models\ShortURLVisit;
use Illuminate\Support\Facades\Log;


class ShortURLVisited
{
    use Dispatchable, SerializesModels;

    /**
     * The short URL that was visited.
     */
    public ShortURL $shortURL;

    /**
     * Details of the visitor that visited the short URL.
     */
    public ShortURLVisit $shortURLVisit;

    public function __construct(ShortURL $shortURL, ShortURLVisit $shortURLVisit)
    {
        Log::info('event ShortURLVisited event triggered for ShortURL ID: ' . $shortURL->toJson());
        Log::info('event ShortURLVisited event triggered for ShortURL ID: ' . $shortURLVisit->toJson());
        $this->shortURL = $shortURL;
        $this->shortURLVisit = $shortURLVisit;
    }
}
