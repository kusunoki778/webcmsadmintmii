<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Define roles
        $superAdminRole = Role::firstOrCreate(['name' => 'super-admin']);
        $staffRole = Role::firstOrCreate(['name' => 'staff']);
        $pimpinanRole = Role::firstOrCreate(['name' => 'pimpinan']);

        // Create 3 dummy users and assign roles
        $superAdminUser = User::firstOrCreate([
            'email' => 'admin@tmii.com'
        ],[
            'name' => 'Super Admin TMII',
            'password' => bcrypt('password123'),
        ]);
        $superAdminUser->assignRole($superAdminRole);

        $staffUser = User::firstOrCreate([
            'email' => 'staff@tmii.com'
        ],[
            'name' => 'Staff Operasional',
            'password' => bcrypt('password123'),
        ]);
        $staffUser->assignRole($staffRole);

        $pimpinanUser = User::firstOrCreate([
            'email' => 'pimpinan@tmii.com'
        ],[
            'name' => 'Pimpinan TMII',
            'password' => bcrypt('password123'),
        ]);
        $pimpinanUser->assignRole($pimpinanRole);
    }
}
