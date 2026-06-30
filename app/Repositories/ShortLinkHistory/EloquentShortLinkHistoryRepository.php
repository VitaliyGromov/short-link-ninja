<?php

declare(strict_types=1);

namespace App\Repositories\ShortLinkHistory;

use App\Data\ShortLinkHistoryDTO;
use App\Models\ShortLinkHistory;

final readonly class EloquentShortLinkHistoryRepository implements ShortLinkHistoryRepositoryContract
{
    public function create(ShortLinkHistoryDTO $shortLinkHistory): ShortLinkHistoryDTO
    {
        /** @var ShortLinkHistory $model */
        $model = $shortLinkHistory->toModel();
        $model->saveOrFail();

        return ShortLinkHistoryDTO::fromModel($model);
    }
}
