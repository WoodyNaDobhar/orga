<?php

namespace App\Repositories;

use App\Models\Realm;
use App\Repositories\BaseRepository;

class RealmRepository extends BaseRepository
{
	protected $fieldSearchable = [
		'parent_id',
		'name',
		'abbreviation',
		'color',
		'heraldry',
		'is_active',
		'credit_minimum',
		'credit_maximum',
		'daily_minimum',
		'weekly_minimum',
		'average_period_type',
		'average_period',
		'dues_amount',
		'dues_intervals_type',
		'dues_intervals',
		'dues_take'
	];

	public function getFieldsSearchable(): array
	{
		return $this->fieldSearchable;
	}

	public function model(): string
	{
		return Realm::class;
	}
}
