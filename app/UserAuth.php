<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserAuth extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'user_id', 'auth', 'token', 'device'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
