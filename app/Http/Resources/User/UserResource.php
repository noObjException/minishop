<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\Resource;

class UserResource extends Resource
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
            'id'       => $this->id,
            'username' => $this->username,
            'nickname' => $this->nickname,
            'realname' => $this->realname,
            'email'    => $this->email,
            'status'   => $this->status,
            'group_id' => $this->group_id,
            'level_id' => $this->level_id,
            'phone'    => $this->phone,
            'point'    => $this->point,
            'balance'  => $this->balance,
            'gender'   => $this->gender,
            'avatar'   => $this->avatar,
            'province' => $this->province,
            'city'     => $this->city,
            'area'     => $this->area,
        ];
    }
}
