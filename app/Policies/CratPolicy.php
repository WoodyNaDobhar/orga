<?php

namespace App\Policies;

use App\Models\Crat;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CratPolicy
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
	 * Determine whether the user can view any crats.
	 *
	 * @param  \App\Models\User  $user
	 * @return mixed
	 */
	public function viewAny(User $user)
	{
// 		if ($user->can('list crats')) {
			return true;
// 		}
	}
	
	/**
	 * Determine whether the user can view the crat.
	 *
	 * @param  \App\Models\User $user
	 * @param  \App\Models\Crat  $crat
	 * @return mixed
	 */
	public function view(User $user, Crat $crat)
	{
// 		if ($user->can('display crats')) {
			return true;
// 		}
	}
	
	/**
	 * Determine whether the user can create crats.
	 *
	 * @param  \App\Models\User  $user
	 * @return mixed
	 */
	public function create(User $user)
	{
		if ($user->can('store crats')) {
			return true;
		}
	}
	
	/**
	 * Determine whether the user can update the crat.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Crat  $crat
	 * @return mixed
	 */
	public function update(User $user, Crat $crat)
	{
		if ($user->can('update crats') ||
				(
						$user->can('updateRelated crats') &&
						(
								$user->persona->crats->contains(function ($item) use ($crat) {
									return $item->event_id === $crat->event_id && $item->is_autocrat === 1;
								})
						)
				)
		) {
			return true;
		}
	}
	
	/**
	 * Determine whether the user can delete the crat.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Crat  $crat
	 * @return mixed
	 */
	public function delete(User $user, Crat $crat)
	{
		if ($user->can('remove crats') ||
				(
						$user->can('removeRelated crats') &&
						(
								$user->persona->crats->contains(function ($item) use ($crat) {
									return $item->event_id === $crat->event_id && $item->is_autocrat === 1;
								})
						)
				)
		) {
			return true;
		}
	}
	
	/**
	 * Determine whether the user can restore the crat.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Crat  $crat
	 * @return mixed
	 */
	public function restore(User $user, Crat $crat)
	{
		return false;
	}
	
	/**
	 * Determine whether the user can permanently delete the crat.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Crat  $crat
	 * @return mixed
	 */
	public function forceDelete(User $user, Crat $crat)
	{
		return false;
	}
}