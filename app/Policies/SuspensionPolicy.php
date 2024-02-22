<?php

namespace App\Policies;

use App\Models\Suspension;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SuspensionPolicy
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
	 * Determine whether the user can view any suspensions.
	 *
	 * @param  \App\Models\User  $user
	 * @return mixed
	 */
	public function viewAny(User $user)
	{
// 		if ($user->can('list suspensions')) {
			return true;
// 		}
	}
	
	/**
	 * Determine whether the user can view the suspension.
	 *
	 * @param  \App\Models\User $user
	 * @param  \App\Models\Suspension  $suspension
	 * @return mixed
	 */
	public function view(User $user, Suspension $suspension)
	{
// 		if ($user->can('display suspensions')) {
			return true;
// 		}
	}
	
	/**
	 * Determine whether the user can create suspensions.
	 *
	 * @param  \App\Models\User  $user
	 * @return mixed
	 */
	public function create(User $user)
	{
		if ($user->can('store suspensions')) {
			return true;
		}
	}
	
	/**
	 * Determine whether the user can update the suspension.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Suspension  $suspension
	 * @return mixed
	 */
	public function update(User $user, Suspension $suspension)
	{
		if (
				$user->can('update suspensions') ||
				(
						$user->can('updateRelated suspensions') &&
						(
								(
										$suspension->suspendable_type === 'Chapter' &&
										(
												(
														$user->persona->chapter_id === $suspension->suspendable_id &&
														$user->persona->chapter->reign->officers->contains(function ($item) use ($user) {
															return $item->persona_id === $user->persona->id;
														})
												) ||
												(
														$user->persona->chapter->realm_id === $suspension->suspendable->realm_id &&
														$user->persona->chapter->realm->reign->officers->contains(function ($item) use ($user) {
															return $item->persona_id === $user->persona->id;
														})
												)
										)
								) ||
								(
										$suspension->suspendable_type === 'Realm' &&
										$user->persona->chapter->realm_id === $suspension->suspendable_id &&
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
	 * Determine whether the user can delete the suspension.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Suspension  $suspension
	 * @return mixed
	 */
	public function delete(User $user, Suspension $suspension)
	{
		if (
				$user->can('remove suspensions') ||
				(
						$user->can('removeRelated suspensions') &&
						(
								(
										$suspension->suspendable_type === 'Chapter' &&
										(
												(
														$user->persona->chapter_id === $suspension->suspendable_id &&
														$user->persona->chapter->reign->officers->contains(function ($item) use ($user) {
															return $item->persona_id === $user->persona->id;
														})
												) ||
												(
														$user->persona->chapter->realm_id === $suspension->suspendable->realm_id &&
														$user->persona->chapter->realm->reign->officers->contains(function ($item) use ($user) {
															return $item->persona_id === $user->persona->id;
														})
												)
										)
								) ||
								(
										$suspension->suspendable_type === 'Realm' &&
										$user->persona->chapter->realm_id === $suspension->suspendable_id &&
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
	 * Determine whether the user can restore the suspension.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Suspension  $suspension
	 * @return mixed
	 */
	public function restore(User $user, Suspension $suspension)
	{
		return false;
	}
	
	/**
	 * Determine whether the user can permanently delete the suspension.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Suspension  $suspension
	 * @return mixed
	 */
	public function forceDelete(User $user, Suspension $suspension)
	{
		return false;
	}
}