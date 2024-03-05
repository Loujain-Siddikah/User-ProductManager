<?php

namespace Database\Seeders;

use App\Enums\RolesEnum;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'first_name' => 'admin',
            'last_name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('0123456'),
            'email_verified_at' => now(),
        ]);
        $admin->markEmailAsVerified();
        $admin->assignRole(RolesEnum::ADMIN->value);
        User::factory()->count(10)->create();

    }
}
