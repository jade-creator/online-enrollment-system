<?php

namespace App\Services\Prospectus;

use App\Models;

class ProspectusService
{
    /**
     * @throws \Exception
     */
    public function store(Models\Program $program)
    {
        $type = Models\SchoolType::where('type', 'College')
            ->with('levels')
            ->first();

        if (empty($type)) throw new \Exception('College type not found. Please contact the admins.');

        $terms = Models\Term::get(['id']);
        $levelIds = $type->levels->pluck('id')->toArray();
        sort($levelIds);

        $prospectuses = [];
        foreach ($levelIds as $key => $levelId) {

            if ($key >= $program->year) {
                break;
            }

            foreach ($terms as $term) {
                $prospectuses[] = [
                    'level_id' => $levelId,
                    'program_id' => $program->id,
                    'term_id' => $term->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        Models\Prospectus::insert($prospectuses);
    }
}
