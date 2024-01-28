<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RealmResource extends JsonResource
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
            'parent_id' => $this->parent_id,
            'name' => $this->name,
            'abbreviation' => $this->abbreviation,
            'color' => $this->color,
            'heraldry' => $this->heraldry,
            'is_active' => $this->is_active,
            'credit_minimum' => $this->credit_minimum,
            'credit_maximum' => $this->credit_maximum,
            'daily_minimum' => $this->daily_minimum,
            'weekly_minimum' => $this->weekly_minimum,
            'average_period_type' => $this->average_period_type,
            'average_period' => $this->average_period,
            'dues_amount' => $this->dues_amount,
            'dues_intervals_type' => $this->dues_intervals_type,
            'dues_intervals' => $this->dues_intervals,
            'dues_take' => $this->dues_take,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at
        ];
    }
}
