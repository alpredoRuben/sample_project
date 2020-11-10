<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductClassification extends Model
{
    protected $fillable = ['classification_id', 'name', 'value'];

    public function classification()
    {
        return $this->belongsTo('App\Models\Classification', 'classification_id', 'id');
    }

    public function class_variants()
    {
        return $this->hasMany('App\Models\ProductVariant', 'product_class_id', 'id');
    }
}
