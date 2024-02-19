<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class TournamentResource extends JsonResource
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
			'tournamentable_type' => $this->tournamentable_type,
			'tournamentable_id' => $this->tournamentable_id,
			'name' => $this->name,
			'description' => $this->description,
			'occured_at' => $this->occured_at,
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
