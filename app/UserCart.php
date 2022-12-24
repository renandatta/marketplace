<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserCart extends Model
{
    protected $fillable = [
        'product_id', 'user_id', 'qty'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class)
            ->with('store');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getTotalPriceAttribute()
    {
        return $this->qty * $this->product->price;
    }
}
