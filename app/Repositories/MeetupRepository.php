<?php

namespace App\Repositories;

use App\Models\Meetup;
use App\Repositories\BaseRepository;

class MeetupRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'park_id',
        'location_id',
        'alt_location_id',
        'recurrence',
        'week_of_month',
        'week_day',
        'month_day',
        'occurs_at',
        'purpose',
        'description'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Meetup::class;
    }
}
