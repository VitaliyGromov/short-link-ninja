<?php

declare(strict_types=1);

namespace App\Services;

use App\Data\ShortLinkHistoryDTO;
use App\Exceptions\NotFoundException;
use App\Repositories\ShortLink\ShortLinkRepositoryContract;
use App\Repositories\ShortLinkHistory\ShortLinkHistoryRepositoryContract;

final class ShortLinkRedirectService
{
    public function __construct(
        private readonly ShortLinkRepositoryContract $shortLinkRepository,
        private readonly ShortLinkHistoryRepositoryContract $shortLinkHistoryRepository,
    ) {}

    public function getRedirectUrl(string $shortCode, string $ipAddress): string
    {
        $shortLink = $this->shortLinkRepository->findByShortCode($shortCode);

        if ($shortLink === null) {
            throw new NotFoundException('Short link not found');
        }

        $this->shortLinkHistoryRepository->create(new ShortLinkHistoryDTO(
            shortLinkId: $shortLink->id,
            ipAddress: $ipAddress,
            visitedAt: now(),
        ));

        return $shortLink->targetUrl;
    }
}
