<?php

namespace App\Services\Prospectus;

use App\Models\ProspectusSubject;

class CoRequisiteService
{
    public function store(ProspectusSubject $prospectusSubject, array $coRequisites)
    {
        $coRequisites = array_filter($coRequisites);
        $coRequisites = array_unique($coRequisites);

        $prospectusSubject->corequisites()->attach($coRequisites);
    }

    public function update(ProspectusSubject $prospectusSubject, array $coRequisites)
    {
        if ($prospectusSubject->corequisites->isNotEmpty()) $prospectusSubject->corequisites()->detach();

        $this->store($prospectusSubject, $coRequisites);
    }
}
