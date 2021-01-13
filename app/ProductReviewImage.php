<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductReviewImage extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'product_review_id', 'location'
    ];

    public function product_review()
    {
        return $this->belongsTo(ProductReview::class);
    }
}
