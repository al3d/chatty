<?php

namespace App\Listeners;

use App\Events\User\JoinedChannel;

class JoinChannel
{
    public function handle(JoinedChannel $event)
    {
        $user = $event->user;
        $channel = $event->channel;

        if (!$channel->members->contains($user->id)) {
            $channel
                ->members()
                ->attach($user)
            ;
        }
    }
}
