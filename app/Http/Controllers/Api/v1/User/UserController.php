<?php

namespace App\Http\Controllers\Api\v1\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\Order\OrderResource;
use App\Http\Resources\User\UserResource;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\UnauthorizedException;


class UserController extends Controller
{
    public function show($id)
    {
        $user = Auth::user();

        throw_unless($user, new UnauthorizedException());

        $orders = Order::where('user_id', $user->id)->paginate(20);

        $data = [
            'userInfo' => new UserResource($user),
            'orders'   => OrderResource::collection($orders)
        ];

        return compact('data');
    }
}
