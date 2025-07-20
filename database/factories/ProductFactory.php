<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Product;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->sentence(10),
            'code' => strtoupper(Str::random(8)),
            'amount' => $this->faker->randomFloat(2, 10, 1000),
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Product $product) {
            $product->variances()->createMany(
                \App\Models\ProductVariance::factory()->count(rand(1, 3))->make()->toArray()
            );
        });
    }
}
