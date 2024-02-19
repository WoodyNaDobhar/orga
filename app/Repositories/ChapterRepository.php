<?php

namespace App\Repositories;

use App\Models\Chapter;
use App\Repositories\BaseRepository;

class ChapterRepository extends BaseRepository
{
	protected $fieldSearchable = [
		'realm_id',
		'chaptertype_id',
		'location_id',
		'name',
		'abbreviation',
		'heraldry',
		'is_active'
	];

	public function getFieldsSearchable(): array
	{
		return $this->fieldSearchable;
	}

	public function model(): string
	{
		return Chapter::class;
	}
}
