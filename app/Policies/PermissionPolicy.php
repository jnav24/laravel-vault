<?php

namespace App\Policies;

use App\Enums\PermissionEnum;
use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use App\Models\Permission;

class PermissionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo(PermissionEnum::VIEW_PERMISSION->value) || $user->hasRole(RoleEnum::SUPER_ADMIN->value);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Permission $permission): bool
    {
        return $user->hasPermissionTo(PermissionEnum::VIEW_PERMISSION->value) || $user->hasRole(RoleEnum::SUPER_ADMIN->value);;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo(PermissionEnum::CREATE_PERMISSION->value) || $user->hasRole(RoleEnum::SUPER_ADMIN->value);;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Permission $permission): bool
    {
        return $user->hasPermissionTo(PermissionEnum::EDIT_PERMISSION->value) || $user->hasRole(RoleEnum::SUPER_ADMIN->value);;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Permission $permission): bool
    {
        return $user->hasPermissionTo(PermissionEnum::DELETE_PERMISSION->value) || $user->hasRole(RoleEnum::SUPER_ADMIN->value);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Permission $permission): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Permission $permission): bool
    {
        return $user->hasPermissionTo(PermissionEnum::DELETE_PERMISSION->value) || $user->hasRole(RoleEnum::SUPER_ADMIN->value);;
    }
}
