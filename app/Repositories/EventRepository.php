<?php

namespace App\Repositories;

use App\Models\Event;
use App\Repositories\BaseRepository;

class EventRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'eventable_type',
        'eventable_id',
        'location_id',
        'name',
        'description',
        'image',
        'is_active',
        'is_demo',
        'event_started_at',
        'event_ended_at',
        'price'
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
