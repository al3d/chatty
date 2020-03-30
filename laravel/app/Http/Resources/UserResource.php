<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{

    protected $is_owner = false;

    public function isOwner(bool $isOwner): self
    {
        $this->is_owner = $isOwner;
        return $this;
    }

    public function toArray($request): array
    {
        return [
            'uuid' => $this->uuid,
            'name' => $this->name,
            'email' => $this->when($this->is_owner, $this->email),
            'last_login_at' => $this->last_login_at->toIso8601String(),
            'created_at' => $this->when($this->is_owner, $this->created_at->toIso8601String()),
            'updated_at' => $this->when($this->is_owner, optional($this->updated_at)->toIso8601String()),
        ];
    }
}
