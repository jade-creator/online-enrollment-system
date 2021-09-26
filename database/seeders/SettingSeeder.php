<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->delete();

        $setting = [ 'auto_account_approval' => 1, 'created_at' => now(), 'updated_at' => now()];

        DB::table('settings')->insert($setting);
    }
}
