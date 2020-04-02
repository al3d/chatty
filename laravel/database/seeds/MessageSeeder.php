<?php

use App\Models\Channel;
use App\Models\Message;
use App\Models\User;
use Illuminate\Database\Seeder;

class MessageSeeder extends Seeder
{

    public function run()
    {
        $users = User::all();
        $channel = Channel::first();

        factory(Message::class, 100)
            ->create()
            ->each(function (Message $message) use ($users, $channel) {
                $message->user_id = $users->random()->id;
                $message->channel_id = $channel->id;
                $message->save();
            })
        ;
    }

}
