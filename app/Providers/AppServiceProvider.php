<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register()
	{
		//
		$this->app->register(\L5Swagger\L5SwaggerServiceProvider::class);
	}
	
	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		// Fix for MySQL < 5.7.7 and MariaDB < 10.2.2
		Schema::defaultStringLength(191); //Update defaultStringLength
		Relation::enforceMorphMap([
			'Account' => 'App\Models\Account',
			'Archetype' => 'App\Models\Archetype',
			'Attendance' => 'App\Models\Attendance',
			'Award' => 'App\Models\Award',
			'BaseModel' => 'App\Models\BaseModel',
			'Chapter' => 'App\Models\Chapter',
			'Chaptertype' => 'App\Models\Chaptertype',
			'Crat' => 'App\Models\Crat',
			'Due' => 'App\Models\Due',
			'Event' => 'App\Models\Event',
			'Guest' => 'App\Models\Guest',
			'Issuance' => 'App\Models\Issuance',
			'Location' => 'App\Models\Location',
			'Meetup' => 'App\Models\Meetup',
			'Member' => 'App\Models\Member',
			'Officer' => 'App\Models\Officer',
			'Office' => 'App\Models\Office',
			'PasswordHistory' => 'App\Models\PasswordHistory',
			'Persona' => 'App\Models\Persona',
			'Pronoun' => 'App\Models\Pronoun',
			'Realm' => 'App\Models\Realm',
			'Recommendation' => 'App\Models\Recommendation',
			'Reconciliation' => 'App\Models\Reconciliation',
			'Reign' => 'App\Models\Reign',
			'Social' => 'App\Models\Social',
			'Split' => 'App\Models\Split',
			'Suspension' => 'App\Models\Suspension',
			'Title' => 'App\Models\Title',
			'Tournament' => 'App\Models\Tournament',
			'Transaction' => 'App\Models\Transaction',
			'Unit' => 'App\Models\Unit',
			'User' => 'App\Models\User',
			'Waiver' => 'App\Models\Waiver'
		]);
	}
}
