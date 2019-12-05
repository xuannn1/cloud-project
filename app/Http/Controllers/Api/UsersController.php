<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Http\Requests\Api\UserRequest;
use Illuminate\Auth\AuthenticationException;

class UsersController extends Controller
{
    public function store(UserRequest $request) 
    {
        // 从缓存中读取验证码的key
        $verifyData = \Cache::get($request->verification_key);
        // 缓存中不存在，说明已经超时失效
        if(!$verifyData) {
            abort(403, '验证码已失效');
        }
        // 获取的验证码与缓存中的验证码不相等
        if(!hash_equals($verifyData['code'], $request->verification_code)){
            throw new AuthenticationException('验证码错误');
        }
        // 验证成功，创建用户
        $user = User::create([
            'name' => $request->name,
            'phone' => $verifyData['phone'],
            'password' => $request->password,
        ]);

        // 清除验证码缓存
        \Cache::forget($request->verification_key);

        return (new UserResource($user))->showSensitiveFields();
    }

    public function show(User $user, Request $request){
        return new UserResource($user);
    }

    public function me(Request $request){
        return (new UserResource($request->user()))->showSensitiveFields();
    }
}
