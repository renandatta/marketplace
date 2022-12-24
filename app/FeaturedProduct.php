<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FeaturedProduct extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name'
    ];

    public function details()
    {
        return $this->hasMany(FeaturedProductDetail::class)
            ->with('product');
    }
}
