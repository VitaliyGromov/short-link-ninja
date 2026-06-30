<?php

declare(strict_types=1);

namespace App\Filament\Resources\ShortLinkResource\Pages;

use App\Filament\Resources\ShortLinkResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

final class ListShortLinks extends ListRecords
{
    protected static string $resource = ShortLinkResource::class;

    protected static ?string $title = 'Ссылки';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Создать ссылку'),
        ];
    }
}
