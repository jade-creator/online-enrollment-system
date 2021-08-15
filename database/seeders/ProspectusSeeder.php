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
            ['level_id' => 14, 'program_id' => 1, 'term_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 14, 'program_id' => 1, 'term_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 15, 'program_id' => 1, 'term_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 15, 'program_id' => 1, 'term_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 16, 'program_id' => 1, 'term_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 16, 'program_id' => 1, 'term_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 17, 'program_id' => 1, 'term_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 17, 'program_id' => 1, 'term_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 14, 'program_id' => 2, 'term_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 14, 'program_id' => 2, 'term_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 15, 'program_id' => 2, 'term_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 15, 'program_id' => 2, 'term_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 16, 'program_id' => 2, 'term_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 16, 'program_id' => 2, 'term_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 17, 'program_id' => 2, 'term_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 17, 'program_id' => 2, 'term_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 14, 'program_id' => 3, 'term_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 14, 'program_id' => 3, 'term_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 15, 'program_id' => 3, 'term_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 15, 'program_id' => 3, 'term_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 16, 'program_id' => 3, 'term_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 16, 'program_id' => 3, 'term_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 17, 'program_id' => 3, 'term_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 17, 'program_id' => 3, 'term_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 14, 'program_id' => 4, 'term_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 14, 'program_id' => 4, 'term_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 15, 'program_id' => 4, 'term_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 15, 'program_id' => 4, 'term_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 16, 'program_id' => 4, 'term_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 16, 'program_id' => 4, 'term_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 17, 'program_id' => 4, 'term_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 17, 'program_id' => 4, 'term_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 14, 'program_id' => 5, 'term_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 14, 'program_id' => 5, 'term_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 15, 'program_id' => 5, 'term_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 15, 'program_id' => 5, 'term_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 16, 'program_id' => 5, 'term_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 16, 'program_id' => 5, 'term_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 17, 'program_id' => 5, 'term_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 17, 'program_id' => 5, 'term_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 14, 'program_id' => 6, 'term_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 14, 'program_id' => 6, 'term_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 15, 'program_id' => 6, 'term_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 15, 'program_id' => 6, 'term_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 16, 'program_id' => 6, 'term_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 16, 'program_id' => 6, 'term_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 17, 'program_id' => 6, 'term_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 17, 'program_id' => 6, 'term_id' => 2, 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('prospectuses')->insert($prospectuses);
    }
}
