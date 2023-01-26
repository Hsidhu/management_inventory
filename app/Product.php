<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\ProductBalance;

class Product extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    public function category()
    {
        return $this->belongsTo('App\ProductCategory', 'product_category_id')->withTrashed();
    }

    public function balance()
    {
        return $this->hasOne(ProductBalance::class, 'product_id', 'id');
    }

    public function solds()
    {
        return $this->hasMany('App\SoldProduct');
    }

    public function received()
    {
        return $this->hasMany('App\ReceivedProduct');
    }
}
