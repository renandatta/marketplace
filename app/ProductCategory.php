<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class ProductCategory extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name', 'description', 'code', 'parent_code'
    ];

    public function sub()
    {
        return $this->hasMany(ProductCategory::class, 'parent_code', 'code');
    }

    public function parent()
    {
        return $this->belongsTo(ProductCategory::class, 'parent_code', 'code');
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function getProductCountAttribute()
    {
        return Product::where('product_category_id', '=', $this->attributes['id'])->count();
    }
}
