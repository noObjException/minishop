<?php

namespace App\Http\Controllers\Api\v1\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\UnauthorizedException;


class UserController extends Controller
{
    public function show($id)
    {
        $user = Auth::user();

        throw_unless($user, new UnauthorizedException());

        $data = [
            'userInfo' => new UserResource($user),
        ];

        return compact('data');
    }
}
