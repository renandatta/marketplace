<?php

use App\FeaturedProduct;
use App\FeaturedProductDetail;
use Illuminate\Database\Seeder;

class FeaturedProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        FeaturedProduct::insert([
            ['name' => 'Best Seller', 'image' => 'https://picsum.photos/id/'. mt_rand(000, 200) .'/400'],
            ['name' => 'This Month Special', 'image' => 'https://picsum.photos/id/'. mt_rand(000, 200) .'/400'],
            ['name' => 'Favorite', 'image' => 'https://picsum.photos/id/'. mt_rand(000, 200) .'/400'],
            ['name' => 'For You', 'image' => 'https://picsum.photos/id/'. mt_rand(000, 200) .'/400'],
            ['name' => 'Promotion', 'image' => 'https://picsum.photos/id/'. mt_rand(000, 200) .'/400'],
        ]);
        for ($j = 1; $j <= 5; $j++) {
            for ($i = 0; $i <= rand(6, 9); $i++) {
                FeaturedProductDetail::create([
                    'featured_product_id' => $j,
                    'product_id' => rand(1, 200),
                    'order' => $i,
                ]);
            }
        }
    }
}
