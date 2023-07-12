<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\BaseRepository;

class UserRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'park_id',
        'pronoun_id',
        'name',
        'persona',
        'heraldry',
        'image',
        'email',
        'email_verified_at',
        'password',
        'remember_token',
        'restricted',
        'waivered',
        'waiver_ext',
        'penalty_box',
        'is_active',
        'reeve_qualified_expires',
        'corpora_qualified_expires',
        'joined_park_at'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return User::class;
    }
}
