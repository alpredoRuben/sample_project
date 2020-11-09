<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classification extends Model
{
    protected $fillable = ['type_name'];

    public function product_classification()
    {
        return $this->hasMany('App\Models\ProductClassification', 'classification_id', 'id');
    }
}
