<?php

namespace App\Repositories;

use App\Models\Issuance;

class IssuanceRepository extends BaseRepository
{
	protected $fieldSearchable = [
		'issuable_type',
		'issuable_id',
		'whereable_type',
		'whereable_id',
		'issuer_type',
		'issuer_id',
		'recipient_type',
		'recipient_id',
		'signator_id',
		'custom_name',
		'rank',
		'parent_id',
		'issued_on',
		'reason',
		'image',
		'revoked_by',
		'revoked_on',
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
