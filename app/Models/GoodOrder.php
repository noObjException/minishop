<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GoodOrder extends Model
{
    use SoftDeletes;

    protected $table = 'good_order';

    public function good()
    {
        return $this->belongsTo('App\Models\Good', 'good_id', 'id');
    }

    public function order()
    {
        return $this->belongsTo('App\Models\Order');
    }
}
