<?php

namespace App\Http\Resources;

use App\Helpers\AppHelper;
use App\Policies\RecommendationPolicy;
use Illuminate\Http\Resources\Json\JsonResource;

class RecommendationResource extends JsonResource
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
			'persona_id' => $this->persona_id,
			'recommendable_type' => $this->recommendable_type,
			'recommendable_id' => $this->recommendable_id,
			'rank' => $this->rank,
			'is_anonymous' => $this->is_anonymous,
			'reason' => $this->reason,
			'can_list' => 0,
			'can_view' => 0,
			'can_create' => 0,
			'can_update' => 0,
			'can_delete' => 0,
			'can_restore' => 0,
			'can_nuke' => 0,
			'created_at' => $this->created_at,
			'updated_at' => $this->updated_at,
			'deleted_at' => $this->deleted_at,
		];
		
		//related
		foreach (array_keys($this->relationships) as $relationship) {
			$attachName = $relationship;
			if (array_key_exists($relationship . '_type', $data)) {
				$plural = substr($relationship, -1) === 's' ? true : false;
				$relationship = strtolower($data[$relationship . '_type']) . ($plural ? 's' : '');
			}
			$resourceClass = 'App\\Http\\Resources\\' . AppHelper::instance()->fixEloquentName($relationship) . 'Resource';
			if ($request->has('with') && class_exists($resourceClass)) {
				foreach ($request->with as $withItem) {
					$withItems = explode('.', $withItem);
					if (
						$relationship === $withItem || 
						(
							(
								strpos(AppHelper::instance()->fixWithName($withItem), $this->table . '.') !== false ||
								strpos(AppHelper::instance()->fixWithName($withItem), substr($this->table, 0, -1) . '.') !== false
							) &&
							(
								$withItems[0] === AppHelper::instance()->fixTableName($this->table) ||
								$withItems[0] . 's' === AppHelper::instance()->fixTableName($this->table) ||
								strpos(\AppHelper::instance()->fixTableName($this->table) . '|', $withItems[0]) !== false ||
								strpos('|' . AppHelper::instance()->fixTableName($this->table), $withItems[0]) !== false 
							) &&
							count($withItems) > 1 &&
							$withItems[1] === $attachName
						)
					) {
						if (substr($relationship, -1) === 's') {
							$data[$attachName] = $resourceClass::collection($this->whenLoaded($attachName));
						} else {
							$data[$attachName] = $resourceClass::make($this->whenLoaded($attachName));
						}
					}
				}
			}
		}
		
		if(auth('sanctum')->check()){
			$recommendationPolicy = new RecommendationPolicy();
			$data['can_list'] = $recommendationPolicy->viewAny(auth('sanctum')->user(), $this->resource) ? 1 : 0;
			$data['can_view'] = $recommendationPolicy->view(auth('sanctum')->user(), $this->resource) ? 1 : 0;
			$data['can_create'] = $recommendationPolicy->create(auth('sanctum')->user(), $this->resource) ? 1 : 0;
			$data['can_update'] = $recommendationPolicy->update(auth('sanctum')->user(), $this->resource) ? 1 : 0;
			$data['can_delete'] = $recommendationPolicy->delete(auth('sanctum')->user(), $this->resource) ? 1 : 0;
			$data['can_restore'] = $recommendationPolicy->restore(auth('sanctum')->user(), $this->resource) ? 1 : 0;
			$data['can_nuke'] = $recommendationPolicy->forceDelete(auth('sanctum')->user(), $this->resource) ? 1 : 0;
		}
		
		return $data;
	}
}
