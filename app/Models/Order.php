<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'product_detail_id',
        'code',
        'name',
        'description',
        'quantity',
        'price',
        'total_price',
        'invoice_id',
    ];

    public function invoices()
    {
        return $this->belongsTo('App\Models\Invoice', 'invoice_id', 'id');
    }

    public function product_details()
    {
        return $this->belongsTo('App\Models\ProductDetail', 'product_detail_id', 'id');
    }
}
