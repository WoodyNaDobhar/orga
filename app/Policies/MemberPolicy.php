<?php

namespace App\Policies;

use App\Models\Member;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MemberPolicy
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
	 * Determine whether the user can view any members.
	 *
	 * @param  \App\Models\User  $user
	 * @return mixed
	 */
	public function viewAny(User $user)
	{
// 		if ($user->can('list members')) {
			return true;
// 		}
	}
	
	/**
	 * Determine whether the user can view the member.
	 *
	 * @param  \App\Models\User $user
	 * @param  \App\Models\Member  $member
	 * @return mixed
	 */
	public function view(User $user, Member $member)
	{
// 		if ($user->can('display members')) {
			return true;
// 		}
	}
	
	/**
	 * Determine whether the user can create members.
	 *
	 * @param  \App\Models\User  $user
	 * @return mixed
	 */
	public function create(User $user)
	{
		if ($user->can('store members')) {
			return true;
		}
	}
	
	/**
	 * Determine whether the user can update the member.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Member  $member
	 * @return mixed
	 */
	public function update(User $user, Member $member)
	{
		if (
				$user->can('update members') ||
				(
						$user->can('updateRelated members') &&
						$user->persona->units->first(function ($unit) use ($member, $user) {
							return $unit->id === $member->unit_id &&
							$unit->officers->contains('persona_id', $user->persona_id);
						}) !== null
				)
		) {
			return true;
		}
		return false;
	}
	
	/**
	 * Determine whether the user can delete the member.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Member  $member
	 * @return mixed
	 */
	public function delete(User $user, Member $member)
	{
		if (
				$user->can('remove members') ||
				(
						$user->can('removeRelated members') &&
						$user->persona->units->first(function ($unit) use ($member, $user) {
							return $unit->id === $member->unit_id &&
							$unit->officers->contains('persona_id', $user->persona_id);
						}) !== null
				)
		) {
			return true;
		}
	}
	
	/**
	 * Determine whether the user can restore the member.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Member  $member
	 * @return mixed
	 */
	public function restore(User $user, Member $member)
	{
		return false;
	}
	
	/**
	 * Determine whether the user can permanently delete the member.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Member  $member
	 * @return mixed
	 */
	public function forceDelete(User $user, Member $member)
	{
		return false;
	}
}