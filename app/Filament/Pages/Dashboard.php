<?php

namespace App\Filament\Pages;

use App\Models\Site;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Actions\Action;
use Filament\Pages\Page;
use App\Filament\Widgets\StatsOverview;
use App\Filament\Widgets\UserApps;
use Illuminate\Support\Str;

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static string $view = 'filament.pages.dashboard';

    protected function getHeaderWidgets(): array
    {
        return [
            StatsOverview::class,
            UserApps::class,
        ];
    }

    protected function getActions(): array
    {
        return [
            Action::make('edit')
                ->label('New App')
                ->action(function (array $data): void {
                    $record = new Site();
                    $record->user_id = auth()->user()->id;
                    $record->domain = $data['domain'];
                    $record->name = $data['name'];
                    $record->save();
                    $this->emit('updateSitesTable');
                })
                ->form([
                    TextInput::make('name')->required()->rules(['min:3']),
                    TextInput::make('domain')
                        ->required()
                        ->unique()
                        ->hint('e.g. https://google.com')
                        ->rules(['url']),
                ]),
        ];
    }
}
