<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $casts = [
        'address' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function goods()
    {
        return $this->belongsToMany('App\Models\Good')
            ->withPivot('total', 'total_price')
            ->withTimestamps();
    }
}
