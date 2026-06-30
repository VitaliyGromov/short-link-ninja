<?php

declare(strict_types=1);

namespace App\Services;

use App\Data\ShortLinkHistoryDTO;
use App\Repositories\ShortLink\ShortLinkRepositoryContract;
use App\Repositories\ShortLinkHistory\ShortLinkHistoryRepositoryContract;
use Illuminate\Database\Eloquent\ModelNotFoundException;

final class ShortLinkRedirectService
{
    public function __construct(
        private readonly ShortLinkRepositoryContract $shortLinkRepository,
        private readonly ShortLinkHistoryRepositoryContract $shortLinkHistoryRepository,
    ) {}

    public function redirect(string $shortCode, string $ipAddress): string
    {
        $shortLink = $this->shortLinkRepository->findByShortCode($shortCode);

        if ($shortLink === null) {
            throw new ModelNotFoundException;
        }

        $this->shortLinkHistoryRepository->create(new ShortLinkHistoryDTO(
            shortLinkId: $shortLink->id,
            ipAddress: $ipAddress,
            visitedAt: now(),
        ));

        return $shortLink->targetUrl;
    }
}
