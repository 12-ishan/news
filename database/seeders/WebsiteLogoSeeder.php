<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin\WebsiteLogo;
use Illuminate\Support\Facades\DB;

class WebsiteLogoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('global_settings')->insert([
        [
            'page_title' => 'Home',
            'favicon' => 1,
            'imageId' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        
    ]);
}
    }

