<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\GetDateTimeInAppTimezone;

class ProductBalance extends Model
{
    use GetDateTimeInAppTimezone;

    protected $guarded = ['id'];

    /**
     * Get the product balance
     */
    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}
