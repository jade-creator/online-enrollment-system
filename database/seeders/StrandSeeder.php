<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $strands = [
            ['code' => 'ABM', 'strand' => 'Accountancy, Business and Management', 'track_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'HUMSS', 'strand' => 'Humanities and Social Sciences', 'track_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'STEM', 'strand' => 'Science, Technology, Engineering, and Mathematics', 'track_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'GAS', 'strand' => 'General Academic Strand', 'track_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'A-F', 'strand' => 'Agri-Fishery', 'track_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'HE', 'strand' => 'Home Economics', 'track_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'ICT', 'strand' => 'Information, Communication and Technology', 'track_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'IA', 'strand' => 'Industrial Arts', 'track_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'TVLM', 'strand' => 'Technical Vocational Livelihood Maritime', 'track_id' => 2, 'created_at' => now(), 'updated_at' => now()],
        ];  

        DB::table('strands')->insert($strands);
    }
}
