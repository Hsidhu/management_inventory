<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SoldProduct extends Model
{
    protected $guarded = ['id'];
    
    public function product()
    {
        return $this->belongsTo('App\Product');
    }

    public function sale()
    {
        return $this->belongsTo('App\Sale');
    }

    public function received()
    {
        return $this->belongsTo('App\ReceivedProduct');
    }
    
}
