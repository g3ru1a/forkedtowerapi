<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'discord_id' => $this['discord_id'],
            'username' => $this['discord_nickname'],
            'handle' => $this['discord_username'],
            'avatar_url' => $this['discord_avatar_url'],
            'email' => $this['email'],
            'characters' => CharacterResource::collection($this->whenLoaded('characters')),
            'bot_notifications' =>  $this['bot_notifications']
        ];
    }
}
