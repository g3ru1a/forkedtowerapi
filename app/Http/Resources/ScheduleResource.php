<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ScheduleResource extends JsonResource
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
            'group' => GroupResource::make($this->whenLoaded('group')),
            'host' => UserResource::make($this->whenLoaded('host')),
            'type' => RunTypeResource::make($this->whenLoaded('type')),
            'public' => $this['public'],
            'date' => $this['date'],
            'time' => $this['time'],
            'description' => $this['description'],
            'registration_open' => $this['registration_open'],
            'registration_deadline' => $this['registration_deadline'],
            'slots' => $this['slots'],
            'deleted_at'=> $this->whenNotNull($this['deleted_at']),
        ];
    }
}
