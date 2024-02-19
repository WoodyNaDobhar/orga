<?php

namespace App\Policies;

use App\Models\Issuance;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class IssuancePolicy
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
	 * Determine whether the user can view any issuances.
	 *
	 * @param  \App\Models\User  $user
	 * @return mixed
	 */
	public function viewAny(User $user)
	{
// 		if ($user->can('list issuances')) {
			return true;
// 		}
	}
	
	/**
	 * Determine whether the user can view the issuance.
	 *
	 * @param  \App\Models\User $user
	 * @param  \App\Models\Issuance  $issuance
	 * @return mixed
	 */
	public function view(User $user, Issuance $issuance)
	{
// 		if ($user->can('display issuances')) {
			return true;
// 		}
	}
	
	/**
	 * Determine whether the user can create issuances.
	 *
	 * @param  \App\Models\User  $user
	 * @return mixed
	 */
	public function create(User $user)
	{
		if ($user->can('store issuances')) {
			return true;
		}
	}
	
	/**
	 * Determine whether the user can update the issuance.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Issuance  $issuance
	 * @return mixed
	 */
	public function update(User $user, Issuance $issuance)
	{
		if (
				$user->can('update issuances') ||
				(
						$user->can('updateOwn issuances') &&
						$issuance->issuer_type === 'Persona' &&
						$issuance->issuer_id === $user->id
				) ||
				(
						$user->can('updateRelated issuances') &&
						(
								(
										$issuance->issuer_type === 'Chapter' &&
										(
												(
														$user->persona->chapter_id === $issuance->issuer_id &&
														$user->persona->chapter->reign->officers->contains(function ($item) use ($user) {
															return $item->persona_id === $user->persona_id;
														})
												) ||
												(
														$user->persona->chapter->realm_id === $issuance->issuer->realm_id &&
														$user->persona->chapter->realm->reign->officers->contains(function ($item) use ($user) {
															return $item->persona_id === $user->persona_id;
														})
												)
										)
								) ||
								(
										$issuance->issuer_type === 'Realm' &&
										(
												$user->persona->chapter->realm_id === $issuance->issuer_id &&
												$user->persona->chapter->realm->reign->officers->contains(function ($item) use ($user) {
													return $item->persona_id === $user->persona_id;
												})
										)
								) ||
								(
										$issuance->issuer_type === 'Unit' &&
										$user->persona->units->first(function ($unit) use ($issuance, $user) {
											return $unit->id === $issuance->issuer_id &&
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
	 * Determine whether the user can delete the issuance.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Issuance  $issuance
	 * @return mixed
	 */
	public function delete(User $user, Issuance $issuance)
	{
		if (
				$user->can('remove issuances') ||
				(
						$user->can('removeOwn issuances') &&
						$issuance->issuer_type === 'Persona' &&
						$issuance->issuer_id === $user->id
				) ||
				(
						$user->can('removeRelated issuances') &&
						(
								(
										$issuance->issuer_type === 'Chapter' &&
										(
												(
														$user->persona->chapter_id === $issuance->issuer_id &&
														$user->persona->chapter->reign->officers->contains(function ($item) use ($user) {
															return $item->persona_id === $user->persona_id;
														})
												) ||
												(
														$user->persona->chapter->realm_id === $issuance->issuer->realm_id &&
														$user->persona->chapter->realm->reign->officers->contains(function ($item) use ($user) {
															return $item->persona_id === $user->persona_id;
														})
												)
										)
								) ||
								(
										$issuance->issuer_type === 'Realm' &&
										(
												$user->persona->chapter->realm_id === $issuance->issuer_id &&
												$user->persona->chapter->realm->reign->officers->contains(function ($item) use ($user) {
													return $item->persona_id === $user->persona_id;
												})
										)
								) ||
								(
										$issuance->issuer_type === 'Unit' &&
										$user->persona->units->first(function ($unit) use ($issuance, $user) {
											return $unit->id === $issuance->issuer_id &&
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
	 * Determine whether the user can restore the issuance.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Issuance  $issuance
	 * @return mixed
	 */
	public function restore(User $user, Issuance $issuance)
	{
		return false;
	}
	
	/**
	 * Determine whether the user can permanently delete the issuance.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Issuance  $issuance
	 * @return mixed
	 */
	public function forceDelete(User $user, Issuance $issuance)
	{
		return false;
	}
}