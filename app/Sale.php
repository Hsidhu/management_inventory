<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $guarded = ['id'];

   
    public function transactions() {
        return $this->hasMany('App\Transaction');
    }

    public function products() {
        return $this->hasMany('App\SoldProduct');
    }
    
    public function user() {
        return $this->belongsTo('App\User');
    }
}
