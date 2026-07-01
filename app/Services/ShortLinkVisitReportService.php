<?php

declare(strict_types=1);

namespace App\Services;

use App\Data\ShortLinkHistoryDTO;
use App\Data\ShortLinkVisitReportDTO;
use App\Repositories\ShortLinkHistory\ShortLinkHistoryRepositoryContract;

final class ShortLinkVisitReportService
{
    public function __construct(
        private readonly ShortLinkHistoryRepositoryContract $shortLinkHistoryRepository,
    ) {}

    public function getReportForUser(string $userId): ShortLinkVisitReportDTO
    {
        return new ShortLinkVisitReportDTO(
            totalVisitsCount: $this->shortLinkHistoryRepository->countTotalForUser($userId),
            links: $this->shortLinkHistoryRepository->countPerShortLinkForUser($userId),
        );
    }

    /**
     * @return list<ShortLinkHistoryDTO>
     */
    public function getVisitsForShortLink(string $shortLinkId, string $userId): array
    {
        return $this->shortLinkHistoryRepository->findByShortLinkIdForUser($shortLinkId, $userId);
    }
}
