<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PronounResource extends JsonResource
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
            'subject' => $this->subject,
            'object' => $this->object,
            'possessive' => $this->possessive,
            'possessivepronoun' => $this->possessivepronoun,
            'reflexive' => $this->reflexive,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at
        ];
    }
}
