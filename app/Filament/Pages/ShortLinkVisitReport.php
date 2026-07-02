<?php

declare(strict_types=1);

namespace App\Filament\Pages;

use App\Actions\ShortLink\BuildShortLinkUrl;
use App\Data\ShortLinkHistoryDTO;
use App\Data\ShortLinkVisitStatDTO;
use App\Models\ShortLink;
use App\Services\ShortLinkVisitReportService;
use Filament\Actions\Action;
use Illuminate\Support\Carbon;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Contracts\View\View;

final class ShortLinkVisitReport extends Page implements HasActions, HasForms
{
    use InteractsWithActions;
    use InteractsWithForms;

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

    public function viewLinkDetailsAction(): Action
    {
        return Action::make('viewLinkDetails')
            ->label('Детали')
            ->icon('heroicon-o-eye')
            ->color('gray')
            ->modalHeading('История переходов')
            ->modalWidth(MaxWidth::Large)
            ->modalSubmitAction(false)
            ->modalCancelActionLabel('Закрыть')
            ->modalContent(function(array $arguments): View {
                $visits = app(ShortLinkVisitReportService::class)->getVisitsForShortLink(
                    shortLinkId: $arguments['shortLinkId'],
                    userId: (string)auth()->id(),
                );

                return view('filament.pages.partials.short-link-visit-details', [
                    'visits' => array_map(
                        static fn(ShortLinkHistoryDTO $visit): array => [
                            'ipAddress' => $visit->ipAddress,
                            'visitedAt' => $visit->visitedAt !== null
                                ? Carbon::parse($visit->visitedAt)->timezone(config('app.timezone'))->format('d.m.Y H:i:s')
                                : null,
                        ],
                        $visits,
                    ),
                ]);
            });
    }

    public function formatShortUrl(string $shortCode): string
    {
        $shortLink = new ShortLink(['short_code' => $shortCode]);

        return app(BuildShortLinkUrl::class)->handle($shortLink);
    }
}
