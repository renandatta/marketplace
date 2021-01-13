<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseDetail extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'purchase_id', 'product_id', 'qty', 'price', 'courier_service_id', 'shipping_cost'
    ];

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getTotalPriceAttribute()
    {
        return $this->qty * $this->price;
    }

    public function courier_service()
    {
        return $this->belongsTo(CourierService::class);
    }
}
