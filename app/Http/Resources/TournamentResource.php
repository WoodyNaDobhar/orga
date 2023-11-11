<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TournamentResource extends JsonResource
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
            'tournamentable_type' => $this->tournamentable_type,
            'tournamentable_id' => $this->tournamentable_id,
            'name' => $this->name,
            'description' => $this->description,
            'url' => $this->url,
            'occured_at' => $this->occured_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at
        ];
    }
}
