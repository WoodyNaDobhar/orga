<?php

namespace App\Http\Resources;

use App\Helpers\AppHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class MeetupResource extends JsonResource
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
			'chapter_id' => $this->chapter_id,
			'location_id' => $this->location_id,
			'is_active' => $this->is_active,
			'purpose' => $this->purpose,
			'recurrence' => $this->recurrence,
			'week_of_month' => $this->week_of_month,
			'week_day' => $this->week_day,
			'month_day' => $this->month_day,
			'occurs_at' => $this->occurs_at,
			'description' => $this->description,
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
