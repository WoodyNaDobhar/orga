<?php

namespace App\Repositories;

use App\Models\Social;
use App\Repositories\BaseRepository;

class SocialRepository extends BaseRepository
{
	protected $fieldSearchable = [
		'sociable_type',
		'sociable_id',
		'media',
		'value'
	];

	public function getFieldsSearchable(): array
	{
		return $this->fieldSearchable;
	}

	public function model(): string
	{
		return Social::class;
	}
}
