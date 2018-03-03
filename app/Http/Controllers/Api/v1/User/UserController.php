<?php

namespace App\Http\Controllers\Api\v1\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    public function show($id)
    {
        $user = Auth::user();

        $data = [
            'userInfo' => new UserResource($user),
        ];

        return compact('data');
    }
}
