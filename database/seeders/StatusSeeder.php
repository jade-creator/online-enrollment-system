<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('statuses')->delete();

        $statuses = [
            ['name' => 'pending', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'enrolled', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'denied', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'released', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('statuses')->insert($statuses);
    }
}
