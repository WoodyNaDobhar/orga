<?php

namespace App\Repositories;

use App\Models\Account;
use App\Repositories\BaseRepository;

class AccountRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'parent_id',
        'accountable_type',
        'accountable_id',
        'name',
        'type'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Account::class;
    }
}
