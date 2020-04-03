<?php

use App\Models\Channel;
use App\Models\User;
use Illuminate\Database\Seeder;

class ChannelSeeder extends Seeder
{

    public function run()
    {
        // No creator set for general channel
        $channel = Channel::create([
            'name' => 'general',
            'description' => 'Description for the general channel for Chatty'
        ]);

        User::all()->each(function (User $user) use ($channel) {
            $channel
                ->members()
                ->attach($user)
            ;
        });
    }
}
