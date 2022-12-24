<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourierService extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'courier_id', 'name', 'price'
    ];

    public function courier()
    {
        return $this->belongsTo(Courier::class);
    }
}
