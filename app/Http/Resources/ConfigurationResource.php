<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ConfigurationResource extends JsonResource
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
            'configurable_type' => $this->configurable_type,
            'configurable_id' => $this->configurable_id,
            'key' => $this->key,
            'value' => $this->value,
            'is_user_setting' => $this->is_user_setting,
            'allowed_values' => $this->allowed_values,
            'modified' => $this->modified,
            'var_type' => $this->var_type,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at
        ];
    }
}
