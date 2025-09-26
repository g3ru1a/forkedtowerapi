<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ScheduleSummary extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'total' => $this['total'],
            'recruiting_count' => $this['recruiting_count'],
            'active_schedules_count' => $this['active_schedules_count'],
        ];
    }
}
