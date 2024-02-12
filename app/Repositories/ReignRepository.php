<?php

namespace App\Repositories;

use App\Models\Reign;
use App\Repositories\BaseRepository;

class ReignRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'reignable_type',
        'reignable_id',
        'name',
        'starts_on',
        'midreign_on',
        'ends_on'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Reign::class;
    }
}
