<?php

use App\Models\Channel;
use App\Models\ChannelUser;
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
            ChannelUser::create([
                'channel_id' => $channel->id,
                'user_id' => $user->id,
            ]);
        });
    }
}
