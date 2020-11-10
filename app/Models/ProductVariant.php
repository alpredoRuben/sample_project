<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    protected $fillable = ['product_detail_id', 'product_class_id', 'variant_value'];


    public function product_detail()
    {
        return $this->belongsTo('App\Models\ProductDetail', 'product_detail_id', 'id');
    }

    public function product_classification()
    {
        return $this->belongsTo('App\Models\ProductClassification', 'product_class_id', 'id');
    }
}
