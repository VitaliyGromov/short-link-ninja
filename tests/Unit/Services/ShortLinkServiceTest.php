<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Data\ShortLinkDTO;
use App\Exceptions\NotFoundException;
use App\Services\ShortLinkService;
use Tests\TestCase;

final class ShortLinkServiceTest extends TestCase
{
    private ShortLinkService $shortLinkService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->shortLinkService = $this->app->make(ShortLinkService::class);
    }

    public function test_create(): void
    {
        $userId = '1';
        $targetUrl = 'https://example.com';
        $shortLinkDTO = $this->shortLinkService->create($userId, $targetUrl);
        $this->assertInstanceOf(ShortLinkDTO::class, $shortLinkDTO);
        $this->assertNotNull($shortLinkDTO->id);
        $this->assertEquals($userId, $shortLinkDTO->userId);
        $this->assertEquals($targetUrl, $shortLinkDTO->targetUrl);
        $this->assertNotNull($shortLinkDTO->createdAt);
        $this->assertDatabaseHas('short_links', [
            'id' => $shortLinkDTO->id,
            'user_id' => $userId,
            'target_url' => $targetUrl,
            'short_code' => $shortLinkDTO->shortCode,
        ]);
    }

    public function test_delete(): void
    {
        $userId = '1';
        $targetUrl = 'https://example.com';
        $shortLinkDTO = $this->shortLinkService->create($userId, $targetUrl);
        $this->shortLinkService->delete($shortLinkDTO->id, $userId);
        $this->assertSoftDeleted('short_links', [
            'id' => $shortLinkDTO->id,
        ]);
    }

    public function test_delete_not_found(): void
    {
        $userId = '1';
        $id = 'not-found';
        $this->expectException(NotFoundException::class);
        $this->shortLinkService->delete($id, $userId);
    }
}
