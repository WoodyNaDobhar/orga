<?php

namespace App\Repositories;

use App\Models\Due;
use App\Repositories\BaseRepository;

class DueRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'user_id',
        'park_id',
        'transaction_id',
        'is_for_life',
        'dues_at',
        'intervals',
        'revoked_on',
        'revoked_by'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Due::class;
    }
}
