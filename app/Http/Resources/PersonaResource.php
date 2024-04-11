<?php

namespace App\Http\Resources;

use App\Helpers\AppHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class PersonaResource extends JsonResource
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
			'honorific_id' => $this->honorific_id,
			'pronoun_id' => $this->pronoun_id,
			'mundane' => $this->mundane,
			'name' => $this->name,
			'heraldry' => $this->heraldry,
			'image' => $this->image,
			'is_active' => $this->is_active,
			'reeve_qualified_expires_at' => $this->reeve_qualified_expires_at,
			'corpora_qualified_expires_at' => $this->corpora_qualified_expires_at,
			'joined_chapter_at' => $this->joined_chapter_at,
			'chapter_full_abbreviation' => $this->chapter_full_abbreviation,
			'attendance_count' => $this->attendance_count,
			'credit_count' => $this->credit_count,
			'score' => $this->score,
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
