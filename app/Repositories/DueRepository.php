<?php

namespace App\Repositories;

use App\Models\Account;
use App\Models\Chapter;
use App\Models\Due;
use App\Models\Persona;
use App\Models\Realm;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Model;
use App\Models\Split;

class DueRepository extends BaseRepository
{
	protected $fieldSearchable = [
		'persona_id',
		'transaction_id',
		'dues_on',
		'intervals'
	];

	public function getFieldsSearchable(): array
	{
		return $this->fieldSearchable;
	}

	public function model(): string
	{
		return Due::class;
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
		
		//get stuff
		$persona = Persona::where('id', $input['persona_id'])->first();
		if($input['recipient_type'] === 'Realm'){
			$recipient = Realm::where('id', $input['recipient_id'])->first();
			$realm = $recipient;
			$realmTake = 0;
		}else{
			$recipient = Chapter::where('id', $input['recipient_id'])->first();
			$realm = $recipient->realm;
			$realmTake = $recipient->realm->dues_take / $recipient->realm->dues_amount;
		}
		
		$intervals = round($input['amount'] / $realm->dues_amount, 4);
		
		$accounts = Account::where('accountable_type', 'Chapter')->where('accountable_id', $input['recipient_id'])->get();
		$accountAsset = $accounts->filter(function($account) {
			return $account['name'] === 'Cash';
		})->first();
		$accountPaid = $accounts->filter(function($account) {
			return $account['name'] === 'Dues Paid';
		})->first();

		//transaction
		$transaction = Transaction::create([
			'description' => 'Dues Paid for ' .( $persona->mundane ? $persona->mundane : $persona->name),
			'memo' => $input['memo'] != '' ? $input['memo'] : null,
			'transaction_on' => $input['dues_on']
		]);
		
		//splits
		Split::create([
			'account_id' => $accountAsset->id,
			'persona_id' => $persona->id,
			'transaction_id' => $transaction->id,
			'amount' => $input['amount']
		]);
		Split::create([
			'account_id' => $accountPaid->id,
			'persona_id' => $persona->id,
			'transaction_id' => $transaction->id,
			'amount' => $input['amount']
		]);
		if($input['recipient_type'] === 'Chapter' && $realmTake > 0){
			$takeIncomeAccount = Account::where('accountable_type', 'Realm')->where('accountable_id', $realm->id)->where('name', 'Park Dues')->first();
			$accountTax = $accounts->filter(function($account) {
				return $account['name'] === 'Realm Take';
			})->first();
			$accountOwed = $accounts->filter(function($account) {
				return $account['name'] === 'Dues Owed';
			})->first();
			Split::create([
				'account_id' => $takeIncomeAccount->id,
				'persona_id' => $persona->id,
				'transaction_id' => $transaction->id,
				'amount' => $realmTake
			]);
			Split::create([
				'account_id' => $accountTax->id,
				'persona_id' => $persona->id,
				'transaction_id' => $transaction->id,
				'amount' => $realmTake
			]);
			Split::create([
				'account_id' => $accountOwed->id,
				'persona_id' => $persona->id,
				'transaction_id' => $transaction->id,
				'amount' => $realmTake
			]);
		}
		
		//due
		$due = Due::create([
			'persona_id' => $persona->id,
			'transaction_id' => $transaction->id,
			'dues_on' => $input['dues_on'],
			'intervals' => $intervals
		]);
		
		return $due->with('transaction.splits.account');
	}
}
