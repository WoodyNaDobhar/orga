<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'pronoun_id' => $this->pronoun_id,
            'name' => $this->name,
            'persona' => $this->persona,
            'heraldry' => $this->heraldry,
            'image' => $this->image,
            'email' => $this->email,
            'email_verified_at' => $this->email_verified_at,
            'password' => $this->password,
            'remember_token' => $this->remember_token,
            'restricted' => $this->restricted,
            'waivered' => $this->waivered,
            'waiver_ext' => $this->waiver_ext,
            'penalty_box' => $this->penalty_box,
            'is_active' => $this->is_active,
            'reeve_qualified_expires' => $this->reeve_qualified_expires,
            'corpora_qualified_expires' => $this->corpora_qualified_expires,
            'joined_park_at' => $this->joined_park_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at
        ];
    }
}
