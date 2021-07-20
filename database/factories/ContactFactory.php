<?php

namespace Database\Factories;

use App\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Contact::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'address' => $this->faker->address,
            'mobile_number' => function() {
                $result = '0';

                for ($index=0; $index < 10; $index++) { 
                    $result .= mt_rand(0, 9);
                }

                return $result;
            },
        ];
    }
}
