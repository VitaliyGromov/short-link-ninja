<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Actions\ShortLink\BuildShortLinkUrl;
use App\Filament\Resources\ShortLinkResource\Pages;
use App\Models\ShortLink;
use App\Services\ShortLinkService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

final class ShortLinkResource extends Resource
{
    protected static ?string $model = ShortLink::class;

    protected static ?string $navigationIcon = 'heroicon-o-link';

    protected static ?string $navigationLabel = 'Ссылки';

    protected static ?string $modelLabel = 'ссылка';

    protected static ?string $pluralModelLabel = 'Ссылки';

    protected static ?string $slug = 'links';

    protected static ?int $navigationSort = 1;

    protected static bool $shouldSkipAuthorization = true;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('target_url')
                    ->label('URL')
                    ->url()
                    ->required()
                    ->maxLength(2048),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('user_id', auth()->id());
    }

    public static function table(Table $table): Table
    {
        $buildShortLinkUrl = app(BuildShortLinkUrl::class);

        return $table
            ->columns([
                Tables\Columns\TextColumn::make('target_url')
                    ->label('Оригинальная ссылка')
                    ->url(fn(ShortLink $record): string => $record->target_url)
                    ->openUrlInNewTab()
                    ->searchable()
                    ->limit(config('short-link.length_of_original_url')),
                Tables\Columns\TextColumn::make('short_code')
                    ->label('Короткая ссылка')
                    ->formatStateUsing(fn(string $state, ShortLink $record): string => $buildShortLinkUrl->handle($record))
                    ->url(fn(ShortLink $record): string => $buildShortLinkUrl->handle($record))
                    ->openUrlInNewTab()
                    ->copyable()
                    ->copyableState(fn(ShortLink $record): string => $buildShortLinkUrl->handle($record))
                    ->copyMessage('Ссылка скопирована')
                    ->copyMessageDuration(1500)
                    ->searchable(),
            ])
            ->emptyStateHeading('Вы пока не добавили ни одну ссылку')
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->label('Создать ссылку'),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                Tables\Actions\DeleteAction::make()
                    ->label('Удалить')
                    ->using(function(ShortLink $record): bool {
                        app(ShortLinkService::class)->delete($record->id, auth()->id());

                        return true;
                    }),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListShortLinks::route('/'),
            'create' => Pages\CreateShortLink::route('/create'),
        ];
    }
}
