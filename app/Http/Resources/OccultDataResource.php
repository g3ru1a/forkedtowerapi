<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OccultDataResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'knowledge_level' => $this['knowledge_level'],
            'phantom_mastery' =>  $this['phantom_mastery'],
            'phantom_jobs_json' => $this['phantom_jobs'],
        ];
    }
}
