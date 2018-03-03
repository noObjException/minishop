<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Good
 *
 * @property int $id
 * @property string $title
 * @property float $price
 * @property int $category_id
 * @property mixed|null $thumbs
 * @property string|null $detail
 * @property int $status
 * @property int $sort
 * @property int $good_categories_id
 */
class Good extends Model
{
    use SoftDeletes;

    public function setThumbsAttribute($thumbs)
    {
        if (is_array($thumbs)) {
            $this->attributes['thumbs'] = json_encode($thumbs);
        }
    }

    public function getThumbsAttribute($thumbs)
    {
        return json_decode($thumbs, true);
    }

    public function category()
    {
        return $this->belongsTo('App\Models\GoodCategory');
    }

    public function theme()
    {
        return $this->belongsTo('App\Models\GoodTheme');
    }
}
