<?php

namespace App\Repositories;

use App\Product;
use App\UserCart;

class CartRepository extends BaseRepository {

    private $userCart;
    private $product;
    public function __construct(UserCart $userCart, Product $product)
    {
        $this->userCart = $userCart;
        $this->product = $product;
    }

    public function find($id)
    {
        return $this->userCart->find($id);
    }

    public function search($parameters, $paginate = false)
    {
        $userCart = $this->userCart->select('user_carts.*', 'products.store_id')
            ->with('product')
            ->join('products', 'products.id', '=', 'user_carts.product_id')
            ->orderBy('store_id', 'asc');
        $userCart = $this->setParameter($userCart, $parameters);
        return $paginate == false ? $userCart->get() : $userCart->paginate(10);
    }

    public function save($userId, $productId, $qty)
    {
        $check = $this->userCart->where('user_id', '=', $userId)
            ->where('product_id', '=', $productId)
            ->first();
        if (empty($check)) {
            $cart = $this->userCart->create([
                'user_id' => $userId,
                'product_id' => $productId,
                'qty' => $qty
            ]);
        } else {
            $cart = $this->userCart->find($check->id);
            $cart->update(['qty' => ($cart->qty + $qty)]);
        }
        return $cart;
    }

    public function delete($id)
    {
        return $this->userCart->find($id)->delete();
    }

    public function update($id, $qty)
    {
        return $this->userCart->find($id)->update(['qty' => $qty]);
    }

    public function empty_cart($user_id)
    {
        $this->userCart->where('user_id', '=', $user_id)->delete();
    }

}
