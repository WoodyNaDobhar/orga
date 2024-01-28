<?php

namespace App\Repositories;

use App\Models\Location;
use App\Repositories\BaseRepository;

class LocationRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'label',
        'address',
        'city',
        'province',
        'postal_code',
        'country',
        'google_geocode',
        'latitude',
        'longitude',
        'location',
        'map_url',
        'directions'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Location::class;
    }
}
