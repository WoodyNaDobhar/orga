<?php

namespace App\Policies;

use App\Models\Award;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AwardPolicy
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
	 * Determine whether the user can view any awards.
	 *
	 * @param  \App\Models\User  $user
	 * @return mixed
	 */
	public function viewAny(User $user)
	{
// 		if ($user->can('list awards')) {
			return true;
// 		}
	}
	
	/**
	 * Determine whether the user can view the award.
	 *
	 * @param  \App\Models\User $user
	 * @param  \App\Models\Award  $award
	 * @return mixed
	 */
	public function view(User $user, Award $award)
	{
// 		if ($user->can('display awards')) {
			return true;
// 		}
	}
	
	/**
	 * Determine whether the user can create awards.
	 *
	 * @param  \App\Models\User  $user
	 * @return mixed
	 */
	public function create(User $user)
	{
		if ($user->can('store awards')) {
			return true;
		}
	}
	
	/**
	 * Determine whether the user can update the award.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Award  $award
	 * @return mixed
	 */
	public function update(User $user, Award $award)
	{
		if (
				$user->can('update awards') ||
				(
						$user->can('updateRelated awards') &&
						(
								(
										$award->awarder_type === 'Chapter' &&
										(
												(
														$user->persona->chapter_id === $award->awarder_id &&
														$user->persona->chapter->reign->officers->contains(function ($item) use ($user) {
															return $item->persona_id === $user->persona_id;
														})
												) ||
												(
														$user->persona->chapter->realm_id === $award->awarder->realm_id &&
														$user->persona->chapter->realm->reign->officers->contains(function ($item) use ($user) {
															return $item->persona_id === $user->persona_id;
														})
												)
										)
								) ||
								(
										$award->awarder_type === 'Realm' &&
										$user->persona->chapter->realm_id === $award->awarder_id &&
										$user->persona->chapter->realm->reign->officers->contains(function ($item) use ($user) {
											return $item->persona_id === $user->persona_id;
										})
								) ||
								(
										$award->awarder_type === 'Unit' &&
										$user->persona->units->first(function ($unit) use ($award, $user) {
											return $unit->id === $award->awarder_id &&
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
	 * Determine whether the user can delete the award.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Award  $award
	 * @return mixed
	 */
	public function delete(User $user, Award $award)
	{
		if (
				$user->can('remove awards') ||
				(
						$user->can('removeRelated awards') &&
						(
								(
										$award->awarder_type === 'Chapter' &&
										(
												(
														$user->persona->chapter_id === $award->awarder_id &&
														$user->persona->chapter->reign->officers->contains(function ($item) use ($user) {
															return $item->persona_id === $user->persona_id;
														})
												) ||
												(
														$user->persona->chapter->realm_id === $award->awarder->realm_id &&
														$user->persona->chapter->realm->reign->officers->contains(function ($item) use ($user) {
															return $item->persona_id === $user->persona_id;
														})
												)
										)
								) ||
								(
										$award->awarder_type === 'Realm' &&
										$user->persona->chapter->realm_id === $award->awarder_id &&
										$user->persona->chapter->realm->reign->officers->contains(function ($item) use ($user) {
											return $item->persona_id === $user->persona_id;
										})
								) ||
								(
										$award->awarder_type === 'Unit' &&
										$user->persona->units->first(function ($unit) use ($award, $user) {
											return $unit->id === $award->awarder_id &&
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
	 * Determine whether the user can restore the award.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Award  $award
	 * @return mixed
	 */
	public function restore(User $user, Award $award)
	{
		return false;
	}
	
	/**
	 * Determine whether the user can permanently delete the award.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Award  $award
	 * @return mixed
	 */
	public function forceDelete(User $user, Award $award)
	{
		return false;
	}
}