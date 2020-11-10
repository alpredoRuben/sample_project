<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartOrder extends Model
{
    protected $fillable = [
        'cart_code',
        'product_detail_id',
        'count_order',
        'price',
        'total_order',
        'user_id',
        'description'
    ];
}
