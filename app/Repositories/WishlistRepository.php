<?php

namespace App\Repositories;

use App\Product;
use App\UserWishlist;

class WishlistRepository extends BaseRepository {

    private $userWishlist;
    private $product;
    public function __construct(UserWishlist $userWishlist, Product $product)
    {
        $this->userWishlist = $userWishlist;
        $this->product = $product;
    }

    public function find($id)
    {
        return $this->userWishlist->find($id);
    }

    public function search($parameters, $paginate = false)
    {
        $userWishlist = $this->userWishlist->with('product');
        $userWishlist = $this->setParameter($userWishlist, $parameters);
        return $paginate == false ? $userWishlist->get() : $userWishlist->paginate(10);
    }

    public function save($userId, $productId)
    {
        return $this->userWishlist->firstOrCreate([
            'user_id' => $userId,
            'product_id' => $productId,
        ]);
    }

    public function delete($id)
    {
        return $this->userWishlist->find($id)->delete();
    }

}
