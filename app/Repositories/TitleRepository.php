<?php

namespace App\Repositories;

use App\Models\Title;
use App\Repositories\BaseRepository;

class TitleRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'name',
        'rank',
        'peerage'
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
