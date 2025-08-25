<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AssignmentResource extends JsonResource
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
            'schedule' => ScheduleResource::make($this->whenLoaded('schedule')),
            'user' => UserResource::make($this->whenLoaded('user')),
            'character' => CharacterResource::make($this->whenLoaded('character')),
            'seat' => $this['seat'],
            'class' => $this['class'],
            'job' => $this['job'],
            'is_lead' => $this['is_lead'],
            'is_absent'=> $this['is_absent'],
            'did_participate' => $this['did_participate'],
            'deleted_at'=> $this->whenNotNull($this['deleted_at']),
        ];
    }
}
