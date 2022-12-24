<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Store extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'store_level_id', 'name', 'address', 'city', 'district', 'phone', 'email'
    ];

    public function store_level()
    {
        return $this->belongsTo(StoreLevel::class);
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function getLogoLocationAttribute()
    {
        if ($this->logo == '') return 'https://picsum.photos/id/'. mt_rand(000, 200) .'/400';
        elseif (substr($this->logo, 0, 5) == 'https') return $this->logo;
        else return asset('image/' . $this->logo);
    }
}
