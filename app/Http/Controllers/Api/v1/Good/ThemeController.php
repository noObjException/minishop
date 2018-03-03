<?php

namespace App\Http\Controllers\Api\v1\Good;

use App\Http\Controllers\Controller;
use App\Http\Resources\Good\ThemeResource;
use App\Models\GoodTheme;

class ThemeController extends Controller
{
    public function show($id)
    {
        $data = [
            'theme' => new ThemeResource(GoodTheme::findOrFail($id))
        ];

        return compact('data');
    }
}
