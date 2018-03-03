<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Setting\CarouselResource;
use App\Models\Carousel;

class HomeController extends Controller
{
    public function index()
    {
        $data = [
            'carousels'   => CarouselResource::collection(Carousel::NormalStatus()->get()),
            'themes'      => CarouselResource::collection(Carousel::NormalStatus()->get()),
            'newProducts' => CarouselResource::collection(Carousel::NormalStatus()->get()),
        ];

        return compact('data');
    }
}
