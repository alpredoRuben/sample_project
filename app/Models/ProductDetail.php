<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    protected $fillable = [
        'product_id',
        'name',
        'stock',
        'price',
        'user_id'
    ];

    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'product_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function product_variants()
    {
        return $this->hasMany('App\Models\ProductVariant', 'product_detail_id', 'id');
    }
}
