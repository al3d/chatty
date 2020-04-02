<?php

namespace App\Policies;

use App\Models\Message;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class MessagePolicy
{
    use HandlesAuthorization;

    public function create(User $user)
    {
        return Response::allow();
    }

    public function update(User $user, Message $message)
    {
        return $user->id === $message->user_id
            ? Response::allow()
            : Response::deny('You cannot edit this message')
        ;
    }

    public function delete(User $user, Message $message)
    {
        return $user->id === $message->user_id
            ? Response::allow()
            : Response::deny('You cannot delete this message')
        ;
    }

}
