<?php

namespace App\Policies;

use App\Models\Social;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SocialPolicy
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
	 * Determine whether the user can view any socials.
	 *
	 * @param  \App\Models\User  $user
	 * @return mixed
	 */
	public function viewAny(User $user)
	{
// 		if ($user->can('list socials')) {
			return true;
// 		}
	}
	
	/**
	 * Determine whether the user can view the social.
	 *
	 * @param  \App\Models\User $user
	 * @param  \App\Models\Social  $social
	 * @return mixed
	 */
	public function view(User $user, Social $social)
	{
// 		if ($user->can('display socials')) {
			return true;
// 		}
	}
	
	/**
	 * Determine whether the user can create socials.
	 *
	 * @param  \App\Models\User  $user
	 * @return mixed
	 */
	public function create(User $user)
	{
		if ($user->can('store socials')) {
			return true;
		}
	}
	
	/**
	 * Determine whether the user can update the social.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Social  $social
	 * @return mixed
	 */
	public function update(User $user, Social $social)
	{
		if (
				$user->can('update socials') ||
				(
						$user->can('updateOwn socials') &&
						$social->id === $user->id
				) ||
				(
						$user->can('updateRelated socials') &&
						(
								(
										$social->sociable_type === 'Chapter' &&
										(
												(
														$user->persona->chapter_id === $social->sociable_id &&
														$user->persona->chapter->reign->officers->contains(function ($item) use ($user) {
															return $item->persona_id === $user->persona->id;
														})
												) ||
												(
														$user->persona->chapter->realm_id === $social->sociable->realm_id &&
														$user->persona->chapter->realm->reign->officers->contains(function ($item) use ($user) {
															return $item->persona_id === $user->persona->id;
														})
												)
										)
								) ||
								(
										$social->sociable_type === 'Event' &&
										$social->sociable->crats->contains(function ($item) use ($user) {
											return $item->persona_id === $user->persona->id;
										})
								) ||
								(
										$social->sociable_type === 'Realm' &&
										$user->persona->chapter->realm_id === $social->sociable_id &&
										$user->persona->chapter->realm->reign->officers->contains(function ($item) use ($user) {
											return $item->persona_id === $user->persona->id;
										})
								) ||
								(
										$social->sociable_type === 'Unit' &&
										$user->persona->units->first(function ($unit) use ($social, $user) {
											return $unit->id === $social->sociable_id &&
											$unit->officers->contains('persona_id', $user->persona->id);
										}) !== null
								)
						)
				)
		) {
			return true;
		}
	}
	
	/**
	 * Determine whether the user can delete the social.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Social  $social
	 * @return mixed
	 */
	public function delete(User $user, Social $social)
	{
		if (
				$user->can('remove socials') ||
				(
						$user->can('removeOwn socials') &&
						$social->id === $user->id
				) ||
				(
						$user->can('removeRelated socials') &&
						(
								(
										$social->sociable_type === 'Chapter' &&
										(
												(
														$user->persona->chapter_id === $social->sociable_id &&
														$user->persona->chapter->reign->officers->contains(function ($item) use ($user) {
															return $item->persona_id === $user->persona->id;
														})
												) ||
												(
														$user->persona->chapter->realm_id === $social->sociable->realm_id &&
														$user->persona->chapter->realm->reign->officers->contains(function ($item) use ($user) {
															return $item->persona_id === $user->persona->id;
														})
												)
										)
								) ||
								(
										$social->sociable_type === 'Event' &&
										$social->sociable->crats->contains(function ($item) use ($user) {
											return $item->persona_id === $user->persona->id;
										})
								) ||
								(
										$social->sociable_type === 'Realm' &&
										$user->persona->chapter->realm_id === $social->sociable_id &&
										$user->persona->chapter->realm->reign->officers->contains(function ($item) use ($user) {
											return $item->persona_id === $user->persona->id;
										})
								) ||
								(
										$social->sociable_type === 'Unit' &&
										$user->persona->units->first(function ($unit) use ($social, $user) {
											return $unit->id === $social->sociable_id &&
											$unit->officers->contains('persona_id', $user->persona->id);
										}) !== null
								)
						)
				)
		) {
			return true;
		}
	}
	
	/**
	 * Determine whether the user can restore the social.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Social  $social
	 * @return mixed
	 */
	public function restore(User $user, Social $social)
	{
		return false;
	}
	
	/**
	 * Determine whether the user can permanently delete the social.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Social  $social
	 * @return mixed
	 */
	public function forceDelete(User $user, Social $social)
	{
		return false;
	}
}