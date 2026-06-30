<?php

declare(strict_types=1);

namespace App\Data;

use App\Models\ShortLink;
use DateTimeInterface;

final class ShortLinkDTO extends Data
{
    public function __construct(
        public readonly ?string $id = null,
        public readonly string $targetUrl = '',
        public readonly string $shortCode = '',
        public readonly ?string $userId = null,
        public readonly ?DateTimeInterface $createdAt = null,
    ) {}

    public static function getModel(): string
    {
        return ShortLink::class;
    }

    public static function fromModel(ShortLink $shortLink): self
    {
        return new self(
            id: $shortLink->id,
            targetUrl: $shortLink->target_url,
            shortCode: $shortLink->short_code,
            userId: $shortLink->user_id,
            createdAt: $shortLink->created_at,
        );
    }
}
