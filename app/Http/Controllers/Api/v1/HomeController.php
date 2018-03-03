<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Good\GoodResource;
use App\Http\Resources\Setting\CarouselResource;
use App\Models\Carousel;
use App\Models\Good;

class HomeController extends Controller
{
    public function index()
    {
        $data = [
            'carousels'   => CarouselResource::collection(Carousel::NormalStatus()->get()),
            'themes'      => CarouselResource::collection(Carousel::NormalStatus()->get()),
            'newProducts' => GoodResource::collection(Good::NormalStatus()->get()),
        ];

        return compact('data');
    }
}
