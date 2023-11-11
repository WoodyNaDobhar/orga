<?php

namespace App\Repositories;

use App\Models\Suspension;
use App\Repositories\BaseRepository;

class SuspensionRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'persona_id',
        'kingdom_id',
        'suspended_by',
        'suspended_at',
        'expires_at',
        'cause',
        'is_propogating'
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
