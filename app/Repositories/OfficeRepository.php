<?php

namespace App\Repositories;

use App\Models\Office;

class OfficeRepository extends BaseRepository
{
	protected $fieldSearchable = [
		'officeable_type',
		'officeable_id',
		'name',
		'duration',
		'is_forgiven',
		'is_midreign',
		'order'
	];

	public function getFieldsSearchable(): array
	{
		return $this->fieldSearchable;
	}

	public function model(): string
	{
		return Office::class;
	}
}
