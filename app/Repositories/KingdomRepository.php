<?php

namespace App\Repositories;

use App\Models\Kingdom;
use App\Repositories\BaseRepository;

class KingdomRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'parent_id',
        'name',
        'abbreviation',
        'heraldry',
        'is_active'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Kingdom::class;
    }
}
