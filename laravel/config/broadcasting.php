<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Broadcaster
    |--------------------------------------------------------------------------
    |
    | This option controls the default broadcaster that will be used by the
    | framework when an event needs to be broadcast. You may set this to
    | any of the connections defined in the "connections" array below.
    |
    | Supported: "pusher", "redis", "log", "null", "localsockets"
    |
    */

    'default' => env('BROADCAST_DRIVER', 'null'),

    /*
    |--------------------------------------------------------------------------
    | Broadcast Connections
    |--------------------------------------------------------------------------
    |
    | Here you may define all of the broadcast connections that will be used
    | to broadcast events to other systems or over websockets. Samples of
    | each available type of connection are provided inside this array.
    |
    */

    'connections' => [

        'pusher' => [
            'driver' => 'pusher',
            'key' => env('PUSHER_APP_KEY'),
            'secret' => env('PUSHER_APP_SECRET'),
            'app_id' => env('PUSHER_APP_ID'),
            'options' => [
                'cluster' => env('PUSHER_APP_CLUSTER'),
                'useTLS' => true,
            ],
        ],

        /**
         * This is for laravel-websockets. It closely follows
         * the same structure as pusher because it's a drop-in
         * replacement for pusher, but I created it as a new
         * connection in order to be able to quickly switch
         * default connections without changing configuration.
         */
        'localsockets' => [
            'driver' => 'pusher',
            'key' => env('LOCALSOCKETS_APP_KEY'),
            'secret' => env('LOCALSOCKETS_APP_SECRET'),
            'app_id' => env('LOCALSOCKETS_APP_ID'),
            'options' => [
                'cluster' => env('LOCALSOCKETS_APP_CLUSTER'),
                'encrypted' => env('LOCALSOCKETS_ENCRYPTED', 'true') === 'true',
                'useTLS' => env('LOCALSOCKETS_ENCRYPTED', 'true') === 'true',
                'host' => env('LOCALSOCKETS_HOST', '127.0.0.1'),
                'port' => env('LOCALSOCKETS_PORT', 6001),
                'scheme' => env('LOCALSOCKETS_SCHEME', 'http'),
            ],
        ],

        'redis' => [
            'driver' => 'redis',
            'connection' => 'default',
        ],

        'log' => [
            'driver' => 'log',
        ],

        'null' => [
            'driver' => 'null',
        ],

    ],

];
