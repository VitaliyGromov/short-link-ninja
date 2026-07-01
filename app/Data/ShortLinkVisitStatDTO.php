<?php

declare(strict_types=1);

namespace App\Data;

final readonly class ShortLinkVisitStatDTO
{
    public function __construct(
        public string $shortLinkId,
        public string $targetUrl,
        public string $shortCode,
        public int $visitsCount,
    ) {}
}
