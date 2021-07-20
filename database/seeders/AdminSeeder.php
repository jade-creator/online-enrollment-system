<?php

namespace Database\Seeders;

use App\Models\Contact;
use App\Models\Detail;
use App\Models\Role;
use App\Models\User;
use App\Models\Person;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::where('name', 'admin')->first();

        Person::factory()->count(4)->create()->each(function ($person) use ($role) {
            $person->user()->save(
                User::factory()->make([
                    'role_id' => $role->id,
                ])
            );

            $person->contact()->save(Contact::factory()->make());

            $person->detail()->save(Detail::factory()->make());
        });
    }
}
