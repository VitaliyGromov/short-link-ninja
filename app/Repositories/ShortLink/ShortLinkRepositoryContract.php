<?php

declare(strict_types=1);

namespace App\Repositories\ShortLink;

use App\Data\ShortLinkDTO;

interface ShortLinkRepositoryContract
{
    public function create(ShortLinkDTO $shortLink): ShortLinkDTO;

    public function delete(ShortLinkDTO $shortLink): void;

    public function findByIdAndUserId(string $id, string $userId): ?ShortLinkDTO;

    public function existsByShortCode(string $shortCode): bool;

    public function findByShortCode(string $shortCode): ?ShortLinkDTO;
}
