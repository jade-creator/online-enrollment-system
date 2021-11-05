<?php

namespace Database\Seeders;

use App\Models\AttendedSchool;
use App\Models\Contact;
use App\Models\Detail;
use App\Models\Employee;
use App\Models\Person;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('qwert@1Q'),
                'email_verified_at' => now(),
                'role_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'jade',
                'email' => 'jade@gmail.com',
                'password' => Hash::make('qwert@1Q'),
                'email_verified_at' => now(),
                'role_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'andrew',
                'email' => 'andrew@gmail.com',
                'password' => Hash::make('qwert@1Q'),
                'email_verified_at' => now(),
                'role_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'pat',
                'email' => 'pat@gmail.com',
                'password' => Hash::make('qwert@1Q'),
                'email_verified_at' => now(),
                'role_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'reg',
                'email' => 'registrar@gmail.com',
                'password' => Hash::make('qwert@1Q'),
                'email_verified_at' => now(),
                'role_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'dean1',
                'email' => 'dean1@gmail.com',
                'password' => Hash::make('qwert@1Q'),
                'email_verified_at' => now(),
                'role_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'dean2',
                'email' => 'dean2@gmail.com',
                'password' => Hash::make('qwert@1Q'),
                'email_verified_at' => now(),
                'role_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'faculty1',
                'email' => 'faculty1@gmail.com',
                'password' => Hash::make('qwert@1Q'),
                'email_verified_at' => now(),
                'role_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'faculty2',
                'email' => 'faculty2@gmail.com',
                'password' => Hash::make('qwert@1Q'),
                'email_verified_at' => now(),
                'role_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'faculty3',
                'email' => 'faculty3@gmail.com',
                'password' => Hash::make('qwert@1Q'),
                'email_verified_at' => now(),
                'role_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        $persons = Person::factory()->count(count($users))->create();

        foreach ($persons as $key => $person) {
            $person->user()->save(new User($users[$key]));

            $person->contact()->save(Contact::factory()->make());

            $person->detail()->save(Detail::factory()->make());

            if ($users[$key]['role_id'] == 2) {
                $student = new Student([
                    'custom_id' => null,
                    'program_id' => 1,
                    'curriculum_id' => 1,
                ]);
                $person->user->student()->save($student);
                $person->user->student->custom_id = $person->user->student->id;
                $person->user->student->save();

                $person->user->student->attendedSchool()->save(AttendedSchool::factory()->make());
            } else {
                $employee = new Employee([
                    'custom_id' => null,
                ]);

                $person->user->employee()->save($employee);
                $person->user->employee->custom_id = $person->user->employee->id;
                $person->user->employee->save();
            }
        }
    }
}
