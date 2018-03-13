<?php

namespace App\Admin\Controllers\Order;

use App\Models\Order;


use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Layout\Row;
use Encore\Admin\Widgets\Box;
use Encore\Admin\Widgets\Table;

class OrderController extends Controller
{
    use ModelForm;

    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('订单');


            $content->body($this->grid());
        });
    }

    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('订单详情');

            $content->row(function (Row $row) use ($id) {
                $order = Order::findOrFail($id);
                $row->column(6, function (Column $column) use ($order) {
                    $address = $order['address'];
                    $details = [
                        '订单编号:'  => $order['order_num'],
                        '订单金额:'  => '￥' . $order['total_price'],
                        '付款方式:'  => get_pay_type($order['pay_type']),
                        '收货地址:'  => $address['name'] . ' ' . $address['mobile'] . '<br>' .
                            $address['totalDetail'],
                        '备注:   ' => $order['remark'],
                    ];
                    $column->append((new Box('订单信息', new Table([], $details)))->style('info')->solid());

                    // 商品信息
                    $goods = $order->goods
                        ->map(function ($good) {
                            return [
                                'title'       => $good->title,
                                'price'       => '¥ ' . $good->price,
                                'total'       => 'x' . $good->pivot->total,
                                'total_price' => '¥ ' . $good->pivot->total_price,
                            ];
                        })
                        ->all();
                    $column->append((new Box('商品信息', new Table(['商品', '单价', '数量', '总价'], $goods)))->style('info')->solid());

                    $times['下单时间:'] = $order['created_at'];
                    if (!empty($order['paid_at'])) {
                        $times['支付时间:'] = $order['paid_at'];
                    }
                    if (!empty($order['finished_at'])) {
                        $times['完成时间:'] = $order['finished_at'];
                    }
                    $column->append((new Box('订单跟踪', new Table([], $times)))->style('info')->solid());
                });

                $row->column(4, function (Column $column) use ($order) {
                    switch ($order['status']) {
                        case -1:
                            $order['status'] = '已关闭';
                            break;
                        case 0:
                            $order['status'] = '待付款';
                            break;
                        case 1:
                            $order['status'] = '待发货';
                            break;
                        case 2:
                            $order['status'] = '送货中';
                            break;
                        case 3:
                            $order['status'] = '已完成';
                            break;
                        default:
                            $order['status'] = '';
                            break;
                    }
                    $status = [
                        '订单状态:' => $order['status'],
                    ];
                    $column->append((new Box('订单状态', new Table([], $status)))->style('info')->solid());
                });
            });
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Order::class, function (Grid $grid) {

            $grid->disableCreateButton();

            $grid->column('id');
            $grid->column('user.avatar', '下单人头像')->image('', 40, 40);
            $grid->column('user.nickname', '下单人昵称')->limit(6);
            $grid->column('goods', '购买信息')->display(function ($goods) {
                return '商品种类: ' . count($goods) . '<br>' .
                        '商品总数: ' . collect($goods)->sum(function ($good) {
                            return $good['pivot']['total'];
                        }) . '<br>';
            });
            $grid->column('pay_type_status', '支付方式/状态')->display(function () {
                switch ($this->status) {
                    case -1:
                        $status = '<span class="label label-default">已关闭</span>';
                        break;
                    case 0:
                        $status = '<span class="label label-danger">待付款</span>';
                        break;
                    case 1:
                        $status = '<span class="label label-success">待发货</span>';
                        break;
                    case 2:
                        $status = '<span class="label label-success">送货中</span>';
                        break;
                    case 3:
                        $status = '<span class="label label-success">已完成</span>';
                        break;
                    default:
                        $status = '';
                        break;
                }

                switch ($this->pay_type) {
                    case 'WECHAT_PAY':
                        $pay_type = '<span class="label label-success">微信支付</span>';
                        break;
                    case 'BALANCE_PAY':
                        $pay_type = '<span class="label label-danger">余额支付</span>';
                        break;
                    case 'ADMIN_PAY':
                        $pay_type = '<span class="label label-danger">后台付款</span>';
                        break;
                    default:
                        $pay_type = '';
                        break;
                }

                return $status . '<br>' . $pay_type;
            });
            $grid->column('total_price', '支付总价/到账金额')->display(function () {
                $data = '￥ ' . $this->total_price . '<br>';
                $data .= $this->arrived_amount ? '￥ ' . $this->arrived_amount : '(待付款)';

                return $data;
            });
            $grid->column('times', '下单时间/付款时间')->display(function () {
                $data = $this->created_at . '<br>';
                $data .= $this->paid_at ?: '(待付款)';

                return $data;
            });

            $grid->model()->with(['user', 'goods']);

            $grid->filter(function ($filter) {
                $filter->useModal();
                $filter->disableidfilter();
                $filter->like('order_num', '订单号');
                $filter->like('user.nickname', '下单人昵称');
                $filter->like('address', '收货人信息');
                $filter->between('created_at', '下单时间')->datetime();
                $filter->equal('status', '状态')->select(['-1' => '已取消', '0' => '待付款', '1' => '待接单', '2' => '配送中', '3' => '已完成']);
            });
        });
    }
}
