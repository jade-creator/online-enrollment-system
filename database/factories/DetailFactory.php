<?php

namespace Database\Factories;

use App\Models\Country;
use App\Models\Detail;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class DetailFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Detail::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $country = Country::select('id')->inRandomOrder()->first();

        return [
            'gender' => $this->faker->randomElement(['Other', 'Male', 'Female', 'Prefer not to say']),
            'civil_status' => $this->faker->randomElement(['Single', 'Married', 'Divorced', 'Widowed', 'Prefer not to say']),
            'religion' => $this->faker->randomElement(['Other', 'Catholic Christianity', 'Protestant Christianity', 'Islam', 'Tribal', 'None']),
            'birthdate' => Carbon::now()->format('Y-m-d'),
            'birthplace' => $this->faker->city,
            'country_id' => $country->id,
        ];
    }
}
