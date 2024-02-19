<?php

namespace App\Repositories;

use App\Models\Tournament;
use App\Repositories\BaseRepository;

class TournamentRepository extends BaseRepository
{
	protected $fieldSearchable = [
		'tournamentable_type',
		'tournamentable_id',
		'name',
		'description',
		'occured_at'
	];

	public function getFieldsSearchable(): array
	{
		return $this->fieldSearchable;
	}

	public function model(): string
	{
		return Tournament::class;
	}
}
