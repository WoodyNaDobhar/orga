<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

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
			'pronoun_id' => $this->pronoun_id,
			'mundane' => $this->mundane,
			'name' => $this->name,
			'heraldry' => $this->heraldry,
			'image' => $this->image,
			'is_active' => $this->is_active,
			'reeve_qualified_expires_at' => $this->reeve_qualified_expires_at,
			'corpora_qualified_expires_at' => $this->corpora_qualified_expires_at,
			'joined_chapter_at' => $this->joined_chapter_at,
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
