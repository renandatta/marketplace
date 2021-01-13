<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchasePayment extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'purchase_id', 'payment_type_id', 'sub_total', 'shipping', 'tax', 'total', 'unique_code'
    ];

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    public function payment_type()
    {
        return $this->belongsTo(PaymentType::class);
    }
}
