<?php

namespace App\Http\Resources;

use App\Helpers\AppHelper;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Policies\PersonaPolicy;

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
			'is_officer' => $this->is_officer,
			'is_paid' => $this->is_paid,
			'is_suspended' => $this->is_suspended,
			'is_waivered' => $this->is_waivered,
			'reeve_qualified_expires_at' => $this->reeve_qualified_expires_at,
			'corpora_qualified_expires_at' => $this->corpora_qualified_expires_at,
			'joined_chapter_at' => $this->joined_chapter_at,
			'awards' => $this->awards,
			'roptitles' => $this->roptitles,
			'chapter_full_abbreviation' => $this->chapter_full_abbreviation,
			'credits' => $this->credits,
			'score' => $this->score,
			'can_list' => 0,
			'can_view' => 0,
			'can_create' => 0,
			'can_update' => 0,
			'can_delete' => 0,
			'can_restore' => 0,
			'can_nuke' => 0,
			'created_at' => $this->created_at,
			'updated_at' => $this->updated_at,
			'deleted_at' => $this->deleted_at
		];
		
		//related
		foreach (array_keys($this->relationships) as $relationship) {
			$resourceClass = 'App\\Http\\Resources\\' . AppHelper::instance()->fixEloquentName($relationship) . 'Resource';
			if ($request->has('with') && class_exists($resourceClass)) {
				$matches = [];
				foreach ($request->with as $withItem) {
					if (
						$relationship === $withItem || 
						(
							(
								strpos($withItem, $this->table . '.') !== false ||
								strpos($withItem, substr($this->table, 0, -1) . '.') !== false
							) &&
							preg_match('/' . substr($this->table, 0, -1) . '\.(.*?)(?:\.|$)/', $withItem, $matches) &&
							$matches[1] === $relationship
						)
					) {
						if (substr($relationship, -1) === 's') {
							$data[$relationship] = $resourceClass::collection($this->whenLoaded($relationship));
						} else {
							$data[$relationship] = $resourceClass::make($this->whenLoaded($relationship));
						}
					}
				}
			}
		}
		
		if(auth('sanctum')->check()){
			$personaPolicy = new PersonaPolicy();
			$data['can_list'] = $personaPolicy->viewAny(auth('sanctum')->user(), $this->resource) ? 1 : 0;
			$data['can_view'] = $personaPolicy->delete(auth('sanctum')->user(), $this->resource) ? 1 : 0;
			$data['can_create'] = $personaPolicy->create(auth('sanctum')->user(), $this->resource) ? 1 : 0;
			$data['can_update'] = $personaPolicy->update(auth('sanctum')->user(), $this->resource) ? 1 : 0;
			$data['can_delete'] = $personaPolicy->delete(auth('sanctum')->user(), $this->resource) ? 1 : 0;
			$data['can_restore'] = $personaPolicy->restore(auth('sanctum')->user(), $this->resource) ? 1 : 0;
			$data['can_nuke'] = $personaPolicy->forceDelete(auth('sanctum')->user(), $this->resource) ? 1 : 0;
		}
		
		return $data;
	}
}
