<?php

namespace App\Services\Section;

use App\Models;

class SectionService
{
    /**
     * @throws \Exception
     */
    public function find($programId, $levelId, $termId) : Models\Prospectus
    {
        $prospectus = Models\Prospectus::select(['id'])
            ->where([
                'program_id' => $programId,
                'level_id' => $levelId,
                'term_id' => $termId,
            ])
            ->first();

        if (is_null($prospectus)) throw new \Exception("Prospectus doesn't exists.");

        if ($prospectus->subjects->isEmpty()) throw new \Exception('Please add subject/s first under this prospectus.');

        return $prospectus;
    }

    /**
     * @throws \Exception
     */
    public function store($programId, $levelId, $termId, Models\Section $section) : Models\Section
    {
        $prospectus = $this->find($programId, $levelId, $termId);

        $section->prospectus_id = $prospectus->id;
        $section->seat = 0;
        $section->save();

        return $section;
    }

    /**
     * @throws \Exception
     */
    public function update($programId, $levelId, $termId, Models\Section $section) : Models\Section
    {
        $prospectus = $this->find($programId, $levelId, $termId);

        $section->prospectus_id = $prospectus->id;
        $section->update();

        return $section;
    }

    public function destroy(Models\Section $section) : Models\Section
    {
        $section->delete();

        return $section;
    }
}
