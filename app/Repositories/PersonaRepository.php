<?php

namespace App\Repositories;

use App\Models\Persona;
use App\Repositories\BaseRepository;

class PersonaRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'park_id',
        'user_id',
        'pronoun_id',
        'mundane',
        'persona',
        'heraldry',
        'image',
        'restricted',
        'waivered',
        'waiver_ext',
        'penalty_box',
        'is_active',
        'reeve_qualified_expires',
        'corpora_qualified_expires',
        'joined_park_at'
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
