<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MeetupResource extends JsonResource
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
            'park_id' => $this->park_id,
            'location_id' => $this->location_id,
            'alt_location_id' => $this->alt_location_id,
            'recurrence' => $this->recurrence,
            'week_of_month' => $this->week_of_month,
            'week_day' => $this->week_day,
            'month_day' => $this->month_day,
            'occurs_at' => $this->occurs_at,
            'purpose' => $this->purpose,
            'description' => $this->description,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at
        ];
    }
}
