<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserAddress extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'user_id', 'name', 'address', 'province', 'city', 'district', 'postal_code', 'phone', 'province_id', 'city_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
