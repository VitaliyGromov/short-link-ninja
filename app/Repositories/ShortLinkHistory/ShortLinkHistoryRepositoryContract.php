<?php

declare(strict_types=1);

namespace App\Repositories\ShortLinkHistory;

use App\Data\ShortLinkHistoryDTO;
use App\Data\ShortLinkVisitStatDTO;

interface ShortLinkHistoryRepositoryContract
{
    public function create(ShortLinkHistoryDTO $shortLinkHistory): ShortLinkHistoryDTO;

    public function countTotalForUser(string $userId): int;

    /**
     * @return list<ShortLinkVisitStatDTO>
     */
    public function countPerShortLinkForUser(string $userId): array;

    /**
     * @return list<ShortLinkHistoryDTO>
     */
    public function findByShortLinkIdForUser(string $shortLinkId, string $userId): array;
}
