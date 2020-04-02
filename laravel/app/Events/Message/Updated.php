<?php

namespace App\Events\Message;

use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Updated implements ShouldBroadcastNow
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    public function broadcastOn()
    {
        /**
         * An issue with authorizing private channels with laravel sanctum means
         * that we're going public... for now
         */
        return new Channel('channel.' . $this->message->channel->name);
    }

    public function broadcastAs()
    {
        return 'message.updated';
    }

    public function broadcastWith()
    {
        return [
            'uuid' => $this->message->uuid,
            'channel' => $this->message->channel->name,
            'message' => $this->message->is_deleted ? null : $this->message->message,
            'user' => [
                'uuid' => $this->message->user->uuid,
                'name' => $this->message->user->name,
                'initials' => $this->message->user->initials,
                'color' => $this->message->user->color,
                'last_login_at' => optional($this->message->user->last_login_at)->toIso8601String(),
            ],
            'created_at' => $this->message->created_at->toIso8601String(),
            'updated_at' => optional($this->message->updated_at)->toIso8601String(),
            'is_deleted' => $this->message->is_deleted,
        ];
    }
}
