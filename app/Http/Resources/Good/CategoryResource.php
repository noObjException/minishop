<?php

namespace App\Http\Resources\Good;

use Illuminate\Http\Resources\Json\Resource;

class CategoryResource extends Resource
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
            'id'    => $this->id,
            'title' => $this->title,
            'image' => admin_upload_link($this->image),
            'goods' => GoodResource::collection($this->goods)
        ];
    }
}
