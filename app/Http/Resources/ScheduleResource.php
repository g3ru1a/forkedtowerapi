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
            'host' => CharacterResource::make($this->whenLoaded('host')),
            'type' => RunTypeResource::make($this->whenLoaded('type')),
            'fight' => FightResource::make($this->whenLoaded('fight')),
            'seats' => SeatSimpleResource::collection($this->whenLoaded('seats')),
            'public' => $this['public'],
            'private_key' => $this->whenNotNull($this['private_key']),
            'date' => $this['date'],
            'time' => $this['time'],
            'description' => $this['description'],
            'require_registration' => $this['require_registration'],
            'duration_hours' => $this['duration_hours'],
            'seat_count' => $this['seat_count'],
            'status' => $this['status'],
            'recruiting_count' => $this->whenNotNull($this['recruiting_count']),
            'filled_count' => $this->whenNotNull($this['filled_count']),
            'deleted_at'=> $this->whenNotNull($this['deleted_at']),
        ];
    }
}
