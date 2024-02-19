<?php

namespace App\Policies;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TransactionPolicy
{
	use HandlesAuthorization;
	
	/**
	 * Perform pre-authorization checks.
	 *
	 * @param  \App\Models\User  $user
	 * @param  string  $ability
	 * @return void|bool
	 */
	public function before(User $user, $ability)
	{
		if ($user->hasRole('admin')) {
			return true;
		}
	}
	
	/**
	 * Determine whether the user can view any transactions.
	 *
	 * @param  \App\Models\User  $user
	 * @return mixed
	 */
	public function viewAny(User $user)
	{
		if ($user->can('list transactions')) {
			return true;
		}
	}
	
	/**
	 * Determine whether the user can view the transaction.
	 *
	 * @param  \App\Models\User $user
	 * @param  \App\Models\Transaction  $transaction
	 * @return mixed
	 */
	public function view(User $user, Transaction $transaction)
	{
		if ($user->can('display transactions')) {
			return true;
		}
	}
	
	/**
	 * Determine whether the user can create transactions.
	 *
	 * @param  \App\Models\User  $user
	 * @return mixed
	 */
	public function create(User $user)
	{
		if ($user->can('store transactions')) {
			return true;
		}
	}
	
	/**
	 * Determine whether the user can update the transaction.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Transaction  $transaction
	 * @return mixed
	 */
	public function update(User $user, Transaction $transaction)
	{
		if (
				$user->can('update transactions') ||
				(
						$user->can('updateRelated transactions') &&
						(
								(
										$transaction->splits->every(function ($item) use ($user) {
											return $item->account->accountable_type === 'Unit';
										}) &&
										$user->persona->units->first(function ($unit) use ($transaction, $user) {
											return $unit->id === $transaction->splits->first()->account->accountable_id &&
											$unit->officers->contains('persona_id', $user->persona_id);
										}) !== null
								) ||
								(
										$transaction->splits->every(function ($item) use ($user) {
											return $item->account->accountable_type === 'Realm';
										}) &&
										$user->persona->chapter->realm === $transaction->splits->first()->account->accountable_id &&
										$user->persona->chapter->realm->reign->officers->contains(function ($item) use ($user) {
											return $item->persona_id === $user->persona_id;
										})
								) ||
								(
										$transaction->splits->every(function ($item) use ($user) {
											return $item->account->accountable_type === 'Chapter';
										}) &&
										(
												(
														$user->persona->chapters === $transaction->splits->first()->account->accountable_id &&
														$user->persona->chapter->reign->officers->contains(function ($item) use ($user) {
															return $item->persona_id === $user->persona_id;
														})
												) ||
												(
														$user->persona->chapter->realm === $transaction->splits->first()->account->accountable_id &&
														$user->persona->chapter->realm->reign->officers->contains(function ($item) use ($user) {
															return $item->persona_id === $user->persona_id;
														})
												)
										)
								)
						)
				)
		) {
			return true;
		}
	}
	
	/**
	 * Determine whether the user can delete the transaction.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Transaction  $transaction
	 * @return mixed
	 */
	public function delete(User $user, Transaction $transaction)
	{
		if (
				$user->can('remove transactions') ||
				(
						$user->can('removeRelated transactions') &&
						(
								(
										$transaction->splits->every(function ($item) use ($user) {
											return $item->account->accountable_type === 'Unit';
										}) &&
										$user->persona->units->first(function ($unit) use ($transaction, $user) {
											return $unit->id === $transaction->splits->first()->account->accountable_id &&
											$unit->officers->contains('persona_id', $user->persona_id);
										}) !== null
								) ||
								(
										$transaction->splits->every(function ($item) use ($user) {
											return $item->account->accountable_type === 'Realm';
										}) &&
										$user->persona->chapter->realm === $transaction->splits->first()->account->accountable_id &&
										$user->persona->chapter->realm->reign->officers->contains(function ($item) use ($user) {
											return $item->persona_id === $user->persona_id;
										})
								) ||
								(
										$transaction->splits->every(function ($item) use ($user) {
											return $item->account->accountable_type === 'Chapter';
										}) &&
										(
												(
														$user->persona->chapters === $transaction->splits->first()->account->accountable_id &&
														$user->persona->chapter->reign->officers->contains(function ($item) use ($user) {
															return $item->persona_id === $user->persona_id;
														})
												) ||
												(
														$user->persona->chapter->realm === $transaction->splits->first()->account->accountable_id &&
														$user->persona->chapter->realm->reign->officers->contains(function ($item) use ($user) {
															return $item->persona_id === $user->persona_id;
														})
												)
										)
								)
						)
				)
		) {
			return true;
		}
	}
	
	/**
	 * Determine whether the user can restore the transaction.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Transaction  $transaction
	 * @return mixed
	 */
	public function restore(User $user, Transaction $transaction)
	{
		return false;
	}
	
	/**
	 * Determine whether the user can permanently delete the transaction.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Transaction  $transaction
	 * @return mixed
	 */
	public function forceDelete(User $user, Transaction $transaction)
	{
		return false;
	}
}