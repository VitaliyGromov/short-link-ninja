<?php

declare(strict_types=1);

namespace Tests\Unit\Listeners\ShortLink;

use App\Events\ShortLink\Redirect;
use App\Listeners\ShortLink\CreateShortLinkHistoryListener;
use App\Models\ShortLink;
use Tests\TestCase;

final class CreateShortLinkHistoryListenerTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_can_create_short_link_history(): void
    {
        $shortLink = ShortLink::factory()->create();
        $ipAddress = '127.0.0.1';
        $visitedAt = now()->toImmutable();
        $event = new Redirect($shortLink->id, $ipAddress, $visitedAt);
        $listener = $this->app->make(CreateShortLinkHistoryListener::class);
        $listener->handle($event);

        $this->assertDatabaseHas('short_link_histories', [
            'short_link_id' => $shortLink->id,
            'ip_address' => $ipAddress,
            'visited_at' => $visitedAt,
        ]);
    }
}
