<?php

declare(strict_types=1);

namespace App\Filament\Pages;

use App\Actions\ShortLink\BuildShortLinkUrl;
use App\Data\ShortLinkVisitStatDTO;
use App\Models\ShortLink;
use App\Services\ShortLinkVisitReportService;
use Filament\Pages\Page;

final class ShortLinkVisitReport extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';

    protected static ?string $navigationLabel = 'Отчёт';

    protected static ?string $title = 'Отчёт по переходам';

    protected static ?string $slug = 'report';

    protected static ?int $navigationSort = 2;

    protected static string $view = 'filament.pages.short-link-visit-report';

    public int $totalVisitsCount = 0;

    /** @var list<array{shortLinkId: string, targetUrl: string, shortCode: string, visitsCount: int}> */
    public array $links = [];

    public function mount(ShortLinkVisitReportService $reportService): void
    {
        $report = $reportService->getReportForUser((string)auth()->id());

        $this->totalVisitsCount = $report->totalVisitsCount;
        $this->links = array_map(
            static fn(ShortLinkVisitStatDTO $link): array => [
                'shortLinkId' => $link->shortLinkId,
                'targetUrl' => $link->targetUrl,
                'shortCode' => $link->shortCode,
                'visitsCount' => $link->visitsCount,
            ],
            $report->links,
        );
    }

    public function formatShortUrl(string $shortCode): string
    {
        $shortLink = new ShortLink(['short_code' => $shortCode]);

        return app(BuildShortLinkUrl::class)->handle($shortLink);
    }
}
