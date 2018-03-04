<?php

namespace App\Http\Controllers\Api\v1\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\Order\OrderResource;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(Order $order)
    {
        $lists = $order->where('user_id', Auth::user()->id)->paginate(20);

        return new OrderResource($lists);
    }
}
