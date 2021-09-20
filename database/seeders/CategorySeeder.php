<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            ['name' => 'Tuition Fee', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Miscellaneous Fee', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Other Fees', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('categories')->insert($categories);
    }
}
