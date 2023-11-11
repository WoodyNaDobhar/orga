<?php

namespace App\Repositories;

use App\Models\Title;
use App\Repositories\BaseRepository;

class TitleRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'titleable_type',
        'titleable_id',
        'name',
        'rank',
        'peerage',
        'is_active',
        'is_roaming'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Title::class;
    }
}
