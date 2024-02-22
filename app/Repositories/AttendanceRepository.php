<?php

namespace App\Repositories;

use App\Models\Attendance;

class AttendanceRepository extends BaseRepository
{
	protected $fieldSearchable = [
		'archetype_id',
		'attendable_type',
		'attendable_id',
		'persona_id',
		'attended_at',
		'credits'
	];

	public function getFieldsSearchable(): array
	{
		return $this->fieldSearchable;
	}

	public function model(): string
	{
		return Attendance::class;
	}
}
