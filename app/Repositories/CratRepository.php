<?php

namespace App\Repositories;

use App\Models\Crat;

class CratRepository extends BaseRepository
{
	protected $fieldSearchable = [
		'event_id',
		'persona_id',
		'role',
		'is_autocrat'
	];

	public function getFieldsSearchable(): array
	{
		return $this->fieldSearchable;
	}

	public function model(): string
	{
		return Crat::class;
	}
}
