<?php

namespace App\Policies;

use App\User;
use App\Reply;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReplyPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function destroy(User $user, Reply $reply){
        // 只有回复的作者和本帖子的作者可以删除回复
        return $user->isAuthorOf($reply) || $user->isAuthorOf($reply->thread);
    }
}
