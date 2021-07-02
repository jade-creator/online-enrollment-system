<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TrackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tracks = [
            ['track' => 'Academic', 'created_at' => now(), 'updated_at' => now()],
            ['track' => 'Technical Vocational Livelihood', 'created_at' => now(), 'updated_at' => now()],
            ['track' => 'Sports', 'created_at' => now(), 'updated_at' => now()],
            ['track' => 'Arts and Design', 'created_at' => now(), 'updated_at' => now()],
        ];
        
        DB::table('tracks')->insert($tracks);
    }
}
