<?php

namespace App\Repositories;

use App\Models\Title;

class TitleRepository extends BaseRepository
{
	protected $fieldSearchable = [
		'titleable_type',
		'titleable_id',
		'name',
		'rank',
		'peerage',
		'is_roaming',
		'is_active'
	];

	public function getFieldsSearchable(): array
	{
		return $this->fieldSearchable;
	}

	public function model(): string
	{
		return Title::class;
	}
}
