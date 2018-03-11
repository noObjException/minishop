<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Good\GoodResource;
use App\Http\Resources\Good\ThemeResource;
use App\Http\Resources\Setting\CarouselResource;
use App\Models\Carousel;
use App\Models\Good;
use App\Models\GoodTheme;

class HomeController extends Controller
{
    public function index()
    {
        $data = [
            'carousels' => CarouselResource::collection(Carousel::NormalStatus()->take(4)->get()),
            'themes'    => ThemeResource::collection(GoodTheme::NormalStatus()->take(3)->get()),
            'newGoods'  => GoodResource::collection(Good::NormalStatus()->take(20)->get()),
        ];

        return compact('data');
    }
}
