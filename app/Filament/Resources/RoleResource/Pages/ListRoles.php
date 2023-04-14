<?php

namespace App\Filament\Resources\RoleResource\Pages;

use App\Enums\RoleEnum;
use App\Filament\Resources\RoleResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Spatie\Permission\Models\Role;

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
        return fn (Role $role) => $role->name != RoleEnum::SUPER_ADMIN->value;
    }
}
