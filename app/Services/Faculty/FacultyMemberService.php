<?php

namespace App\Services\Faculty;

use App\Models\Employee;

class FacultyMemberService
{
    public function remove(Employee $employee) : Employee
    {
        $employee->faculty_id = null;
        $employee->update();

        return $employee;
    }

    public function add(string $facultyId, array $employees)
    {
        return Employee::where('id', $employees)->update([
            'faculty_id' => $facultyId,
        ]);
    }
}
