<?php

declare(strict_types=1);

namespace App\Repositories\ShortLinkHistory;

use App\Data\ShortLinkHistoryDTO;

interface ShortLinkHistoryRepositoryContract
{
    public function create(ShortLinkHistoryDTO $shortLinkHistory): ShortLinkHistoryDTO;
}
