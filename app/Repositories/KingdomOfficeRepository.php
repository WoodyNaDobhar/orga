<?php

namespace App\Repositories;

use App\Models\KingdomOffice;
use App\Repositories\BaseRepository;

class KingdomOfficeRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'kingdom_id',
        'office_id',
        'custom_name'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return KingdomOffice::class;
    }
}
