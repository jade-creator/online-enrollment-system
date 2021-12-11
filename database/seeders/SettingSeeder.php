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
            'profile_photo_path' => 'https://res.cloudinary.com/ds2znjplk/image/upload/v1636794692/ue5w8r6b4rneytnblmnk.svg',
            'school_name' => 'University',
            'school_email' => 'olcollegeenrollmentsystem@gmail.com',
            'school_address' => 'Alcalde St., Kapisagan Pasig City',
            'auto_account_approval' => 1,
            'allow_irregular_student_to_enroll' => 1,
            'max_slots' => 40,
            'downpayment_minimum_percentage' => 30,
            'created_at' => now(),
            'updated_at' => now()
        ];

        DB::table('settings')->insert($setting);
    }
}
