<?php

namespace App\Http\Controllers\Api\v1\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\OrderPost;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {

    }

    public function show($id)
    {

    }

    public function store(OrderPost $request)
    {
        $params = $request->json()->all();
        $params = collect($params);

        $order_data['order_num'] = get_order_num('SC');
        $order_data['pay_type'] = 'WECHAT_PAY';
        $order_data['status'] = 0;
        $order_data['total'] = $params->sum('counts');
        $order_data['user_id'] = Auth::user()->id;

        unset($order_data['good_id']);
        unset($order_data['counts']);

        $order = Order::create($order_data);

        $data = [
            'order_id' => $order->id
        ];

        return compact('data');
    }
}
