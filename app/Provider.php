<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Provider extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    public function receipts()
    {
        return $this->hasMany('App\Receipt');
    }
}
