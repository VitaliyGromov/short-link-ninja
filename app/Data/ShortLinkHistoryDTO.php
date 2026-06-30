<?php

declare(strict_types=1);

namespace App\Data;

use App\Models\ShortLinkHistory;
use DateTimeInterface;

final class ShortLinkHistoryDTO extends Data
{
    public function __construct(
        public readonly ?string $id = null,
        public readonly ?string $shortLinkId = null,
        public readonly string $ipAddress = '',
        public readonly ?DateTimeInterface $visitedAt = null,
    ) {}

    public static function getModel(): string
    {
        return ShortLinkHistory::class;
    }

    public static function fromModel(ShortLinkHistory $shortLinkHistory): self
    {
        return new self(
            id: $shortLinkHistory->id,
            shortLinkId: $shortLinkHistory->short_link_id,
            ipAddress: $shortLinkHistory->ip_address,
            visitedAt: $shortLinkHistory->visited_at,
        );
    }
}
