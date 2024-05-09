<?php

namespace App\Repositories;

use App\Models\Persona;

class PersonaRepository extends BaseRepository
{
	protected $fieldSearchable = [
		'chapter_id',
		'honorific_id',
		'pronoun_id',
		'mundane',
		'name',
		'slug',
		'heraldry',
		'image',
		'is_active',
		'reeve_qualified_expires_at',
		'corpora_qualified_expires_at',
		'joined_chapter_at'
	];

	public function getFieldsSearchable(): array
	{
		return $this->fieldSearchable;
	}

	public function model(): string
	{
		return Persona::class;
	}
}
