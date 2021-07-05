<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProspectusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('prospectuses')->delete();

        $prospectuses = [
            ['level_id' => 14, 'program_id' => 1, 'strand_id' => null, 'term_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 14, 'program_id' => 1, 'strand_id' => null, 'term_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 15, 'program_id' => 1, 'strand_id' => null, 'term_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 15, 'program_id' => 1, 'strand_id' => null, 'term_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 16, 'program_id' => 1, 'strand_id' => null, 'term_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 16, 'program_id' => 1, 'strand_id' => null, 'term_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 17, 'program_id' => 1, 'strand_id' => null, 'term_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 17, 'program_id' => 1, 'strand_id' => null, 'term_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 14, 'program_id' => 2, 'strand_id' => null, 'term_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 14, 'program_id' => 2, 'strand_id' => null, 'term_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 15, 'program_id' => 2, 'strand_id' => null, 'term_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 15, 'program_id' => 2, 'strand_id' => null, 'term_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 16, 'program_id' => 2, 'strand_id' => null, 'term_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 16, 'program_id' => 2, 'strand_id' => null, 'term_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 17, 'program_id' => 2, 'strand_id' => null, 'term_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 17, 'program_id' => 2, 'strand_id' => null, 'term_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 14, 'program_id' => 3, 'strand_id' => null, 'term_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 14, 'program_id' => 3, 'strand_id' => null, 'term_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 15, 'program_id' => 3, 'strand_id' => null, 'term_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 15, 'program_id' => 3, 'strand_id' => null, 'term_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 16, 'program_id' => 3, 'strand_id' => null, 'term_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 16, 'program_id' => 3, 'strand_id' => null, 'term_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 17, 'program_id' => 3, 'strand_id' => null, 'term_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 17, 'program_id' => 3, 'strand_id' => null, 'term_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 14, 'program_id' => 4, 'strand_id' => null, 'term_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 14, 'program_id' => 4, 'strand_id' => null, 'term_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 15, 'program_id' => 4, 'strand_id' => null, 'term_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 15, 'program_id' => 4, 'strand_id' => null, 'term_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 16, 'program_id' => 4, 'strand_id' => null, 'term_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 16, 'program_id' => 4, 'strand_id' => null, 'term_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 17, 'program_id' => 4, 'strand_id' => null, 'term_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 17, 'program_id' => 4, 'strand_id' => null, 'term_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 14, 'program_id' => 5, 'strand_id' => null, 'term_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 14, 'program_id' => 5, 'strand_id' => null, 'term_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 15, 'program_id' => 5, 'strand_id' => null, 'term_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 15, 'program_id' => 5, 'strand_id' => null, 'term_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 16, 'program_id' => 5, 'strand_id' => null, 'term_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 16, 'program_id' => 5, 'strand_id' => null, 'term_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 17, 'program_id' => 5, 'strand_id' => null, 'term_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 17, 'program_id' => 5, 'strand_id' => null, 'term_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 14, 'program_id' => 6, 'strand_id' => null, 'term_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 14, 'program_id' => 6, 'strand_id' => null, 'term_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 15, 'program_id' => 6, 'strand_id' => null, 'term_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 15, 'program_id' => 6, 'strand_id' => null, 'term_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 16, 'program_id' => 6, 'strand_id' => null, 'term_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 16, 'program_id' => 6, 'strand_id' => null, 'term_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 17, 'program_id' => 6, 'strand_id' => null, 'term_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 17, 'program_id' => 6, 'strand_id' => null, 'term_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 12, 'program_id' => null, 'strand_id' => 1, 'term_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 12, 'program_id' => null, 'strand_id' => 1, 'term_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 13, 'program_id' => null, 'strand_id' => 1, 'term_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 13, 'program_id' => null, 'strand_id' => 1, 'term_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 12, 'program_id' => null, 'strand_id' => 2, 'term_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 12, 'program_id' => null, 'strand_id' => 2, 'term_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 13, 'program_id' => null, 'strand_id' => 2, 'term_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 13, 'program_id' => null, 'strand_id' => 2, 'term_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 12, 'program_id' => null, 'strand_id' => 3, 'term_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 12, 'program_id' => null, 'strand_id' => 3, 'term_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 13, 'program_id' => null, 'strand_id' => 3, 'term_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 13, 'program_id' => null, 'strand_id' => 3, 'term_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 12, 'program_id' => null, 'strand_id' => 4, 'term_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 12, 'program_id' => null, 'strand_id' => 4, 'term_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 13, 'program_id' => null, 'strand_id' => 4, 'term_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 13, 'program_id' => null, 'strand_id' => 4, 'term_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 12, 'program_id' => null, 'strand_id' => 5, 'term_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 12, 'program_id' => null, 'strand_id' => 5, 'term_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 13, 'program_id' => null, 'strand_id' => 5, 'term_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 13, 'program_id' => null, 'strand_id' => 5, 'term_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 12, 'program_id' => null, 'strand_id' => 6, 'term_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 12, 'program_id' => null, 'strand_id' => 6, 'term_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 13, 'program_id' => null, 'strand_id' => 6, 'term_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 13, 'program_id' => null, 'strand_id' => 6, 'term_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 12, 'program_id' => null, 'strand_id' => 7, 'term_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 12, 'program_id' => null, 'strand_id' => 7, 'term_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 13, 'program_id' => null, 'strand_id' => 7, 'term_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 13, 'program_id' => null, 'strand_id' => 7, 'term_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 12, 'program_id' => null, 'strand_id' => 8, 'term_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 12, 'program_id' => null, 'strand_id' => 8, 'term_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 13, 'program_id' => null, 'strand_id' => 8, 'term_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 13, 'program_id' => null, 'strand_id' => 8, 'term_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 12, 'program_id' => null, 'strand_id' => 9, 'term_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 12, 'program_id' => null, 'strand_id' => 9, 'term_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 13, 'program_id' => null, 'strand_id' => 9, 'term_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 13, 'program_id' => null, 'strand_id' => 9, 'term_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 11, 'program_id' => null, 'strand_id' => null, 'term_id' => null, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 10, 'program_id' => null, 'strand_id' => null, 'term_id' => null, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 9, 'program_id' => null, 'strand_id' => null, 'term_id' => null, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 8, 'program_id' => null, 'strand_id' => null, 'term_id' => null, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 7, 'program_id' => null, 'strand_id' => null, 'term_id' => null, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 6, 'program_id' => null, 'strand_id' => null, 'term_id' => null, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 5, 'program_id' => null, 'strand_id' => null, 'term_id' => null, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 4, 'program_id' => null, 'strand_id' => null, 'term_id' => null, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 3, 'program_id' => null, 'strand_id' => null, 'term_id' => null, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 2, 'program_id' => null, 'strand_id' => null, 'term_id' => null, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 1, 'program_id' => null, 'strand_id' => null, 'term_id' => null, 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('prospectuses')->insert($prospectuses);
    }
}
