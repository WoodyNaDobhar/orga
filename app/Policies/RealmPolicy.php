<?php

namespace App\Policies;

use App\Models\Realm;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RealmPolicy
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
	 * Determine whether the user can view any realms.
	 *
	 * @param  \App\Models\User  $user
	 * @return mixed
	 */
	public function viewAny(User $user)
	{
// 		if ($user->can('list realms')) {
			return true;
// 		}
	}
	
	/**
	 * Determine whether the user can view the realm.
	 *
	 * @param  \App\Models\User $user
	 * @param  \App\Models\Realm  $realm
	 * @return mixed
	 */
	public function view(User $user, Realm $realm)
	{
// 		if ($user->can('display realms')) {
			return true;
// 		}
	}
	
	/**
	 * Determine whether the user can create realms.
	 *
	 * @param  \App\Models\User  $user
	 * @return mixed
	 */
	public function create(User $user)
	{
		if ($user->can('store realms')) {
			return true;
		}
	}
	
	/**
	 * Determine whether the user can update the realm.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Realm  $realm
	 * @return mixed
	 */
	public function update(User $user, Realm $realm)
	{
		if (
				$user->can('update realms') ||
				(
						$user->can('updateRelated realms') &&
						(
								(
										$user->persona->chapter->realm_id === $realm->id &&
										$user->persona->chapter->realm->reign->officers->contains(function ($item) use ($user) {
											return $item->persona_id === $user->persona->id;
										})
								) ||
								(
										$realm->parent_id !== null &&
										$user->persona->chapter->realm_id === $realm->parent_id &&
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
	 * Determine whether the user can delete the realm.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Realm  $realm
	 * @return mixed
	 */
	public function delete(User $user, Realm $realm)
	{
		if (
				$user->can('remove realms') ||
				(
						$user->can('removeRelated realms') &&
						(
								(
										$user->persona->chapter->realm_id === $realm->id &&
										$user->persona->chapter->realm->reign->officers->contains(function ($item) use ($user) {
											return $item->persona_id === $user->persona->id;
										})
								) ||
								(
										$realm->parent_id !== null &&
										$user->persona->chapter->realm_id === $realm->parent_id &&
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
	 * Determine whether the user can restore the realm.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Realm  $realm
	 * @return mixed
	 */
	public function restore(User $user, Realm $realm)
	{
		return false;
	}
	
	/**
	 * Determine whether the user can permanently delete the realm.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Realm  $realm
	 * @return mixed
	 */
	public function forceDelete(User $user, Realm $realm)
	{
		return false;
	}
}