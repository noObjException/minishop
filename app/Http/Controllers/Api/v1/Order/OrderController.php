<?php

namespace App\Http\Controllers\Api\v1\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\OrderPost;
use App\Http\Resources\Order\OrderResource;
use App\Models\Good;
use App\Models\Order;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {

    }

    public function show($id)
    {
        $order = Order::findOrFail($id);

        $data = [
            'orderInfo' => new OrderResource($order),
        ];

        return compact('data');
    }

    public function store(OrderPost $request)
    {
        $params   = $request->json()->all();
        $cartData = collect($params['cartData']);

        // 查询购买商品
        $goods = Good::whereIn('id', $cartData->pluck('good_id'))->get();

        // 计算商品价格
        $good_counts = $cartData->pluck('counts', 'good_id');
        $goods       = $goods->map(function ($item) use ($good_counts) {
            $item->total_price = $item->price * $good_counts[$item->id];
            $item->total       = $good_counts[$item->id];

            return $item;
        });

        // 生成订单
        $order_data['order_num']   = get_order_num('SC');
        $order_data['pay_type']    = 'WECHAT_PAY';
        $order_data['status']      = 0;
        $order_data['total_price'] = $goods->sum('total_price');
        $order_data['total']       = $cartData->sum('counts');
        $order_data['user_id']     = Auth::user()->id;

        $order = Order::create($order_data);

        // 减库存
        foreach ($goods as $good) {
            Good::where('id', $good->id)->decrement('stock', $good->total);
        }

        // 记录订单商品信息
        $order_goods = $goods->map(function ($item) use ($order) {
            return [
                'order_id'    => $order->id,
                'good_id'     => $item->id,
                'total'       => $item->total,
                'total_price' => $item->total_price,
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now(),
            ];
        });
        DB::table('order_goods')->insert($order_goods->all());

        $data = [
            'order_id' => $order->id,
        ];

        return compact('data');
    }
}
