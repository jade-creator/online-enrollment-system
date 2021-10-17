<?php

namespace Database\Seeders;

use App\Models\Program;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurriculumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('curricula')->delete();

        $programs = Program::get(['id', 'code', 'program']);
        $curricula = [];

        foreach($programs as $program) {
            $curricula[] = ['program_id' => $program->id, 'code' => $program->code.'2021', 'description' => null,
                'isActive' => 1, 'start_date' => now(), 'end_date' => now(), 'created_at' => now(), 'updated_at' => now()];
        }

        DB::table('curricula')->insert($curricula);
    }
}
