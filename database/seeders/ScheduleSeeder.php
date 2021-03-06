<?php

namespace Database\Seeders;

use App\Models\User;
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
        $schedules = [];

        $subjects = DB::table('prospectus_subjects')->skip(0)->take(5)->pluck('id');
        $day = DB::table('days')->skip(0)->take(1)->pluck('id');
        $users = User::with('employee')->whereIn('role_id', [4,5])->get()->pluck('employee.id')->toArray();

        foreach ($subjects as $index => $subject) {
            $schedules[] = ['prospectus_subject_id' => $subject, 'day_id' => $day[0], 'section_id' => 1, 'start_time' => now(),
                'end_time' => now(), 'created_at' => now(), 'updated_at' => now(), 'employee_id' => $users[$index]];
        }

        DB::table('schedules')->insert($schedules);
    }
}
