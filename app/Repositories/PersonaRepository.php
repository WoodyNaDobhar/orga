<?php

namespace App\Repositories;

use App\Models\Persona;
use App\Repositories\BaseRepository;

class PersonaRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'chapter_id',
        'pronoun_id',
        'mundane',
        'name',
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
