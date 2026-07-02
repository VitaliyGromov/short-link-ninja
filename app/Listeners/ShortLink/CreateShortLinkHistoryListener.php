<?php

declare(strict_types=1);

namespace App\Listeners\ShortLink;

use App\Data\ShortLinkHistoryDTO;
use App\Events\ShortLink\Redirect;
use App\Repositories\ShortLinkHistory\ShortLinkHistoryRepositoryContract;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

final class CreateShortLinkHistoryListener implements ShouldQueue
{
    use InteractsWithQueue;

    public function __construct(
        private readonly ShortLinkHistoryRepositoryContract $shortLinkHistoryRepository,
    ) {}

    public function handle(Redirect $event): void
    {
        $this->shortLinkHistoryRepository->create(new ShortLinkHistoryDTO(
            shortLinkId: $event->shortLinkId,
            ipAddress: $event->ipAddress,
            visitedAt: $event->visitedAt,
        ));
    }
}
