<?php

namespace App\Http\Controllers\Api;

use App\Thread;
use Illuminate\Http\Request;
use App\Http\Resources\ThreadResource;
use App\Http\Requests\Api\ThreadRequest;

class ThreadsController extends Controller
{
    // 获取帖子列表
    public function index(){
        return ThreadResource::collection(Thread::all());
    }

    // 发布帖子
    public function store(ThreadRequest $request, Thread $thread){
        $thread->fill($request->all());
        $thread->user_id = $request->user()->id;
        $thread->save();

        return new ThreadResource($thread);
    }

    // 编辑帖子
    public function update(ThreadRequest $request, Thread $thread){
        // 待做：修改的权限控制
        $thread->update($request->all());

        return new ThreadResource($thread);
    }

    // 单个帖子详情
    public function show(Thread $thread){
        return new ThreadResource($thread);
    }

    // 删除帖子
    public function destroy(Thread $thread){
        $thread->delete();

        return response(null, 204);
    }
}
