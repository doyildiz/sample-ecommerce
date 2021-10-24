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
            'name' => 'Product-'.strtoupper($this->faker->randomLetter),
            'stock' => $this->faker->numberBetween($min = 3, $max = 50),
            'price' => $this->faker->numberBetween($min = 150, $max = 600),
        ];
    }
}
