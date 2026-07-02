<?php

declare(strict_types=1);

namespace App\Services;

use App\Events\ShortLink\Redirect;
use App\Exceptions\NotFoundException;
use App\Repositories\ShortLink\ShortLinkRepositoryContract;

final class ShortLinkRedirectService
{
    public function __construct(
        private readonly ShortLinkRepositoryContract $shortLinkRepository,
    ) {}

    public function redirect(string $shortCode, string $ipAddress): string
    {
        $shortLink = $this->shortLinkRepository->findByShortCode($shortCode);

        if ($shortLink === null) {
            throw new NotFoundException('Short link not found');
        }

            event(new Redirect(
                shortLinkId: $shortLink->id,
                ipAddress: $ipAddress,
                visitedAt: now(),
            ));
        

        return $shortLink->targetUrl;
    }
}
