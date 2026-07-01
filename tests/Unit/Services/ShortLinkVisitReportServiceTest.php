<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Data\ShortLinkVisitReportDTO;
use App\Models\ShortLink;
use App\Models\ShortLinkHistory;
use App\Models\User;
use App\Services\ShortLinkVisitReportService;
use Tests\TestCase;

final class ShortLinkVisitReportServiceTest extends TestCase
{
    private ShortLinkVisitReportService $shortLinkVisitReportService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->shortLinkVisitReportService = $this->app->make(ShortLinkVisitReportService::class);
    }

    public function test_get_report_for_user(): void
    {
        $user = User::factory()->create();
        $shortLink = ShortLink::factory()->create([
            'user_id' => $user->id,
        ]);
        ShortLinkHistory::factory()->count(10)->create([
            'short_link_id' => $shortLink->id,
        ]);
        $report = $this->shortLinkVisitReportService->getReportForUser($user->id);

        $this->assertInstanceOf(ShortLinkVisitReportDTO::class, $report);
        $this->assertEquals(10, $report->totalVisitsCount);
        $this->assertEquals(1, count($report->links));
    }
}
