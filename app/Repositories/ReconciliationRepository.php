<?php

namespace App\Repositories;

use App\Models\Reconciliation;
use App\Repositories\BaseRepository;

class ReconciliationRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'archetype_id',
        'user_id',
        'is_reconciled'
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
