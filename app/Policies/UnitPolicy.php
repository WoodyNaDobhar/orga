<?php

namespace App\Policies;

use App\Models\Unit;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UnitPolicy
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
	 * Determine whether the user can view any units.
	 *
	 * @param  \App\Models\User  $user
	 * @return mixed
	 */
	public function viewAny(User $user)
	{
// 		if ($user->can('list units')) {
			return true;
// 		}
	}
	
	/**
	 * Determine whether the user can view the unit.
	 *
	 * @param  \App\Models\User $user
	 * @param  \App\Models\Unit  $unit
	 * @return mixed
	 */
	public function view(User $user, Unit $unit)
	{
// 		if ($user->can('display units')) {
			return true;
// 		}
	}
	
	/**
	 * Determine whether the user can create units.
	 *
	 * @param  \App\Models\User  $user
	 * @return mixed
	 */
	public function create(User $user)
	{
		if ($user->can('store units')) {
			return true;
		}
	}
	
	/**
	 * Determine whether the user can update the unit.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Unit  $unit
	 * @return mixed
	 */
	public function update(User $user, Unit $unit)
	{
		if (
				$user->can('update units') ||
				(
						$user->can('updateRelated units') &&
						(
								$user->persona->units->first(function ($item) use ($unit, $user) {
									return $item->id === $unit->id &&
									$unit->officers->contains('persona_id', $user->persona_id);
								}) !== null
						)
				)
		) {
			return true;
		}
	}
	
	/**
	 * Determine whether the user can delete the unit.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Unit  $unit
	 * @return mixed
	 */
	public function delete(User $user, Unit $unit)
	{
		if ($user->can('remove units')) {
			return true;
		}
	}
	
	/**
	 * Determine whether the user can restore the unit.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Unit  $unit
	 * @return mixed
	 */
	public function restore(User $user, Unit $unit)
	{
		return false;
	}
	
	/**
	 * Determine whether the user can permanently delete the unit.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Unit  $unit
	 * @return mixed
	 */
	public function forceDelete(User $user, Unit $unit)
	{
		return false;
	}
}