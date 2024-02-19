<?php

namespace App\Policies;

use App\Models\Location;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LocationPolicy
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
	 * Determine whether the user can view any locations.
	 *
	 * @param  \App\Models\User  $user
	 * @return mixed
	 */
	public function viewAny(User $user)
	{
// 		if ($user->can('list locations')) {
			return true;
// 		}
	}
	
	/**
	 * Determine whether the user can view the location.
	 *
	 * @param  \App\Models\User $user
	 * @param  \App\Models\Location  $location
	 * @return mixed
	 */
	public function view(User $user, Location $location)
	{
// 		if ($user->can('display locations')) {
			return true;
// 		}
	}
	
	/**
	 * Determine whether the user can create locations.
	 *
	 * @param  \App\Models\User  $user
	 * @return mixed
	 */
	public function create(User $user)
	{
		if ($user->can('store locations')) {
			return true;
		}
	}
	
	/**
	 * Determine whether the user can update the location.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Location  $location
	 * @return mixed
	 */
	public function update(User $user, Location $location)
	{
		if (
				$user->can('update locations') ||
				(
						$user->can('updateOwn locations') &&
						$location->events->count() > 0 &&
						$location->events->every(function ($event) use ($user) {
							return $event->eventable_type === 'Persona' && $event->eventable_id === $user->persona->id;
						})
				) ||
				(
						$user->can('updateRelated locations') &&
						(
								(
										$location->chapters->count() > 0 &&
										$location->chapters->every(function ($chapter) use ($user) {
											return $chapter->reign->officers->contains(function ($item) use ($user) {
												return $item->persona_id === $user->persona_id;
											}) ||
											$chapter->realm->reign->officers->contains(function ($item) use ($user) {
												return $item->persona_id === $user->persona_id;
											});
										})
								) ||
								(
										$location->events->count() > 0 &&
										$location->events->every(function ($event) use ($user) {
											return $event->crats->contains(function ($item) use ($user) {
												return $item->persona_id === $user->persona_id;
											});
										})
								) ||
								(
										$location->issuances->count() > 0 &&
										(
												(
														$location->issuances->every(function ($issuance) use ($user) {
															return $issuance->issuer_type === 'Chapter';
														}) &&
														$location->issuances->every(function ($issuance) use ($user) {
															return $issuance->issuer->reign->officers->contains(function ($item) use ($user) {
																return $item->persona_id === $user->persona_id;
															}) ||
															$issuance->issuer->realm->reign->officers->contains(function ($item) use ($user) {
																return $item->persona_id === $user->persona_id;
															});
														})
												) ||
												(
														$location->issuances->every(function ($issuance) use ($user) {
															return $issuance->issuer_type === 'Realm';
														}) &&
														$location->issuances->every(function ($issuance) use ($user) {
															return $issuance->issuer->reign->officers->contains(function ($item) use ($user) {
																return $item->persona_id === $user->persona_id;
															});
														})
												) ||
												(
														$location->issuances->every(function ($issuance) use ($user) {
															return $issuance->issuer_type === 'Unit';
														}) &&
														$location->issuances->every(function ($issuance) use ($user) {
															return $issuance->issuer->officers->contains(function ($item) use ($user) {
																return $item->persona_id === $user->persona_id;
															});
														})
												)
										)
								) ||
								(
										$location->meetups->count() > 0 &&
										$location->meetups->every(function ($meetup) use ($user) {
											return $meetup->chapter->reign->officers->contains(function ($item) use ($user) {
												return $item->persona_id === $user->persona_id;
											}) ||
											$meetup->chapter->realm->reign->officers->contains(function ($item) use ($user) {
												return $item->persona_id === $user->persona_id;
											});
										})
								) ||
								(
										$location->waivers->count() > 0 &&
										$location->waivers->every(function ($waiver) use ($user) {
											return (
												(
														$waiver->persona_id &&
														(
																$waiver->persona->chapter->reign->officers->contains(function ($item) use ($user) {
																	return $item->persona_id === $user->persona_id;
																}) ||
																$waiver->persona->chapter->realm->reign->officers->contains(function ($item) use ($user) {
																	return $item->persona_id === $user->persona_id;
																})
																)
												) ||
												(
														$waiver->waiverable_type === 'Realm' &&
														$waiver->waiverable->reign->officers->contains(function ($item) use ($user) {
															return $item->persona_id === $user->persona_id;
														})
												) ||
												(
														$waiver->waiverable_type === 'Event' &&
														$waiver->waiverable->crats->contains(function ($item) use ($user) {
															return $item->persona_id === $user->persona_id;
														})
												)
											);
										})
								)
						)
				)
		) {
			return true;
		}
	}
	
	/**
	 * Determine whether the user can delete the location.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Location  $location
	 * @return mixed
	 */
	public function delete(User $user, Location $location)
	{
		if (
				$user->can('remove locations') ||
				(
						$user->can('removeOwn locations') &&
						$location->events->count() > 0 &&
						$location->events->every(function ($event) use ($user) {
							return $event->eventable_type === 'Persona' && $event->eventable_id === $user->persona->id;
						})
				) ||
				(
						$user->can('removeRelated locations') &&
						(
								(
										$location->chapters->count() > 0 &&
										$location->chapters->every(function ($chapter) use ($user) {
											return $chapter->reign->officers->contains(function ($item) use ($user) {
												return $item->persona_id === $user->persona_id;
											}) ||
											$chapter->realm->reign->officers->contains(function ($item) use ($user) {
												return $item->persona_id === $user->persona_id;
											});
										})
								) ||
								(
										$location->events->count() > 0 &&
										$location->events->every(function ($event) use ($user) {
											return $event->crats->contains(function ($item) use ($user) {
												return $item->persona_id === $user->persona_id;
											});
										})
								) ||
								(
										$location->issuances->count() > 0 &&
										(
												(
														$location->issuances->every(function ($issuance) use ($user) {
															return $issuance->issuer_type === 'Chapter';
														}) &&
														$location->issuances->every(function ($issuance) use ($user) {
															return $issuance->issuer->reign->officers->contains(function ($item) use ($user) {
																return $item->persona_id === $user->persona_id;
															}) ||
															$issuance->issuer->realm->reign->officers->contains(function ($item) use ($user) {
																return $item->persona_id === $user->persona_id;
															});
														})
												) ||
												(
														$location->issuances->every(function ($issuance) use ($user) {
															return $issuance->issuer_type === 'Realm';
														}) &&
														$location->issuances->every(function ($issuance) use ($user) {
															return $issuance->issuer->reign->officers->contains(function ($item) use ($user) {
																return $item->persona_id === $user->persona_id;
															});
														})
												) ||
												(
														$location->issuances->every(function ($issuance) use ($user) {
															return $issuance->issuer_type === 'Unit';
														}) &&
														$location->issuances->every(function ($issuance) use ($user) {
															return $issuance->issuer->officers->contains(function ($item) use ($user) {
																return $item->persona_id === $user->persona_id;
															});
														})
												)
										)
								) ||
								(
										$location->meetups->count() > 0 &&
										$location->meetups->every(function ($meetup) use ($user) {
											return $meetup->chapter->reign->officers->contains(function ($item) use ($user) {
												return $item->persona_id === $user->persona_id;
											}) ||
											$meetup->chapter->realm->reign->officers->contains(function ($item) use ($user) {
												return $item->persona_id === $user->persona_id;
											});
										})
								) ||
								(
										$location->waivers->count() > 0 &&
										$location->waivers->every(function ($waiver) use ($user) {
											return (
												(
														$waiver->persona_id &&
														(
																$waiver->persona->chapter->reign->officers->contains(function ($item) use ($user) {
																	return $item->persona_id === $user->persona_id;
																}) ||
																$waiver->persona->chapter->realm->reign->officers->contains(function ($item) use ($user) {
																	return $item->persona_id === $user->persona_id;
																})
														)
												) ||
												(
														$waiver->waiverable_type === 'Realm' &&
														$waiver->waiverable->reign->officers->contains(function ($item) use ($user) {
															return $item->persona_id === $user->persona_id;
														})
												) ||
												(
														$waiver->waiverable_type === 'Event' &&
														$waiver->waiverable->crats->contains(function ($item) use ($user) {
															return $item->persona_id === $user->persona_id;
														})
												)
											);
										})
								)
						)
				)
		) {
			return true;
		}
	}
	
	/**
	 * Determine whether the user can restore the location.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Location  $location
	 * @return mixed
	 */
	public function restore(User $user, Location $location)
	{
		return false;
	}
	
	/**
	 * Determine whether the user can permanently delete the location.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Location  $location
	 * @return mixed
	 */
	public function forceDelete(User $user, Location $location)
	{
		return false;
	}
}