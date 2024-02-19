<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
	use HandlesAuthorization;
	
	/**
	 * Perform pre-authorization checks.
	 *
	 * @param  \App\Models\User  $sessionUser
	 * @param  string  $ability
	 * @return void|bool
	 */
	public function before(User $sessionUser, $ability)
	{
		if ($sessionUser->hasRole('admin')) {
			return true;
		}
	}
	
	/**
	 * Determine whether the user can view any users.
	 *
	 * @param  \App\Models\User  $sessionUser
	 * @return mixed
	 */
	public function viewAny(User $sessionUser)
	{
// 		if ($sessionUser->can('list users')) {
			return true;
// 		}
	}
	
	/**
	 * Determine whether the user can view the user.
	 *
	 * @param  \App\Models\User $sessionUser
	 * @param  \App\Models\User  $user
	 * @return mixed
	 */
	public function view(User $sessionUser, User $user)
	{
// 		if ($sessionUser->can('display users')) {
			return true;
// 		}
	}
	
	/**
	 * Determine whether the user can create users.
	 *
	 * @param  \App\Models\User  $sessionUser
	 * @return mixed
	 */
	public function create(User $sessionUser)
	{
		if ($sessionUser->can('store users')) {
			return true;
		}
	}
	
	/**
	 * Determine whether the user can update the user.
	 *
	 * @param  \App\Models\User  $sessionUser
	 * @param  \App\Models\User  $user
	 * @return mixed
	 */
	public function update(User $sessionUser, User $user)
	{
		if (
				$sessionUser->can('update users') ||
				(
						$sessionUser->can('updateOwn users') &&
						$user->id === $sessionUser->id
				) ||
				(
						$sessionUser->can('updateRelated users') &&
						(
								(
										$sessionUser->persona->chapter_id === $user->chapter_id &&
										$sessionUser->persona->chapter->reign->officers->contains(function ($item) use ($sessionUser) {
											return $item->persona_id === $sessionUser->persona_id;
										})
								) ||
								(
										$sessionUser->persona->chapter->realm_id === $user->chapter->realm_id &&
										$sessionUser->persona->chapter->realm->reign->officers->contains(function ($item) use ($sessionUser) {
											return $item->persona_id === $sessionUser->persona_id;
										})
								)
						)
				)
		) {
			return true;
		}
	}
	
	/**
	 * Determine whether the user can delete the user.
	 *
	 * @param  \App\Models\User  $sessionUser
	 * @param  \App\Models\User  $user
	 * @return mixed
	 */
	public function delete(User $sessionUser, User $user)
	{
		if (
				$sessionUser->can('remove users') ||
				(
						$sessionUser->can('removeOwn users') &&
						$user->id === $sessionUser->id
				) ||
				(
						$sessionUser->can('removeRelated users') &&
						(
								(
										$sessionUser->persona->chapter_id === $user->chapter_id &&
										$sessionUser->persona->chapter->reign->officers->contains(function ($item) use ($sessionUser) {
											return $item->persona_id === $sessionUser->persona_id;
										})
								) ||
								(
										$sessionUser->persona->chapter->realm_id === $user->chapter->realm_id &&
										$sessionUser->persona->chapter->realm->reign->officers->contains(function ($item) use ($sessionUser) {
											return $item->persona_id === $sessionUser->persona_id;
										})
								)
						)
				)
		) {
			return true;
		}
	}
	
	/**
	 * Determine whether the user can restore the user.
	 *
	 * @param  \App\Models\User  $sessionUser
	 * @param  \App\Models\User  $user
	 * @return mixed
	 */
	public function restore(User $sessionUser, User $user)
	{
		return false;
	}
	
	/**
	 * Determine whether the user can permanently delete the user.
	 *
	 * @param  \App\Models\User  $sessionUser
	 * @param  \App\Models\User  $user
	 * @return mixed
	 */
	public function forceDelete(User $sessionUser, User $user)
	{
		return false;
	}
}