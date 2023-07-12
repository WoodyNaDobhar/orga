<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class KingdomTitleResource extends JsonResource
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
            'title_id' => $this->title_id,
            'custom_name' => $this->custom_name,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at
        ];
    }
}
