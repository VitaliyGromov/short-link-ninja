<?php

declare(strict_types=1);

namespace Tests\Unit\Actions;

use App\Actions\ShortLink\GenerateUniqueShortCode;
use App\Models\ShortLink;
use App\Repositories\ShortLink\ShortLinkRepositoryContract;
use Tests\TestCase;

final class GenerateUniqueShortCodeTest extends TestCase
{
    public function test_handle_returns_code_with_configured_length(): void
    {
        config(['short-link.short_code_length' => 8]);

        $repository = $this->mock(ShortLinkRepositoryContract::class);
        $repository->shouldReceive('existsByShortCode')->once()->andReturn(false);

        $shortCode = (new GenerateUniqueShortCode($repository))->handle();

        $this->assertSame(8, strlen($shortCode));
        $this->assertMatchesRegularExpression('/^[a-z0-9]{8}$/', $shortCode);
    }

    public function test_handle_retries_when_short_code_already_exists(): void
    {
        config(['short-link.short_code_length' => 10]);

        $repository = $this->mock(ShortLinkRepositoryContract::class);
        $repository->shouldReceive('existsByShortCode')
            ->twice()
            ->andReturn(true, false);

        $shortCode = (new GenerateUniqueShortCode($repository))->handle();

        $this->assertSame(10, strlen($shortCode));
        $this->assertMatchesRegularExpression('/^[a-z0-9]{10}$/', $shortCode);
    }

    public function test_handle_returns_unique_code_using_repository(): void
    {
        config(['short-link.short_code_length' => 10]);

        $existingShortLink = ShortLink::factory()->create();

        $shortCode = $this->app->make(GenerateUniqueShortCode::class)->handle();

        $this->assertNotSame($existingShortLink->short_code, $shortCode);
        $this->assertDatabaseMissing('short_links', [
            'short_code' => $shortCode,
        ]);
    }
}
