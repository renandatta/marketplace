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
        if ($this->location == '') return 'https://picsum.photos/id/'. mt_rand(000, 200) .'/400';
        elseif (substr($this->location, 0, 5) == 'https') return $this->location;
        else return asset('image/' . $this->location);
    }
}
