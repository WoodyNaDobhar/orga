<?php

namespace App\Repositories;

use App\Models\Transaction;
use App\Repositories\BaseRepository;

class TransactionRepository extends BaseRepository
{
	protected $fieldSearchable = [
		'description',
		'memo',
		'transaction_at'
	];

	public function getFieldsSearchable(): array
	{
		return $this->fieldSearchable;
	}

	public function model(): string
	{
		return Transaction::class;
	}
}
