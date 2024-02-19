<?php

namespace App\Models;

use App\Traits\NullableTrait;

class PasswordHistory extends BaseModel
{
	use NullableTrait;

	public $table = 'password_histories';
	public $timestamps = false;
	
	const CREATED_AT = 'created_at';

	public $fillable = [
		'user_id',
		'password'
	];

	/**
	 * The attributes that should be casted to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		'id' => 'integer',
		'user_id' => 'integer',
		'password' => 'string'
	];

	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public static $rules = [
		'user_id' => 'required',
		'password' => 'required'
	];
	
	/**
	 * The relationships map for the model.
	 *
	 * @var array
	 */
	public $relationships = [
		'user' => 'BelongsTo'
	];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 **/
	public function user()
	{
		return $this->belongsTo(\App\Models\User::class, 'user_id');
	}
}
