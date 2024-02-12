<?php

namespace App\Repositories;

use App\Models\Waiver;
use App\Repositories\BaseRepository;

class WaiverRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'guest_id',
        'location_id',
        'pronoun_id',
        'persona_id',
        'waiverable_type',
        'waiverable_id',
        'file',
        'player',
        'email',
        'phone',
        'dob',
        'age_verified_at',
        'age_verified_by',
        'guardian',
        'emergency_name',
        'emergency_relationship',
        'emergency_phone',
        'signed_at'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Waiver::class;
    }
}
