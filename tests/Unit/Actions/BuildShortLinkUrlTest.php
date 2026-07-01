<?php

declare(strict_types=1);

namespace Tests\Unit\Actions;

use App\Actions\ShortLink\BuildShortLinkUrl;
use App\Models\ShortLink;
use Tests\TestCase;

final class BuildShortLinkUrlTest extends TestCase
{
    private BuildShortLinkUrl $buildShortLinkUrl;

    protected function setUp(): void
    {
        parent::setUp();
        $this->buildShortLinkUrl = $this->app->make(BuildShortLinkUrl::class);
    }

    public function test_handle(): void
    {
        config(['short-link.base_url' => 'https://example.com']);
        $shortLink = ShortLink::factory()->create();
        $url = $this->buildShortLinkUrl->handle($shortLink);
        $this->assertEquals('https://example.com/' . $shortLink->short_code, $url);
    }
}
