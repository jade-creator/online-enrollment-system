<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SchoolYearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('school_years')->delete();

        $years = [
            [ 'from_date' => Carbon::parse('2019-01-01'), 'to_date' => Carbon::parse('2020-01-01')],
            [ 'from_date' => Carbon::parse('2020-01-01'), 'to_date' => Carbon::parse('2021-01-01')]
        ];

        DB::table('school_years')->insert($years);
    }
}
