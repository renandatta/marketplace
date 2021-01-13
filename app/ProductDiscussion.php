<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductDiscussion extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'product_id', 'user_id', 'parent_id', 'content'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parent()
    {
        return $this->belongsTo(ProductDiscussion::class, 'parent_id', 'id');
    }

    public function replies()
    {
        return $this->hasMany(ProductDiscussion::class, 'parent_id', 'id');
    }
}
