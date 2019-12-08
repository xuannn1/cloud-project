<?php

namespace App\Http\Controllers\Api;

use App\Thread;
use App\User;
use Illuminate\Http\Request;
use App\Http\Resources\ThreadResource;
use App\Http\Requests\Api\ThreadRequest;

class ThreadsController extends Controller
{
    // 获取帖子列表
    public function index(Request $request, Thread $thread){
        $query = $thread->query();

        if($categoryId = $request->category_id){
            $query->where('category_id', $categoryId);
        }

        $threads = $query
            ->paginate();
        // $threads = Thread::withOrder($request->order);
        return ThreadResource::collection($threads);
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
        $this->authorize('update', $thread);
        $thread->update($request->all());

        return new ThreadResource($thread);
    }

    // 单个帖子详情
    public function show(Thread $thread){
        return new ThreadResource($thread);
    }

    // 删除帖子
    public function destroy(Thread $thread){
        $this->authorize('destroy', $thread);
        $thread->delete();

        return response(null, 204);
    }

}
