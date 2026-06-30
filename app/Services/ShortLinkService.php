<?php

declare(strict_types=1);

namespace App\Services;

use App\Data\ShortLinkDTO;
use App\Repositories\ShortLink\ShortLinkRepositoryContract;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Str;

final class ShortLinkService
{
    public function __construct(
        private readonly ShortLinkRepositoryContract $shortLinkRepository,
    ) {}

    public function create(string $userId, string $targetUrl): ShortLinkDTO
    {
        return $this->shortLinkRepository->create(new ShortLinkDTO(
            targetUrl: $targetUrl,
            shortCode: $this->generateUniqueShortCode(),
            userId: $userId,
        ));
    }

    public function delete(string $id, string $userId): void
    {
        $shortLink = $this->shortLinkRepository->findByIdAndUserId($id, $userId);

        if ($shortLink === null) {
            throw new ModelNotFoundException;
        }

        $this->shortLinkRepository->delete($shortLink);
    }

    private function generateUniqueShortCode(): string
    {
        do {
            $shortCode = Str::lower(Str::random(config('short-link.short_code_length')));
        } while ($this->shortLinkRepository->existsByShortCode($shortCode));

        return $shortCode;
    }
}
