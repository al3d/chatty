<?php

namespace App\Listeners;

use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateLastLoggedIn
{
    public function handle($event)
    {
        \Illuminate\Support\Facades\Log::info('updating user logged in date');
        $user = $event->user;
        $user->last_login_at = Carbon::now();
        $user->save();
    }
}
