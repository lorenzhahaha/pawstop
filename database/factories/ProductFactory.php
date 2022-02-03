<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->firstName,
            'category' => $this->faker->randomElement([
                "Working",
                "Companion",
                "Herding",
                "Hound",
                "Hybrid",
                "Sporting",
                "Terrier",
            ]),
            'description' => $this->faker->sentence(50),
            'available_at' => $this->faker->dateTimeThisMonth(),
            'created_by' => $this->faker->unique()->userName(),
        ];
    }
}
