<?php

namespace App\Policies;

use App\Models\Reign;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReignPolicy
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
	 * Determine whether the user can view any reigns.
	 *
	 * @param  \App\Models\User  $user
	 * @return mixed
	 */
	public function viewAny(User $user)
	{
// 		if ($user->can('list reigns')) {
			return true;
// 		}
	}
	
	/**
	 * Determine whether the user can view the reign.
	 *
	 * @param  \App\Models\User $user
	 * @param  \App\Models\Reign  $reign
	 * @return mixed
	 */
	public function view(User $user, Reign $reign)
	{
// 		if ($user->can('display reigns')) {
			return true;
// 		}
	}
	
	/**
	 * Determine whether the user can create reigns.
	 *
	 * @param  \App\Models\User  $user
	 * @return mixed
	 */
	public function create(User $user)
	{
		if ($user->can('store reigns')) {
			return true;
		}
	}
	
	/**
	 * Determine whether the user can update the reign.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Reign  $reign
	 * @return mixed
	 */
	public function update(User $user, Reign $reign)
	{
		if (
				$user->can('update reigns') ||
				(
						$user->can('updateRelated reigns') &&
						(
								(
										$reign->reignable_type === 'Chapter' &&
										(
												(
														$user->persona->chapter_id === $reign->reignable_id &&
														$user->persona->chapter->reign->officers->contains(function ($item) use ($user) {
															return $item->persona_id === $user->persona->id;
														})
												) ||
												(
														$user->persona->chapter->realm_id === $reign->reignable->realm_id &&
														$user->persona->chapter->realm->reign->officers->contains(function ($item) use ($user) {
															return $item->persona_id === $user->persona->id;
														})
												)
										)
								) ||
								(
										$reign->reignable_type === 'Realm' &&
										$user->persona->chapter->realm_id === $reign->reignable->realm_id &&
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
	 * Determine whether the user can delete the reign.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Reign  $reign
	 * @return mixed
	 */
	public function delete(User $user, Reign $reign)
	{
		if (
				$user->can('remove reigns') ||
				(
						$user->can('removeRelated reigns') &&
						(
								(
										$reign->reignable_type === 'Chapter' &&
										(
												(
														$user->persona->chapter_id === $reign->reignable_id &&
														$user->persona->chapter->reign->officers->contains(function ($item) use ($user) {
															return $item->persona_id === $user->persona->id;
														})
												) ||
												(
														$user->persona->chapter->realm_id === $reign->reignable->realm_id &&
														$user->persona->chapter->realm->reign->officers->contains(function ($item) use ($user) {
															return $item->persona_id === $user->persona->id;
														})
												)
										)
								) ||
								(
										$reign->reignable_type === 'Realm' &&
										$user->persona->chapter->realm_id === $reign->reignable_id &&
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
	 * Determine whether the user can restore the reign.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Reign  $reign
	 * @return mixed
	 */
	public function restore(User $user, Reign $reign)
	{
		return false;
	}
	
	/**
	 * Determine whether the user can permanently delete the reign.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Reign  $reign
	 * @return mixed
	 */
	public function forceDelete(User $user, Reign $reign)
	{
		return false;
	}
}