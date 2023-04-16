<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $models = ['role', 'permission', 'user'];
        $types = ['view', 'create', 'edit', 'delete'];

        foreach ($models as $model) {
            foreach ($types as $type) {
                Permission::create(['name' => $type . '_' . $model]);
            }
        }
    }
}
