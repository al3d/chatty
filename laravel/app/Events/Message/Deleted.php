<?php

namespace App\Events\Message;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Deleted implements ShouldBroadcastNow
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public $uuid;
    protected $channel;

    public function __construct($message)
    {
        $this->uuid = $message->uuid;
        $this->channel = $message->channel->name;
    }

    public function broadcastOn()
    {
        /**
         * An issue with authorizing private channels with laravel sanctum means
         * that we're going public... for now
         */
        return new Channel('channel.' . $this->channel);
    }

    public function broadcastAs()
    {
        return 'message.deleted';
    }

    public function broadcastWith()
    {
        return [
            'uuid' => $this->message->uuid,
            'channel' => $this->message->channel->name,
        ];
    }
}
