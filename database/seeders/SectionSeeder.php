<?php

namespace Database\Seeders;

use App\Models\Prospectus;
use App\Models\Room;
use App\Models\Section;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SectionSeeder extends Seeder
{
    public $name = '';
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $prospectuses = Prospectus::select(['id', 'program_id', 'level_id', 'term_id'])
                    ->with([
                        'program:id,code',
                        'level:id,level',
                        'term:id,term',
                    ])
                    ->get();

        $sectionNames = ['A', 'B'];

        $prospectuses->map(function($prospectus) use ($sectionNames) {
            foreach ($sectionNames as $sectionName) {
                $room = Room::select('id')->inRandomOrder()->first();

                $this->name = $prospectus->program->code . "-" . $prospectus->level->level[0] . $sectionName;

                Section::create([
                    'name' => $this->name,
                    'prospectus_id' => $prospectus->id,
                    'room_id' => $room->id,
                    'seat' => mt_rand(30, 40),
                ]);
            }
        });
    }
}
