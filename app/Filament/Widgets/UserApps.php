<?php

namespace App\Filament\Widgets;

use App\Models\Site;
use App\Models\User;
use App\Models\UserAccessToken;
use Filament\Forms\Components\TextInput;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class UserApps extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    protected $listeners = ['updateSitesTable' => '$refresh'];

    protected static ?string $heading = '';

    protected function getTableQuery(): Builder
    {
        return Site::query()->where('user_id', auth()->user()->id);
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('domain')
                ->url(fn (Site $record) => $record->domain)
                ->openUrlInNewTab()
                ->searchable()
                ->sortable(),
            Tables\Columns\TextColumn::make('access')
                ->getStateUsing(function (Site $record) {
                    return $record->access->count();
                })
                ->label('No. Users')
                ->sortable(),
            Tables\Columns\TextColumn::make('created_at')
                ->label('Created')
                ->dateTime('d-M-Y')
                ->sortable(),
        ];
    }

    protected function getTableActions(): array
    {
        return [
            Action::make('details')
                ->color('primary')
                ->icon('heroicon-s-cog')
                ->url(fn (Site $record) => route('filament.resources.sites.view', ['record' => $record])),
            Action::make('edit')
                ->action(function (array $data, Site $record): void {
                    $record->domain = $data['domain'];
                    $record->name = $data['name'];
                    $record->save();
                })
                ->after(function ($livewire){
                    $this->emit('updateSitesTable');
                })
                ->color('primary')
                ->icon('heroicon-s-pencil')
                ->mountUsing(fn (\Filament\Forms\ComponentContainer $form, Site $record) => $form->fill([
                    'name' => $record->name,
                    'domain' => $record->domain,
                ]))
                ->form([
                    TextInput::make('name')->required()->rules(['min:3']),
                    TextInput::make('domain')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->hint('e.g. https://google.com')
                        ->rules(['url']),
                ]),
            Action::make('delete')
                ->action(function (array $data, Site $record): void {
                    dd('delete action');
                    $record->domain = $data['domain'];
                    $record->name = $data['name'];
                    $record->save();
                })
                ->requiresConfirmation()
                ->icon('heroicon-s-trash')
                ->color('danger'),
//            Action::make('details')
//                ->url(fn (User $record): string => route('filament.resources.users.edit', $record))
//                ->openUrlInNewTab(),
        ];
    }

//    protected function getTableRecordsPerPageSelectOptions(): array
//    {
//        return [10, 69];
//    }
}
