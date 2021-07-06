<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SchoolTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('school_types')->delete();

        $types = [
            [ 'type' => 'Elementary',  'created_at' => now(), 'updated_at' => now()],
            [ 'type' => 'Junior High School',  'created_at' => now(), 'updated_at' => now()],
            [ 'type' => 'Senior High School',  'created_at' => now(), 'updated_at' => now()],
            [ 'type' => 'College',  'created_at' => now(), 'updated_at' => now()],
            [ 'type' => 'Alternative Learning System Accreditation And Equivalency',  'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('school_types')->insert($types);
    }
}
