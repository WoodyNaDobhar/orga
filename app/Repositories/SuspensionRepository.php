<?php

namespace App\Repositories;

use App\Models\Suspension;
use App\Repositories\BaseRepository;

class SuspensionRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'id',
        'user_id',
        'suspended_by',
        'suspended_at',
        'suspended_expires',
        'cause'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Suspension::class;
    }
}
