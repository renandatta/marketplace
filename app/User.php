<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    protected $fillable = [
        'name', 'email', 'password', 'user_level'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function store_owner()
    {
        return $this->hasMany(StoreOwner::class);
    }

    public function last_user_auth()
    {
        return $this->hasOne(UserAuth::class)
            ->where('auth', '=', 'login')
            ->orderBy('id', 'desc');
    }

    public function addresses()
    {
        return $this->hasMany(UserAddress::class, 'user_id', 'id');
    }

    public function default_address()
    {
        return $this->hasOne(UserAddress::class, 'user_id', 'id')
            ->where('is_default', '=', 1);
    }

    public function getPhotoLocationAttribute()
    {
        $photo = 'https://picsum.photos/id/1/400';
        $photo = $this->photo != '' ? substr($this->photo, 0, 5) ? $this->photo : asset('image/' . $this->photo) : $photo;
        return $photo;
    }
}
