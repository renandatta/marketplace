<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Product extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'store_id', 'product_category_id', 'name', 'price', 'weight', 'condition', 'stock', 'stock_min', 'description'
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function product_category()
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function discussions()
    {
        return $this->hasMany(ProductDiscussion::class)
            ->whereNull('parent_id');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('is_featured', 'desc');
    }

    public function price_histories()
    {
        return $this->hasMany(ProductPriceHistory::class);
    }

    public function reviews()
    {
        return $this->hasMany(ProductReview::class)
            ->orderBy('id', 'desc');
    }

    public function getRatingAttribute()
    {
        return $this->reviews->avg('rating');
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function getCheckWishlistAttribute()
    {
        if (!Auth::check()) return false;
        $wishlist = UserWishlist::where('user_id', '=', Auth::user()->id)
            ->where('product_id', '=', $this->attributes['id'])
            ->count();
        return $wishlist == 1;
    }

    public function featured_list()
    {
        return $this->hasMany(FeaturedProductDetail::class)
            ->join('featured_products', 'featured_products.id', '=', 'featured_product_details.featured_product_id');
    }
}
