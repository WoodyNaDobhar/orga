<?php

namespace App\Traits;

trait ProtectFieldsTrait{
	protected static function bootProtectFieldsTrait(){
		static::updating(function ($model) {
			foreach ($model->protectedFields as $field) {
				if ($model->isDirty($field)) {
					$model->setOriginal($field, $model->getOriginal($field));
				}
			}
		});
	}
}