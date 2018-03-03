<?php

namespace App\Models;

use Encore\Admin\Traits\AdminBuilder;
use Encore\Admin\Traits\ModelTree;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
/**
 * App\Models\GoodTheme
 *
 * @property int $id
 * @property string $title
 * @property int $pid
 * @property string $image
 * @property int $status
 * @property int $sort
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 */
class GoodTheme extends Model
{
    use SoftDeletes, ModelTree, AdminBuilder;

    protected $table = 'good_themes';

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('sort', function(Builder $builder) {
            $builder->orderByDesc('sort');
        });
    }

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setTitleColumn('title');
        $this->setOrderColumn('sort');
        $this->setParentColumn('pid');
    }

    public function goods()
    {
        return $this->hasMany('App\Models\Good', 'category_id', 'id');
    }
}
