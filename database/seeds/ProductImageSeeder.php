<?php

use App\Product;
use App\ProductImage;
use Illuminate\Database\Seeder;

class ProductImageSeeder extends Seeder
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
                ProductImage::create([
                    'product_id' => $product->id,
                    'location' => 'https://picsum.photos/id/'. mt_rand(000, 200) .'/400'
                ]);
            }
        }
    }
}
