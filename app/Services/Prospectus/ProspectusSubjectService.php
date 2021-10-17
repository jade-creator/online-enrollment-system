<?php

namespace App\Services\Prospectus;

use App\Models\Curriculum;
use App\Models\Prospectus;
use App\Models\ProspectusSubject;

class ProspectusSubjectService
{
    /**
     * @throws \Exception
     */
    public function isAllowed(string $curriculumId)
    {
        if (empty($curriculumId)) throw new \Exception('No curriculum found!');

        $curriculum = Curriculum::with('registrations')->find($curriculumId);

        if (filled($curriculum) && isset($curriculum->registrations) && $curriculum->registrations->isNotEmpty()) {
            throw new \Exception('Not Allowed! There are already students registered under this curriculum.');
        }
    }

    public function store(ProspectusSubject $prospectusSubject, string $prospectusId, string $curriculumId, array $preRequisites, array $coRequisites) : ProspectusSubject
    {
        $this->isAllowed($curriculumId);

        $prospectusSubject->curriculum_id = $curriculumId;
        $prospectusSubject->prospectus_id = $prospectusId;
        $prospectusSubject->save();

        (new PreRequisiteService())->store($prospectusSubject, $preRequisites);
        (new CoRequisiteService())->store($prospectusSubject, $coRequisites);

        return $prospectusSubject;
    }

    public function update(ProspectusSubject $prospectusSubject, string $curriculumId, array $preRequisites, array $coRequisites) : ProspectusSubject
    {
        $this->isAllowed($curriculumId);

        $prospectusSubject->update();

        (new PreRequisiteService())->update($prospectusSubject, $preRequisites);
        (new CoRequisiteService())->update($prospectusSubject, $coRequisites);

        return $prospectusSubject;
    }

    public function destroy(ProspectusSubject $prospectusSubject, string $curriculumId) : bool
    {
        $this->isAllowed($curriculumId);

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
