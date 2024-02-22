<?php

namespace App\Repositories;

use App\Models\Pronoun;

class PronounRepository extends BaseRepository
{
	protected $fieldSearchable = [
		'subject',
		'object',
		'possessive',
		'possessivepronoun',
		'reflexive'
	];

	public function getFieldsSearchable(): array
	{
		return $this->fieldSearchable;
	}

	public function model(): string
	{
		return Pronoun::class;
	}
}
