<?php

namespace App\Repositories;

use App\Models\Officer;
use App\Repositories\BaseRepository;

class OfficerRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'office_id',
        'user_id',
        'authorized_by',
        'officerable_type',
        'officerable_id',
        'scope'
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
