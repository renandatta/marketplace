<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseStatus extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'purchase_id', 'status', 'description'
    ];

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }
}
