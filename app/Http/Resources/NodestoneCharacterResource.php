<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NodestoneCharacterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this['ID'],
            'name' => $this['Name'],
            'world' => $this['World'],
            'datacenter' => $this['DC'],
            'avatar_url' => $this['Avatar'],
            'bio'  => $this['Bio'],
        ];
    }
}
