<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Foundation\Application;
use Hashids\Hashids;
use App\ShortURL\Classes\KeyGenerator;
use App\ShortURL\Classes\Builder;
use App\ShortURL\Classes\UserAgent\ParserPhpDriver;
use App\Interfaces\UserAgentDriver;
use App\Interfaces\UrlKeyGenerator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/short-url.php', 'short-url');

        $this->app->bind(UserAgentDriver::class, ParserPhpDriver::class);
        $this->app->bind(UrlKeyGenerator::class, config('short-url.url_key_generator'));  

        $this->app->bind('short-url.builder', function (Application $app): Builder {
            return new Builder(
                urlKeyGenerator: $app->make(UrlKeyGenerator::class),
            );
        });

        $this->app->when(KeyGenerator::class)
            ->needs(Hashids::class)
            ->give(fn (): Hashids => new Hashids(
                salt: config('short-url.key_salt'),
                minHashLength: (int) config('short-url.key_length'),
                alphabet: config('short-url.alphabet')
            ));
      
    }

    public function boot(): void
    {
        // Config
        $this->publishes([
            __DIR__ . '/../../config/short-url.php' => config_path('short-url.php'),
        ], 'short-url-config');

        // Migrations
        $this->publishes([
            __DIR__ . '/../../database/migrations' => database_path('migrations'),
        ], 'short-url-migrations');

        // Routes
        $this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');
    }
}
