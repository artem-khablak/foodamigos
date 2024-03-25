<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        foreach (range(1, 20) as $index) {
            DB::table('products')->insert([
                'name' => $faker->word,
                'quantity' => $faker->numberBetween(100, 500),
                'price' => $faker->randomFloat(2, 3, 5), // Generate a random float between 3 and 5
            ]);
        }
    }
}
