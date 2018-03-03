<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {

        $data = [
            'banners'  => [['fds' => 'das']],
            'themes'   => [],
            'products' => [],
        ];

        return compact('data');
    }
}
