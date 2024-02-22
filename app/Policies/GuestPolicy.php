<?php

namespace App\Policies;

use App\Models\Guest;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class GuestPolicy
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
	 * Determine whether the user can view any guests.
	 *
	 * @param  \App\Models\User  $user
	 * @return mixed
	 */
	public function viewAny(User $user)
	{
// 		if ($user->can('list guests')) {
			return true;
// 		}
	}
	
	/**
	 * Determine whether the user can view the guest.
	 *
	 * @param  \App\Models\User $user
	 * @param  \App\Models\Guest  $guest
	 * @return mixed
	 */
	public function view(User $user, Guest $guest)
	{
// 		if ($user->can('display guests')) {
			return true;
// 		}
	}
	
	/**
	 * Determine whether the user can create guests.
	 *
	 * @param  \App\Models\User  $user
	 * @return mixed
	 */
	public function create(User $user)
	{
		if ($user->can('store guests')) {
			return true;
		}
	}
	
	/**
	 * Determine whether the user can update the guest.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Guest  $guest
	 * @return mixed
	 */
	public function update(User $user, Guest $guest)
	{
		if (
				$user->can('update guests') ||
				(
						$user->can('updateRelated guests') &&
						(
								(
										$guest->event->eventable_type === 'Chapter' &&
										(
												(
														$user->persona->chapter_id === $guest->event->eventable_id &&
														$user->persona->chapter->reign->officers->contains(function ($item) use ($user) {
															return $item->persona_id === $user->persona->id;
														})
												) ||
												(
														$user->persona->chapter->realm_id === $guest->event->chapter->realm_id &&
														$user->persona->chapter->realm->reign->officers->contains(function ($item) use ($user) {
															return $item->persona_id === $user->persona->id;
														})
												)
										)
								) ||
								(
										$guest->event->eventable_type === 'Realm' &&
										(
												$user->persona->chapter->realm_id === $guest->event->eventable_id &&
												$user->persona->chapter->realm->reign->officers->contains(function ($item) use ($user) {
													return $item->persona_id === $user->persona->id;
												})
										)
								) ||
								(
										$guest->event->eventable_type === 'Unit' &&
										$user->persona->units->first(function ($unit) use ($guest, $user) {
											return $unit->id === $guest->event->eventable_id &&
											$unit->officers->contains('persona_id', $user->persona->id);
										}) !== null
								) ||
								(
										$guest->event->crats->contains(function ($crat) use ($user) {
											return $crat->persona_id === $user->persona->id && $crat->is_autocrat === 1;
										})
								)
						)
				)
		) {
			return true;
		}
	}
	
	/**
	 * Determine whether the user can delete the guest.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Guest  $guest
	 * @return mixed
	 */
	public function delete(User $user, Guest $guest)
	{
		if (
				$user->can('remove guests') ||
				(
						$user->can('removeRelated guests') &&
						(
								(
										$guest->event->eventable_type === 'Chapter' &&
										(
												(
														$user->persona->chapter_id === $guest->event->eventable_id &&
														$user->persona->chapter->reign->officers->contains(function ($item) use ($user) {
															return $item->persona_id === $user->persona->id;
														})
												) ||
												(
														$user->persona->chapter->realm_id === $guest->event->chapter->realm_id &&
														$user->persona->chapter->realm->reign->officers->contains(function ($item) use ($user) {
															return $item->persona_id === $user->persona->id;
														})
												)
										)
								) ||
								(
										$guest->event->eventable_type === 'Realm' &&
										(
												$user->persona->chapter->realm_id === $guest->event->eventable_id &&
												$user->persona->chapter->realm->reign->officers->contains(function ($item) use ($user) {
													return $item->persona_id === $user->persona->id;
												})
										)
								) ||
								(
										$guest->event->eventable_type === 'Unit' &&
										$user->persona->units->first(function ($unit) use ($guest, $user) {
											return $unit->id === $guest->event->eventable_id &&
											$unit->officers->contains('persona_id', $user->persona->id);
										}) !== null
								) ||
								(
										$guest->event->crats->contains(function ($crat) use ($user) {
											return $crat->persona_id === $user->persona->id && $crat->is_autocrat === 1;
										})
								)
						)
				)
		) {
			return true;
		}
	}
	
	/**
	 * Determine whether the user can restore the guest.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Guest  $guest
	 * @return mixed
	 */
	public function restore(User $user, Guest $guest)
	{
		return false;
	}
	
	/**
	 * Determine whether the user can permanently delete the guest.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Guest  $guest
	 * @return mixed
	 */
	public function forceDelete(User $user, Guest $guest)
	{
		return false;
	}
}