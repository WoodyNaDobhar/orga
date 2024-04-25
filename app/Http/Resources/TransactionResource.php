<?php

namespace App\Http\Resources;

use App\Helpers\AppHelper;
use App\Policies\TransactionPolicy;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
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
			'description' => $this->description,
			'memo' => $this->memo,
			'transaction_at' => $this->transaction_at,
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
			$transactionPolicy = new TransactionPolicy();
			$data['can_list'] = $transactionPolicy->viewAny(auth('sanctum')->user(), $this->resource) ? 1 : 0;
			$data['can_view'] = $transactionPolicy->view(auth('sanctum')->user(), $this->resource) ? 1 : 0;
			$data['can_create'] = $transactionPolicy->create(auth('sanctum')->user(), $this->resource) ? 1 : 0;
			$data['can_update'] = $transactionPolicy->update(auth('sanctum')->user(), $this->resource) ? 1 : 0;
			$data['can_delete'] = $transactionPolicy->delete(auth('sanctum')->user(), $this->resource) ? 1 : 0;
			$data['can_restore'] = $transactionPolicy->restore(auth('sanctum')->user(), $this->resource) ? 1 : 0;
			$data['can_nuke'] = $transactionPolicy->forceDelete(auth('sanctum')->user(), $this->resource) ? 1 : 0;
		}
		
		return $data;
	}
}
