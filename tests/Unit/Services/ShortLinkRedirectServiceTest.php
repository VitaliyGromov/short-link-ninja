<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Events\ShortLink\Redirect;
use App\Exceptions\NotFoundException;
use App\Models\ShortLink;
use App\Services\ShortLinkRedirectService;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

final class ShortLinkRedirectServiceTest extends TestCase
{
    private ShortLinkRedirectService $shortLinkRedirectService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->shortLinkRedirectService = $this->app->make(ShortLinkRedirectService::class);
    }

    public function test_get_redirect_url(): void
    {
        $shortLink = ShortLink::factory()->create();
        $ipAddress = '127.0.0.1';
        $redirectUrl = $this->shortLinkRedirectService->redirect($shortLink->short_code, $ipAddress);
        $this->assertEquals($shortLink->target_url, $redirectUrl);
        Event::assertDispatched(Redirect::class);
    }

    public function test_get_redirect_url_not_found(): void
    {
        $shortCode = 'not-found';
        $ipAddress = '127.0.0.1';
        $this->expectException(NotFoundException::class);
        $this->shortLinkRedirectService->redirect($shortCode, $ipAddress);
        Event::assertNotDispatched(Redirect::class);
    }
}
