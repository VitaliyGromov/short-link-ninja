<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Exceptions\NotFoundException;
use App\Models\ShortLink;
use App\Services\ShortLinkRedirectService;
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
        $redirectUrl = $this->shortLinkRedirectService->getRedirectUrl($shortLink->short_code, $ipAddress);
        $this->assertEquals($shortLink->target_url, $redirectUrl);
    }

    public function test_get_redirect_url_not_found(): void
    {
        $shortCode = 'not-found';
        $ipAddress = '127.0.0.1';
        $this->expectException(NotFoundException::class);
        $this->shortLinkRedirectService->getRedirectUrl($shortCode, $ipAddress);
    }
}
