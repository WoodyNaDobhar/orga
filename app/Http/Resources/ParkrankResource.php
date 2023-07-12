<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ParkrankResource extends JsonResource
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
            'kingdom_id' => $this->kingdom_id,
            'name' => $this->name,
            'rank' => $this->rank,
            'minimumattendance' => $this->minimumattendance,
            'minimumcutoff' => $this->minimumcutoff,
            'period' => $this->period,
            'period_length' => $this->period_length,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at
        ];
    }
}
