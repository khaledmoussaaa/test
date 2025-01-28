<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            LaratrustSeeder::class, // Laratrust Seeder
            SuperAdminSeeder::class, // Laratrust Seeder
            NurserySeeder::class, // Nursery Seeder
        ]);
    }
}
