<?php

namespace App\Repositories;

use App\Models\Parkrank;
use App\Repositories\BaseRepository;

class ParkrankRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'kingdom_id',
        'name',
        'rank',
        'minimumattendance',
        'minimumcutoff',
        'period',
        'period_length'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Parkrank::class;
    }
}
