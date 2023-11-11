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
            'persona_id' => $this->persona_id,
            'transaction_id' => $this->transaction_id,
            'dues_on' => $this->dues_on,
            'intervals' => $this->intervals,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at
        ];
    }
}
