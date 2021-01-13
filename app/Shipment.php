<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shipment extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'purchase_id', 'courier_service_id', 'weight', 'store_id', 'no_shipment'
    ];

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    public function courier_service()
    {
        return $this->belongsTo(CourierService::class);
    }

    public function shipment_status()
    {
        return $this->hasMany(ShipmentStatus::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
