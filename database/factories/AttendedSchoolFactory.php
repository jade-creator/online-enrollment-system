<?php

namespace Database\Factories;

use App\Models\AttendedSchool;
use App\Models\Level;
use App\Models\SchoolType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class AttendedSchoolFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AttendedSchool::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $schoolType = SchoolType::select('id')->inRandomOrder()->first();
        $level = Level::select('id')->inRandomOrder()->first();

        return [
            'name' => $this->faker->city,
            'date_graduated' => Carbon::now()->format('Y-m-d'),
            'program' => $this->faker->text,
            'school_type_id' => $schoolType->id,
            'level_id' => $level->id,
        ];
    }
}
