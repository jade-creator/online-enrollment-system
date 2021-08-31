<?php

namespace App\Services\Prospectus;

use App\Models\ProspectusSubject;

class ProspectusSubjectService
{
    public function store(ProspectusSubject $prospectusSubject, string $prospectusId, array $preRequisites)
    {
        $prospectusSubject->prospectus_id = $prospectusId;
        $prospectusSubject->save();

        (new PreRequisiteService())->store($prospectusSubject, $preRequisites);
    }

    public function update(ProspectusSubject $prospectusSubject, array $preRequisites)
    {
        $prospectusSubject->update();

        (new PreRequisiteService())->update($prospectusSubject, $preRequisites);
    }

    public function destroy(ProspectusSubject $prospectusSubject)
    {
        $prospectusSubject->delete();
    }
}
