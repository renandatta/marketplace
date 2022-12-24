<?php

use App\User;
use App\UserWishlist;
use Illuminate\Database\Seeder;

class UserWishlistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (User::where('user_level', '=', 'User')->get() as $user) {
            for ($i = 0; $i <= rand(3, 6); $i++) {
                UserWishlist::create([
                    'product_id' => rand(1, 200),
                    'user_id' => $user->id
                ]);
            }
        }
    }
}
