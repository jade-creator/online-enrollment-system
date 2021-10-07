<?php

namespace App\Services\Faculty;

use App\Models\Faculty;

class FacultyService
{
    public function store(Faculty $faculty): Faculty
    {
        $faculty->save();

        return $faculty;
    }

    public function update(Faculty $faculty): Faculty
    {
        $faculty->update();

        return $faculty;
    }

    public function destroy(Faculty $faculty): Faculty
    {
        $faculty->delete();

        return $faculty;
    }
}
