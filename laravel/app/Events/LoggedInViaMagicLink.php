<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Queue\SerializesModels;

class LoggedInViaMagicLink
{
    use SerializesModels;

    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }
}
