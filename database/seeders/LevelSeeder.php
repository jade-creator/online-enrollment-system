<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('levels')->delete();

        $levels = [
            [ 'level' => 'Kindergarten', 'school_type_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            [ 'level' => 'Grade 1', 'school_type_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            [ 'level' => 'Grade 2', 'school_type_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            [ 'level' => 'Grade 3', 'school_type_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            [ 'level' => 'Grade 4', 'school_type_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            [ 'level' => 'Grade 5', 'school_type_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            [ 'level' => 'Grade 6', 'school_type_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            [ 'level' => 'Grade 7', 'school_type_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            [ 'level' => 'Grade 8', 'school_type_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            [ 'level' => 'Grade 9', 'school_type_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            [ 'level' => 'Grade 10', 'school_type_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            [ 'level' => 'Grade 11', 'school_type_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            [ 'level' => 'Grade 12', 'school_type_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            [ 'level' => '1st Year', 'school_type_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            [ 'level' => '2nd Year', 'school_type_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            [ 'level' => '3rd Year', 'school_type_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            [ 'level' => '4th Year', 'school_type_id' => 4, 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('levels')->insert($levels);
    }
}
