<?php

namespace Database\Seeders;

use App\Models\AttendedSchool;
use App\Models\Contact;
use App\Models\Detail;
use App\Models\Person;
use App\Models\Program;
use App\Models\Role;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::where('name', 'student')->first();
        $programs = Program::get(['id', 'program'])->pluck('id')->toArray();

        Person::factory()->count(199)->create()->each(function ($person) use ($role, $programs) {
            $person->user()->save(
                User::factory()->make([
                    'role_id' => $role->id,
                ])
            );

            $person->contact()->save(Contact::factory()->make());

            $person->detail()->save(Detail::factory()->make());

            $student = new Student([
                'custom_id' => null,
                'program_id' => $programs[array_rand($programs)],
            ]);
            $person->user->student()->save($student);
            $person->user->student->custom_id = $person->user->student->id;
            $person->user->student->save();

            $person->user->student->attendedSchool()->save(AttendedSchool::factory()->make());
        });
    }
}
