<?php

namespace App\Repositories;

use App\Models\Meetup;

class MeetupRepository extends BaseRepository
{
	protected $fieldSearchable = [
		'chapter_id',
		'location_id',
		'name',
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
