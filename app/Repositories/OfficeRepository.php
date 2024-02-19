<?php

namespace App\Repositories;

use App\Models\Office;
use App\Repositories\BaseRepository;

class OfficeRepository extends BaseRepository
{
	protected $fieldSearchable = [
		'officeable_type',
		'officeable_id',
		'name',
		'duration',
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
