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
			'sponsorable_type' => $this->sponsorable_type,
			'sponsorable_id' => $this->sponsorable_id,
			'location_id' => $this->location_id,
			'name' => $this->name,
			'description' => $this->description,
			'image' => $this->image,
			'is_active' => $this->is_active,
			'is_demo' => $this->is_demo,
			'event_started_at' => $this->event_started_at,
			'event_ended_at' => $this->event_ended_at,
			'price' => $this->price,
			'created_at' => $this->created_at,
			'updated_at' => $this->updated_at,
			'deleted_at' => $this->deleted_at
		];
	}
}
