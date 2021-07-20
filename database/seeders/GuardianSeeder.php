<?php

namespace Database\Seeders;

use App\Models\Contact;
use App\Models\Detail;
use App\Models\Guardian;
use App\Models\Person;
use App\Models\Student;
use Illuminate\Database\Seeder;

class GuardianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $students = Student::get('id');

        if ($students) {
            foreach ($students as $student) {
            
                $person = Person::factory()->create();
                $person->guardian()->save(
                    Guardian::factory()->make([
                        'person_id' => $person->id,
                        'student_id' => $student->id,
                    ])
                );
    
                $person->contact()->save(Contact::factory()->make());
    
                $person->detail()->save(Detail::factory()->make());
            }
        }
    }
}
