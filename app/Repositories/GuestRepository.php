<?php

namespace App\Repositories;

use App\Models\Guest;
use App\Repositories\BaseRepository;

class GuestRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'event_id',
        'chapter_id',
        'is_followedup',
        'notes'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Guest::class;
    }
}
