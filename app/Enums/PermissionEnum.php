<?php

namespace App\Enums;

enum PermissionEnum: string
{
    case VIEW_PERMISSION = 'view_permission';
    case CREATE_PERMISSION = 'create_permission';
    case EDIT_PERMISSION = 'edit_permission';
    case DELETE_PERMISSION = 'delete_permission';
    case VIEW_ROLE = 'view_role';
    case CREATE_ROLE = 'create_role';
    case EDIT_ROLE = 'edit_role';
    case DELETE_ROLE = 'delete_role';
    case EDIT_USER = 'edit_user';

    public function label(): string
    {
        return match ($this) {
            static::VIEW_ROLE => 'view_role',
            static::CREATE_ROLE => 'create_role',
            static::EDIT_ROLE => 'edit_role',
            static::DELETE_ROLE => 'delete_role',
        };
    }
}
