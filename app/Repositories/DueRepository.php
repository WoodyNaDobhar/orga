<?php

namespace App\Repositories;

use App\Models\Due;
use App\Repositories\BaseRepository;

class DueRepository extends BaseRepository
{
	protected $fieldSearchable = [
		'persona_id',
		'transaction_id',
		'dues_on',
		'intervals'
	];

	public function getFieldsSearchable(): array
	{
		return $this->fieldSearchable;
	}

	public function model(): string
	{
		return Due::class;
	}
}
