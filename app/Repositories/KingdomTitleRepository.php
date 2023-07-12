<?php

namespace App\Repositories;

use App\Models\KingdomTitle;
use App\Repositories\BaseRepository;

class KingdomTitleRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'kingdom_id',
        'title_id',
        'custom_name'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return KingdomTitle::class;
    }
}
