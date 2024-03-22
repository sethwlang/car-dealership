<?php

namespace Database\Factories;

use App\Models\Car;
use Illuminate\Database\Eloquent\Factories\Factory;

class CarFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Car::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'model' => $this->faker->word,
            'year' => $this->faker->numberBetween(1990, 2022),
            'manufacturer_id' => function () {
                return \Database\Factories\ManufacturerFactory::new()->create()->id;
            },
            // Define other attributes as needed
        ];
    }
}
