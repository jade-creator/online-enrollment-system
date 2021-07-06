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
        DB::table('tracks')->delete();
        $tracks = [
            ['track' => 'Academic', 'description' => 'This track appeals to those who have set their minds towards college education. Divided into degree-specific courses, the Academic track in senior high school aims to prepare students to more advanced university courses. Under this umbrella are four strands.', 'created_at' => now(), 'updated_at' => now()],
            ['track' => 'Technical Vocational Livelihood', 'description' => 'It calls out to eligible students with subjects focused on job-ready skills. Besides, it offers practical knowledge with matching certificates to help students land their desired job after they graduate from SHS. Under the senior high school tech-voc track are the following strands.', 'created_at' => now(), 'updated_at' => now()],
            ['track' => 'Sports', 'description' => 'Developed to equip SHS students with sports-related and physical fitness and safety knowledge, this track appeals to those who wish to venture into athletics, fitness, and recreational industries.', 'created_at' => now(), 'updated_at' => now()],
            ['track' => 'Arts and Design', 'description' => 'Inside this course, students with a penchant for the Arts can enroll in subjects that will hone their skills in visual design and the performing arts.', 'created_at' => now(), 'updated_at' => now()],
        ];
        
        DB::table('tracks')->insert($tracks);
    }
}
