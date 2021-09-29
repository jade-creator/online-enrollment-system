<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TermSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('terms')->delete();
        $terms = [
            [ 'term' => '1st Semester',  'created_at' => now(), 'updated_at' => now()],
            [ 'term' => '2nd Semester',  'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('terms')->insert($terms);
    }
}
