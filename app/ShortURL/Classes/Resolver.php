<?php

namespace App\ShortURL\Classes;
use App\Interfaces\UserAgentDriver;
use App\Events\ShortURLVisited;
use App\Models\ShortURL;
use App\Models\ShortURLVisit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;

// use App\Exceptions\ValidationException;


class Resolver
{
    private UserAgentDriver $userAgentDriver;

    public function __construct(UserAgentDriver $userAgentDriver)
    {
        $this->userAgentDriver = $userAgentDriver;
    }

    /**
     * Handle the visit. Check that the visitor is allowed to visit the URL. If
     * the short URL has tracking enabled, track the visit in the database.
     * If this method is executed successfully, return true.
     */
    public function handleVisit(Request $request, ShortURL $shortURL): bool
    {
        // if (! $this->shouldAllowAccess($shortURL)) {
        //     abort(404);
        // }

        $visit = $this->recordVisit($request, $shortURL);

        Event::dispatch(new ShortURLVisited($shortURL, $visit));

        return true;
    }

    /**
     * Determine whether if the visitor is allowed access to the URL. If the short
     * URL is a single use URL and has already been visited, return false. If
     * the URL is not activated yet, return false. If the URL has been
     * deactivated, return false.
     */
    protected function shouldAllowAccess(ShortURL $shortURL): bool
    {
        // if ($shortURL->single_use && $shortURL->visits()->count()) {
        //     return false;
        // }

        // if (now()->isBefore($shortURL->activated_at)) {
        //     return false;
        // }

        // if ($shortURL->deactivated_at && now()->isAfter($shortURL->deactivated_at)) {
        //     return false;
        // }

        return true;
    }

    /**
     * Record the visit in the database. We record basic information of the visit if
     * tracking even if tracking is not enabled. We do this so that we can check
     * if single-use URLs have been visited before.
     */
    protected function recordVisit(Request $request, ShortURL $shortURL): ShortURLVisit
    {

        // Check if a visit already exists with the same short_url_id and ip_address
        $existingVisit = ShortURLVisit::where('short_url_id', $shortURL->id)->where('ip_address', $request->ip())->first();

        if ($existingVisit) {

            $existingVisit->visited_at = now();
            $existingVisit->save();
            return $existingVisit;
        }

        // Check if a visit already not exists with the same short_url_id and ip_address

        $visit = new ShortURLVisit();
        $visit->short_url_id = $shortURL->id;
        $visit->visited_at = now();


        $this->trackVisit($shortURL, $visit, $request);

        $visit->save();

        return $visit;
    }

    /**
     * Check which fields should be tracked and then store them if needed. Otherwise, add
     * them as null.
     */
    protected function trackVisit(ShortURL $shortURL, ShortURLVisit $visit, Request $request): void
    {
        $userAgentParser = $this->userAgentDriver->usingUserAgentString($request->userAgent());


        $visit->ip_address = $request->ip();

        $visit->operating_system = $userAgentParser->getOperatingSystem();

        $visit->operating_system_version = $userAgentParser->getOperatingSystemVersion();

        $visit->browser = $userAgentParser->getBrowser();

        $visit->browser_version = $userAgentParser->getBrowserVersion();

        $visit->referer_url = $request->headers->get('referer');

        $visit->device_type = $this->guessDeviceType($userAgentParser);
    }

    /**
     * Guess and return the device type that was used to visit the short URL. Null
     * will be returned if we cannot determine the device type.
     */
    protected function guessDeviceType(UserAgentDriver $userAgentParser): ?string
    {
        return match (true) {
            $userAgentParser->isDesktop() => ShortURLVisit::DEVICE_TYPE_DESKTOP,
            $userAgentParser->isMobile() => ShortURLVisit::DEVICE_TYPE_MOBILE,
            $userAgentParser->isTablet() => ShortURLVisit::DEVICE_TYPE_TABLET,
            $userAgentParser->isRobot() => ShortURLVisit::DEVICE_TYPE_ROBOT,
            default => null,
        };
    }
}
