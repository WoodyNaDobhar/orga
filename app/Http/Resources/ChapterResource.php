<?php

namespace App\Http\Resources;

use App\Helpers\AppHelper;
use App\Policies\ChapterPolicy;
use Illuminate\Http\Resources\Json\JsonResource;

class ChapterResource extends JsonResource
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
			'realm_id' => $this->realm_id,
			'chaptertype_id' => $this->chaptertype_id,
			'location_id' => $this->location_id,
			'name' => $this->name,
			'abbreviation' => $this->abbreviation,
			'full_abbreviation' => $this->full_abbreviation,
			'heraldry' => $this->heraldry,
			'is_active' => $this->is_active,
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
			$chapterPolicy = new ChapterPolicy();
			$data['can_list'] = $chapterPolicy->viewAny(auth('sanctum')->user(), $this->resource) ? 1 : 0;
			$data['can_view'] = $chapterPolicy->delete(auth('sanctum')->user(), $this->resource) ? 1 : 0;
			$data['can_create'] = $chapterPolicy->create(auth('sanctum')->user(), $this->resource) ? 1 : 0;
			$data['can_update'] = $chapterPolicy->update(auth('sanctum')->user(), $this->resource) ? 1 : 0;
			$data['can_delete'] = $chapterPolicy->delete(auth('sanctum')->user(), $this->resource) ? 1 : 0;
			$data['can_restore'] = $chapterPolicy->restore(auth('sanctum')->user(), $this->resource) ? 1 : 0;
			$data['can_nuke'] = $chapterPolicy->forceDelete(auth('sanctum')->user(), $this->resource) ? 1 : 0;
		}
		
		return $data;
	}
}
