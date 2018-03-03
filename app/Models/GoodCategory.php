<?php

namespace App\Models;

use Encore\Admin\Traits\AdminBuilder;
use Encore\Admin\Traits\ModelTree;
use Illuminate\Database\Eloquent\SoftDeletes;
/**
 * App\Models\GoodCategory
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
class GoodCategory extends Model
{
    use SoftDeletes, ModelTree, AdminBuilder;

    protected $table = 'good_categories';

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setTitleColumn('title');
        $this->setOrderColumn('sort');
        $this->setParentColumn('pid');
    }

    public function good()
    {
        return $this->belongsTo('App\Models\Good');
    }
}
