<?php

declare(strict_types=1);

namespace App\Actions\ShortLink;

use App\Models\ShortLink;

final readonly class BuildShortLinkUrl
{
    public function handle(ShortLink $shortLink): string
    {
        $baseUrl = rtrim((string)config('short-link.base_url'), '/');

        return "{$baseUrl}/{$shortLink->short_code}";
    }
}
