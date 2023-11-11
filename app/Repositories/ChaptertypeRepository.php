<?php

namespace App\Repositories;

use App\Models\Chaptertype;
use App\Repositories\BaseRepository;

class ChaptertypeRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'kingdom_id',
        'name',
        'rank',
        'minimumattendance',
        'minimumcutoff'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Chaptertype::class;
    }
}
