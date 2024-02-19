<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class OfficerResource extends JsonResource
{
	/**
	 * Transform the resource into an array.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return array
	 */
	public function toArray($request)
	{
		$data = [
			'id' => $this->id,
			'officerable_type' => $this->officerable_type,
			'officerable_id' => $this->officerable_id,
			'office_id' => $this->office_id,
			'persona_id' => $this->persona_id,
			'label' => $this->label,
			'starts_on' => $this->starts_on,
			'ends_on' => $this->ends_on,
			'notes' => $this->notes,
			'created_at' => $this->created_at,
			'updated_at' => $this->updated_at,
			'deleted_at' => $this->deleted_at
		];
		
		//related
		foreach (array_keys($this->relationships) as $relationship) {
			$resourceClass = 'App\\Http\\Resources\\' . ucfirst(Str::singular($relationship)) . 'Resource';
			if ($request->has('with') && in_array($relationship, $request->with) && class_exists($resourceClass)) {
				$data[$relationship] = $resourceClass::collection($this->whenLoaded($relationship));
			}
		}
		
		return $data;
	}
}
