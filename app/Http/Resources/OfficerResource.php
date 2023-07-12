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
            'office_id' => $this->office_id,
            'user_id' => $this->user_id,
            'authorized_by' => $this->authorized_by,
            'officerable_type' => $this->officerable_type,
            'officerable_id' => $this->officerable_id,
            'scope' => $this->scope,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at
        ];
    }
}
