<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductPriceHistory extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'product_id', 'price'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
