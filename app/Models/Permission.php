<?php

namespace App\Models;

use App\Enums\PermissionEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Permission extends \Spatie\Permission\Models\Permission
{
    use HasFactory;

    protected $casts = [
        'name' => PermissionEnum::class,
    ];
}
