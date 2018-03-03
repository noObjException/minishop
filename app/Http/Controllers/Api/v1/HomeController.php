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
            'carousels'   => CarouselResource::collection(Carousel::NormalStatus()->take(4)->get()),
            'themes'      => CarouselResource::collection(Carousel::NormalStatus()->get()),
            'newProducts' => GoodResource::collection(Good::NormalStatus()->take(20)->get()),
        ];

        return compact('data');
    }
}
