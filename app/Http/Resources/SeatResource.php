<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SeatResource extends JsonResource
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
            'character' => CharacterResource::make($this->whenLoaded('character')),
            'registration' => RegistrationResource::make($this->whenLoaded('registration')),
            'class' => FFClassResource::make($this->whenLoaded('ffclass')),
            'phantom_job' => PhantomJobResource::make($this->whenLoaded('phantom_job')),
            'number' => $this['number'],
            'is_raidlead' => $this['is_raidlead'],
            'deleted_at' => $this->whenNotNull($this, 'deleted_at'),
        ];
    }
}
