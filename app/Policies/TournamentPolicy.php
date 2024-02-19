<?php

namespace App\Policies;

use App\Models\Tournament;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TournamentPolicy
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
	 * Determine whether the user can view any tournaments.
	 *
	 * @param  \App\Models\User  $user
	 * @return mixed
	 */
	public function viewAny(User $user)
	{
// 		if ($user->can('list tournaments')) {
			return true;
// 		}
	}
	
	/**
	 * Determine whether the user can view the tournament.
	 *
	 * @param  \App\Models\User $user
	 * @param  \App\Models\Tournament  $tournament
	 * @return mixed
	 */
	public function view(User $user, Tournament $tournament)
	{
// 		if ($user->can('display tournaments')) {
			return true;
// 		}
	}
	
	/**
	 * Determine whether the user can create tournaments.
	 *
	 * @param  \App\Models\User  $user
	 * @return mixed
	 */
	public function create(User $user)
	{
		if ($user->can('store tournaments')) {
			return true;
		}
	}
	
	/**
	 * Determine whether the user can update the tournament.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Tournament  $tournament
	 * @return mixed
	 */
	public function update(User $user, Tournament $tournament)
	{
		if (
				$user->can('update tournaments') ||
				(
						$user->can('updateRelated tournaments') &&
						(
								(
										$tournament->tourmentable_type === 'Chapter' &&
										(
												(
														$user->persona->chapter_id === $tournament->tourmentable_id &&
														$user->persona->chapter->reign->officers->contains(function ($item) use ($user) {
															return $item->persona_id === $user->persona_id;
														})
												) ||
												(
														$user->persona->chapter->realm_id === $tournament->tourmentable->realm_id &&
														$user->persona->chapter->realm->reign->officers->contains(function ($item) use ($user) {
															return $item->persona_id === $user->persona_id;
														})
												)
										)
								) ||
								(
										$tournament->tourmentable_type === 'Event' &&
										$tournament->tourmentable->crats->contains(function ($item) use ($user) {
											return $item->persona_id === $user->persona_id;
										})
								) ||
								(
										$tournament->tourmentable_type === 'Realm' &&
										$user->persona->chapter->realm_id === $tournament->tourmentable_id &&
										$user->persona->chapter->realm->reign->officers->contains(function ($item) use ($user) {
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
	 * Determine whether the user can delete the tournament.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Tournament  $tournament
	 * @return mixed
	 */
	public function delete(User $user, Tournament $tournament)
	{
		if (
				$user->can('remove tournaments') ||
				(
						$user->can('removeRelated tournaments') &&
						(
								(
										$tournament->tourmentable_type === 'Chapter' &&
										(
												(
														$user->persona->chapter_id === $tournament->tourmentable_id &&
														$user->persona->chapter->reign->officers->contains(function ($item) use ($user) {
															return $item->persona_id === $user->persona_id;
														})
												) ||
												(
														$user->persona->chapter->realm_id === $tournament->tourmentable->realm_id &&
														$user->persona->chapter->realm->reign->officers->contains(function ($item) use ($user) {
															return $item->persona_id === $user->persona_id;
														})
												)
										)
								) ||
								(
										$tournament->tourmentable_type === 'Event' &&
										$tournament->tourmentable->crats->contains(function ($item) use ($user) {
											return $item->persona_id === $user->persona_id;
										})
								) ||
								(
										$tournament->tourmentable_type === 'Realm' &&
										$user->persona->chapter->realm_id === $tournament->tourmentable_id &&
										$user->persona->chapter->realm->reign->officers->contains(function ($item) use ($user) {
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
	 * Determine whether the user can restore the tournament.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Tournament  $tournament
	 * @return mixed
	 */
	public function restore(User $user, Tournament $tournament)
	{
		return false;
	}
	
	/**
	 * Determine whether the user can permanently delete the tournament.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Tournament  $tournament
	 * @return mixed
	 */
	public function forceDelete(User $user, Tournament $tournament)
	{
		return false;
	}
}