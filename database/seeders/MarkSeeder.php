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
            ['name' => 'tba', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'dropped', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'failed', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'passed', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('marks')->insert($marks);
    }
}
