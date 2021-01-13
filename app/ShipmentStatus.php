<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShipmentStatus extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'shipment_id', 'status', 'description'
    ];

    public function shipment()
    {
        return $this->belongsTo(Shipment::class);
    }
}
