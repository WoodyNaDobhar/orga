<?php

namespace App\Http\Resources;

use App\Helpers\AppHelper;
use App\Policies\GuestPolicy;
use Illuminate\Http\Resources\Json\JsonResource;

class GuestResource extends JsonResource
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
			'event_id' => $this->event_id,
			'chapter_id' => $this->chapter_id,
			'is_followedup' => $this->is_followedup,
			'notes' => $this->notes,
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
			$guestPolicy = new GuestPolicy();
			$data['can_list'] = $guestPolicy->viewAny(auth('sanctum')->user(), $this->resource) ? 1 : 0;
			$data['can_view'] = $guestPolicy->delete(auth('sanctum')->user(), $this->resource) ? 1 : 0;
			$data['can_create'] = $guestPolicy->create(auth('sanctum')->user(), $this->resource) ? 1 : 0;
			$data['can_update'] = $guestPolicy->update(auth('sanctum')->user(), $this->resource) ? 1 : 0;
			$data['can_delete'] = $guestPolicy->delete(auth('sanctum')->user(), $this->resource) ? 1 : 0;
			$data['can_restore'] = $guestPolicy->restore(auth('sanctum')->user(), $this->resource) ? 1 : 0;
			$data['can_nuke'] = $guestPolicy->forceDelete(auth('sanctum')->user(), $this->resource) ? 1 : 0;
		}
		
		return $data;
	}
}
