<?php

namespace App\Repositories;

use App\Models\Issuance;
use App\Repositories\BaseRepository;

class IssuanceRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'issuable_type',
        'issuable_id',
        'whereable_type',
        'whereable_id',
        'authority_type',
        'authority_id',
        'recipient_type',
        'recipient_id',
        'issuer_id',
        'custom_name',
        'rank',
        'issued_at',
        'note',
        'image',
        'revoked_by',
        'revoked_at',
        'revocation'
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
