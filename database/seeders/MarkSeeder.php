<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MarkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('marks')->delete();

        $marks = [
            ['name' => 'TBA', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Dropped', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Failed', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Passed', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('marks')->insert($marks);
    }
}
