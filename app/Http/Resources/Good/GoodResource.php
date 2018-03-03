<?php

namespace App\Http\Resources\Good;

use Illuminate\Http\Resources\Json\Resource;

class GoodResource extends Resource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'       => $this->id,
            'title'    => $this->title,
            'price'    => $this->price,
            'category' => $this->category->title,
            'stock'    => $this->stock,
            'thumb'    => admin_upload_link(($this->thumbs)[0]),
            'thumbs'   => collect($this->thumbs)->map(function ($item) {
                return admin_upload_link($item);
            }),
        ];
    }
}
