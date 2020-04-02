<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{

    public function toArray($request): array
    {
        return [
            'uuid' => $this->uuid,
            'channel' => $this->channel->name,
            'message' => $this->is_deleted ? null : $this->message,
            'user' => new UserResource($this->user),
            'created_at' => $this->created_at->toIso8601String(),
            'updated_at' => optional($this->updated_at)->toIso8601String(),
            'is_deleted' => $this->is_deleted,
        ];
    }
}
