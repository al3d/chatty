<?php

use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('channel.{name]', function (User $user, $name) {
    /**
     * We've defined this as a private channel simply in order to
     * ensure that users need to be authenticated.
     *
     * If we were to add additional security and authorization features
     * this would be important.
     */
    return true;
});

// Broadcast::channel('App.User.{id}', function ($user, $id) {
//     return (int) $user->id === (int) $id;
// });
