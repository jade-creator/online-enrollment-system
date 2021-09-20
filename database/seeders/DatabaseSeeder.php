<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

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
            ProgramSeeder::class,
            TermSeeder::class,
            ProspectusSeeder::class,
            SubjectSeeder::class,
            RoomSeeder::class,
            StatusSeeder::class,
            MarkSeeder::class,
            AdminSeeder::class,
            StudentSeeder::class,
            GuardianSeeder::class,
            SectionSeeder::class,
            DaySeeder::class,
            CategorySeeder::class,
        ]);
    }
}
