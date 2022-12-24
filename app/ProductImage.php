<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductImage extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'product_id'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getImageLocationAttribute()
    {
        if (substr($this->location, 0, 5) == 'https') return $this->location;
        else return asset('image/' . $this->location);
    }
}
