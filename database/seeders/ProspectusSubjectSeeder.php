<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProspectusSubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('prospectus_subjects')->delete();

        $bsitProspectuses = DB::table('prospectuses')->where('program_id', 1)->pluck('id');
        $subjects = DB::table('subjects')->skip(0)->take(16)->pluck('id');
        $prospectusSubjects = [];
        $index = 0;

        foreach ($bsitProspectuses as $prospectus) {
            for ($loop = 0; $loop <= 1; $loop++) {
                $prospectusSubjects[] = ['prospectus_id' => $prospectus, 'subject_id' => $subjects[$index], 'unit' => 3, 'created_at' => now(), 'updated_at' => now()];
                $index++;
            }
        }

        DB::table('prospectus_subjects')->insert($prospectusSubjects);
    }
}
