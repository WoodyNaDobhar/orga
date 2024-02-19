@php
    echo "<?php".PHP_EOL;
@endphp

namespace {{ $config->namespaces->apiResource }};

use Illuminate\Http\Resources\Json\JsonResource;

class {{ $config->modelNames->name }}Resource extends JsonResource
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
            {!! $fields !!}
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
