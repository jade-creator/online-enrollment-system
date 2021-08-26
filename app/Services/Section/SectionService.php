<?php

namespace App\Services\Section;

use App\Models;

class SectionService
{
    public function store(int $programId, $levelId, $termId, Models\Section $section) : void
    {
        $prospectus = Models\Prospectus::select(['id'])
            ->with('subjects:id')
            ->where([
                'program_id' => $programId,
                'level_id' => $levelId,
                'term_id' => $termId,
            ])
            ->firstOrFail();

        if ($prospectus->subjects->isEmpty()) throw new \Exception('Please add subject/s first under this prospectus.');

        $section->prospectus_id = $prospectus->id;
        $section->save();

        $prospectus->subjects->map(function ($subject) use ($section) {
            $schedule = Models\Schedule::create([
                'subject_id' => $subject->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $schedule->sections()->attach([$section->id]);
        });
    }

    public function update(Models\Section $section) : Models\Section
    {
        $section->update();

        return $section;
    }

    public function destroy(Models\Section $section) : Models\Section
    {
        $section->delete();

        return $section;
    }
}
