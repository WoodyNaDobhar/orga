<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class IssuanceResource extends JsonResource
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
            'issuable_type' => $this->issuable_type,
            'issuable_id' => $this->issuable_id,
            'user_id' => $this->user_id,
            'issuer_id' => $this->issuer_id,
            'issuedable_type' => $this->issuedable_type,
            'issuedable_id' => $this->issuedable_id,
            'custom_name' => $this->custom_name,
            'rank' => $this->rank,
            'issued_at' => $this->issued_at,
            'note' => $this->note,
            'image' => $this->image,
            'revocation' => $this->revocation,
            'revoked_by' => $this->revoked_by,
            'revoked_at' => $this->revoked_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at
        ];
    }
}
