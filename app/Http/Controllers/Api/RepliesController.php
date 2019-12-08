<?php

namespace App\Http\Controllers\Api;

use App\Thread;
use App\Reply;
use Illuminate\Http\Request;
use App\Http\Resources\ReplyResource;
use App\Http\Requests\Api\ReplyRequest;
use App\Http\Queries\ReplyQuery;

class RepliesController extends Controller
{
    public function store(ReplyRequest $request, Thread $thread, Reply $reply){
        $reply->body = $request->body;
        $reply->thread()->associate($thread);
        $reply->user()->associate($request->user());
        $reply->save();

        return new ReplyResource($reply);
    }

    public function destroy(Thread $thread, Reply $reply){
        if($reply->thread_id != $thread->id) {
            abort(404);
        }
        $this->authorize('destroy', $reply);
        $reply->delete();

        return response(null, 204);
    }

    public function index($threadId, ReplyQuery $query){
        $replies = $query->where('thread_id', $threadId)->paginate();

        return ReplyResource::collection($replies);
    }

    public function userIndex($userId, ReplyQuery $query){
        $replies = $query->where('user_id', $userId)->paginate();

        return ReplyResource::collection($replies);        
    }
}
