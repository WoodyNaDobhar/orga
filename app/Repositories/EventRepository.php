<?php

namespace App\Repositories;

use App\Models\Event;
use App\Repositories\BaseRepository;

class EventRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'eventable_type',
        'eventable_id',
        'autocrat_id',
        'location_id',
        'name',
        'description',
        'event_start',
        'event_end',
        'price',
        'url',
        'url_name'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Event::class;
    }
}
