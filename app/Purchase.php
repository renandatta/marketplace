<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Purchase extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'user_id', 'no_purchase', 'user_address_id', 'shipping_cost'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(PurchaseDetail::class)
            ->select('purchase_details.*')
            ->with('product')
            ->join('products', 'products.id', '=', 'purchase_details.product_id')
            ->orderBy('products.store_id', 'asc');
    }

    public function status_list()
    {
        return $this->hasMany(PurchaseStatus::class)
            ->orderBy('id', 'desc');
    }

    public function getShippingCostDataAttribute()
    {
        return PurchaseDetail::where('purchase_id', '=', $this->id)
            ->join('products', 'products.id', '=', 'purchase_details.product_id')
            ->select('purchase_details.*', 'products.store_id')
            ->groupBy('products.store_id')
            ->get();
    }

    public function user_address()
    {
        return $this->belongsTo(UserAddress::class);
    }

    public function purchase_payment()
    {
        return $this->hasOne(PurchasePayment::class);
    }
}
