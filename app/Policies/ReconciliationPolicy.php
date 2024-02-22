<?php

namespace App\Policies;

use App\Models\Reconciliation;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReconciliationPolicy
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
	 * Determine whether the user can view any reconciliations.
	 *
	 * @param  \App\Models\User  $user
	 * @return mixed
	 */
	public function viewAny(User $user)
	{
// 		if ($user->can('list reconciliations')) {
			return true;
// 		}
	}
	
	/**
	 * Determine whether the user can view the reconciliation.
	 *
	 * @param  \App\Models\User $user
	 * @param  \App\Models\Reconciliation  $reconciliation
	 * @return mixed
	 */
	public function view(User $user, Reconciliation $reconciliation)
	{
// 		if ($user->can('display reconciliations')) {
			return true;
// 		}
	}
	
	/**
	 * Determine whether the user can create reconciliations.
	 *
	 * @param  \App\Models\User  $user
	 * @return mixed
	 */
	public function create(User $user)
	{
		if ($user->can('store reconciliations')) {
			return true;
		}
	}
	
	/**
	 * Determine whether the user can update the reconciliation.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Reconciliation  $reconciliation
	 * @return mixed
	 */
	public function update(User $user, Reconciliation $reconciliation)
	{
		if (
				$user->can('update reconciliations') ||
				(
						$user->can('updateRelated reconciliations') &&
						(
								(
										$user->persona->chapter_id === $reconciliation->persona->chapter_id &&
										$user->persona->chapter->reign->officers->contains(function ($item) use ($user) {
											return $item->persona_id === $user->persona->id;
										})
								) ||
								(
										$user->persona->chapter->realm_id === $reconciliation->persona->chapter->realm_id &&
										$user->persona->chapter->realm->reign->officers->contains(function ($item) use ($user) {
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
	 * Determine whether the user can delete the reconciliation.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Reconciliation  $reconciliation
	 * @return mixed
	 */
	public function delete(User $user, Reconciliation $reconciliation)
	{
		if (
				$user->can('remove reconciliations') ||
				(
						$user->can('removeRelated reconciliations') &&
						(
								(
										$user->persona->chapter_id === $reconciliation->persona->chapter_id &&
										$user->persona->chapter->reign->officers->contains(function ($item) use ($user) {
											return $item->persona_id === $user->persona->id;
										})
								) ||
								(
										$user->persona->chapter->realm_id === $reconciliation->persona->chapter->realm_id &&
										$user->persona->chapter->realm->reign->officers->contains(function ($item) use ($user) {
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
	 * Determine whether the user can restore the reconciliation.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Reconciliation  $reconciliation
	 * @return mixed
	 */
	public function restore(User $user, Reconciliation $reconciliation)
	{
		return false;
	}
	
	/**
	 * Determine whether the user can permanently delete the reconciliation.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Reconciliation  $reconciliation
	 * @return mixed
	 */
	public function forceDelete(User $user, Reconciliation $reconciliation)
	{
		return false;
	}
}