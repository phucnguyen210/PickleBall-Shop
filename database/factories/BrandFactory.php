<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Brand;
use App\Models\Brand as ModelsBrand;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\brands>
 */
class BrandFactory extends Factory
{
    /**
     * Define the model's default state.
     * protected $model = Brand::class;
     *
     * @return array<string, mixed>
     */
    protected $model = Brand::class;

    public function definition(): array
    {
        return [
            //
            'name' => $this->faker->name(),
            'slug' => $this->faker->slug(),
            'status' => $this->faker->randomElement([0,1]),
        ];
    }
}
