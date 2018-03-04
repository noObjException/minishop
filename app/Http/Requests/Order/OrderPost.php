<?php

namespace App\Http\Requests\Order;


use App\Http\Requests\Request;

class OrderPost extends Request
{
    public function rules()
    {
        return [
//            'id' => 'required'
        ];
    }

    public function messages()
    {
       return [

       ];
    }
}
