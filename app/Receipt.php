<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    protected $guarded = ['id'];

    public function provider()
    {
        return $this->belongsTo('App\Provider');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function products()
    {
        return $this->hasMany('App\ReceivedProduct');
    }

    public function transactions() {
        return $this->hasMany('App\Transaction');
    }
    
}
