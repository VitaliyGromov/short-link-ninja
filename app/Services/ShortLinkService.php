<?php

declare(strict_types=1);

namespace App\Services;

use App\Actions\ShortLink\GenerateUniqueShortCode;
use App\Data\ShortLinkDTO;
use App\Exceptions\NotFoundException;
use App\Repositories\ShortLink\ShortLinkRepositoryContract;

final class ShortLinkService
{
    public function __construct(
        private readonly ShortLinkRepositoryContract $shortLinkRepository,
        private readonly GenerateUniqueShortCode $generateUniqueShortCode,
    ) {}

    public function create(string $userId, string $targetUrl): ShortLinkDTO
    {
        return $this->shortLinkRepository->create(new ShortLinkDTO(
            targetUrl: $targetUrl,
            shortCode: $this->generateUniqueShortCode->handle(),
            userId: $userId,
        ));
    }

    public function delete(string $id, string $userId): void
    {
        $shortLink = $this->shortLinkRepository->findByIdAndUserId($id, $userId);

        if ($shortLink === null) {
            throw new NotFoundException;
        }

        $this->shortLinkRepository->delete($shortLink);
    }
}
