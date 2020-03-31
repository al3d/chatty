<?php

namespace App\Listeners;

use App\Events\LoggedInViaMagicLink;
use App\Models\User;

class RegenerateUserSalt
{

    public function handle(LoggedInViaMagicLink $event)
    {
        $user = $event->user;

        /**
         * Since we're using $user->salt to generate a user hash,
         * and the magic link's no longer useful, we should
         * regenerate the salt.
         *
         * User::$salt is guarded/non-fillable, so we must be explicit
         * when assigning it
         */
        $user->salt = User::generateSalt();
        $user->save();
    }
}
