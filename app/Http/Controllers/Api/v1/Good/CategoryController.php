<?php

namespace App\Http\Controllers\Api\v1\Good;

use App\Http\Controllers\Controller;
use App\Http\Resources\Good\CategoryResource;
use App\Models\GoodCategory;

class CategoryController extends Controller
{
    public function index()
    {
        $data = [
            'categories' => CategoryResource::collection(GoodCategory::normalStatus()->get())
        ];

        return compact('data');
    }

    public function show($id)
    {

    }
}
