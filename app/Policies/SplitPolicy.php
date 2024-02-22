<?php

namespace App\Policies;

use App\Models\Split;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SplitPolicy
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
	 * Determine whether the user can view any splits.
	 *
	 * @param  \App\Models\User  $user
	 * @return mixed
	 */
	public function viewAny(User $user)
	{
		if ($user->can('list splits')) {
			return true;
		}
	}
	
	/**
	 * Determine whether the user can view the split.
	 *
	 * @param  \App\Models\User $user
	 * @param  \App\Models\Split  $split
	 * @return mixed
	 */
	public function view(User $user, Split $split)
	{
		if ($user->can('display splits')) {
			return true;
		}
	}
	
	/**
	 * Determine whether the user can create splits.
	 *
	 * @param  \App\Models\User  $user
	 * @return mixed
	 */
	public function create(User $user)
	{
		if ($user->can('store splits')) {
			return true;
		}
	}
	
	/**
	 * Determine whether the user can update the split.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Split  $split
	 * @return mixed
	 */
	public function update(User $user, Split $split)
	{
		if (
				$user->can('update splits') ||
				(
						$user->can('updateRelated splits') &&
						(
								(
										$split->account->accountable_type === 'Chapter' &&
										(
												(
														$user->persona->chapter_id === $split->account->accountable_id &&
														$user->persona->chapter->reign->officers->contains(function ($item) use ($user) {
															return $item->persona_id === $user->persona->id;
														})
												) ||
												(
														$user->persona->chapter->realm_id === $split->account->accountable->realm_id &&
														$user->persona->chapter->realm->reign->officers->contains(function ($item) use ($user) {
															return $item->persona_id === $user->persona->id;
														})
												)
										)
								) ||
								(
										$split->account->accountable_type === 'Realm' &&
										$user->persona->chapter->realm === $split->account->accountable_id &&
										$user->persona->chapter->realm->reign->officers->contains(function ($item) use ($user) {
											return $item->persona_id === $user->persona->id;
										})
								) ||
								(
										$split->account->accountable_type === 'Unit' &&
										$user->persona->chapter === $split->account->accountable_id &&
										$user->persona->chapter->reign->officers->contains(function ($item) use ($user) {
											return $item->persona_id === $user->persona->id;
										})
								)
						)
				)
		) {
			return true;
		}
	}
	
	/**
	 * Determine whether the user can delete the split.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Split  $split
	 * @return mixed
	 */
	public function delete(User $user, Split $split)
	{
		if (
				$user->can('remove splits') ||
				(
						$user->can('removeRelated splits') &&
						(
								(
										$split->account->accountable_type === 'Chapter' &&
										(
												(
														$user->persona->chapter_id === $split->account->accountable_id &&
														$user->persona->chapter->reign->officers->contains(function ($item) use ($user) {
															return $item->persona_id === $user->persona->id;
														})
												) ||
												(
														$user->persona->chapter->realm_id === $split->account->accountable->realm_id &&
														$user->persona->chapter->realm->reign->officers->contains(function ($item) use ($user) {
															return $item->persona_id === $user->persona->id;
														})
												)
										)
								) ||
								(
										$split->account->accountable_type === 'Realm' &&
										$user->persona->chapter->realm === $split->account->accountable_id &&
										$user->persona->chapter->realm->reign->officers->contains(function ($item) use ($user) {
											return $item->persona_id === $user->persona->id;
										})
								) ||
								(
										$split->account->accountable_type === 'Unit' &&
										$user->persona->chapter === $split->account->accountable_id &&
										$user->persona->chapter->reign->officers->contains(function ($item) use ($user) {
											return $item->persona_id === $user->persona->id;
										})
								)
						)
				)
		) {
			return true;
		}
	}
	
	/**
	 * Determine whether the user can restore the split.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Split  $split
	 * @return mixed
	 */
	public function restore(User $user, Split $split)
	{
		return false;
	}
	
	/**
	 * Determine whether the user can permanently delete the split.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Split  $split
	 * @return mixed
	 */
	public function forceDelete(User $user, Split $split)
	{
		return false;
	}
}