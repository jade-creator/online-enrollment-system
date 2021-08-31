<?php

namespace App\Services\Prospectus;

use App\Models\ProspectusSubject;

class PreRequisiteService
{
    public function store(ProspectusSubject $prospectusSubject, array $preRequisites)
    {
        $preRequisites = array_filter($preRequisites);
        $preRequisites = array_unique($preRequisites);

        $prospectusSubject->prerequisites()->attach($preRequisites);
    }

    public function update(ProspectusSubject $prospectusSubject, array $preRequisites)
    {
        if ($prospectusSubject->prerequisites->isNotEmpty()) $prospectusSubject->prerequisites()->detach();

        $this->store($prospectusSubject, $preRequisites);
    }
}
