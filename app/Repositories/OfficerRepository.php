<?php

namespace App\Repositories;

use App\Models\Officer;
use App\Repositories\BaseRepository;

class OfficerRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'officeable_type',
        'officeable_id',
        'office_id',
        'persona_id',
        'authorized_by',
        'label',
        'starts_on',
        'ends_on'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Officer::class;
    }
}
