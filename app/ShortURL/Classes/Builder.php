<?php

namespace App\ShortURL\Classes;

use App\Http\Controllers\ShortURLController;
use App\Exceptions\ShortURLException;
use App\Models\ShortURL;
use App\Models\Subscription;
use App\Models\UserSubscription;
use Carbon\Carbon;
use Closure;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Illuminate\Support\Traits\Conditionable;
use App\Interfaces\UrlKeyGenerator;

class Builder
{
    use Conditionable;

    /**
     * The class that is used for generating the random URL keys.
     */
    protected UrlKeyGenerator $keyGenerator;

    /**
     * The destination URL that the short URL will redirect to.
     */
    protected ?string $destinationUrl = null;

    /**
     * Whether to force the destination URL and the shortened URL to use HTTPS
     * rather than HTTP. Null means the default value (set in the config) will
     * be used.
     */
    protected ?bool $secure = null;

    /**
     * A custom URL key that might be explicitly set for this URL.
     */
    protected ?string $urlKey = null;

    /**
     * Define an optional seed that can be used when generating a short URL key.
     */
    protected ?int $generateKeyUsing = null;

    /**
     * Define a callback to access the ShortURL model prior to creation.
     */
    protected ?Closure $beforeCreateCallback = null;

    /**
     * Defining Current user id
     */
    protected ?int $userId = null;

    /**
     * Check if the user has active subscription and enough URL creation limits.
     */
    protected ?string $canCreateShortUrl = null;

    protected $isSubscriptionExpired = null;
    protected $existingDestinationUrl = null;

    public function __construct(UrlKeyGenerator $urlKeyGenerator)
    {
        $this->keyGenerator = $urlKeyGenerator;
    }

    /**
     * Get the short URL route prefix.
     */
    public function prefix(): ?string
    {
        $prefix = config('short-url.prefix');

        if ($prefix === null) {
            return null;
        }

        return trim($prefix, '/');
    }

    /**
     * Get the middleware for short URL route.
     */
    public function middleware(): array
    {
        return config('short-url.middleware', []);
    }

    /**
     * Register the routes to handle the Short URL visits.
     */
    public function routes(): void
    {
        Route::middleware($this->middleware())->group(function (): void {
            Route::get(
                '/' . $this->prefix() . '/{shortURLKey}',
                ShortURLController::class
            )->name('shortURL.redirect');
        });
    }

    /**
     * Set the destination URL that the shortened URL will redirect to.
     *
     * @throws ShortURLException
     */
    public function destinationUrl(string $url): self
    {
        $allowedPrefixes = config('short-url.allowed_url_schemes');

        if (!Str::startsWith($url, $allowedPrefixes)) {
            throw new ShortURLException('The destination URL must begin with an allowed prefix: ' . implode(', ', $allowedPrefixes));
        }

        $this->destinationUrl = $url;

        return $this;
    }

    /**
     * Check if the destination URL already exists for the user.
     *
     * @throws ShortURLException
     */
    public function existingDestinationUrl(int $userId): self
    {
        $existingUrl = ShortURL::where('user_id', $userId)
            ->where('destination_url', $this->destinationUrl)
            ->first();

        if ($existingUrl) {
            throw new ShortURLException('Destination URL already exits');
        }

        return $this;
    }

    /**
     * Set whether the destination URL and shortened URL should be forced to use HTTPS.
     */
    public function secure(bool $isSecure = true): self
    {
        $this->secure = $isSecure;

        return $this;
    }

    /**
     * Explicitly set a URL key for this short URL.
     */
    public function urlKey(string $key): self
    {
        $this->urlKey = urlencode($key);

        return $this;
    }

    /**
     * Explicitly set the key generator.
     */
    public function keyGenerator(UrlKeyGenerator $keyGenerator): self
    {
        $this->keyGenerator = $keyGenerator;

        return $this;
    }

    /**
     * Override the HTTP status code that will be used for redirecting the visitor.
     *
     * @throws ShortURLException
     */
    public function redirectStatusCode(int $statusCode): self
    {
        if ($statusCode < 300 || $statusCode > 399) {
            throw new ShortURLException('The redirect status code must be a valid redirect HTTP status code.');
        }

        $this->redirectStatusCode = $statusCode;

        return $this;
    }

    /**
     * Set the seed to be used when generating a short URL key.
     */
    public function generateKeyUsing(int $generateUsing): self
    {
        $this->generateKeyUsing = $generateUsing;

        return $this;
    }

    /**
     * Pass the Short URL model into the callback before it is created.
     */
    public function beforeCreate(Closure $callback): self
    {
        $this->beforeCreateCallback = $callback;

        return $this;
    }

    /**
     * Check if the user can create a short URL based on their subscription.
     *
     * @throws ShortURLException
     */
    public function canCreateShortUrl(int $userId): bool
    {
        $userSubscription = UserSubscription::where('user_id', $userId)
            ->where('subscription_active_date', '<=', Carbon::now())
            ->first();

        if (!$userSubscription) {
            throw new ShortURLException('No active subscription found.');
        }

        if ($this->isSubscriptionExpired($userSubscription)) {
            throw new ShortURLException('Your subscription has expired.');
        }

        // Check remaining short URL limits
        $remainingLimit = $this->remainingShortUrlLimit($userId);

        if ($remainingLimit <= 0) {
            throw new ShortURLException('You have reached the short URL creation limit for your subscription.');
        }

        return true;
    }

    /**
     * Get the remaining limit of short URLs for the user.
     *
     * @return int
     */
    public function remainingShortUrlLimit(int $userId): int
    {
        $userSubscription = UserSubscription::where('user_id', $userId)->first();

        if (!$userSubscription || $this->isSubscriptionExpired($userSubscription)) {
            return 0;
        }

        $subscription = Subscription::find($userSubscription->subscription_id);

        if (!$subscription) {
            return 0; // Invalid subscription
        }

        $createdUrlsCount = ShortURL::where('user_id', $userId)->count();

        return max(0, $subscription->links_limit - $createdUrlsCount);
    }

    /**
     * Check if a subscription is expired.
     *
     * @param UserSubscription $userSubscription
     * @return bool
     */
    private function isSubscriptionExpired(UserSubscription $userSubscription): bool
    {
        $expiryDate = Carbon::parse($userSubscription->subscription_active_date)
            ->addDays($userSubscription->expire_plan_days);

        return Carbon::now()->greaterThan($expiryDate);
    }

    /**
     * Attempt to build a shortened URL and return it.
     *
     * @throws ShortURLException
     */
    public function make(): ShortURL
    {
        if (!$this->destinationUrl) {
            throw new ShortURLException('No destination URL has been set.');
        }

        $this->canCreateShortUrl($this->userId);

        $this->existingDestinationUrl($this->userId);

        $data = $this->toArray();

        $this->checkKeyDoesNotExist();

        $shortURL = new ShortURL($data);

        if ($this->beforeCreateCallback) {
            value($this->beforeCreateCallback, $shortURL);
        }

        $shortURL->save();

        $this->resetOptions();

        return $shortURL;
    }

    /**
     * Returns an array of all properties used during record creation.
     *
     * @return array<string,mixed>
     */
    public function userId(int $userId): self
    {
        $this->userId = $userId;
        return $this;
    }

    public function toArray(): array
    {
        $this->setOptions();

        return [
            'user_id' => $this->userId,
            'destination_url' => $this->destinationUrl,
            'default_short_url' => $this->buildDefaultShortUrl(),
            'url_key' => $this->urlKey,
        ];
    }

    /**
     * Check whether a short URL already exists with the given URL key.
     *
     * @throws ShortURLException
     */
    protected function checkKeyDoesNotExist(): void
    {
        if (ShortURL::where('url_key', $this->urlKey)->exists()) {
            throw new ShortURLException('A short URL with this key already exists.');
        }
    }

    /**
     * Set the options for the short URL that is being created.
     */
    private function setOptions(): void
    {
        if ($this->secure === null) {
            $this->secure = config('short-url.enforce_https');
        }

        if ($this->secure) {
            $this->destinationUrl = str_replace('http://', 'https://', $this->destinationUrl);
        }

        if (!$this->urlKey) {
            $this->urlKey = $this->keyGenerator->generateKeyUsing($this->generateKeyUsing);
        }
    }

    /**
     * Reset the options for the class.
     */
    public function resetOptions(): self
    {
        $this->destinationUrl = null;
        $this->urlKey = null;
        $this->secure = null;
        $this->redirectStatusCode = 301;
        $this->generateKeyUsing = null;
        $this->beforeCreateCallback = null;

        return $this;
    }

    /**
     * Build the default short URL based on the URL key.
     */
    public function buildDefaultShortUrl(): string
    {
        return route('shortURL.redirect', ['shortURLKey' => $this->urlKey]);
    }
}
