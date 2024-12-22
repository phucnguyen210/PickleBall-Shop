<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {

        // Product::factory()->count(20)->create();
        \App\Models\User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make("admin123"),
            'role' => 1,
        ]);
        // Category::factory()->count(10)->create();
        // Brand::factory()->count(10)->create();

    }
}
// \App\Models\Product::factory(20)->create();