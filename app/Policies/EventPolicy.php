<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EventPolicy
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
	 * Determine whether the user can view any events.
	 *
	 * @param  \App\Models\User  $user
	 * @return mixed
	 */
	public function viewAny(User $user)
	{
// 		if ($user->can('list events')) {
			return true;
// 		}
	}
	
	/**
	 * Determine whether the user can view the event.
	 *
	 * @param  \App\Models\User $user
	 * @param  \App\Models\Event  $event
	 * @return mixed
	 */
	public function view(User $user, Event $event)
	{
// 		if ($user->can('display events')) {
			return true;
// 		}
	}
	
	/**
	 * Determine whether the user can create events.
	 *
	 * @param  \App\Models\User  $user
	 * @return mixed
	 */
	public function create(User $user)
	{
		if ($user->can('store events')) {
			return true;
		}
	}
	
	/**
	 * Determine whether the user can update the event.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Event  $event
	 * @return mixed
	 */
	public function update(User $user, Event $event)
	{
		if (
				$user->can('update events') ||
				(
						$user->can('updateOwn events') &&
						$event->eventable_type === 'Persona' && 
						$event->eventable_id === $user->id
				) ||
				(
						$user->can('updateRelated events') &&
						(
								(
										$event->eventable_type === 'Chapter' &&
										(
												(
														$user->persona->chapter_id === $event->eventable_id &&
														$user->persona->chapter->reign->officers->contains(function ($item) use ($user) {
															return $item->persona_id === $user->persona->id;
														})
												) ||
												(
														$user->persona->chapter->realm_id === $event->eventable->realm_id &&
														$user->persona->chapter->realm->reign->officers->contains(function ($item) use ($user) {
															return $item->persona_id === $user->persona->id;
														})
												)
										)
								) ||
								(
										$event->eventable_type === 'Realm' &&
										(
												$user->persona->chapter->realm_id === $event->eventable_id &&
												$user->persona->chapter->realm->reign->officers->contains(function ($item) use ($user) {
													return $item->persona_id === $user->persona->id;
												})
										)
								) ||
								(
										$event->eventable_type === 'Unit' &&
										$user->persona->units->first(function ($unit) use ($event, $user) {
											return $unit->id === $event->eventable_id &&
											$unit->officers->contains('persona_id', $user->persona->id);
										}) !== null
								) ||
								(
										$event->crats->contains(function ($crat) use ($user) {
											return $crat->persona_id === $user->persona->id && $crat->is_autocrat === 1;
										})
								)
						)
				)
		) {
			return true;
		}
	}
	
	/**
	 * Determine whether the user can delete the event.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Event  $event
	 * @return mixed
	 */
	public function delete(User $user, Event $event)
	{
		if (
				$user->can('remove events') ||
				(
						$user->can('removeOwn events') &&
						$event->eventable_type === 'Persona' &&
						$event->eventable_id === $user->id
				) ||
				(
						$user->can('removeRelated events') &&
						(
								(
										$event->eventable_type === 'Chapter' &&
										(
												(
														$user->persona->chapter_id === $event->eventable_id &&
														$user->persona->chapter->reign->officers->contains(function ($item) use ($user) {
															return $item->persona_id === $user->persona->id;
														})
												) ||
												(
														$user->persona->chapter->realm_id === $event->eventable->realm_id &&
														$user->persona->chapter->realm->reign->officers->contains(function ($item) use ($user) {
															return $item->persona_id === $user->persona->id;
														})
												)
										)
								) ||
								(
										$event->eventable_type === 'Realm' &&
										(
												$user->persona->chapter->realm_id === $event->eventable_id &&
												$user->persona->chapter->realm->reign->officers->contains(function ($item) use ($user) {
													return $item->persona_id === $user->persona->id;
												})
										)
								) ||
								(
										$event->eventable_type === 'Unit' &&
										$user->persona->units->first(function ($unit) use ($event, $user) {
											return $unit->id === $event->eventable_id &&
											$unit->officers->contains('persona_id', $user->persona->id);
										}) !== null
								) ||
								(
										$event->crats->contains(function ($crat) use ($user) {
											return $crat->persona_id === $user->persona->id && $crat->is_autocrat === 1;
										})
								)
						)
				)
		) {
			return true;
		}
	}
	
	/**
	 * Determine whether the user can restore the event.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Event  $event
	 * @return mixed
	 */
	public function restore(User $user, Event $event)
	{
		return false;
	}
	
	/**
	 * Determine whether the user can permanently delete the event.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Event  $event
	 * @return mixed
	 */
	public function forceDelete(User $user, Event $event)
	{
		return false;
	}
}