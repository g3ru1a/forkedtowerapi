<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RegistrationResource extends JsonResource
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
            'preferred_class' => FFClassResource::make($this->whenLoaded('preferred_class')),
            'preferred_job' => BarePhantomJobResource::make($this->whenLoaded('preferred_job')),
            'flex_classes' => FFClassResource::collection($this->whenLoaded('flex_classes')),
            'flex_jobs' => BarePhantomJobResource::collection($this->whenLoaded('flex_jobs')),
            'can_solo_heal'=> $this['can_solo_heal'],
            'can_english'=> $this['can_english'],
            'can_markers'=> $this['can_markers'],
            'notes' => $this['notes'],
            'status' => $this['status'],
            'deleted_at'=> $this->whenNotNull($this['deleted_at']),
        ];
    }
}
