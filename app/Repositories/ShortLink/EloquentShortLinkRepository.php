<?php

declare(strict_types=1);

namespace App\Repositories\ShortLink;

use App\Data\ShortLinkDTO;
use App\Models\ShortLink;

final readonly class EloquentShortLinkRepository implements ShortLinkRepositoryContract
{
    public function create(ShortLinkDTO $shortLink): ShortLinkDTO
    {
        /** @var ShortLink $model */
        $model = $shortLink->toModel();
        $model->saveOrFail();

        return ShortLinkDTO::fromModel($model);
    }

    public function delete(ShortLinkDTO $shortLink): void
    {
        /** @var ShortLink $model */
        $model = $shortLink->toModel();
        $model->deleteOrFail();
    }

    public function findByIdAndUserId(string $id, string $userId): ?ShortLinkDTO
    {
        $model = ShortLink::query()
            ->whereKey($id)
            ->where('user_id', $userId)
            ->first();

        if ($model === null) {
            return null;
        }

        return ShortLinkDTO::fromModel($model);
    }

    public function existsByShortCode(string $shortCode): bool
    {
        return ShortLink::query()
            ->where('short_code', $shortCode)
            ->exists();
    }

    public function findByShortCode(string $shortCode): ?ShortLinkDTO
    {
        $model = ShortLink::query()
            ->where('short_code', $shortCode)
            ->first();

        if ($model === null) {
            return null;
        }

        return ShortLinkDTO::fromModel($model);
    }
}
