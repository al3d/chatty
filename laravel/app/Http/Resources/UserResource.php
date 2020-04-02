<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{

    protected $isOwner = false;

    public function isOwner(bool $isOwner): self
    {
        $this->isOwner = $isOwner;
        return $this;
    }

    public function toArray($request): array
    {
        return [
            'uuid' => $this->uuid,
            'name' => $this->name,
            'initials' => $this->initials,
            'color' => $this->color,
            'notifications' => $this->when($this->isOwner, []),
            'email' => $this->when($this->isOwner, $this->email),
            'last_login_at' => optional($this->last_login_at)->toIso8601String(),
            'created_at' => $this->when($this->isOwner, $this->created_at->toIso8601String()),
            'updated_at' => $this->when($this->isOwner, optional($this->updated_at)->toIso8601String()),
        ];
    }
}
