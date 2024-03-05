<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    // protected $model = Product::class;

        
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(2),
            'image' => 'https://via.placeholder.com/150', // Placeholder image
            'price' => $this->faker->numberBetween(10000, 100000),
            // Create a related user & user must be verify his email
            'user_id' => User::factory()->verified()->create()->id,
        ];
    }
}
