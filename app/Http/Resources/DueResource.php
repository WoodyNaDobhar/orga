<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DueResource extends JsonResource
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
            'user_id' => $this->user_id,
            'park_id' => $this->park_id,
            'transaction_id' => $this->transaction_id,
            'is_for_life' => $this->is_for_life,
            'dues_at' => $this->dues_at,
            'intervals' => $this->intervals,
            'revoked_on' => $this->revoked_on,
            'revoked_by' => $this->revoked_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at
        ];
    }
}
