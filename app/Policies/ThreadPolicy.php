<?php

namespace App\Policies;

use App\User;
use App\Thread;
use Illuminate\Auth\Access\HandlesAuthorization;

class ThreadPolicy
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

    public function update(User $user, Thread $thread){
        return $user->isAuthorOf($thread);
    }

    public function destroy(User $user, Thread $thread){
        return $user->isAuthorOf($thread);
    }
}
