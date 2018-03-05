<?php

namespace App\Http\Controllers\Api\v1\Order;


use App\Http\Controllers\Controller;
use App\Models\Order;
use Carbon\Carbon;
use EasyWeChat;
use EasyWeChat\Kernel\Exceptions\HttpException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function miniProgramPay(Request $request)
    {
        $user = Auth::user();

        $order_id = $request->get('order_id');
        $order    = Order::findOrFail($order_id);

        $payment = EasyWeChat::payment();

        $result = $payment->order->unify([
            'body'         => '商城购物',
            'detail'       => '商城购物',
            'out_trade_no' => $order->order_num,
            'total_fee'    => $order->total_price * 100,
            'notify_url'   => url('/api/v1/payment/wxNotify'),
            'trade_type'   => 'JSAPI',
            'openid'       => $user->wx_mini_program_openid,
        ]);

        throw_unless($result['return_code'] === 'SUCCESS' && $result['result_code'] === 'SUCCESS',
            new HttpException('支付错误'));

        $data = $payment->jssdk->sdkConfig($result['prepay_id']);

        return compact('data');
    }

    public function wxNotify()
    {
        $payment = EasyWeChat::payment();

        return $payment->handlePaidNotify(function ($message, $fail) {
            $order = Order::where('order_num', $message['out_trade_no'])->first();
            if (!$order) {
                $fail('Order not exist.');
            }
            if ($order->paid_at) {
                return true;
            }
            // 用户是否支付成功
            if ($message['result_code'] === 'SUCCESS') {
                // 不是已经支付状态则修改为已经支付状态
                $order->paid_at       = Carbon::now();
                $order->status         = 1;
                $order->pay_type       = 'WECHAT_PAY';
//                $order->arrived_amount = $message['total_fee'] / 100;
            }

            $order->save();

            return true;
        });
    }
}