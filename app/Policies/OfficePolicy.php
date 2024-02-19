<?php

namespace App\Policies;

use App\Models\Office;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OfficePolicy
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
	 * Determine whether the user can view any offices.
	 *
	 * @param  \App\Models\User  $user
	 * @return mixed
	 */
	public function viewAny(User $user)
	{
// 		if ($user->can('list offices')) {
			return true;
// 		}
	}
	
	/**
	 * Determine whether the user can view the office.
	 *
	 * @param  \App\Models\User $user
	 * @param  \App\Models\Office  $office
	 * @return mixed
	 */
	public function view(User $user, Office $office)
	{
// 		if ($user->can('display offices')) {
			return true;
// 		}
	}
	
	/**
	 * Determine whether the user can create offices.
	 *
	 * @param  \App\Models\User  $user
	 * @return mixed
	 */
	public function create(User $user)
	{
		if ($user->can('store offices')) {
			return true;
		}
	}
	
	/**
	 * Determine whether the user can update the office.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Office  $office
	 * @return mixed
	 */
	public function update(User $user, Office $office)
	{
		if (
				$user->can('update offices') ||
				(
						$user->can('updateRelated offices') &&
						(
								(
										$office->officerable_type === 'Chaptertype' &&
										$user->persona->chapter->realm_id === $office->officerable->realm->id &&
										$user->persona->chapter->realm->reign->officers->contains(function ($item) use ($user) {
											return $item->persona_id === $user->persona_id;
										})
								) ||
								(
										$office->officerable_type === 'Realm' &&
										$user->persona->chapter->realm_id === $office->officerable->id &&
										$user->persona->chapter->realm->reign->officers->contains(function ($item) use ($user) {
											return $item->persona_id === $user->persona_id;
										})
								) ||
								(
										$office->officerable_type === 'Unit' &&
										$user->persona->units->first(function ($unit) use ($office, $user) {
											return $unit->id === $office->officerable_id &&
											$unit->officers->contains('persona_id', $user->persona_id);
										}) !== null
								)
						)
				)
		) {
			return true;
		}
	}
	
	/**
	 * Determine whether the user can delete the office.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Office  $office
	 * @return mixed
	 */
	public function delete(User $user, Office $office)
	{
		if (
				$user->can('remove offices') ||
				(
						$user->can('removeRelated offices') &&
						(
								(
										$office->officerable_type === 'Chaptertype' &&
										$user->persona->chapter->realm_id === $office->officerable->realm->id &&
										$user->persona->chapter->realm->reign->officers->contains(function ($item) use ($user) {
											return $item->persona_id === $user->persona_id;
										})
								) ||
								(
										$office->officerable_type === 'Realm' &&
										$user->persona->chapter->realm_id === $office->officerable->id &&
										$user->persona->chapter->realm->reign->officers->contains(function ($item) use ($user) {
											return $item->persona_id === $user->persona_id;
										})
								) ||
								(
										$office->officerable_type === 'Unit' &&
										$user->persona->units->first(function ($unit) use ($office, $user) {
											return $unit->id === $office->officerable_id &&
											$unit->officers->contains('persona_id', $user->persona_id);
										}) !== null
								)
						)
				)
		) {
			return true;
		}
	}
	
	/**
	 * Determine whether the user can restore the office.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Office  $office
	 * @return mixed
	 */
	public function restore(User $user, Office $office)
	{
		return false;
	}
	
	/**
	 * Determine whether the user can permanently delete the office.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Office  $office
	 * @return mixed
	 */
	public function forceDelete(User $user, Office $office)
	{
		return false;
	}
}