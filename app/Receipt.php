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

    public function numberOfProducts()
    {
        return $this->with(['products' => function($query){
            $query->groupBy('product_id');
        }])->count();
    }

    public function receiptTotal()
    {
        return $this->products->sum('price');
    }

    public function transactions() {
        return $this->hasMany('App\Transaction');
    }
    
}
