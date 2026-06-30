<?php

declare(strict_types=1);

namespace App\Providers;

use App\Repositories\ShortLink\EloquentShortLinkRepository;
use App\Repositories\ShortLink\ShortLinkRepositoryContract;
use App\Repositories\ShortLinkHistory\EloquentShortLinkHistoryRepository;
use App\Repositories\ShortLinkHistory\ShortLinkHistoryRepositoryContract;
use App\Repositories\User\EloquentUserRepository;
use App\Repositories\User\UserRepositoryContract;
use Illuminate\Support\ServiceProvider;

final class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryContract::class, EloquentUserRepository::class);
        $this->app->bind(ShortLinkRepositoryContract::class, EloquentShortLinkRepository::class);
        $this->app->bind(ShortLinkHistoryRepositoryContract::class, EloquentShortLinkHistoryRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
