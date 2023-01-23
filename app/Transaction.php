<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class Transaction extends Model
{
    protected $guarded = ['id'];

    public function soldProduct()
    {
        return $this->belongsTo('App\SoldProduct', 'sold_product_id');
    }

    public function receivedProduct()
    {
        return $this->belongsTo('App\ReceivedProduct', 'received_product_id');
    }

    public function scopeThisMonth($query)
    {
        return $query->whereMonth('created_at', Carbon::now()->month);
    }

    public function user() {
        return $this->belongsTo('App\User');
    }
}
