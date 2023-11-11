<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CratResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'event_id' => $this->event_id,
            'persona_id' => $this->persona_id,
            'role' => $this->role,
            'is_autocrat' => $this->is_autocrat,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at
        ];
    }
}
