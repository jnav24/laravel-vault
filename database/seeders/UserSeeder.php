<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'Super Admin',
            'password' => bcrypt('password'),
            'email' => 'superadmin@admin.com',
            'email_verified_at' => Carbon::now(),
        ]);

        $user->assignRole(RoleEnum::SUPER_ADMIN->value);
    }
}
