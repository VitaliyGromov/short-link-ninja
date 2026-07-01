<?php

declare(strict_types=1);

namespace App\Data;

final readonly class ShortLinkVisitReportDTO
{
    /**
     * @param  list<ShortLinkVisitStatDTO>  $links
     */
    public function __construct(
        public int $totalVisitsCount,
        public array $links,
    ) {}
}
