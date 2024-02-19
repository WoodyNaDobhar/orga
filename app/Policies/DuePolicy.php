<?php

namespace App\Policies;

use App\Models\Due;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DuePolicy
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
	 * Determine whether the user can view any dues.
	 *
	 * @param  \App\Models\User  $user
	 * @return mixed
	 */
	public function viewAny(User $user)
	{
// 		if ($user->can('list dues')) {
			return true;
// 		}
	}
	
	/**
	 * Determine whether the user can view the due.
	 *
	 * @param  \App\Models\User $user
	 * @param  \App\Models\Due  $due
	 * @return mixed
	 */
	public function view(User $user, Due $due)
	{
// 		if ($user->can('display dues')) {
			return true;
// 		}
	}
	
	/**
	 * Determine whether the user can create dues.
	 *
	 * @param  \App\Models\User  $user
	 * @return mixed
	 */
	public function create(User $user)
	{
		if ($user->can('store dues')) {
			return true;
		}
	}
	
	/**
	 * Determine whether the user can update the due.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Due  $due
	 * @return mixed
	 */
	public function update(User $user, Due $due)
	{
		if (
				$user->can('update dues') ||
				(
						$user->can('updateRelated dues') &&
						(
								$user->persona->chapter_id === $due->chapter_id &&
								$user->persona->chapter->reign->officers->contains(function ($item) use ($user) {
									return $item->persona_id === $user->persona_id;
								})
						) ||
						(
								$user->persona->chapter->realm_id === $due->realm_id &&
								$user->persona->chapter->realm->reign->officers->contains(function ($item) use ($user) {
									return $item->persona_id === $user->persona_id;
								})
						)
				)
		) {
			return true;
		}
	}
	
	/**
	 * Determine whether the user can delete the due.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Due  $due
	 * @return mixed
	 */
	public function delete(User $user, Due $due)
	{
		if (
				$user->can('remove dues') ||
				(
						$user->can('removeRelated dues') &&
						(
								$user->persona->chapter_id === $due->chapter_id &&
								$user->persona->chapter->reign->officers->contains(function ($item) use ($user) {
									return $item->persona_id === $user->persona_id;
								})
						) ||
						(
								$user->persona->chapter->realm_id === $due->realm_id &&
								$user->persona->chapter->realm->reign->officers->contains(function ($item) use ($user) {
									return $item->persona_id === $user->persona_id;
								})
						)
				)
		) {
			return true;
		}
	}
	
	/**
	 * Determine whether the user can restore the due.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Due  $due
	 * @return mixed
	 */
	public function restore(User $user, Due $due)
	{
		return false;
	}
	
	/**
	 * Determine whether the user can permanently delete the due.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Due  $due
	 * @return mixed
	 */
	public function forceDelete(User $user, Due $due)
	{
		return false;
	}
}