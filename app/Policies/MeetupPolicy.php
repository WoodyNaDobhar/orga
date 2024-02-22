<?php

namespace App\Policies;

use App\Models\Meetup;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MeetupPolicy
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
	 * Determine whether the user can view any meetups.
	 *
	 * @param  \App\Models\User  $user
	 * @return mixed
	 */
	public function viewAny(User $user)
	{
// 		if ($user->can('list meetups')) {
			return true;
// 		}
	}
	
	/**
	 * Determine whether the user can view the meetup.
	 *
	 * @param  \App\Models\User $user
	 * @param  \App\Models\Meetup  $meetup
	 * @return mixed
	 */
	public function view(User $user, Meetup $meetup)
	{
// 		if ($user->can('display meetups')) {
			return true;
// 		}
	}
	
	/**
	 * Determine whether the user can create meetups.
	 *
	 * @param  \App\Models\User  $user
	 * @return mixed
	 */
	public function create(User $user)
	{
		if ($user->can('store meetups')) {
			return true;
		}
	}
	
	/**
	 * Determine whether the user can update the meetup.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Meetup  $meetup
	 * @return mixed
	 */
	public function update(User $user, Meetup $meetup)
	{
		if (
				$user->can('update meetups') ||
				(
						$user->can('updateRelated meetups') &&
						(
								(
										$user->persona->chapter_id === $meetup->chapter_id &&
										$user->persona->chapter->reign->officers->contains(function ($item) use ($user) {
											return $item->persona_id === $user->persona->id;
										})
								) ||
								(
										$user->persona->chapter->realm_id === $meetup->chapter->realm_id &&
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
	 * Determine whether the user can delete the meetup.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Meetup  $meetup
	 * @return mixed
	 */
	public function delete(User $user, Meetup $meetup)
	{
		if (
				$user->can('remove meetups') ||
				(
						$user->can('removeRelated meetups') &&
						(
								(
										$user->persona->chapter_id === $meetup->chapter_id &&
										$user->persona->chapter->reign->officers->contains(function ($item) use ($user) {
											return $item->persona_id === $user->persona->id;
										})
								) ||
								(
										$user->persona->chapter->realm_id === $meetup->chapter->realm_id &&
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
	 * Determine whether the user can restore the meetup.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Meetup  $meetup
	 * @return mixed
	 */
	public function restore(User $user, Meetup $meetup)
	{
		return false;
	}
	
	/**
	 * Determine whether the user can permanently delete the meetup.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Meetup  $meetup
	 * @return mixed
	 */
	public function forceDelete(User $user, Meetup $meetup)
	{
		return false;
	}
}