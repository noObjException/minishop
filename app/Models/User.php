<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $username
 * @property string $nickname
 * @property string $realname
 * @property int $status
 * @property int $group_id
 * @property int $level_id
 * @property string $password
 * @property string $wx_official_account_openid 微信公众号openid
 * @property string $wx_mini_program_openid 微信小程序openid
 * @property string $wx_unionid 微信unionid，微信公众号id与微信小程序关联的id
 * @property string $phone_number 用户手机号
 * @property int $point 用户积分
 * @property float $balance 用户余额
 * @property int $gender 性别：0未知，1男，2女
 * @property string $avatar 头像
 * @property string $province
 * @property string $city
 * @property string $area
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property string $register_ip 注册ip
 * @property string $last_login_ip 最后登录ip
 */
class User extends Authenticatable
{
    use SoftDeletes, HasApiTokens, Notifiable;

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('created_at', function(Builder $builder) {
            $builder->orderByDesc('created_at');
        });
    }

    public function findForPassport($login)
    {
        return $this->orWhere('username', $login)
            ->orWhere('wx_official_account_openid', $login)
            ->orWhere('email', $login)
            ->orWhere('phone', $login)
            ->first();
    }
}
