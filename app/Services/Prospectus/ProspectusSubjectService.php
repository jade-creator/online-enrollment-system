<?php

namespace App\Services\Prospectus;

use App\Models\Prospectus;
use App\Models\ProspectusSubject;

class ProspectusSubjectService
{
    public function store(ProspectusSubject $prospectusSubject, string $prospectusId, array $preRequisites) : ProspectusSubject
    {
        $prospectusSubject->prospectus_id = $prospectusId;
        $prospectusSubject->save();

        (new PreRequisiteService())->store($prospectusSubject, $preRequisites);

        return $prospectusSubject;
    }

    public function update(ProspectusSubject $prospectusSubject, array $preRequisites) : ProspectusSubject
    {
        $prospectusSubject->update();

        (new PreRequisiteService())->update($prospectusSubject, $preRequisites);

        return $prospectusSubject;
    }

    public function destroy(ProspectusSubject $prospectusSubject) : bool
    {
        return $prospectusSubject->delete();
    }

    /**
     * @throws \Exception
     */
    public function register($programId, $levelId, $termId) : Prospectus
    {
        $prospectus = Prospectus::select(['id', 'level_id', 'program_id', 'term_id'])
            ->with('subjects.prerequisites')
            ->where([
               ['program_id', $programId],
               ['level_id', $levelId],
               ['term_id', $termId],
            ])
            ->first();

        if (is_null($prospectus)) throw new \Exception("Prospectus doesn't exist.");

        if (! $prospectus->subjects()->exists()) throw new \Exception('There are no subjects yet under this prospectus. If error persists please contact the admins.');

        return $prospectus;
    }
}
