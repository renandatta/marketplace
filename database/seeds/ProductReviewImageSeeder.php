<?php

use App\ProductReview;
use App\ProductReviewImage;
use Illuminate\Database\Seeder;

class ProductReviewImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (ProductReview::all() as $productReview) {
            for ($i = 0; $i <= rand(0, 2); $i++) {
                ProductReviewImage::create([
                    'product_review_id' => $productReview->id,
                    'location' => 'https://picsum.photos/id/'. mt_rand(000, 200) .'/400'
                ]);
            }
        }
    }
}
