<?php

namespace App\Http\Resources;

use App\Helpers\AppHelper;
use App\Policies\SuspensionPolicy;
use Illuminate\Http\Resources\Json\JsonResource;

class SuspensionResource extends JsonResource
{
	/**
	 * Transform the resource into an array.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return array
	 */
	public function toArray($request)
	{
		return [
			'id' => $this->id,
			'persona_id' => $this->persona_id,
			'suspendable_type' => $this->suspendable_type,
			'suspendable_id' => $this->suspendable_id,
			'suspended_by' => $this->suspended_by,
			'suspended_at' => $this->suspended_at,
			'expires_at' => $this->expires_at,
			'cause' => $this->cause,
			'is_propogating' => $this->is_propogating,
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
			$suspensionPolicy = new SuspensionPolicy();
			$data['can_list'] = $suspensionPolicy->viewAny(auth('sanctum')->user(), $this->resource) ? 1 : 0;
			$data['can_view'] = $suspensionPolicy->delete(auth('sanctum')->user(), $this->resource) ? 1 : 0;
			$data['can_create'] = $suspensionPolicy->create(auth('sanctum')->user(), $this->resource) ? 1 : 0;
			$data['can_update'] = $suspensionPolicy->update(auth('sanctum')->user(), $this->resource) ? 1 : 0;
			$data['can_delete'] = $suspensionPolicy->delete(auth('sanctum')->user(), $this->resource) ? 1 : 0;
			$data['can_restore'] = $suspensionPolicy->restore(auth('sanctum')->user(), $this->resource) ? 1 : 0;
			$data['can_nuke'] = $suspensionPolicy->forceDelete(auth('sanctum')->user(), $this->resource) ? 1 : 0;
		}
	}
}
