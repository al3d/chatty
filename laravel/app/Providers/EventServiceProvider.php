<?php

namespace App\Providers;

use App\Events\User\JoinedChannel;
use App\Events\User\LoggedInViaMagicLink;
use App\Listeners\JoinChannel;
use App\Listeners\UpdateLastLoggedIn;
use Illuminate\Auth\Events\Login as LoggedIn;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        JoinedChannel::class => [
            JoinChannel::class,
        ],
        LoggedIn::class => [
            UpdateLastLoggedIn::class,
        ],
        LoggedInViaMagicLink::class => [
            UpdateLastLoggedIn::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}
