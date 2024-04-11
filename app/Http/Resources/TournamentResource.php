<?php

namespace App\Http\Resources;

use App\Helpers\AppHelper;
use Illuminate\Http\Resources\Json\JsonResource;

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
			$resourceClass = 'App\\Http\\Resources\\' . AppHelper::instance()->fixEloquentName($relationship) . 'Resource';
			if ($request->has('with') && in_array($relationship, $request->with) && class_exists($resourceClass)) {
				if(substr($relationship, -1) === 's'){
					$data[$relationship] = $resourceClass::collection($this->whenLoaded($relationship));
				}else{
					$data[$relationship] = $resourceClass::make($this->whenLoaded($relationship));
				}
			}
		}
		
		return $data;
	}
}
