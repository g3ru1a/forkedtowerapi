<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PhantomJobResource extends JsonResource
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
            'icon_url' => $this['icon_url'],
            'level' => $this->pivot->level,
            'current_xp' => $this->pivot->current_xp,
            'max_xp' => $this->pivot->max_xp,
            'mastered' => $this->pivot->mastered,
        ];
    }
}
