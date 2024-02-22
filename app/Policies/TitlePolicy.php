<?php

namespace App\Policies;

use App\Models\Title;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TitlePolicy
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
	 * Determine whether the user can view any titles.
	 *
	 * @param  \App\Models\User  $user
	 * @return mixed
	 */
	public function viewAny(User $user)
	{
// 		if ($user->can('list titles')) {
			return true;
// 		}
	}
	
	/**
	 * Determine whether the user can view the title.
	 *
	 * @param  \App\Models\User $user
	 * @param  \App\Models\Title  $title
	 * @return mixed
	 */
	public function view(User $user, Title $title)
	{
// 		if ($user->can('display titles')) {
			return true;
// 		}
	}
	
	/**
	 * Determine whether the user can create titles.
	 *
	 * @param  \App\Models\User  $user
	 * @return mixed
	 */
	public function create(User $user)
	{
		if ($user->can('store titles')) {
			return true;
		}
	}
	
	/**
	 * Determine whether the user can update the title.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Title  $title
	 * @return mixed
	 */
	public function update(User $user, Title $title)
	{
		if (
				$user->can('update titles') ||
				(
						$user->can('updateRelated titles') &&
						(
								(
										$title->titleable_type === 'Chapter' &&
										(
												(
														$user->persona->chapter_id === $title->titleable_id &&
														$user->persona->chapter->reign->officers->contains(function ($item) use ($user) {
															return $item->persona_id === $user->persona->id;
														})
												) ||
												(
														$user->persona->chapter->realm_id === $title->titleable->realm_id &&
														$user->persona->chapter->realm->reign->officers->contains(function ($item) use ($user) {
															return $item->persona_id === $user->persona->id;
														})
												)
										)
								) ||
								(
										$title->titleable_type === 'Realm' &&
										$user->persona->chapter->realm_id === $title->titleable_id &&
										$user->persona->chapter->realm->reign->officers->contains(function ($item) use ($user) {
											return $item->persona_id === $user->persona->id;
										})
								) ||
								(
										$title->titleable_type === 'Unit' &&
										$user->persona->units->first(function ($unit) use ($title, $user) {
											return $unit->id === $title->titleable_id &&
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
	 * Determine whether the user can delete the title.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Title  $title
	 * @return mixed
	 */
	public function delete(User $user, Title $title)
	{
		if (
				$user->can('remove titles') ||
				(
						$user->can('removeRelated titles') &&
						(
								(
										$title->titleable_type === 'Chapter' &&
										(
												(
														$user->persona->chapter_id === $title->titleable_id &&
														$user->persona->chapter->reign->officers->contains(function ($item) use ($user) {
															return $item->persona_id === $user->persona->id;
														})
												) ||
												(
														$user->persona->chapter->realm_id === $title->titleable->realm_id &&
														$user->persona->chapter->realm->reign->officers->contains(function ($item) use ($user) {
															return $item->persona_id === $user->persona->id;
														})
												)
										)
								) ||
								(
										$title->titleable_type === 'Realm' &&
										$user->persona->chapter->realm_id === $title->titleable_id &&
										$user->persona->chapter->realm->reign->officers->contains(function ($item) use ($user) {
											return $item->persona_id === $user->persona->id;
										})
								) ||
								(
										$title->titleable_type === 'Unit' &&
										$user->persona->units->first(function ($unit) use ($title, $user) {
											return $unit->id === $title->titleable_id &&
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
	 * Determine whether the user can restore the title.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Title  $title
	 * @return mixed
	 */
	public function restore(User $user, Title $title)
	{
		return false;
	}
	
	/**
	 * Determine whether the user can permanently delete the title.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Title  $title
	 * @return mixed
	 */
	public function forceDelete(User $user, Title $title)
	{
		return false;
	}
}