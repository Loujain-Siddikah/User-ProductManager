<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CreateAdminRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'first_name' => 'admin',
            'last_name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('0123456'),
            'email_verified'=>1,
            'email_verified_at' => now(),
            // 'role_name' => "admin",
        ]);
        $user->markEmailAsVerified();
        $role1= Role::create(['name' => 'admin']);
        $role2= Role::create(['name' => 'user']);
        $user->assignRole([$role1->id]);
    }
}
