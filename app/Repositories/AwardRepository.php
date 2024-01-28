<?php

namespace App\Repositories;

use App\Models\Award;
use App\Repositories\BaseRepository;

class AwardRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'awarder_type',
        'awarder_id',
        'name',
        'is_ladder'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Award::class;
    }
}
