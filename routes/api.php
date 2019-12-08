<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')
    ->namespace('Api')
    ->name('api.v1.')
    ->group(function() {
        // 使用throttle中间件限制访问频率
        Route::middleware('throttle:' . config('api.rate_limits.sign'))
            ->group(function(){
                // 图片验证码
                Route::post('captchas', 'CaptchasController@store')
                    ->name('captchas.store');
                // 短信验证码
                Route::post('verificationCodes', 'VerificationCodesController@store')
                    ->name('verificationCodes.store');
                // 用户注册
                Route::post('users', 'UsersController@store')
                    ->name('users.store');
                // 登录
                Route::post('authorizations', 'AuthorizationsController@store')
                    ->name('authorizations.store');
                 // 刷新token
                Route::put('authorizations/current','AuthorizationsController@update')
                    ->name('authorizations.update');
                // 删除token
                Route::delete('authorizations/current', 'AuthorizationsController@destroy')
                    ->name('authorizations.destroy');
            });

        Route::middleware('throttle:' . config('api.rate_limits.access'))
            ->group(function(){
                // 游客可以访问的接口

                // 某个用户的详情
                Route::get('users/{user}', 'UsersController@show')
                    ->name('users.show');
                // 获取分类列表
                Route::get('categories', 'CategoriesController@index')
                    ->name('categories.index');
                // 获取帖子列表
                Route::get('threads', 'ThreadsController@index')
                    ->name('threads.index');
                // 获取某个用户发布的帖子列表
                Route::get('users/{user}/threads', 'ThreadsController@userIndex')
                    ->name('users.threads.index');
                // 单个帖子详情
                Route::get('threads/{thread}', 'ThreadsController@show')
                    ->name('threads.show');
                // 获取某个帖子的回复列表
                Route::get('threads/{thread}/replies', 'RepliesController@index')
                    ->name('threads.replies.index');
                // 获取某个用户的回复列表
                Route::get('users/{user}/replies', 'RepliesController@userIndex')
                    ->name('users.replies.index');
                

                // 登录后可以访问的接口
                Route::middleware('auth:api')->group(function() {
                    // 当前登录用户信息
                    Route::get('user', 'UsersController@me')
                        ->name('user.show');
                    // 编辑登录用户信息
                    Route::patch('user', 'UsersController@update')
                        ->name('user.update');
                    // 上传图片
                    Route::post('images', 'ImagesController@store')
                        ->name('images.store');
                    // 发布帖子
                    Route::post('threads', 'ThreadsController@store')
                        ->name('threads.store');
                    // 编辑帖子
                    Route::patch('threads/{thread}', 'ThreadsController@update')
                        ->name('threads.update');
                    // 删除帖子
                    Route::delete('threads/{thread}', 'ThreadsController@destroy')
                        ->name('threads.destroy');
                    // 发布回复
                    Route::post('threads/{thread}/replies', 'RepliesController@store')
                        ->name('threads.replies.store');
                    // 删除回复
                    Route::delete('threads/{thread}/replies/{reply}', 'RepliesController@destroy')
                        ->name('threads.replies.destroy');
                });
            });
});

