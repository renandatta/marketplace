<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FeaturedProductDetail extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'featured_product_id', 'product_id'
    ];

    public function featured_product()
    {
        return $this->belongsTo(FeaturedProduct::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class)
            ->with('images', 'reviews')
            ->withTrashed();
    }
}
