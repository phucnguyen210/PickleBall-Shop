<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->unique()->name();
        $slug = Str::slug($title);
        $sub_categories = [20,21];
        $subCatergoryRand = array_rand($sub_categories);
        $brand = [3,5,6,8,10,14,25];
        $brandRand = array_rand($brand);
        return [
            'title' => $title,
            'slug' => $slug,
            'category_id' => 57,
            'sub_category_id' => $sub_categories[ $subCatergoryRand],
            'brand_id' =>  $brand[$brandRand],
            'price' => rand(50, 20000),
            'sku' => rand(1000, 10000),
            'track_qty' => 'Yes',
            'qty' => 10,
            'status' => 1,
            'is_featured' => 'Yes',



        ];
    }
}
