<?php

namespace App\Repositories;

use App\Models\Member;
use App\Repositories\BaseRepository;

class MemberRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'persona_id',
        'unit_id',
        'is_head',
        'is_voting',
        'joined_at',
        'left_at',
        'notes'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Member::class;
    }
}
