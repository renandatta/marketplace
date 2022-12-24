<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Courier extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name'
    ];

    public function services()
    {
        return $this->hasMany(CourierService::class);
    }
}
