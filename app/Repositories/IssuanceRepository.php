<?php

namespace App\Repositories;

use App\Models\Issuance;
use App\Repositories\BaseRepository;

class IssuanceRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'issuable_type',
        'issuable_id',
        'user_id',
        'issuer_id',
        'issuedable_type',
        'issuedable_id',
        'custom_name',
        'rank',
        'issued_at',
        'note',
        'image',
        'revocation',
        'revoked_by',
        'revoked_at'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Issuance::class;
    }
}
