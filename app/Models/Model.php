<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model as Eloquent;

class Model extends Eloquent
{
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('created_at', function(Builder $builder) {
            $builder->orderByDesc('created_at');
        });
    }

    public function scopeNormalStatus($query)
    {
        return $query->where('status', '1');
    }
}