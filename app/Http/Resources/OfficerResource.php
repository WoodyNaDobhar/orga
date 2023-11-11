<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OfficerResource extends JsonResource
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
            'officeable_type' => $this->officeable_type,
            'officeable_id' => $this->officeable_id,
            'office_id' => $this->office_id,
            'persona_id' => $this->persona_id,
            'authorized_by' => $this->authorized_by,
            'label' => $this->label,
            'starts_on' => $this->starts_on,
            'ends_on' => $this->ends_on,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at
        ];
    }
}
