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
            SettingSeeder::class,
            RoleSeeder::class,
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
            CurriculumSeeder::class,
            UserSeeder::class,
            StudentSeeder::class,
            GuardianSeeder::class,
            DaySeeder::class,
            CategorySeeder::class,
            FacultySeeder::class,

            /*test*/
//            SectionSeeder::class,
//            AdminSeeder::class,
//            ProspectusSubjectSeeder::class,
//            ScheduleSeeder::class,
//            FeeSeeder::class,
        ]);
    }
}
