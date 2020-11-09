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
}
