<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FacultySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faculties = [
          ['name' => 'College of Computer Studies', 'program_id' => 1, 'description' => null, 'mission' => null, 'vision' => null, 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('faculties')->insert($faculties);
    }
}
