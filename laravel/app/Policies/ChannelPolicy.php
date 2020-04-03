<?php

namespace App\Policies;

use App\Models\Channel;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ChannelPolicy
{
    use HandlesAuthorization;

    public function create(User $user)
    {
        return Response::allow();
    }

    public function update(User $user, Channel $channel)
    {
        return $user->id === $channel->creator_id
            ? Response::allow()
            : Response::deny('You cannot edit this channel')
        ;
    }

    public function delete(User $user, Channel $channel)
    {
        if (!$channel->is_deleteable) {
            return Response::deny('This channel is un-deleteable');
        }
        return $user->id === $channel->creator_id
            ? Response::allow()
            : Response::deny('You cannot delete this channel')
        ;
    }

}
