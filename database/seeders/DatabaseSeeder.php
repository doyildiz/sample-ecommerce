<?php

namespace Database\Seeders;

use App\Models\Option;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Product::factory()->count(6)
            ->has(
                Option::factory()
                    ->count(3)
                    ->state(function (array $attributes, Product $product) {
                        return ['product_id' => $product->id];
                    }),
                'options'
            )
            ->create();
    }
}
