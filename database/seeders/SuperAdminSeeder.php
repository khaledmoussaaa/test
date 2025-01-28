<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ======================= Nursery 1 ======================= //
        $user = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
            'phone' => '01000111222',
            'password' => '12345test',
        ]);
        $user->syncRoles(['superadmin']);
    }
}
