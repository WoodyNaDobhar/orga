<?php

namespace App\Repositories;

use App\Models\Attendance;
use App\Repositories\BaseRepository;

class AttendanceRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'user_id',
        'archetype_id',
        'attendable_type',
        'attendable_id',
        'attended_at',
        'credits'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Attendance::class;
    }
}
