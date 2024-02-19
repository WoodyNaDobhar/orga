<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class UserResource extends JsonResource
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
			'email' => $this->email,
			'email_verified_at' => $this->email_verified_at,
			'password' => $this->password,
			'remember_token' => $this->remember_token,
			'api_token' => $this->api_token,
			'is_restricted' => $this->is_restricted,
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
