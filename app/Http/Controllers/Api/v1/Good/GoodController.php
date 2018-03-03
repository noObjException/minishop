<?php

namespace App\Http\Controllers\Api\v1\Good;

use App\Http\Controllers\Controller;
use App\Http\Resources\Good\GoodResource;
use App\Models\Good;

class GoodController extends Controller
{
    public function index()
    {

    }

    public function show($id)
    {
        $data = [
            'goodDetail' => new GoodResource(Good::findOrFail($id)),
        ];

        return compact('data');
    }
}
