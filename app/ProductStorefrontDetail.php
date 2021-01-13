<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductStorefrontDetail extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'product_storefront_id', 'product_id'
    ];

    public function product_storefront()
    {
        return $this->belongsTo(ProductStorefront::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
