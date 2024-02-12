<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WaiverResource extends JsonResource
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
            'guest_id' => $this->guest_id,
            'location_id' => $this->location_id,
            'pronoun_id' => $this->pronoun_id,
            'persona_id' => $this->persona_id,
            'waiverable_type' => $this->waiverable_type,
            'waiverable_id' => $this->waiverable_id,
            'file' => $this->file,
            'player' => $this->player,
            'email' => $this->email,
            'phone' => $this->phone,
            'dob' => $this->dob,
            'age_verified_at' => $this->age_verified_at,
            'age_verified_by' => $this->age_verified_by,
            'guardian' => $this->guardian,
            'emergency_name' => $this->emergency_name,
            'emergency_relationship' => $this->emergency_relationship,
            'emergency_phone' => $this->emergency_phone,
            'signed_at' => $this->signed_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at
        ];
    }
}
