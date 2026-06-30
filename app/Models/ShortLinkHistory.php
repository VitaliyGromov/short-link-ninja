<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\ShortLinkHistoryFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Override;

#[Fillable(['short_link_id', 'ip_address', 'visited_at'])]
final class ShortLinkHistory extends Model
{
    /** @use HasFactory<ShortLinkHistoryFactory> */
    use HasFactory, HasUuids;

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
