<?php

namespace App\Http\Resources;

use App\Helpers\AppHelper;
use App\Policies\OfficePolicy;
use Illuminate\Http\Resources\Json\JsonResource;

class OfficeResource extends JsonResource
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
			'officeable_type' => $this->officeable_type,
			'officeable_id' => $this->officeable_id,
			'name' => $this->name,
			'duration' => $this->duration,
			'order' => $this->order,
			'is_forgiven' => $this->is_forgiven,
			'is_midreign' => $this->is_midreign,
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
				foreach ($request->with as $withItem) {
					$withItems = explode('.', $withItem);
					if (
						$relationship === $withItem || 
						(
							(
								strpos(\AppHelper::instance()->fixWithName($withItem), $this->table . '.') !== false ||
								strpos(\AppHelper::instance()->fixWithName($withItem), substr($this->table, 0, -1) . '.') !== false
							) &&
							(
								$withItems[0] === \AppHelper::instance()->fixTableName($this->table) ||
								$withItems[0] . 's' === \AppHelper::instance()->fixTableName($this->table) ||
								strpos(\AppHelper::instance()->fixTableName($this->table) . '|', $withItems[0]) !== false ||
								strpos('|' . \AppHelper::instance()->fixTableName($this->table), $withItems[0]) !== false 
							) &&
							count($withItems) > 1 &&
							$withItems[1] === $relationship
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
			$officePolicy = new OfficePolicy();
			$data['can_list'] = $officePolicy->viewAny(auth('sanctum')->user(), $this->resource) ? 1 : 0;
			$data['can_view'] = $officePolicy->view(auth('sanctum')->user(), $this->resource) ? 1 : 0;
			$data['can_create'] = $officePolicy->create(auth('sanctum')->user(), $this->resource) ? 1 : 0;
			$data['can_update'] = $officePolicy->update(auth('sanctum')->user(), $this->resource) ? 1 : 0;
			$data['can_delete'] = $officePolicy->delete(auth('sanctum')->user(), $this->resource) ? 1 : 0;
			$data['can_restore'] = $officePolicy->restore(auth('sanctum')->user(), $this->resource) ? 1 : 0;
			$data['can_nuke'] = $officePolicy->forceDelete(auth('sanctum')->user(), $this->resource) ? 1 : 0;
		}
		
		return $data;
	}
}
