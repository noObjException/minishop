<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Carousel
 *
 * @property int $id
 * @property string $title
 * @property string $image
 * @property string $url
 * @property int $status
 * @property int $sort
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 */
class Carousel extends Model
{
    use SoftDeletes;

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('sort', function(Builder $builder) {
            $builder->orderByDesc('sort');
        });
    }
}
