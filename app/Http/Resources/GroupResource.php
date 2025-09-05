<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GroupResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this['id'],
            'name' => $this['name'],
            'private_path' => $this['private_path'],
            'color' => $this['color'],
            'badge_text' => $this['badge_text'],
            'gradient' => $this['gradient'],
            'discord_invite' => $this['discord_invite'],
            'owner' => UserResource::make($this->owner),
            'members' => UserResource::collection($this->whenLoaded('members')),
            'deleted_at' => $this->whenNotNull('deleted_at'),
        ];
    }
}
