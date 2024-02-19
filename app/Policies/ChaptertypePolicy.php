<?php

namespace App\Policies;

use App\Models\Chaptertype;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ChaptertypePolicy
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
	 * Determine whether the user can view any chaptertypes.
	 *
	 * @param  \App\Models\User  $user
	 * @return mixed
	 */
	public function viewAny(User $user)
	{
// 		if ($user->can('list chaptertypes')) {
			return true;
// 		}
	}
	
	/**
	 * Determine whether the user can view the chaptertype.
	 *
	 * @param  \App\Models\User $user
	 * @param  \App\Models\Chaptertype  $chaptertype
	 * @return mixed
	 */
	public function view(User $user, Chaptertype $chaptertype)
	{
// 		if ($user->can('display chaptertypes')) {
			return true;
// 		}
	}
	
	/**
	 * Determine whether the user can create chaptertypes.
	 *
	 * @param  \App\Models\User  $user
	 * @return mixed
	 */
	public function create(User $user)
	{
// 		if ($user->can('store chaptertypes')) {
			return true;
// 		}
	}
	
	/**
	 * Determine whether the user can update the chaptertype.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Chaptertype  $chaptertype
	 * @return mixed
	 */
	public function update(User $user, Chaptertype $chaptertype)
	{
// 		if ($user->can('update chaptertypes')) {
			return true;
// 		}
	}
	
	/**
	 * Determine whether the user can delete the chaptertype.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Chaptertype  $chaptertype
	 * @return mixed
	 */
	public function delete(User $user, Chaptertype $chaptertype)
	{
		if ($user->can('remove chaptertypes')) {
			return true;
		}
	}
	
	/**
	 * Determine whether the user can restore the chaptertype.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Chaptertype  $chaptertype
	 * @return mixed
	 */
	public function restore(User $user, Chaptertype $chaptertype)
	{
		return false;
	}
	
	/**
	 * Determine whether the user can permanently delete the chaptertype.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Chaptertype  $chaptertype
	 * @return mixed
	 */
	public function forceDelete(User $user, Chaptertype $chaptertype)
	{
		return false;
	}
}