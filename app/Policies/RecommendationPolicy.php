<?php

namespace App\Policies;

use App\Models\Recommendation;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RecommendationPolicy
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
	 * Determine whether the user can view any recommendations.
	 *
	 * @param  \App\Models\User  $user
	 * @return mixed
	 */
	public function viewAny(User $user)
	{
// 		if ($user->can('list recommendations')) {
			return true;
// 		}
	}
	
	/**
	 * Determine whether the user can view the recommendation.
	 *
	 * @param  \App\Models\User $user
	 * @param  \App\Models\Recommendation  $recommendation
	 * @return mixed
	 */
	public function view(User $user, Recommendation $recommendation)
	{
// 		if ($user->can('display recommendations')) {
			return true;
// 		}
	}
	
	/**
	 * Determine whether the user can create recommendations.
	 *
	 * @param  \App\Models\User  $user
	 * @return mixed
	 */
	public function create(User $user)
	{
		if ($user->can('store recommendations')) {
			return true;
		}
	}
	
	/**
	 * Determine whether the user can update the recommendation.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Recommendation  $recommendation
	 * @return mixed
	 */
	public function update(User $user, Recommendation $recommendation)
	{
		if (
				$user->can('update recommendations') ||
				(
						$user->can('updateOwn recommendations') &&
						$recommendation->persona_id === $user->id
				) ||
				(
						$user->can('updateRelated recommendations') &&
						(
								(
										$recommendation->recommendable_type === 'Award' &&
										(
												$recommendation->recommendable->awarder_type === 'Chapter' &&
												(
														(
																$user->persona->chapter_id === $recommendation->recommendable->awarder_id &&
																$user->persona->chapter->reign->officers->contains(function ($item) use ($user) {
																	return $item->persona_id === $user->persona_id;
																})
														) ||
														(
																$user->persona->chapter->realm_id === $recommendation->recommendable->awarder->realm_id &&
																$user->persona->chapter->realm->reign->officers->contains(function ($item) use ($user) {
																	return $item->persona_id === $user->persona_id;
																})
														)
												)
										) ||
										(
												$recommendation->recommendable->awarder_type === 'Realm' &&
												$user->persona->chapter->realm_id === $recommendation->recommendable->awarder_id &&
												$user->persona->chapter->realm->reign->officers->contains(function ($item) use ($user) {
													return $item->persona_id === $user->persona_id;
												})
										) ||
										(
												$recommendation->recommendable->awarder_type === 'Unit' &&
												$user->persona->units->first(function ($unit) use ($recommendation, $user) {
													return $unit->id === $recommendation->recommendable->awarder_id &&
													$unit->officers->contains('persona_id', $user->persona_id);
												}) !== null
										)
								) ||
								(
										$recommendation->recommendable_type === 'Title' &&
										(
												$recommendation->recommendable->titleable_type === 'Chapter' &&
												(
														(
																$user->persona->chapter_id === $recommendation->recommendable->titleable_id &&
																$user->persona->chapter->reign->officers->contains(function ($item) use ($user) {
																	return $item->persona_id === $user->persona_id;
																})
														) ||
														(
																$user->persona->chapter->realm_id === $recommendation->recommendable->titleable->realm_id &&
																$user->persona->chapter->realm->reign->officers->contains(function ($item) use ($user) {
																	return $item->persona_id === $user->persona_id;
																})
														)
												)
										) ||
										(
												$recommendation->recommendable->titleable_type === 'Persona' &&
												$user->persona_id === $recommendation->recommendable->titleable_id
										)||
										(
												$recommendation->recommendable->titleable_type === 'Realm' &&
												$user->persona->chapter->realm_id === $recommendation->recommendable->titleable_id &&
												$user->persona->chapter->realm->reign->officers->contains(function ($item) use ($user) {
													return $item->persona_id === $user->persona_id;
												})
										) ||
										(
												$recommendation->recommendable->titleable_type === 'Unit' &&
												$user->persona->units->first(function ($unit) use ($recommendation, $user) {
													return $unit->id === $recommendation->recommendable->titleable_id &&
													$unit->officers->contains('persona_id', $user->persona_id);
												}) !== null
										)
								)
						)
				)
		) {
			return true;
		}
	}
	
	/**
	 * Determine whether the user can delete the recommendation.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Recommendation  $recommendation
	 * @return mixed
	 */
	public function delete(User $user, Recommendation $recommendation)
	{
		if (
				$user->can('remove recommendations') ||
				(
						$user->can('removeOwn recommendations') &&
						$recommendation->persona_id === $user->id
				) ||
				(
						$user->can('removeRelated recommendations') &&
						(
								(
										$recommendation->recommendable_type === 'Award' &&
										(
												$recommendation->recommendable->awarder_type === 'Chapter' &&
												(
														(
																$user->persona->chapter_id === $recommendation->recommendable->awarder_id &&
																$user->persona->chapter->reign->officers->contains(function ($item) use ($user) {
																	return $item->persona_id === $user->persona_id;
																})
														) ||
														(
																$user->persona->chapter->realm_id === $recommendation->recommendable->awarder->realm_id &&
																$user->persona->chapter->realm->reign->officers->contains(function ($item) use ($user) {
																	return $item->persona_id === $user->persona_id;
																})
														)
												)
										) ||
										(
												$recommendation->recommendable->awarder_type === 'Realm' &&
												$user->persona->chapter->realm_id === $recommendation->recommendable->awarder_id &&
												$user->persona->chapter->realm->reign->officers->contains(function ($item) use ($user) {
													return $item->persona_id === $user->persona_id;
												})
										) ||
										(
												$recommendation->recommendable->awarder_type === 'Unit' &&
												$user->persona->units->first(function ($unit) use ($recommendation, $user) {
													return $unit->id === $recommendation->recommendable->awarder_id &&
													$unit->officers->contains('persona_id', $user->persona_id);
												}) !== null
										)
								) ||
								(
										$recommendation->recommendable_type === 'Title' &&
										(
												$recommendation->recommendable->titleable_type === 'Chapter' &&
												(
														(
																$user->persona->chapter_id === $recommendation->recommendable->titleable_id &&
																$user->persona->chapter->reign->officers->contains(function ($item) use ($user) {
																	return $item->persona_id === $user->persona_id;
																})
														) ||
														(
																$user->persona->chapter->realm_id === $recommendation->recommendable->titleable->realm_id &&
																$user->persona->chapter->realm->reign->officers->contains(function ($item) use ($user) {
																	return $item->persona_id === $user->persona_id;
																})
														)
												)
										) ||
										(
												$recommendation->recommendable->titleable_type === 'Persona' &&
												$user->persona_id === $recommendation->recommendable->titleable_id
										)||
										(
												$recommendation->recommendable->titleable_type === 'Realm' &&
												$user->persona->chapter->realm_id === $recommendation->recommendable->titleable_id &&
												$user->persona->chapter->realm->reign->officers->contains(function ($item) use ($user) {
													return $item->persona_id === $user->persona_id;
												})
										) ||
										(
												$recommendation->recommendable->titleable_type === 'Unit' &&
												$user->persona->units->first(function ($unit) use ($recommendation, $user) {
													return $unit->id === $recommendation->recommendable->titleable_id &&
													$unit->officers->contains('persona_id', $user->persona_id);
												}) !== null
										)
								)
						)
				)
		) {
			return true;
		}
	}
	
	/**
	 * Determine whether the user can restore the recommendation.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Recommendation  $recommendation
	 * @return mixed
	 */
	public function restore(User $user, Recommendation $recommendation)
	{
		return false;
	}
	
	/**
	 * Determine whether the user can permanently delete the recommendation.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Recommendation  $recommendation
	 * @return mixed
	 */
	public function forceDelete(User $user, Recommendation $recommendation)
	{
		return false;
	}
}