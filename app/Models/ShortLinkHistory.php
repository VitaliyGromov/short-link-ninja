<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\ShortLinkHistoryFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Override;

#[Fillable(['short_link_id', 'ip_address', 'visited_at'])]
final class ShortLinkHistory extends Model
{
    /** @use HasFactory<ShortLinkHistoryFactory> */
    use HasFactory, HasUuids;

    /** @return BelongsTo<ShortLink, $this> */
    public function shortLink(): BelongsTo
    {
        return $this->belongsTo(ShortLink::class);
    }

    #[Override]
    protected function casts()
    {
        return [
            'visited_at' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}
