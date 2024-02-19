<?php

namespace App\Traits;

use App\Exceptions\ApiOperationFailedException;
use Illuminate\Support\Facades\DB;
use Throwable;
use Illuminate\Support\Facades\Log;

/**
 * Trait NullableTrait.
 */
trait NullableTrait
{
	
	protected static $columnsInfo = NULL;
	protected static $nullableFields = NULL;

	/**
	 * @param string	   $field
	 *
	 * @throws ApiOperationFailedException
	 *
	 * @return boolean
	 */
	public function isNullable(string $field){
		try {
			if (is_null(static::$columnsInfo) ){
				static::$columnsInfo = DB::select('show columns from '.$this->gettable() );
			}
			if (is_null(static::$nullableFields) ){
				static::$nullableFields = array_map( function ($fld){return $fld->Field;}, array_filter(static::$columnsInfo,function($v){return $v->Null=='YES';}));
			}
			return in_array( $field, static::$nullableFields );
		} catch (Throwable $e) {
			Log::info($e->getMessage());
			throw new ApiOperationFailedException($e->getMessage(), $e->getCode());
		}
	}
}
