<?php

namespace App\Repositories;

use App\Models\Archetype;
use App\Repositories\BaseRepository;

class ArchetypeRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'name',
        'is_active'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Archetype::class;
    }
}
