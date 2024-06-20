<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Item;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 150) as $index) {
            $name = $faker->word();
            Category::create([
                'name' => $name,
                'sort_order' => rand(1, 10),
                'is_active' => $faker->boolean(75),
            ]);
        }
    }
}
