<?php

namespace App\Repositories;

use App\Models\Officer;
use App\Repositories\BaseRepository;

class OfficerRepository extends BaseRepository
{
	protected $fieldSearchable = [
		'officerable_type',
		'officerable_id',
		'office_id',
		'persona_id',
		'label',
		'starts_on',
		'ends_on',
		'notes'
	];

	public function getFieldsSearchable(): array
	{
		return $this->fieldSearchable;
	}

	public function model(): string
	{
		return Officer::class;
	}
}
