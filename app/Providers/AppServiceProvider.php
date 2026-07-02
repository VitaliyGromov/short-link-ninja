<?php

declare(strict_types=1);

namespace App\Providers;

use App\Events\ShortLink\Redirect;
use App\Listeners\ShortLink\CreateShortLinkHistoryListener;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

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
        Event::listen(Redirect::class, CreateShortLinkHistoryListener::class);
    }
}
