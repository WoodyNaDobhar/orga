<?php

namespace App\Policies;

use App\Models\Chapter;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ChapterPolicy
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
	 * Determine whether the user can view any chapters.
	 *
	 * @param  \App\Models\User  $user
	 * @return mixed
	 */
	public function viewAny(User $user)
	{
// 		if ($user->can('list chapters')) {
			return true;
// 		}
	}
	
	/**
	 * Determine whether the user can view the chapter.
	 *
	 * @param  \App\Models\User $user
	 * @param  \App\Models\Chapter  $chapter
	 * @return mixed
	 */
	public function view(User $user, Chapter $chapter)
	{
// 		if ($user->can('display chapters')) {
			return true;
// 		}
	}
	
	/**
	 * Determine whether the user can create chapters.
	 *
	 * @param  \App\Models\User  $user
	 * @return mixed
	 */
	public function create(User $user)
	{
		if ($user->can('store chapters')) {
			return true;
		}
	}
	
	/**
	 * Determine whether the user can update the chapter.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Chapter  $chapter
	 * @return mixed
	 */
	public function update(User $user, Chapter $chapter)
	{
		if (
				$user->can('update chapters') ||
				(
						$user->can('updateRelated chapters') &&
						(
								$user->persona->chapter_id === $chapter->id &&
								$user->persona->chapter->reign->officers->contains(function ($item) use ($user) {
									return $item->persona_id === $user->persona->id;
								})
						) ||
						(
								$user->persona->chapter->realm_id === $chapter->realm_id &&
								$user->persona->chapter->realm->reign->officers->contains(function ($item) use ($user) {
									return $item->persona_id === $user->persona->id;
								})
						)
				)
		) {
			return true;
		}
	}
	
	/**
	 * Determine whether the user can delete the chapter.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Chapter  $chapter
	 * @return mixed
	 */
	public function delete(User $user, Chapter $chapter)
	{
		if (
				$user->can('update chapters') ||
				(
						$user->can('updateRelated chapters') &&
						(
								$user->persona->chapter_id === $chapter->id &&
								$user->persona->chapter->reign->officers->contains(function ($item) use ($user) {
									return $item->persona_id === $user->persona->id;
								})
						) ||
						(
								$user->persona->chapter->realm_id === $chapter->realm_id &&
								$user->persona->chapter->realm->reign->officers->contains(function ($item) use ($user) {
									return $item->persona_id === $user->persona->id;
								})
						)
				)
		) {
			return true;
		}
	}
	
	/**
	 * Determine whether the user can restore the chapter.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Chapter  $chapter
	 * @return mixed
	 */
	public function restore(User $user, Chapter $chapter)
	{
		return false;
	}
	
	/**
	 * Determine whether the user can permanently delete the chapter.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Chapter  $chapter
	 * @return mixed
	 */
	public function forceDelete(User $user, Chapter $chapter)
	{
		return false;
	}
}