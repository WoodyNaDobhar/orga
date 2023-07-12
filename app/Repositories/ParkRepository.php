<?php

namespace App\Repositories;

use App\Models\Park;
use App\Repositories\BaseRepository;

class ParkRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'kingdom_id',
        'parkrank_id',
        'location_id',
        'name',
        'abbreviation',
        'heraldry',
        'url',
        'is_active'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Park::class;
    }
}
