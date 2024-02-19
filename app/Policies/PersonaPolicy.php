<?php

namespace App\Policies;

use App\Models\Persona;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PersonaPolicy
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
	 * Determine whether the user can view any personas.
	 *
	 * @param  \App\Models\User  $user
	 * @return mixed
	 */
	public function viewAny(User $user)
	{
// 		if ($user->can('list personas')) {
			return true;
// 		}
	}
	
	/**
	 * Determine whether the user can view the persona.
	 *
	 * @param  \App\Models\User $user
	 * @param  \App\Models\Persona  $persona
	 * @return mixed
	 */
	public function view(User $user, Persona $persona)
	{
// 		if ($user->can('display personas')) {
			return true;
// 		}
	}
	
	/**
	 * Determine whether the user can create personas.
	 *
	 * @param  \App\Models\User  $user
	 * @return mixed
	 */
	public function create(User $user)
	{
		if ($user->can('store personas')) {
			return true;
		}
	}
	
	/**
	 * Determine whether the user can update the persona.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Persona  $persona
	 * @return mixed
	 */
	public function update(User $user, Persona $persona)
	{
		if (
				$user->can('update personas') ||
				(
						$user->can('updateOwn personas') &&
						$persona->id === $user->id
				) ||
				(
						$user->can('updateRelated personas') &&
						(
								(
										$user->persona->chapter_id === $persona->chapter_id &&
										$user->persona->chapter->reign->officers->contains(function ($item) use ($user) {
											return $item->persona_id === $user->persona_id;
										})
								) ||
								(
										$user->persona->chapter->realm_id === $persona->chapter->realm_id &&
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
	 * Determine whether the user can delete the persona.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Persona  $persona
	 * @return mixed
	 */
	public function delete(User $user, Persona $persona)
	{
		if (
				
				$user->can('remove personas') ||
				(
						$user->can('removeRelated personas') &&
						(
								(
										$user->persona->chapter_id === $persona->chapter_id &&
										$user->persona->chapter->reign->officers->contains(function ($item) use ($user) {
											return $item->persona_id === $user->persona_id;
										})
								) ||
								(
										$user->persona->chapter->realm_id === $persona->chapter->realm_id &&
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
	 * Determine whether the user can restore the persona.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Persona  $persona
	 * @return mixed
	 */
	public function restore(User $user, Persona $persona)
	{
		return false;
	}
	
	/**
	 * Determine whether the user can permanently delete the persona.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Persona  $persona
	 * @return mixed
	 */
	public function forceDelete(User $user, Persona $persona)
	{
		return false;
	}
}