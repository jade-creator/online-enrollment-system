<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            CountrySeeder::class,
            SchoolTypeSeeder::class,
            LevelSeeder::class,
            SchoolYearSeeder::class,
            ProgramSeeder::class,
            TrackSeeder::class,
            StrandSeeder::class,
            TermSeeder::class, 
            ProspectusSeeder::class,
            SubjectSeeder::class,
            RoomSeeder::class,
            StatusSeeder::class,
            MarkSeeder::class,
        ]);
    }
}
