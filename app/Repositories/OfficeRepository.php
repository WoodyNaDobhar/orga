<?php

namespace App\Repositories;

use App\Models\Office;
use App\Repositories\BaseRepository;

class OfficeRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'name',
        'crown_points',
        'crown_limit'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Office::class;
    }
}
