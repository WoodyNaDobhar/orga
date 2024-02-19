<?php

namespace App\Policies;

use App\Models\Officer;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OfficerPolicy
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
	 * Determine whether the user can view any officers.
	 *
	 * @param  \App\Models\User  $user
	 * @return mixed
	 */
	public function viewAny(User $user)
	{
// 		if ($user->can('list officers')) {
			return true;
// 		}
	}
	
	/**
	 * Determine whether the user can view the officer.
	 *
	 * @param  \App\Models\User $user
	 * @param  \App\Models\Officer  $officer
	 * @return mixed
	 */
	public function view(User $user, Officer $officer)
	{
// 		if ($user->can('display officers')) {
			return true;
// 		}
	}
	
	/**
	 * Determine whether the user can create officers.
	 *
	 * @param  \App\Models\User  $user
	 * @return mixed
	 */
	public function create(User $user)
	{
		if ($user->can('store officers')) {
			return true;
		}
	}
	
	/**
	 * Determine whether the user can update the officer.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Officer  $officer
	 * @return mixed
	 */
	public function update(User $user, Officer $officer)
	{
		if (
				$user->can('update offices') ||
				(
						$user->can('updateRelated offices') &&
						(
								(
										$officer->officerable_type === 'Reign' &&
										(
												(
														$officer->officerable->reignable_type === 'Chapter' &&
														$user->persona->chapter_id === $officer->officerable->reignable_id &&
														$user->persona->chapter->reign->officers->contains(function ($item) use ($user) {
															return $item->persona_id === $user->persona_id;
														})
												) ||
												(
														$officer->officerable->reignable_type === 'Realm' &&
														$user->persona->chapter->realm_id === $officer->officerable->reignable_id &&
														$user->persona->chapter->realm->reign->officers->contains(function ($item) use ($user) {
															return $item->persona_id === $user->persona_id;
														})
												)
										)
								) ||
								(
										$officer->officerable_type === 'Unit' &&
										$user->persona->units->first(function ($unit) use ($officer, $user) {
											return $unit->id === $officer->officerable_id &&
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
	 * Determine whether the user can delete the officer.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Officer  $officer
	 * @return mixed
	 */
	public function delete(User $user, Officer $officer)
	{
		if (
				$user->can('remove offices') ||
				(
						$user->can('removeRelated offices') &&
						(
								(
										$officer->officerable_type === 'Reign' &&
										(
												(
														$officer->officerable->reignable_type === 'Chapter' &&
														$user->persona->chapter_id === $officer->officerable->reignable_id &&
														$user->persona->chapter->reign->officers->contains(function ($item) use ($user) {
															return $item->persona_id === $user->persona_id;
														})
												) ||
												(
														$officer->officerable->reignable_type === 'Realm' &&
														$user->persona->chapter->realm_id === $officer->officerable->reignable_id &&
														$user->persona->chapter->realm->reign->officers->contains(function ($item) use ($user) {
															return $item->persona_id === $user->persona_id;
														})
												)
										)
								) ||
								(
										$officer->officerable_type === 'Unit' &&
										$user->persona->units->first(function ($unit) use ($officer, $user) {
											return $unit->id === $officer->officerable_id &&
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
	 * Determine whether the user can restore the officer.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Officer  $officer
	 * @return mixed
	 */
	public function restore(User $user, Officer $officer)
	{
		return false;
	}
	
	/**
	 * Determine whether the user can permanently delete the officer.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Officer  $officer
	 * @return mixed
	 */
	public function forceDelete(User $user, Officer $officer)
	{
		return false;
	}
}