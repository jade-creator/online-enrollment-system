<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->delete();
        $roles = [
            ['name' => 'admin', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'student', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'registrar', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'dean', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'faculty member', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('roles')->insert($roles);
    }
}
