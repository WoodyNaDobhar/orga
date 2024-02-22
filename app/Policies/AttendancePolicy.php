<?php

namespace App\Policies;

use App\Models\Attendance;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AttendancePolicy
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
	 * Determine whether the user can view any attendances.
	 *
	 * @param  \App\Models\User  $user
	 * @return mixed
	 */
	public function viewAny(User $user)
	{
// 		if ($user->can('list attendances')) {
			return true;
// 		}
	}
	
	/**
	 * Determine whether the user can view the attendance.
	 *
	 * @param  \App\Models\User $user
	 * @param  \App\Models\Attendance  $attendance
	 * @return mixed
	 */
	public function view(User $user, Attendance $attendance)
	{
// 		if ($user->can('display attendances')) {
			return true;
// 		}
	}
	
	/**
	 * Determine whether the user can create attendances.
	 *
	 * @param  \App\Models\User  $user
	 * @return mixed
	 */
	public function create(User $user)
	{
		if ($user->can('store attendances')) {
			return true;
		}
	}
	
	/**
	 * Determine whether the user can update the attendance.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Attendance  $attendance
	 * @return mixed
	 */
	public function update(User $user, Attendance $attendance)
	{
		if (
				$user->can('update attendances') ||
				(
						$user->can('updateRelated attendances') &&
						(
								(
										$attendance->attendable_type === 'Event' &&
										(
												(
														$attendance->attendable->eventable_type === 'Chapter' && 
														(
																(
																		$user->persona->chapter_id === $attendance->eventable_id &&
																		$user->persona->chapter->reign->officers->contains(function ($item) use ($user) {
																			return $item->persona_id === $user->persona->id;
																		})
																) ||
																(
																		$user->persona->chapter->realm_id === $attendance->eventable->realm_id &&
																		$user->persona->chapter->realm->reign->officers->contains(function ($item) use ($user) {
																			return $item->persona_id === $user->persona->id;
																		})
																)
														)
												) ||
												(
														$attendance->attendable->eventable_type === 'Realm' &&
														(
																$user->persona->chapter->realm_id === $attendance->eventable_id &&
																$user->persona->chapter->realm->reign->officers->contains(function ($item) use ($user) {
																	return $item->persona_id === $user->persona->id;
																})
														)
												)||
												(
														(
																$attendance->attendable->eventable_type === 'Persona' ||
																$attendance->attendable->eventable_type === 'Unit'
														) &&
														(
																(
																		$attendance->attendable->sponsorable_type === 'Chapter' &&
																		(
																				(
																						$user->persona->chapter_id === $attendance->attendable->sponsorable_id &&
																						$user->persona->chapter->reign->officers->contains(function ($item) use ($user) {
																							return $item->persona_id === $user->persona->id;
																						})
																				) ||
																				(
																						$user->persona->chapter->realm_id === $attendance->sponsorable->realm_id &&
																						$user->persona->chapter->realm->reign->officers->contains(function ($item) use ($user) {
																							return $item->persona_id === $user->persona->id;
																						})
																				)
																		)
																) ||
																(
																		$attendance->attendable->sponsorable_type === 'Realm' &&
																		(
																				$user->persona->chapter->realm_id === $attendance->attendable->sponsorable_id &&
																				$user->persona->chapter->realm->reign->officers->contains(function ($item) use ($user) {
																					return $item->persona_id === $user->persona->id;
																				})
																		)
																)
														)
												)
										)
								) ||
								(
										$attendance->attendable_type === 'Meetup' &&
										(
												$user->persona->chapter_id === $attendance->meetup->chapter_id &&
												$user->persona->chapter->reign->officers->contains(function ($item) use ($user) {
													return $item->persona_id === $user->persona->id;
												})
										)
								)
						)
				)
		) {
			return true;
		}
	}
	
	/**
	 * Determine whether the user can delete the attendance.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Attendance  $attendance
	 * @return mixed
	 */
	public function delete(User $user, Attendance $attendance)
	{
		if (
				$user->can('remove attendances') ||
				(
						$user->can('removeRelated attendances') &&
						(
								(
										$attendance->attendable_type === 'Event' &&
										(
												(
														$attendance->attendable->eventable_type === 'Chapter' &&
														(
																$user->persona->chapter_id === $attendance->eventable_id &&
																$user->persona->chapter->reign->officers->contains(function ($item) use ($user) {
																	return $item->persona_id === $user->persona->id;
																})
														)
												) ||
												(
														$attendance->attendable->eventable_type === 'Realm' &&
														(
																$user->persona->chapter->realm_id === $attendance->eventable_id &&
																$user->persona->chapter->realm->reign->officers->contains(function ($item) use ($user) {
																	return $item->persona_id === $user->persona->id;
																})
														)
												) ||
												(
														(
																$attendance->attendable->eventable_type === 'Persona' ||
																$attendance->attendable->eventable_type === 'Unit'
														) &&
														(
																(
																		$attendance->attendable->sponsorable_type === 'Chapter' &&
																		(
																				(
																						$user->persona->chapter_id === $attendance->attendable->sponsorable_id &&
																						$user->persona->chapter->reign->officers->contains(function ($item) use ($user) {
																							return $item->persona_id === $user->persona->id;
																						})
																				) ||
																				(
																						$user->persona->chapter->realm_id === $attendance->sponsorable->realm_id &&
																						$user->persona->chapter->realm->reign->officers->contains(function ($item) use ($user) {
																							return $item->persona_id === $user->persona->id;
																						})
																				)
																		)
																) ||
																(
																		$attendance->attendable->sponsorable_type === 'Realm' &&
																		(
																				$user->persona->chapter->realm_id === $attendance->attendable->sponsorable_id &&
																				$user->persona->chapter->realm->reign->officers->contains(function ($item) use ($user) {
																					return $item->persona_id === $user->persona->id;
																				})
																		)
																)
														)
												)
										)
								) ||
								(
										$attendance->attendable_type === 'Meetup' &&
										(
											$user->persona->chapter_id === $attendance->meetup->chapter_id &&
											$user->persona->chapter->reign->officers->contains(function ($item) use ($user) {
												return $item->persona_id === $user->persona->id;
											})
										)
								)
						)
				)
		) {
			return true;
		}
	}
	
	/**
	 * Determine whether the user can restore the attendance.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Attendance  $attendance
	 * @return mixed
	 */
	public function restore(User $user, Attendance $attendance)
	{
		return false;
	}
	
	/**
	 * Determine whether the user can permanently delete the attendance.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Attendance  $attendance
	 * @return mixed
	 */
	public function forceDelete(User $user, Attendance $attendance)
	{
		return false;
	}
}