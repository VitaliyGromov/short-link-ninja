<?php

declare(strict_types=1);

namespace App\Events\ShortLink;

use Carbon\CarbonInterface;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

final class Redirect
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public readonly string $shortLinkId,
        public readonly string $ipAddress,
        public readonly CarbonInterface $visitedAt,
    ) {}
}
