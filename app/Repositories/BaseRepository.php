<?php

namespace App\Repositories;

use Exception;
use Illuminate\Container\Container as Application;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Str;

abstract class BaseRepository
{
	/**
	 * @var Model
	 */
	protected $model;
	
	/**
	 * @var Application
	 */
	protected $app;
	
	/**
	 * @param Application $app
	 *
	 * @throws Exception
	 */
	public function __construct(Application $app)
	{
		$this->app = $app;
		$this->makeModel();
	}
	
	/**
	 * Make Model instance.
	 *
	 * @throws Exception
	 *
	 * @return Model
	 */
	public function makeModel()
	{
		$model = $this->app->make($this->model());
		
		if (!$model instanceof Model) {
			throw new Exception("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
		}
		
		return $this->model = $model;
	}
	
	/**
	 * Configure the Model.
	 *
	 * @return string
	 */
	abstract public function model();
	
	/**
	 * Paginate records for scaffold.
	 *
	 * @param  int  $perPage
	 * @param array $columns
	 *
	 * @return LengthAwarePaginator
	 */
	public function paginate($perPage, $columns = ['*'])
	{
		$query = $this->allQuery();
		
		return $query->paginate($perPage, $columns);
	}
	
	/**
	 * Build a query for retrieving all records.
	 *
	 * @param  array  $search
	 * @param int|null $skip
	 * @param int|null $limit
	 *
	 * @return Builder
	 */
	public function allQuery($search = [], $skip = null, $limit = null)
	{
		$query = $this->model->newQuery();
		
		if (count($search)) {
			foreach ($search as $key => $value) {
				if(is_array($value) && in_array($key, $this->getFieldsSearchable())){
					$query->where(function($q) use($key, $value) {
						foreach($value as $v){
							if($v === 'null'){
								$q->orWhereNull($key);
							}else{
								$q->orWhere($key, $v);
							}
						}
					});
				}else{
					if (in_array($key, $this->getFieldsSearchable())) {
						if($value === 'null'){
							$query->whereNull($key);
						}else{
							$query->where($key, $value);
						}
					}
				}
			}
		}
		
		if (!is_null($skip)) {
			$query->skip($skip);
		}
		
		if (!is_null($limit)) {
			$query->limit($limit);
		}
		
		return $query;
	}
	
	/**
	 * Get searchable fields array.
	 *
	 * @return array
	 */
	abstract public function getFieldsSearchable();
	
	/**
	 * Retrieve all records with given filter criteria.
	 *
	 * @param  array  $search
	 * @param int|null $skip
	 * @param int|null $limit
	 * @param  array  $columns
	 *
	 * @return LengthAwarePaginator|Builder[]|Collection
	 */
	public function all($search = [], $skip = null, $limit = null, $columns = ['*'], $with = null, $sort = ['id' => 'asc'])
	{
		
		$query = $this->allQuery($search, $skip, $limit);
		
		if($with){
			foreach($with as $w){
				$query->with($w);
			}
		}
		
		if ($sort) {
			foreach($sort as $key => $s){
				$query = $query->orderBy($key, $s);
			}
		}
		
		return $query->get($columns);
	}
	
	/**
	 * Create model record.
	 *
	 * @param array $input
	 *
	 * @return Model
	 */
	public function create(array $input): Model
	{
		$model = $this->model->newInstance($input);
		
		// $model->save();
		$this->relatedSave($this->model, $input, $model);
		
		return $model;
	}
	
	/**
	 * Find model record for given id.
	 *
	 * @param  int  $id
	 * @param array $columns
	 *
	 * @return Builder|Builder[]|Collection|Model|null
	 */
	public function find($id, $columns = ['*'], $with = null)
	{
		$query = $this->model->newQuery();
		
		if($with){
			if(is_array($with)){
				foreach($with as $w){
					$query->with($w);
				}
			}else{
				$query->with($with);
			}
		}

		return $query->find($id, $columns);
	}
	
	/**
	 * Update model record for given id.
	 *
	 * @param array $input
	 * @param  int  $id
	 *
	 * @return Builder|Builder[]|Collection|Model
	 */
	public function update($input, $id)
	{
		$query = $this->model->newQuery();
		
		$model = $query->findOrFail($id);
		
		$model->fill($input);
		
		// $model->save();
		$this->relatedSave($this->model, $input, $model);
		
		return $model;
	}
	
	/**
	 * @param int $id
	 *
	 * @throws Exception
	 *
	 * @return bool|mixed|null
	 */
	public function delete($id)
	{
		$query = $this->model->newQuery();
		
		$model = $query->findOrFail($id);
		
		// return $model->delete();
		return $this->relatedDelete($this->model, $model);
	}
	
	/**
	 * @param  int  $id
	 * @param  array  $with
	 *
	 * @return mixed
	 */
	public function findOrFail($id, $with = [])
	{
		if (! empty($with)) {
			$record = $this->model::with($with)->find($id);
		} else {
			$record = $this->model::find($id);
		}
		if (empty($record)) {
			throw new ModelNotFoundException(class_basename($this->model).' not found.');
		}
		
		return $record;
	}
	
	/**
	 * @param  int  $id
	 * @param  array  $columns
	 *
	 * @return mixed
	 */
	public function findWithoutFail($id, $columns = ['*'])
	{
		return $this->find($id, $columns);
	}
	
	protected function relatedSave($model, $input, $parent){
		
		//if any exist
		if (count($model->relationships) > 0) {
			
			//for the pre-save items
			foreach ($model->relationships as $related => $type) {
				
				//clean up non-standard relationships
				$relatedObject = $this->fixEloquentName($related);
				
				//BelongsTo
				if (
						$type == 'BelongsTo' &&
						array_key_exists($related, $input)
						) {
							$thisInput = $input[$related];
							$thisModelBase = $this->app->make("App\\Models\\" . ucfirst($relatedObject));
							if ($thisInput) {
								//exists?
								if (
										array_key_exists('id', $thisInput) &&
										$thisInput['id'] != null
										) {
											//update it
											$thisModel = $thisModelBase->findOrFail($thisInput['id']);
											$thisModel->fill($thisInput);
											$thisModel->save();
											$this->relatedSave($thisModelBase, $thisInput, $thisModel);
										} elseif (array_filter($thisInput)) {
											//create and add it to the parent
											$thisModel = $thisModelBase->newInstance($thisInput);
											$this->relatedSave($thisModelBase, $thisInput, $thisModel);
											$thisModel->save();
											$attribute = $related . '_id';
											$parent->$attribute = $thisModel->id;
										}
							}
						}
			}

			$parent->save();
			
			//for the post-save items
			foreach ($model->relationships as $related => $type) {
				
				//clean up non-standard relationships
				$relatedObject = $this->fixEloquentName($related);
				
				//BelongsToMany
				if (
						($type == 'BelongsToMany' || $type == 'MorphToMany' || $type == 'MorphedByMany') &&
						array_key_exists($related, $input) &&
						$parent->id != null
						) {
							$thisInput = $input[$related];
							if ($thisInput && is_array($thisInput)) {
								if (
										//TODO: this sucks, but at least document it.  Handles those entries that have an order.
										($parent->table == 'collections' && $related == 'lessons') ||
										($parent->table == 'assessments' && $related == 'questions')
										) {
											$pivotData = [];
											foreach ($thisInput as $key => $value) {
												if ($value != '') {
													$pivotData[$value] = ['order' => $key];
												}
											}
											$parent->$related()->sync($pivotData);
										} else {
											$pivotData = [];
											foreach ($thisInput as $key => $value) {
												if ($value != '') {
													$pivotData[] = $value;
												}
											}
											$parent->$related()->sync($pivotData);
										}
							}
						}
						
						//HasOne
						// if (
						//	 $type == 'HasOne' &&
						//	 array_key_exists($related, $input) &&
						//	 $input[$related] != null &&
						//	 $parent->id != null
						// ) {
						//	 $thisInput = $input[$related];
						//	 $thisModelBase = $this->app->make("App\\Models\\" . ucfirst($relatedObject));
						//	 $thisModel = $thisModelBase->findOrFail($thisInput['id']);
						//	 $parentIDField = $this->fixEloquentName($parent->table) . '_id';
						//	 $thisModel->$parentIDField = $parent->id;
						//	 $thisModel->save();
						// }
			}
		}
	}
	
	protected function relatedDelete($model, $parent){
		
		//if any exist
		if(count($model->relationships) > 0){
			foreach($model->relationships as $related => $type){
				
				//clean up non-standard relationships
				$relatedObject = $this->fixEloquentName($related);
				
				//hasMany
				if($type == 'HasMany'){
					
					$relatedModelBase = $this->app->make("App\\Models\\" . ucfirst($relatedObject));
					if(!$relatedModelBase->isNullable($relatedObject . '_id')){
						$relatedModels = $relatedModelBase->where(Str::singular($model->table) . '_id', $parent->id)->get();
						foreach($relatedModels as $relatedModel){
							$this->relatedDelete($relatedModelBase, $relatedModel);
						}
					}
				}elseif(
						$type == 'BelongsToMany' ||
						$type == 'MorphToMany' ||
						$type == 'MorphedByMany'
						){
							$parent->$related()->sync([]);
				}
			}
			$parent->delete();
			return true;
		}
	}
	
	// private function fixReferenceName($table){
	//	 return substr($table, -3) == 'zes' ?
	//		 substr($table, 0, -3) :
	//		 substr($table, -3) == 'ies' ?
	//			 substr($table, 0, -3) . 'y' :
	//				 substr($table, -1) == 's' ?
	//					 substr($table, 0, -1) :
	//					 $table;
	// }
	
	private function fixEloquentName($related){
		switch($related){
			case 'portal':
				return 'Collection';
			case 'portalteams':
				return 'Team';
			case 'author':
			case 'owner' :
			case 'completes' :
			case 'createdBy' :
			case 'updatedBy' :
			case 'deletedBy' :
				return 'User';
			case 'lessonCompletes':
				return 'Lesson';
			case 'collectionCompletes':
				return 'Collection';
			case 'sold':
				return 'Roster';
			case 'owns':
				return 'Team';
			default:
				return Str::singular($related);
		}
	}
}
