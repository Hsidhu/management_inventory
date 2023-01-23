<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransactionType extends Model
{
    const ITEM_CHECKEDOUT = 'item_sold';
    const ITEM_RECIVEID = 'item_received';

    protected $fillable = ['type', 'description'];
    public function transactions() {
        return $this->hasMany('App\Transaction');
    }
}
