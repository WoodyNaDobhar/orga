<?php

namespace App\Repositories;

use App\Models\Meetup;
use App\Repositories\BaseRepository;

class MeetupRepository extends BaseRepository
{
	protected $fieldSearchable = [
		'chapter_id',
		'location_id',
		'is_active',
		'purpose',
		'recurrence',
		'week_of_month',
		'week_day',
		'month_day',
		'occurs_at',
		'description'
	];

	public function getFieldsSearchable(): array
	{
		return $this->fieldSearchable;
	}

	public function model(): string
	{
		return Meetup::class;
	}
}
