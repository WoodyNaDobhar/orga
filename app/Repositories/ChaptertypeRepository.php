<?php

namespace App\Repositories;

use App\Models\Chaptertype;

class ChaptertypeRepository extends BaseRepository
{
	protected $fieldSearchable = [
		'realm_id',
		'name',
		'rank',
		'minimumattendance',
		'minimumcutoff'
	];

	public function getFieldsSearchable(): array
	{
		return $this->fieldSearchable;
	}

	public function model(): string
	{
		return Chaptertype::class;
	}
}
