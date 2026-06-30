<?php

declare(strict_types=1);

namespace App\Filament\Resources\ShortLinkResource\Pages;

use App\Filament\Resources\ShortLinkResource;
use App\Services\ShortLinkService;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

final class CreateShortLink extends CreateRecord
{
    protected static string $resource = ShortLinkResource::class;

    protected static ?string $title = 'Создать ссылку';

    protected function handleRecordCreation(array $data): Model
    {
        $shortLinkDTO = app(ShortLinkService::class)->create(
            userId: auth()->id(),
            targetUrl: $data['target_url'],
        );

        return $shortLinkDTO->toModel();
    }
}
