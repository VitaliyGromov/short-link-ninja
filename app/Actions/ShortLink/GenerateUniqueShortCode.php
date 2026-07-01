<?php

declare(strict_types=1);

namespace App\Actions\ShortLink;

use App\Repositories\ShortLink\ShortLinkRepositoryContract;
use Illuminate\Support\Str;

final readonly class GenerateUniqueShortCode
{
    public function __construct(
        private ShortLinkRepositoryContract $shortLinkRepository,
    ) {}

    public function handle(): string
    {
        do {
            $shortCode = Str::lower(Str::random(config('short-link.short_code_length')));
        } while ($this->shortLinkRepository->existsByShortCode($shortCode));

        return $shortCode;
    }
}
