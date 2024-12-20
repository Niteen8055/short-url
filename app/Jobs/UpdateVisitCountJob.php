<?php

namespace App\Jobs;

use App\Models\ShortURL;
use App\Models\ShortURLVisit;
use App\Models\ShortURLVisitCount;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable; // Correct namespace
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class UpdateVisitCountJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $shortURL;
    protected $shortURLVisit;

    /**
     * Create a new job instance.
     */
    public function __construct(ShortURL $shortURL, ShortURLVisit $shortURLVisit)
    {
        $this->shortURL = $shortURL;
        $this->shortURLVisit = $shortURLVisit;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        // Log information for debugging
        Log::info("Processing job for ShortURL ID: " . $this->shortURL->id);

        $userId = $this->shortURL->user_id; 
        $shortURLId = $this->shortURL->id;

        // Find existing visit count or create a new one
        $visitCount = ShortURLVisitCount::firstOrCreate(
            ['short_url_id' => $shortURLId, 'user_id' => $userId],
            ['count' => 0]
        );

        // Increment the visit count
        $visitCount->increment('count');
    }
}
