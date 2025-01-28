<?php

namespace Database\Seeders;

use App\Models\Nursery;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NurserySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ======================= Nursery 1 ======================= //
        Nursery::create([
            'name' => 'Nursery 1',
            'email' => 'nursery1@gmail.com',
            'phone' => '01000111333',
            'country' => 'Egypt',
            'city' => 'Helioplis',
            'address' => 'Nasr City',
            'about' => 'About test for nursery 1',
            'branches_number' => 20,
        ]);

        $user_1 = User::create([
            'name' => 'Nursery 1',
            'email' => 'nursery1@gmail.com',
            'phone' => '01000111444',
            'password' => '12345test',
            'nursery_id' => 1,
        ]);

        $user_1->syncRoles(['owner']);
        $permssions = Permission::all();
        $user_1->syncPermissions(collect($permssions)->toArray());
        // ======================= Nursery 2 ======================= //
        // Nursery::create([
        //     'name' => 'Nursery 2',
        //     'email' => 'nursery2@gmail.com',
        //     'phone' => '01000111333',
        //     'country' => 'Egypt',
        //     'city' => 'Helioplis',
        //     'address' => 'Helioplis',
        //     'about' => 'About test for nursery 2',
        //     'branches_number' => 20,
        // ]);

        // $user_2 = User::create([
        //     'name' => 'Nursery 2',
        //     'email' => 'nursery2@gmail.com',
        //     'phone' => '01000111333',
        //     'password' => '12345test',
        //     'nursery_id' => 2,
        // ]);
        // $user_2->syncRoles(['owner']);
        // $permssions = Permission::all();
        // $user_2->syncPermissions(collect($permssions)->toArray());
    }
}
