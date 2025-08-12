<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CharacterResource extends JsonResource
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
            'user' => UserResource::make($this->whenLoaded('user')),
            'lodestone_id' => $this['lodestone_id'],
            'name' => $this['name'],
            'world' => $this['world'],
            'datacenter' => $this['datacenter'],
            'avatar_url' => $this['avatar_url'],
            'verified' => $this['verified'],
            'deleted_at' => $this->when($this['deleted_at'] != null, $this['deleted_at']),
        ];
    }
}
