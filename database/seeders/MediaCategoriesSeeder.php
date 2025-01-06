<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MediaCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('media_category')->insert([

            [
                'name' => 'Default',
                'slug' => 'default',
                'status' => 1,
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
           
            
        ]);
    }
}
