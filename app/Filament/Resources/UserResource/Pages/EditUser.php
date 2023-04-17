<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Models\Role;
use Filament\Forms;
use Filament\Pages\Actions;
use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Gate;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getActions(): array
    {
        $user = $this->record;
        $role = $user->roles->first();

        $actions = [
            Actions\DeleteAction::make()
        ];

        if (
            Gate::allows('update', $user) &&
            Gate::allows('delete', $user) &&
            Gate::allows('update', $role)
        ) {
            $actions[] = Action::make('updateRole')
                ->mountUsing(fn (Forms\ComponentContainer $form) => $form->fill([
                    'name' => $this->record->roles->first()?->name ?? '',
                ]))
                ->action(function (array $data) use ($user, $role) : void {
                    if ($role) {
                        $user->removeRole($user->roles->first()->name);
                    }

                    $user->assignRole($data['name']);
                })
                ->form([
                    Forms\Components\Select::make('name')
                        ->label('Custom Roles')
                        ->options(Role::all()->pluck('name.value', 'name.value'))
                        ->required(),
                ]);
        }

        return $actions;
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        dd($data);
        return $data;
    }
}
