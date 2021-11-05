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

        $setting = [
            'profile_photo_path' => 'https://drive.google.com/uc?export=view&id=1l2yy9vCB5pFaJwewAGiiOMU3BmQdsG8Q',
            'school_name' => 'University',
            'school_email' => 'olcollegeenrollmentsystem@gmail.com',
            'auto_account_approval' => 1,
            'allow_irregular_student_to_enroll' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];

        DB::table('settings')->insert($setting);
    }
}
