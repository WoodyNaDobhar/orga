<?php

namespace App\Repositories;

use App\Models\Reconciliation;
use App\Repositories\BaseRepository;

class ReconciliationRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'archetype_id',
        'persona_id',
        'credits',
        'notes'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Reconciliation::class;
    }
}
