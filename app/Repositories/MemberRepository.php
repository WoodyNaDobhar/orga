<?php

namespace App\Repositories;

use App\Models\Member;
use App\Repositories\BaseRepository;

class MemberRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'unit_id',
        'user_id',
        'role',
        'title',
        'is_active'
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
