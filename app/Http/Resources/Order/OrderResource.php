<?php

namespace App\Http\Resources\Order;

use Illuminate\Http\Resources\Json\Resource;

class OrderResource extends Resource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'          => $this->id,
            'total_price' => $this->total_price,
            'order_num'   => $this->order_num,
            'status'      => $this->status,
            'pay_type'    => $this->pay_type,
            'remark'      => $this->remark,
            'address'     => $this->address,
            'finished_at' => $this->finished_at,
            'created_at'  => $this->created_at,
            'paid_at'     => $this->paid_at,
            'total'       => $this->total,
            'thumb'       => admin_upload_link((string)($this->goods->first())['thumbs'][0])
        ];
    }
}
