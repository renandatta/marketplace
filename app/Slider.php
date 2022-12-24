<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Slider extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name'
    ];

    public function getImageLocationAttribute()
    {
        if ($this->image == '') return 'https://picsum.photos/id/'. mt_rand(000, 200) .'/400';
        elseif (substr($this->image, 0, 5) == 'https') return $this->image;
        else return asset('image/' . $this->image);
    }
}
