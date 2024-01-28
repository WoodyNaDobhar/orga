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
            'whereable_type' => $this->whereable_type,
            'whereable_id' => $this->whereable_id,
            'authority_type' => $this->authority_type,
            'authority_id' => $this->authority_id,
            'recipient_type' => $this->recipient_type,
            'recipient_id' => $this->recipient_id,
            'issuer_id' => $this->issuer_id,
            'custom_name' => $this->custom_name,
            'rank' => $this->rank,
            'issued_at' => $this->issued_at,
            'reason' => $this->reason,
            'image' => $this->image,
            'revoked_by' => $this->revoked_by,
            'revoked_at' => $this->revoked_at,
            'revocation' => $this->revocation,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at
        ];
    }
}
