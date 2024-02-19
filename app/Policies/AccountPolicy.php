<?php

namespace App\Policies;

use App\Models\Account;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AccountPolicy
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
	 * Determine whether the user can view any accounts.
	 *
	 * @param  \App\Models\User  $user
	 * @return mixed
	 */
	public function viewAny(User $user)
	{
		if ($user->can('list accounts')) {
			return true;
		}
	}
	
	/**
	 * Determine whether the user can view the account.
	 *
	 * @param  \App\Models\User $user
	 * @param  \App\Models\Account  $account
	 * @return mixed
	 */
	public function view(User $user, Account $account)
	{
		if ($user->can('display accounts')) {
			return true;
		}
	}
	
	/**
	 * Determine whether the user can create accounts.
	 *
	 * @param  \App\Models\User  $user
	 * @return mixed
	 */
	public function create(User $user)
	{
		if ($user->can('store accounts')) {
			return true;
		}
	}
	
	/**
	 * Determine whether the user can update the account.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Account  $account
	 * @return mixed
	 */
	public function update(User $user, Account $account)
	{
		if (
				$user->can('update accounts') ||
				(
						$user->can('updateRelated accounts') &&
						(
								(
										$account->accountable_type === 'Chapter' &&
										(
												(
														$user->persona->chapter_id === $account->accountable_id &&
														$user->persona->chapter->reign->officers->contains(function ($item) use ($user) {
															return $item->persona_id === $user->persona_id;
														})
												) ||
												(
														$user->persona->chapter->realm_id === $account->accountable->realm_id &&
														$user->persona->chapter->realm->reign->officers->contains(function ($item) use ($user) {
															return $item->persona_id === $user->persona_id;
														})
												)
										)
								) ||
								(
										$account->accountable_type === 'Realm' &&
										$user->persona->chapter->realm_id === $account->accountable_id &&
										$user->persona->chapter->realm->reign->officers->contains(function ($item) use ($user) {
											return $item->persona_id === $user->persona_id;
										})
								) ||
								(
										$account->accountable_type === 'Unit' &&
										$user->persona->units->first(function ($unit) use ($account, $user) {
											return $unit->id === $account->accountable_id &&
											$unit->officers->contains('persona_id', $user->persona_id);
										}) !== null
								)
						)
				)
		) {
			return true;
		}
	}
	
	/**
	 * Determine whether the user can delete the account.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Account  $account
	 * @return mixed
	 */
	public function delete(User $user, Account $account)
	{
		if (
				$user->can('remove accounts') ||
				(
						$user->can('removeRelated accounts') &&
						(
								(
										$account->accountable_type === 'Chapter' &&
										(
												(
														$user->persona->chapter_id === $account->accountable_id &&
														$user->persona->chapter->reign->officers->contains(function ($item) use ($user) {
															return $item->persona_id === $user->persona_id;
														})
												) ||
												(
														$user->persona->chapter->realm_id === $account->accountable->realm_id &&
														$user->persona->chapter->realm->reign->officers->contains(function ($item) use ($user) {
															return $item->persona_id === $user->persona_id;
														})
												)
										)
								) ||
								(
										$account->accountable_type === 'Realm' &&
										$user->persona->chapter->realm_id === $account->accountable_id &&
										$user->persona->chapter->realm->reign->officers->contains(function ($item) use ($user) {
											return $item->persona_id === $user->persona_id;
										})
								) ||
								(
										$account->accountable_type === 'Unit' &&
										$user->persona->units->first(function ($unit) use ($account, $user) {
											return $unit->id === $account->accountable_id &&
											$unit->officers->contains('persona_id', $user->persona_id);
										}) !== null
								)
						)
				)
		) {
			return true;
		}
	}
	
	/**
	 * Determine whether the user can restore the account.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Account  $account
	 * @return mixed
	 */
	public function restore(User $user, Account $account)
	{
		return false;
	}
	
	/**
	 * Determine whether the user can permanently delete the account.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Account  $account
	 * @return mixed
	 */
	public function forceDelete(User $user, Account $account)
	{
		return false;
	}
}