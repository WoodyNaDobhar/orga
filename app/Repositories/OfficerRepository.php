<?php

namespace App\Repositories;

use App\Models\Office;
use App\Models\Officer;
use App\Models\Persona;
use App\Models\Reign;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\Due;

class OfficerRepository extends BaseRepository
{
	protected $fieldSearchable = [
		'officerable_type',
		'officerable_id',
		'office_id',
		'persona_id',
		'label',
		'starts_on',
		'ends_on',
		'notes'
	];

	public function getFieldsSearchable(): array
	{
		return $this->fieldSearchable;
	}

	public function model(): string
	{
		return Officer::class;
	}
	
	/**
	 * Create model record.
	 *
	 * @param array $input
	 *
	 * @return Model
	 */
	public function create(array $input): Model
	{
		$model = $this->model->newInstance($input);
		
		//credit them with duration months worth of dues?
		if($input['officerable_type'] === 'Reign'){
			$reign = Reign::where('id', $input['officerable_id'])->first();
			$office = Office::where('id', $input['office_id'])->first();
			$persona = Persona::where('id', $input['persona_id'])->first();
			$transactionID = Transaction::create([
				'description' => 'Officer Dues Credit for ' . $persona->name,
				'transaction_on' => $this->starts_on ? $this->starts_on : $reign->starts_on,
				'created_by' => Auth::user()->id
			]);
			Due::create([
				'persona_id' => $this->persona_id,
				'transaction_id' => $transactionID,
				'dues_on' => $this->starts_on ? $this->starts_on : $reign->starts_on,
				'intervals' => $this->starts_on ? (round(Carbon::parse($this->starts_on)->diffInMonths(Carbon::parse($reign->ends_on), false), 4)) : $office->duration,
				'created_by' => Auth::user()->id
			]);
		}
		
		$this->relatedSave($this->model, $input, $model);
		
		return $model;
	}
}
