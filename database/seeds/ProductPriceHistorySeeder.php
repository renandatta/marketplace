<?php

use App\Product;
use App\ProductPriceHistory;
use Illuminate\Database\Seeder;

class ProductPriceHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (Product::all() as $product) {
            for ($i = 0; $i <= rand(3, 5); $i++) {
                ProductPriceHistory::create([
                    'product_id' => $product->id,
                    'price' => $product->price - intval(mt_rand(100, 500))
                ]);
            }
        }
    }
}
