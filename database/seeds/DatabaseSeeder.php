<?php

use App\Courier;
use App\CourierService;
use App\Product;
use App\ProductCategory;
use App\ProductDiscussion;
use App\ProductImage;
use App\ProductReview;
use App\Slider;
use App\Store;
use App\StoreOwner;
use App\User;
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
        $this->call(UserSeeder::class);

        /// Factory Faker
        factory(User::class, 50)->create();
//        factory(Courier::class, 5)->create()->each(function ($courier) {
//            $services = factory(CourierService::class, 2)->make();
//            $courier->services()->saveMany($services);
//        });
        factory(ProductCategory::class, 10)->create(['parent_code' => '#'])->each(function ($category) {
            $subCategories = factory(ProductCategory::class, 3)->make(['parent_code' => $category->code]);
            $category->sub()->savemany($subCategories);
        });
        factory(Slider::class, 3)->create();
        $this->call(StoreSeeder::class);
        factory(Store::class, 10)->create();
        factory(StoreOwner::class, 10)->create();
        factory(Product::class, 200)->create()->each(function ($product) {
            $discussions = factory(ProductDiscussion::class, 4)->make(['parent_id' => null, 'user_id' => rand(2, 50)]);
            $reviews = factory(ProductReview::class, rand(3, 5))->make();
            $product->discussions()->saveMany($discussions);
            $product->reviews()->saveMany($reviews);
        });
        foreach (Product::all() as $product) {
            foreach ($product->discussions as $discussion) {
                ProductDiscussion::create([
                    'product_id' => $product->id,
                    'user_id' => 1,
                    'parent_id' => $discussion->id,
                    'content' => 'Lorem ipsum sir dolor amet'
                ]);
            }
        }
        $this->call(ProductImageSeeder::class);
        $this->call(ProductPriceHistorySeeder::class);
        $this->call(ProductPriceHistorySeeder::class);
        $this->call(ProductReviewImageSeeder::class);
        $this->call(UserWishlistSeeder::class);
        $this->call(UserCartSeeder::class);
        $this->call(FeaturedProductSeeder::class);
    }
}
