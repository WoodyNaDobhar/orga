<?php

namespace App\Http\Resources;

use App\Helpers\AppHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class IssuanceResource extends JsonResource
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
			'issuable_type' => $this->issuable_type,
			'issuable_id' => $this->issuable_id,
			'whereable_type' => $this->whereable_type,
			'whereable_id' => $this->whereable_id,
			'issuer_type' => $this->issuer_type,
			'issuer_id' => $this->issuer_id,
			'recipient_type' => $this->recipient_type,
			'recipient_id' => $this->recipient_id,
			'signator_id' => $this->signator_id,
			'custom_name' => $this->custom_name,
			'rank' => $this->rank,
			'issued_at' => $this->issued_at,
			'reason' => $this->reason,
			'image' => $this->image,
			'name' => $this->name,
			'revoked_by' => $this->revoked_by,
			'revoked_at' => $this->revoked_at,
			'revocation' => $this->revocation,
			'created_at' => $this->created_at,
			'updated_at' => $this->updated_at,
			'deleted_at' => $this->deleted_at,
			'issuable' => $this->issuable
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
