<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rooms')->delete();

        $rooms = [
            ['name' => 'RM 101', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'RM 102', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'RM 103', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'RM 104', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'RM 105', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('rooms')->insert($rooms);
    }
}
