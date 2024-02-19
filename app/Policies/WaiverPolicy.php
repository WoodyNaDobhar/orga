<?php

namespace App\Policies;

use App\Models\Waiver;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class WaiverPolicy
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
	 * Determine whether the user can view any waivers.
	 *
	 * @param  \App\Models\User  $user
	 * @return mixed
	 */
	public function viewAny(User $user)
	{
// 		if ($user->can('list waivers')) {
			return true;
// 		}
	}
	
	/**
	 * Determine whether the user can view the waiver.
	 *
	 * @param  \App\Models\User $user
	 * @param  \App\Models\Waiver  $waiver
	 * @return mixed
	 */
	public function view(User $user, Waiver $waiver)
	{
// 		if ($user->can('display waivers')) {
			return true;
// 		}
	}
	
	/**
	 * Determine whether the user can create waivers.
	 *
	 * @param  \App\Models\User  $user
	 * @return mixed
	 */
	public function create(User $user)
	{
		if ($user->can('store waivers')) {
			return true;
		}
	}
	
	/**
	 * Determine whether the user can update the waiver.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Waiver  $waiver
	 * @return mixed
	 */
	public function update(User $user, Waiver $waiver)
	{
		if (
				$user->can('update waivers') ||
				(
						$user->can('updateRelated waivers') &&
						(
								(
										$waiver->persona_id &&
										(
												$waiver->persona->chapter->reign->officers->contains(function ($item) use ($user) {
													return $item->persona_id === $user->persona_id;
												}) ||
												$waiver->persona->chapter->realm->reign->officers->contains(function ($item) use ($user) {
													return $item->persona_id === $user->persona_id;
												})
										)
								) ||
								(
										$waiver->waiverable_type === 'Realm' &&
										$waiver->waiverable->reign->officers->contains(function ($item) use ($user) {
											return $item->persona_id === $user->persona_id;
										})
								) ||
								(
										$waiver->waiverable_type === 'Event' &&
										$waiver->waiverable->crats->contains(function ($item) use ($user) {
											return $item->persona_id === $user->persona_id;
										})
								)
						)
				)
		) {
			return true;
		}
	}
	
	/**
	 * Determine whether the user can delete the waiver.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Waiver  $waiver
	 * @return mixed
	 */
	public function delete(User $user, Waiver $waiver)
	{
		if (
				$user->can('remove waivers') ||
				(
						$user->can('removeRelated waivers') &&
						(
								(
										$waiver->persona_id &&
										(
												$waiver->persona->chapter->reign->officers->contains(function ($item) use ($user) {
													return $item->persona_id === $user->persona_id;
												}) ||
												$waiver->persona->chapter->realm->reign->officers->contains(function ($item) use ($user) {
													return $item->persona_id === $user->persona_id;
												})
										)
								) ||
								(
										$waiver->waiverable_type === 'Realm' &&
										$waiver->waiverable->reign->officers->contains(function ($item) use ($user) {
											return $item->persona_id === $user->persona_id;
										})
								) ||
								(
										$waiver->waiverable_type === 'Event' &&
										$waiver->waiverable->crats->contains(function ($item) use ($user) {
											return $item->persona_id === $user->persona_id;
										})
								)
						)
				)
		) {
			return true;
		}
	}
	
	/**
	 * Determine whether the user can restore the waiver.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Waiver  $waiver
	 * @return mixed
	 */
	public function restore(User $user, Waiver $waiver)
	{
		return false;
	}
	
	/**
	 * Determine whether the user can permanently delete the waiver.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Waiver  $waiver
	 * @return mixed
	 */
	public function forceDelete(User $user, Waiver $waiver)
	{
		return false;
	}
}