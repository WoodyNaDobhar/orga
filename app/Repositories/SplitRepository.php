<?php

namespace App\Repositories;

use App\Models\Split;
use App\Repositories\BaseRepository;

class SplitRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'account_id',
        'persona_id',
        'transaction_id',
        'amount'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Split::class;
    }
}
