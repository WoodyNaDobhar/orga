<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
	/**
	 * The model to policy mappings for the application.
	 *
	 * @var array<class-string, class-string>
	 */
	protected $policies = [
		'App\Models\Account' => 'App\Policies\AccountPolicy',
		'App\Models\Archetype' => 'App\Policies\ArchetypePolicy',
		'App\Models\Attendance' => 'App\Policies\AttendancePolicy',
		'App\Models\Award' => 'App\Policies\AwardPolicy',
		'App\Models\Chapter' => 'App\Policies\ChapterPolicy',
		'App\Models\Chaptertype' => 'App\Policies\ChaptertypePolicy',
		'App\Models\Crat' => 'App\Policies\CratPolicy',
		'App\Models\Due' => 'App\Policies\DuePolicy',
		'App\Models\Event' => 'App\Policies\EventPolicy',
		'App\Models\Guest' => 'App\Policies\GuestPolicy',
		'App\Models\Issuance' => 'App\Policies\IssuancePolicy',
		'App\Models\Location' => 'App\Policies\LocationPolicy',
		'App\Models\Meetup' => 'App\Policies\MeetupPolicy',
		'App\Models\Member' => 'App\Policies\MemberPolicy',
		'App\Models\Officer' => 'App\Policies\OfficerPolicy',
		'App\Models\Office' => 'App\Policies\OfficePolicy',
		'App\Models\Persona' => 'App\Policies\PersonaPolicy',
		'App\Models\Pronoun' => 'App\Policies\PronounPolicy',
		'App\Models\Realm' => 'App\Policies\RealmPolicy',
		'App\Models\Recommendation' => 'App\Policies\RecommendationPolicy',
		'App\Models\Reconciliation' => 'App\Policies\ReconciliationPolicy',
		'App\Models\Reign' => 'App\Policies\ReignPolicy',
		'App\Models\Social' => 'App\Policies\SocialPolicy',
		'App\Models\Split' => 'App\Policies\SplitPolicy',
		'App\Models\Suspension' => 'App\Policies\SuspensionPolicy',
		'App\Models\Title' => 'App\Policies\TitlePolicy',
		'App\Models\Tournament' => 'App\Policies\TournamentPolicy',
		'App\Models\Transaction' => 'App\Policies\TransactionPolicy',
		'App\Models\Unit' => 'App\Policies\UnitPolicy',
		'App\Models\User' => 'App\Policies\UserPolicy',
		'App\Models\Waiver' => 'App\Policies\WaiverPolicy'
	];
	
	/**
	 * Register any authentication / authorization services.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->registerPolicies();
		//
	}
}
