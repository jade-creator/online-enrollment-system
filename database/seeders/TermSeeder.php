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
        $terms = [
            [ 'term' => '1st Term',  'created_at' => now(), 'updated_at' => now()],
            [ 'term' => '2nd Term',  'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('terms')->insert($terms);
    }
}
