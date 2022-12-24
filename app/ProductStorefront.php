<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductStorefront extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'store_id', 'name'
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function details()
    {
        return $this->hasMany(ProductStorefrontDetail::class);
    }
}
