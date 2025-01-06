<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('role')->insert([
            [
                'name' => 'Admin',
                'slug' => 'admin',
                'status' => 1,
                'sortOrder' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Writer',
                'slug' => 'writer',
                'status' => 1,
                'sortOrder' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Editor',
                'slug' => 'editor',
                'status' => 1,
                'sortOrder' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
        ]);
    }
}
