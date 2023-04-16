<?php

namespace App\Policies;

use App\Enums\PermissionEnum;
use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use App\Models\Role;

class RolePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo(PermissionEnum::VIEW_ROLE->value) || $user->hasRole(RoleEnum::SUPER_ADMIN->value);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Role $role): bool
    {
        return $user->hasPermissionTo(PermissionEnum::VIEW_ROLE->value);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo(PermissionEnum::CREATE_ROLE->value) || $user->hasRole(RoleEnum::SUPER_ADMIN->value);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Role $role): bool
    {
        return $role->name != RoleEnum::SUPER_ADMIN->value &&
            ($user->hasPermissionTo(PermissionEnum::DELETE_ROLE->value) || $user->hasRole(RoleEnum::SUPER_ADMIN->value));
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Role $role): bool
    {
        return $role->name != RoleEnum::SUPER_ADMIN->value &&
            ($user->hasPermissionTo(PermissionEnum::DELETE_ROLE->value) || $user->hasRole(RoleEnum::SUPER_ADMIN->value));
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Role $role): bool
    {
        return $user->hasPermissionTo(PermissionEnum::DELETE_ROLE->value);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Role $role): bool
    {
        return $role->name != RoleEnum::SUPER_ADMIN->value && $user->hasPermissionTo(PermissionEnum::DELETE_ROLE->value);
    }
}
