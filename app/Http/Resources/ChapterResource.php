<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ChapterResource extends JsonResource
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
            'realm_id' => $this->realm_id,
            'chaptertype_id' => $this->chaptertype_id,
            'location_id' => $this->location_id,
            'name' => $this->name,
            'abbreviation' => $this->abbreviation,
            'heraldry' => $this->heraldry,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at
        ];
    }
}
