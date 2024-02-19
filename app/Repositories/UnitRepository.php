<?php

namespace App\Repositories;

use App\Models\Unit;
use App\Repositories\BaseRepository;

class UnitRepository extends BaseRepository
{
	protected $fieldSearchable = [
		'type',
		'name',
		'heraldry',
		'description',
		'history'
	];

	public function getFieldsSearchable(): array
	{
		return $this->fieldSearchable;
	}

	public function model(): string
	{
		return Unit::class;
	}
}
