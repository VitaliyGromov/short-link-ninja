<?php

declare(strict_types=1);

namespace App\Repositories\ShortLinkHistory;

use App\Data\ShortLinkHistoryDTO;
use App\Data\ShortLinkVisitStatDTO;
use App\Models\ShortLink;
use App\Models\ShortLinkHistory;
use Illuminate\Support\Facades\DB;

final readonly class EloquentShortLinkHistoryRepository implements ShortLinkHistoryRepositoryContract
{
    public function create(ShortLinkHistoryDTO $shortLinkHistory): ShortLinkHistoryDTO
    {
        /** @var ShortLinkHistory $model */
        $model = $shortLinkHistory->toModel();
        $model->saveOrFail();

        return ShortLinkHistoryDTO::fromModel($model);
    }

    public function countTotalForUser(string $userId): int
    {
        return ShortLinkHistory::query()
            ->whereHas('shortLink', fn($query) => $query->where('user_id', $userId))
            ->count();
    }

    public function countPerShortLinkForUser(string $userId): array
    {
        return ShortLink::query()
            ->where('short_links.user_id', $userId)
            ->leftJoin('short_link_histories', 'short_links.id', '=', 'short_link_histories.short_link_id')
            ->groupBy('short_links.id', 'short_links.target_url', 'short_links.short_code')
            ->orderByRaw('COUNT(short_link_histories.id) DESC')
            ->get([
                'short_links.id',
                'short_links.target_url',
                'short_links.short_code',
                DB::raw('COUNT(short_link_histories.id) as visits_count'),
            ])
            ->map(fn(ShortLink $row): ShortLinkVisitStatDTO => new ShortLinkVisitStatDTO(
                shortLinkId: $row->id,
                targetUrl: $row->target_url,
                shortCode: $row->short_code,
                visitsCount: (int)$row->visits_count,
            ))
            ->all();
    }

    public function findByShortLinkIdForUser(string $shortLinkId, string $userId): array
    {
        $shortLinkExists = ShortLink::query()
            ->whereKey($shortLinkId)
            ->where('user_id', $userId)
            ->exists();

        if (!$shortLinkExists) {
            return [];
        }

        return ShortLinkHistory::query()
            ->where('short_link_id', $shortLinkId)
            ->orderByDesc('visited_at')
            ->get()
            ->map(fn(ShortLinkHistory $history): ShortLinkHistoryDTO => ShortLinkHistoryDTO::fromModel($history))
            ->all();
    }
}
