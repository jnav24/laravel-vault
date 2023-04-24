<?php

namespace App\Filament\Resources\RoleResource\Pages;

use App\Enums\RoleEnum;
use App\Filament\Resources\RoleResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Gate;
use App\Models\Role;

class ListRoles extends ListRecords
{
    protected static string $resource = RoleResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function isTableRecordSelectable(): ?\Closure
    {
        return fn (Role $role) => Gate::allows('delete', $role);
    }
}
