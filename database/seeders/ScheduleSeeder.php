<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('schedules')->delete();

        $schedules = [];

        $subjects = DB::table('prospectus_subjects')->skip(0)->take(2)->pluck('id');
        $day = DB::table('days')->skip(0)->take(1)->pluck('id');
        $section = DB::table('days')->skip(0)->take(1)->pluck('id');

        foreach ($subjects as $subject) {
            $schedules[] = ['prospectus_subject_id' => $subject, 'day_id' => $day[0], 'section_id' => $section[0], 'start_time' => now(), 'end_time' => now(),
                'created_at' => now(), 'updated_at' => now()];
        }

        DB::table('schedules')->insert($schedules);
    }
}