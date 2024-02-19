<?php

namespace App\Policies;

use App\Models\Archetype;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArchetypePolicy
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
	 * Determine whether the user can view any archetypes.
	 *
	 * @param  \App\Models\User  $user
	 * @return mixed
	 */
	public function viewAny(User $user)
	{
// 		if ($user->can('list archetypes')) {
			return true;
// 		}
	}
	
	/**
	 * Determine whether the user can view the archetype.
	 *
	 * @param  \App\Models\User $user
	 * @param  \App\Models\Archetype  $archetype
	 * @return mixed
	 */
	public function view(User $user, Archetype $archetype)
	{
// 		if ($user->can('display archetypes')) {
			return true;
// 		}
	}
	
	/**
	 * Determine whether the user can create archetypes.
	 *
	 * @param  \App\Models\User  $user
	 * @return mixed
	 */
	public function create(User $user)
	{
		if ($user->can('store archetypes')) {
			return true;
		}
	}
	
	/**
	 * Determine whether the user can update the archetype.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Archetype  $archetype
	 * @return mixed
	 */
	public function update(User $user, Archetype $archetype)
	{
		if ($user->can('update archetypes')) {
			return true;
		}
	}
	
	/**
	 * Determine whether the user can delete the archetype.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Archetype  $archetype
	 * @return mixed
	 */
	public function delete(User $user, Archetype $archetype)
	{
		if ($user->can('remove archetypes')) {
			return true;
		}
	}
	
	/**
	 * Determine whether the user can restore the archetype.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Archetype  $archetype
	 * @return mixed
	 */
	public function restore(User $user, Archetype $archetype)
	{
		return false;
	}
	
	/**
	 * Determine whether the user can permanently delete the archetype.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Archetype  $archetype
	 * @return mixed
	 */
	public function forceDelete(User $user, Archetype $archetype)
	{
		return false;
	}
}