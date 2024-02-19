<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class SuspensionResource extends JsonResource
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
			'suspendable_type' => $this->suspendable_type,
			'suspendable_id' => $this->suspendable_id,
			'suspended_by' => $this->suspended_by,
			'suspended_at' => $this->suspended_at,
			'expires_at' => $this->expires_at,
			'cause' => $this->cause,
			'is_propogating' => $this->is_propogating,
			'created_at' => $this->created_at,
			'updated_at' => $this->updated_at,
			'deleted_at' => $this->deleted_at
		];
	}
}
