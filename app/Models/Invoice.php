<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'invoice_code',
        'customer_name',
        'customer_address',
        'invoice_type',
        'user_id'
    ];

    public function orders()
    {
        return $this->hasMany('App\Models\Order', 'invoice_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
}
