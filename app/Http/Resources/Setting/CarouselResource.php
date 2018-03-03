<?php

namespace App\Http\Resources\Setting;

use Illuminate\Http\Resources\Json\Resource;

class CarouselResource extends Resource
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
            'url'   => $this->url,
            'image' => admin_upload_link($this->image),
        ];
    }
}
