<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Enums\RoleEnum;
use App\Filament\Resources\UserResource;
use App\Models\User;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Gate;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function isTableRecordSelectable(): ?\Closure
    {
        return fn (User $user) => Gate::allows('delete', $user);
    }
}
