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
            ['code' => 'CCS', 'name' => 'College of Computer Studies', 'description' => 'Lorem Ipsum Test.', 'mission' => null, 'vision' => null, 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('faculties')->insert($faculties);
    }
}
