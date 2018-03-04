<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;

class AuthController extends Controller
{
    public $successStatus = 200;

    public function register(Request $request)
    {
        $input               = $request->all();
        $input['password']   = bcrypt($input['password']);
        $user                = User::create($input);
        $success['token']    = $user->createToken('MyApp')->accessToken;
        $success['username'] = $user->username;

        return response()->json(['success' => $success], $this->successStatus);
    }

    public function token(Request $request)
    {
        $code     = $request->get('code');
        $userInfo = $request->get('userInfo');

        $miniProgram = app('wechat.mini_program');

        $wx_session = $miniProgram->auth->session($code);

        $encryptedData = $miniProgram->encryptor->decryptData($wx_session->session_key, $userInfo['iv'], $userInfo['encryptedData']);

        $user = User::firstOrCreate([
            'wx_mini_program_openid' => $encryptedData['openId'],
        ], [
            'wx_union_id' => isset($encryptedData['unionId']) ? ($encryptedData['unionId']) : '',
            'nickname'    => $encryptedData['nickName'],
            'avatar'      => $encryptedData['avatarUrl'],
            'area'        => $encryptedData['country'],
            'province'    => $encryptedData['province'],
            'city'        => $encryptedData['city'],
            'gender'      => $encryptedData['gender'],
            'group_id'    => 1,
            'level_id'    => 1,
            'status'      => 1,
        ]);

        throw_unless($user, new UnauthorizedException('查找用户失败'));

        $data = [
            'token' => $user->createToken('MyApp')->accessToken,
        ];

        return compact('data');
    }
}