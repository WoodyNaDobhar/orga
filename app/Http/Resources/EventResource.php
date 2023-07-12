<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
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
            'eventable_type' => $this->eventable_type,
            'eventable_id' => $this->eventable_id,
            'autocrat_id' => $this->autocrat_id,
            'location_id' => $this->location_id,
            'name' => $this->name,
            'description' => $this->description,
            'event_start' => $this->event_start,
            'event_end' => $this->event_end,
            'price' => $this->price,
            'url' => $this->url,
            'url_name' => $this->url_name,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at
        ];
    }
}
