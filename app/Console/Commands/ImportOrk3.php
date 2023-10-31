<?php

namespace app\Console\Commands;

use Log;
use DateTime;
use Throwable;
use App\Helpers\AppHelper as AppHelper;
//use STS\Tunneler\Jobs\CreateTunnel;
use App\Models\Award;
use App\Models\Archetype;
use App\Models\Event;
use App\Models\Kingdom;
use App\Models\Location;
use App\Models\Meetup;
use App\Models\Member;
use App\Models\Office;
use App\Models\Park;
use App\Models\Parkrank;
use App\Models\Persona;
use App\Models\Title;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Tuqqu\GenderDetector\GenderDetector;

class ImportOrk3 extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'ImportOrk3';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'A one-time command meant to translate the data in ORK3 to the improved format.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{
		try {
			//check environment...!production
			if (app('env') === 'production') {
				$this->error('This function cannot be run on production.  When you are ready to do this on production, put the site in maintenance mode, copy the latest production data to the development server, and run it there.  You can then export the resulting database to production.  Do not forget to take the site out of maintenance mode when you are done.');
				exit();
			}
			
			Schema::disableForeignKeyConstraints();

			//setup
			$localConnect = DB::connection('mysql');
			$backupConnect = DB::connection('mysqlBak');
			$now = DB::raw('CURRENT_TIMESTAMP');
			$this->info('Beginning Import...');
			
			//back

			//testing area
			// $oldEvents = $backupConnect->table('ork_event_calendardetail')
			// 	->join('ork_event', 'ork_event_calendardetail.event_id', '=', 'ork_event.event_id')
			// 	->select('ork_event_calendardetail.*', 'ork_event.*', 'ork_event.modified as modified_1', 'ork_event_calendardetail.modified as modified_2')
			// 	->get()->toArray();
// 			dd($uses);

			//clear out
			DB::table('locations')->truncate();
// 			DB::table('permissions')->truncate();
// 			DB::table('roles')->truncate();
// 			DB::table('role_has_permissions')->truncate();

// 			//roles and permissions
// 			$this->info('Setting Roles & Permissions...');
		
// 			// Reset cached roles and permissions
// 			app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

// 			// create permissions
// 			Permission::create(['name' => 'list accounts', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'store accounts', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'display accounts', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'displayOwn accounts', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'displayRelated accounts', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'update accounts', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'updateOwn accounts', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'updateRelated accounts', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'remove accounts', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'removeOwn accounts', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'removeRelated accounts', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'list archetypes', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'store archetypes', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'display archetypes', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'displayOwn archetypes', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'displayRelated archetypes', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'update archetypes', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'updateOwn archetypes', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'updateRelated archetypes', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'remove archetypes', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'removeOwn archetypes', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'removeRelated archetypes', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'list configurations', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'store configurations', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'display configurations', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'displayOwn configurations', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'displayRelated configurations', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'update configurations', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'updateOwn configurations', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'updateRelated configurations', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'remove configurations', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'removeOwn configurations', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'removeRelated configurations', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'list kingdom_office', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'store kingdom_office', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'display kingdom_office', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'displayOwn kingdom_office', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'displayRelated kingdom_office', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'update kingdom_office', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'updateOwn kingdom_office', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'updateRelated kingdom_office', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'remove kingdom_office', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'removeOwn kingdom_office', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'removeRelated kingdom_office', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'list kingdom_title', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'store kingdom_title', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'display kingdom_title', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'displayOwn kingdom_title', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'displayRelated kingdom_title', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'update kingdom_title', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'updateOwn kingdom_title', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'updateRelated kingdom_title', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'remove kingdom_title', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'removeOwn kingdom_title', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'removeRelated kingdom_title', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'list kingdoms', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'store kingdoms', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'display kingdoms', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'displayOwn kingdoms', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'displayRelated kingdoms', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'update kingdoms', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'updateOwn kingdoms', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'updateRelated kingdoms', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'remove kingdoms', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'removeOwn kingdoms', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'removeRelated kingdoms', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'list locations', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'store locations', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'display locations', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'displayOwn locations', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'displayRelated locations', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'update locations', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'updateOwn locations', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'updateRelated locations', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'remove locations', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'removeOwn locations', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'removeRelated locations', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'list meetups', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'store meetups', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'display meetups', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'displayOwn meetups', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'displayRelated meetups', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'update meetups', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'updateOwn meetups', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'updateRelated meetups', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'remove meetups', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'removeOwn meetups', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'removeRelated meetups', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'list offices', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'store offices', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'display offices', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'displayOwn offices', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'displayRelated offices', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'update offices', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'updateOwn offices', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'updateRelated offices', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'remove offices', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'removeOwn offices', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'removeRelated offices', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'list parkranks', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'store parkranks', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'display parkranks', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'displayOwn parkranks', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'displayRelated parkranks', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'update parkranks', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'remove parkranks', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'list pronouns', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'store pronouns', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'display pronouns', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'displayOwn pronouns', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'displayRelated pronouns', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'update pronouns', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'updateOwn pronouns', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'updateRelated pronouns', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'remove pronouns', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'removeOwn pronouns', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'removeRelated pronouns', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'list titles', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'store titles', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'display titles', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'displayOwn titles', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'displayRelated titles', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'update titles', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'updateOwn titles', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'updateRelated titles', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'remove titles', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'removeOwn titles', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'removeRelated titles', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'list tournaments', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'store tournaments', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'display tournaments', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'displayOwn tournaments', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'displayRelated tournaments', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'update tournaments', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'updateOwn tournaments', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'updateRelated tournaments', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'remove tournaments', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'removeOwn tournaments', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'removeRelated tournaments', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'list transactions', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'store transactions', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'display transactions', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'displayOwn transactions', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'displayRelated transactions', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'update transactions', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'updateOwn transactions', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'updateRelated transactions', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'remove transactions', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'removeOwn transactions', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'removeRelated transactions', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'list units', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'store units', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'display units', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'displayOwn units', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'displayRelated units', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'update units', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'updateOwn units', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'updateRelated units', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'remove units', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'removeOwn units', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'removeRelated units', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'list parks', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'store parks', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'display parks', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'displayOwn parks', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'displayRelated parks', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'update parks', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'updateOwn parks', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'updateRelated parks', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'remove parks', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'removeOwn parks', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'removeRelated parks', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'list awards', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'store awards', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'display awards', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'displayOwn awards', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'displayRelated awards', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'update awards', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'updateOwn awards', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'updateRelated awards', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'remove awards', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'removeOwn awards', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'removeRelated awards', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'list users', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'store users', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'display users', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'displayOwn users', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'displayRelated users', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'update users', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'updateOwn users', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'updateRelated users', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'remove users', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'removeOwn users', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'removeRelated users', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'list attendances', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'store attendances', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'display attendances', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'displayOwn attendances', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'displayRelated attendances', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'update attendances', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'updateOwn attendances', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'updateRelated attendances', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'remove attendances', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'removeOwn attendances', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'removeRelated attendances', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'list dues', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'store dues', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'display dues', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'displayOwn dues', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'displayRelated dues', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'update dues', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'updateOwn dues', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'updateRelated dues', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'remove dues', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'removeOwn dues', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'removeRelated dues', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'list issuances', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'store issuances', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'display issuances', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'displayOwn issuances', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'displayRelated issuances', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'update issuances', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'updateOwn issuances', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'updateRelated issuances', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'remove issuances', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'removeOwn issuances', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'removeRelated issuances', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'list recommendations', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'store recommendations', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'display recommendations', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'displayOwn recommendations', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'displayRelated recommendations', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'update recommendations', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'updateOwn recommendations', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'updateRelated recommendations', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'remove recommendations', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'removeOwn recommendations', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'removeRelated recommendations', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'list reconciliations', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'store reconciliations', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'display reconciliations', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'displayOwn reconciliations', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'displayRelated reconciliations', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'update reconciliations', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'updateOwn reconciliations', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'updateRelated reconciliations', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'remove reconciliations', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'removeOwn reconciliations', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'removeRelated reconciliations', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'list splits', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'store splits', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'display splits', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'displayOwn splits', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'displayRelated splits', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'update splits', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'updateOwn splits', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'updateRelated splits', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'remove splits', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'removeOwn splits', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'removeRelated splits', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'list events', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'store events', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'display events', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'displayOwn events', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'displayRelated events', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'update events', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'updateOwn events', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'updateRelated events', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'remove events', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'removeOwn events', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'removeRelated events', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'list officers', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'store officers', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'display officers', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'displayOwn officers', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'displayRelated officers', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'update officers', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'updateOwn officers', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'updateRelated officers', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'remove officers', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'removeOwn officers', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'removeRelated officers', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'list waivers', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'store waivers', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'display waivers', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'displayOwn waivers', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'displayRelated waivers', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'update waivers', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'updateOwn waivers', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'updateRelated waivers', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'remove waivers', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'removeOwn waivers', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'removeRelated waivers', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'list personas', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'store personas', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'display personas', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'displayOwn personas', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'displayRelated personas', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'update personas', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'updateOwn personas', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'updateRelated personas', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'remove personas', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'removeOwn personas', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'removeRelated personas', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'list suspensions', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'store suspensions', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'display suspensions', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'displayOwn suspensions', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'displayRelated suspensions', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'update suspensions', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'updateOwn suspensions', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'updateRelated suspensions', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'remove suspensions', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'removeOwn suspensions', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'removeRelated suspensions', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'list members', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'store members', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'display members', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'displayOwn members', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'displayRelated members', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'update members', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'updateOwn members', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'updateRelated members', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'remove members', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'removeOwn members', 'guard_name' => 'api']);
// 			Permission::create(['name' => 'removeRelated members', 'guard_name' => 'api']);

// 			// create roles and assign created permissions
// 			$role = Role::create(['name' => 'admin', 'guard_name' => 'api']);
// 			// gets all permissions via Gate::before rule; see AuthServiceProvider

// 			$role = Role::create(['name' => 'officer', 'guard_name' => 'api']);
// 			$role->givePermissionTo('list accounts');
// 			$role->givePermissionTo('store accounts');
// 			$role->givePermissionTo('displayOwn accounts');
// 			$role->givePermissionTo('displayRelated accounts');
// 			$role->givePermissionTo('updateOwn accounts');
// 			$role->givePermissionTo('updateRelated accounts');
// 			$role->givePermissionTo('removeOwn accounts');
// 			$role->givePermissionTo('removeRelated accounts');
// 			$role->givePermissionTo('list archetypes');
// 			$role->givePermissionTo('display archetypes');
// 			$role->givePermissionTo('displayOwn archetypes');
// 			$role->givePermissionTo('displayRelated archetypes');
// 			$role->givePermissionTo('list configurations');
// 			$role->givePermissionTo('store configurations');
// 			$role->givePermissionTo('displayOwn configurations');
// 			$role->givePermissionTo('displayRelated configurations');
// 			$role->givePermissionTo('updateOwn configurations');
// 			$role->givePermissionTo('updateRelated configurations');
// 			$role->givePermissionTo('removeOwn configurations');
// 			$role->givePermissionTo('removeRelated configurations');
// 			$role->givePermissionTo('list kingdom_office');
// 			$role->givePermissionTo('store kingdom_office');
// 			$role->givePermissionTo('display kingdom_office');
// 			$role->givePermissionTo('displayOwn kingdom_office');
// 			$role->givePermissionTo('displayRelated kingdom_office');
// 			$role->givePermissionTo('updateOwn kingdom_office');
// 			$role->givePermissionTo('updateRelated kingdom_office');
// 			$role->givePermissionTo('removeOwn kingdom_office');
// 			$role->givePermissionTo('removeRelated kingdom_office');
// 			$role->givePermissionTo('list kingdom_title');
// 			$role->givePermissionTo('store kingdom_title');
// 			$role->givePermissionTo('display kingdom_title');
// 			$role->givePermissionTo('displayOwn kingdom_title');
// 			$role->givePermissionTo('displayRelated kingdom_title');
// 			$role->givePermissionTo('updateOwn kingdom_title');
// 			$role->givePermissionTo('updateRelated kingdom_title');
// 			$role->givePermissionTo('removeOwn kingdom_title');
// 			$role->givePermissionTo('removeRelated kingdom_title');
// 			$role->givePermissionTo('list kingdoms');
// 			$role->givePermissionTo('display kingdoms');
// 			$role->givePermissionTo('displayOwn kingdoms');
// 			$role->givePermissionTo('displayRelated kingdoms');
// 			$role->givePermissionTo('updateOwn kingdoms');
// 			$role->givePermissionTo('updateRelated kingdoms');
// 			$role->givePermissionTo('list locations');
// 			$role->givePermissionTo('store locations');
// 			$role->givePermissionTo('display locations');
// 			$role->givePermissionTo('displayOwn locations');
// 			$role->givePermissionTo('displayRelated locations');
// 			$role->givePermissionTo('updateOwn locations');
// 			$role->givePermissionTo('updateRelated locations');
// 			$role->givePermissionTo('removeOwn locations');
// 			$role->givePermissionTo('removeRelated locations');
// 			$role->givePermissionTo('list meetups');
// 			$role->givePermissionTo('store meetups');
// 			$role->givePermissionTo('display meetups');
// 			$role->givePermissionTo('displayOwn meetups');
// 			$role->givePermissionTo('displayRelated meetups');
// 			$role->givePermissionTo('updateOwn meetups');
// 			$role->givePermissionTo('updateRelated meetups');
// 			$role->givePermissionTo('removeOwn meetups');
// 			$role->givePermissionTo('removeRelated meetups');
// 			$role->givePermissionTo('list offices');
// 			$role->givePermissionTo('store offices');
// 			$role->givePermissionTo('display offices');
// 			$role->givePermissionTo('displayOwn offices');
// 			$role->givePermissionTo('displayRelated offices');
// 			$role->givePermissionTo('updateOwn offices');
// 			$role->givePermissionTo('updateRelated offices');
// 			$role->givePermissionTo('removeOwn offices');
// 			$role->givePermissionTo('removeRelated offices');
// 			$role->givePermissionTo('list parkranks');
// 			$role->givePermissionTo('store parkranks');
// 			$role->givePermissionTo('display parkranks');
// 			$role->givePermissionTo('displayOwn parkranks');
// 			$role->givePermissionTo('displayRelated parkranks');
// 			$role->givePermissionTo('list pronouns');
// 			$role->givePermissionTo('display pronouns');
// 			$role->givePermissionTo('displayOwn pronouns');
// 			$role->givePermissionTo('displayRelated pronouns');
// 			$role->givePermissionTo('list titles');
// 			$role->givePermissionTo('store titles');
// 			$role->givePermissionTo('display titles');
// 			$role->givePermissionTo('displayOwn titles');
// 			$role->givePermissionTo('displayRelated titles');
// 			$role->givePermissionTo('updateOwn titles');
// 			$role->givePermissionTo('updateRelated titles');
// 			$role->givePermissionTo('removeOwn titles');
// 			$role->givePermissionTo('removeRelated titles');
// 			$role->givePermissionTo('list tournaments');
// 			$role->givePermissionTo('store tournaments');
// 			$role->givePermissionTo('display tournaments');
// 			$role->givePermissionTo('displayOwn tournaments');
// 			$role->givePermissionTo('displayRelated tournaments');
// 			$role->givePermissionTo('updateOwn tournaments');
// 			$role->givePermissionTo('updateRelated tournaments');
// 			$role->givePermissionTo('removeOwn tournaments');
// 			$role->givePermissionTo('removeRelated tournaments');
// 			$role->givePermissionTo('list transactions');
// 			$role->givePermissionTo('store transactions');
// 			$role->givePermissionTo('displayOwn transactions');
// 			$role->givePermissionTo('displayRelated transactions');
// 			$role->givePermissionTo('updateOwn transactions');
// 			$role->givePermissionTo('updateRelated transactions');
// 			$role->givePermissionTo('removeOwn transactions');
// 			$role->givePermissionTo('removeRelated transactions');
// 			$role->givePermissionTo('list units');
// 			$role->givePermissionTo('store units');
// 			$role->givePermissionTo('display units');
// 			$role->givePermissionTo('displayOwn units');
// 			$role->givePermissionTo('displayRelated units');
// 			$role->givePermissionTo('updateOwn units');
// 			$role->givePermissionTo('updateRelated units');
// 			$role->givePermissionTo('removeOwn units');
// 			$role->givePermissionTo('removeRelated units');
// 			$role->givePermissionTo('list parks');
// 			$role->givePermissionTo('store parks');
// 			$role->givePermissionTo('display parks');
// 			$role->givePermissionTo('displayOwn parks');
// 			$role->givePermissionTo('displayRelated parks');
// 			$role->givePermissionTo('updateOwn parks');
// 			$role->givePermissionTo('updateRelated parks');
// 			$role->givePermissionTo('removeOwn parks');
// 			$role->givePermissionTo('removeRelated parks');
// 			$role->givePermissionTo('list awards');
// 			$role->givePermissionTo('store awards');
// 			$role->givePermissionTo('display awards');
// 			$role->givePermissionTo('displayOwn awards');
// 			$role->givePermissionTo('displayRelated awards');
// 			$role->givePermissionTo('updateOwn awards');
// 			$role->givePermissionTo('updateRelated awards');
// 			$role->givePermissionTo('removeOwn awards');
// 			$role->givePermissionTo('removeRelated awards');
// 			$role->givePermissionTo('list users');
// 			$role->givePermissionTo('store users');
// 			$role->givePermissionTo('display users');
// 			$role->givePermissionTo('displayOwn users');
// 			$role->givePermissionTo('displayRelated users');
// 			$role->givePermissionTo('updateOwn users');
// 			$role->givePermissionTo('updateRelated users');
// 			$role->givePermissionTo('removeOwn users');
// 			$role->givePermissionTo('removeRelated users');
// 			$role->givePermissionTo('list attendances');
// 			$role->givePermissionTo('store attendances');
// 			$role->givePermissionTo('display attendances');
// 			$role->givePermissionTo('displayOwn attendances');
// 			$role->givePermissionTo('displayRelated attendances');
// 			$role->givePermissionTo('updateOwn attendances');
// 			$role->givePermissionTo('updateRelated attendances');
// 			$role->givePermissionTo('removeOwn attendances');
// 			$role->givePermissionTo('removeRelated attendances');
// 			$role->givePermissionTo('list dues');
// 			$role->givePermissionTo('store dues');
// 			$role->givePermissionTo('display dues');
// 			$role->givePermissionTo('displayOwn dues');
// 			$role->givePermissionTo('displayRelated dues');
// 			$role->givePermissionTo('updateOwn dues');
// 			$role->givePermissionTo('updateRelated dues');
// 			$role->givePermissionTo('removeOwn dues');
// 			$role->givePermissionTo('removeRelated dues');
// 			$role->givePermissionTo('list issuances');
// 			$role->givePermissionTo('store issuances');
// 			$role->givePermissionTo('display issuances');
// 			$role->givePermissionTo('displayOwn issuances');
// 			$role->givePermissionTo('displayRelated issuances');
// 			$role->givePermissionTo('updateOwn issuances');
// 			$role->givePermissionTo('updateRelated issuances');
// 			$role->givePermissionTo('removeOwn issuances');
// 			$role->givePermissionTo('removeRelated issuances');
// 			$role->givePermissionTo('list recommendations');
// 			$role->givePermissionTo('store recommendations');
// 			$role->givePermissionTo('display recommendations');
// 			$role->givePermissionTo('displayOwn recommendations');
// 			$role->givePermissionTo('displayRelated recommendations');
// 			$role->givePermissionTo('updateOwn recommendations');
// 			$role->givePermissionTo('updateRelated recommendations');
// 			$role->givePermissionTo('removeOwn recommendations');
// 			$role->givePermissionTo('removeRelated recommendations');
// 			$role->givePermissionTo('list reconciliations');
// 			$role->givePermissionTo('store reconciliations');
// 			$role->givePermissionTo('display reconciliations');
// 			$role->givePermissionTo('displayOwn reconciliations');
// 			$role->givePermissionTo('displayRelated reconciliations');
// 			$role->givePermissionTo('updateOwn reconciliations');
// 			$role->givePermissionTo('updateRelated reconciliations');
// 			$role->givePermissionTo('removeOwn reconciliations');
// 			$role->givePermissionTo('removeRelated reconciliations');
// 			$role->givePermissionTo('list splits');
// 			$role->givePermissionTo('store splits');
// 			$role->givePermissionTo('display splits');
// 			$role->givePermissionTo('displayOwn splits');
// 			$role->givePermissionTo('displayRelated splits');
// 			$role->givePermissionTo('updateOwn splits');
// 			$role->givePermissionTo('updateRelated splits');
// 			$role->givePermissionTo('removeOwn splits');
// 			$role->givePermissionTo('removeRelated splits');
// 			$role->givePermissionTo('list events');
// 			$role->givePermissionTo('store events');
// 			$role->givePermissionTo('display events');
// 			$role->givePermissionTo('displayOwn events');
// 			$role->givePermissionTo('displayRelated events');
// 			$role->givePermissionTo('updateOwn events');
// 			$role->givePermissionTo('updateRelated events');
// 			$role->givePermissionTo('removeOwn events');
// 			$role->givePermissionTo('removeRelated events');
// 			$role->givePermissionTo('list officers');
// 			$role->givePermissionTo('store officers');
// 			$role->givePermissionTo('display officers');
// 			$role->givePermissionTo('displayOwn officers');
// 			$role->givePermissionTo('displayRelated officers');
// 			$role->givePermissionTo('updateOwn officers');
// 			$role->givePermissionTo('updateRelated officers');
// 			$role->givePermissionTo('removeOwn officers');
// 			$role->givePermissionTo('removeRelated officers');
// 			$role->givePermissionTo('list waivers');
// 			$role->givePermissionTo('store waivers');
// 			$role->givePermissionTo('display waivers');
// 			$role->givePermissionTo('displayOwn waivers');
// 			$role->givePermissionTo('displayRelated waivers');
// 			$role->givePermissionTo('updateOwn waivers');
// 			$role->givePermissionTo('updateRelated waivers');
// 			$role->givePermissionTo('removeOwn waivers');
// 			$role->givePermissionTo('removeRelated waivers');
// 			$role->givePermissionTo('list personas');
// 			$role->givePermissionTo('store personas');
// 			$role->givePermissionTo('display personas');
// 			$role->givePermissionTo('displayOwn personas');
// 			$role->givePermissionTo('displayRelated personas');
// 			$role->givePermissionTo('updateOwn personas');
// 			$role->givePermissionTo('updateRelated personas');
// 			$role->givePermissionTo('removeOwn personas');
// 			$role->givePermissionTo('removeRelated personas');
// 			$role->givePermissionTo('list suspensions');
// 			$role->givePermissionTo('store suspensions');
// 			$role->givePermissionTo('display suspensions');
// 			$role->givePermissionTo('displayOwn suspensions');
// 			$role->givePermissionTo('displayRelated suspensions');
// 			$role->givePermissionTo('updateOwn suspensions');
// 			$role->givePermissionTo('updateRelated suspensions');
// 			$role->givePermissionTo('removeOwn suspensions');
// 			$role->givePermissionTo('removeRelated suspensions');
// 			$role->givePermissionTo('list members');
// 			$role->givePermissionTo('store members');
// 			$role->givePermissionTo('display members');
// 			$role->givePermissionTo('displayOwn members');
// 			$role->givePermissionTo('displayRelated members');
// 			$role->givePermissionTo('updateOwn members');
// 			$role->givePermissionTo('updateRelated members');
// 			$role->givePermissionTo('removeOwn members');
// 			$role->givePermissionTo('removeRelated members');

// 			$role = Role::create(['name' => 'player', 'guard_name' => 'api']);
// 			$role->givePermissionTo('list archetypes');
// 			$role->givePermissionTo('display archetypes');
// 			$role->givePermissionTo('list kingdom_office');
// 			$role->givePermissionTo('display kingdom_office');
// 			$role->givePermissionTo('list kingdom_title');
// 			$role->givePermissionTo('display kingdom_title');
// 			$role->givePermissionTo('list kingdoms');
// 			$role->givePermissionTo('display kingdoms');
// 			$role->givePermissionTo('list locations');
// 			$role->givePermissionTo('store locations');
// 			$role->givePermissionTo('display locations');
// 			$role->givePermissionTo('displayOwn locations');
// 			$role->givePermissionTo('displayRelated locations');
// 			$role->givePermissionTo('updateOwn locations');
// 			$role->givePermissionTo('removeOwn locations');
// 			$role->givePermissionTo('list meetups');
// 			$role->givePermissionTo('display meetups');
// 			$role->givePermissionTo('displayOwn meetups');
// 			$role->givePermissionTo('displayRelated meetups');
// 			$role->givePermissionTo('list offices');
// 			$role->givePermissionTo('display offices');
// 			$role->givePermissionTo('displayOwn offices');
// 			$role->givePermissionTo('displayRelated offices');
// 			$role->givePermissionTo('list parkranks');
// 			$role->givePermissionTo('display parkranks');
// 			$role->givePermissionTo('displayOwn parkranks');
// 			$role->givePermissionTo('displayRelated parkranks');
// 			$role->givePermissionTo('list pronouns');
// 			$role->givePermissionTo('display pronouns');
// 			$role->givePermissionTo('displayOwn pronouns');
// 			$role->givePermissionTo('displayRelated pronouns');
// 			$role->givePermissionTo('updateOwn pronouns');
// 			$role->givePermissionTo('removeOwn pronouns');
// 			$role->givePermissionTo('list titles');
// 			$role->givePermissionTo('display titles');
// 			$role->givePermissionTo('displayOwn titles');
// 			$role->givePermissionTo('displayRelated titles');
// 			$role->givePermissionTo('list tournaments');
// 			$role->givePermissionTo('store tournaments');
// 			$role->givePermissionTo('display tournaments');
// 			$role->givePermissionTo('displayOwn tournaments');
// 			$role->givePermissionTo('displayRelated tournaments');
// 			$role->givePermissionTo('updateOwn tournaments');
// 			$role->givePermissionTo('removeOwn tournaments');
// 			$role->givePermissionTo('list units');
// 			$role->givePermissionTo('store units');
// 			$role->givePermissionTo('display units');
// 			$role->givePermissionTo('displayOwn units');
// 			$role->givePermissionTo('displayRelated units');
// 			$role->givePermissionTo('update units');
// 			$role->givePermissionTo('updateOwn units');
// 			$role->givePermissionTo('remove units');
// 			$role->givePermissionTo('removeOwn units');
// 			$role->givePermissionTo('list parks');
// 			$role->givePermissionTo('display parks');
// 			$role->givePermissionTo('displayOwn parks');
// 			$role->givePermissionTo('displayRelated parks');
// 			$role->givePermissionTo('list awards');
// 			$role->givePermissionTo('display awards');
// 			$role->givePermissionTo('displayOwn awards');
// 			$role->givePermissionTo('displayRelated awards');
// 			$role->givePermissionTo('list users');
// 			$role->givePermissionTo('store users');
// 			$role->givePermissionTo('display users');
// 			$role->givePermissionTo('displayOwn users');
// 			$role->givePermissionTo('displayRelated users');
// 			$role->givePermissionTo('updateOwn users');
// 			$role->givePermissionTo('removeOwn users');
// 			$role->givePermissionTo('list attendances');
// 			$role->givePermissionTo('store attendances');
// 			$role->givePermissionTo('display attendances');
// 			$role->givePermissionTo('displayOwn attendances');
// 			$role->givePermissionTo('displayRelated attendances');
// 			$role->givePermissionTo('list dues');
// 			$role->givePermissionTo('display dues');
// 			$role->givePermissionTo('displayOwn dues');
// 			$role->givePermissionTo('displayRelated dues');
// 			$role->givePermissionTo('list issuances');
// 			$role->givePermissionTo('display issuances');
// 			$role->givePermissionTo('displayOwn issuances');
// 			$role->givePermissionTo('displayRelated issuances');
// 			$role->givePermissionTo('list recommendations');
// 			$role->givePermissionTo('store recommendations');
// 			$role->givePermissionTo('display recommendations');
// 			$role->givePermissionTo('displayOwn recommendations');
// 			$role->givePermissionTo('displayRelated recommendations');
// 			$role->givePermissionTo('updateOwn recommendations');
// 			$role->givePermissionTo('removeOwn recommendations');
// 			$role->givePermissionTo('list reconciliations');
// 			$role->givePermissionTo('display reconciliations');
// 			$role->givePermissionTo('displayOwn reconciliations');
// 			$role->givePermissionTo('displayRelated reconciliations');
// 			$role->givePermissionTo('list events');
// 			$role->givePermissionTo('display events');
// 			$role->givePermissionTo('displayOwn events');
// 			$role->givePermissionTo('displayRelated events');
// 			$role->givePermissionTo('updateOwn events');
// 			$role->givePermissionTo('list officers');
// 			$role->givePermissionTo('display officers');
// 			$role->givePermissionTo('displayOwn officers');
// 			$role->givePermissionTo('displayRelated officers');
// 			$role->givePermissionTo('list waivers');
// 			$role->givePermissionTo('display waivers');
// 			$role->givePermissionTo('displayOwn waivers');
// 			$role->givePermissionTo('displayRelated waivers');
// 			$role->givePermissionTo('list personas');
// 			$role->givePermissionTo('display personas');
// 			$role->givePermissionTo('displayOwn personas');
// 			$role->givePermissionTo('displayRelated personas');
// 			$role->givePermissionTo('updateOwn personas');
// 			$role->givePermissionTo('list suspensions');
// 			$role->givePermissionTo('display suspensions');
// 			$role->givePermissionTo('displayOwn suspensions');
// 			$role->givePermissionTo('displayRelated suspensions');
// 			$role->givePermissionTo('list members');
// 			$role->givePermissionTo('store members');
// 			$role->givePermissionTo('display members');
// 			$role->givePermissionTo('displayOwn members');
// 			$role->givePermissionTo('displayRelated members');
// 			$role->givePermissionTo('updateOwn members');
// 			$role->givePermissionTo('removeOwn members');

// 			app('cache')
// 				->store(config('permission.cache.store') != 'default' ? config('permission.cache.store') : null)
// 				->forget(config('permission.cache.key'));

			//TODO: delete this
			$trans = DB::table('trans')->get();
			
			//various holders
			$deadRecords = [];
			//TODO: delete these (keep the = [] stuff)
			$transDone = $trans->filter(function($item) {
				return ($item->table === 'kingdomawardsprocessed');
			});
			if($transDone->first()){
				$kingdomawardsProcessed = unserialize($transDone->first()->value);
			}else{
				DB::table('trans')->insert([
						'table' => 'kingdomawardsprocessed',
						'value' => serialize([])
				]);
				$kingdomawardsProcessed = [];
			}
			$transArchetypes = [];
			$transDone = $trans->filter(function($item) {
				return ($item->table === 'archetypes');
			});
			if(count($transDone) > 0){
				$transArchetypes = unserialize($transDone->first()->value);
			}
			$transKingdoms = [];
			$transDone = $trans->filter(function($item) {
				return ($item->table === 'kingdoms');
			});
			if(count($transDone) > 0){
				$transKingdoms = unserialize($transDone->first()->value);
			}
			$transParkRanks = [];
			$transDone = $trans->filter(function($item) {
				return ($item->table === 'parkranks');
			});
			if(count($transDone) > 0){
				$transParkRanks = unserialize($transDone->first()->value);
			}
			$transParks = [];
			$transDone = $trans->filter(function($item) {
				return ($item->table === 'parks');
			});
			if(count($transDone) > 0){
				$transParks = unserialize($transDone->first()->value);
			}
			$transUnits = [];
			$transDone = $trans->filter(function($item) {
				return ($item->table === 'units');
			});
			if(count($transDone) > 0){
				$transUnits = unserialize($transDone->first()->value);
			}
			$transGenericAwards = [];
			$transDone = $trans->filter(function($item) {
				return ($item->table === 'genericawards');
			});
			if(count($transDone) > 0){
				$transGenericAwards = unserialize($transDone->first()->value);
			}
			$transCustomAwards = [];
			$transDone = $trans->filter(function($item) {
				return ($item->table === 'customawards');
			});
			if(count($transDone) > 0){
				$transCustomAwards = unserialize($transDone->first()->value);
			}
			$transTitles = [];
			$transDone = $trans->filter(function($item) {
				return ($item->table === 'titles');
			});
			if(count($transDone) > 0){
				$transTitles = unserialize($transDone->first()->value);
			}
			$transCustomTitles = [];
			$transDone = $trans->filter(function($item) {
				return ($item->table === 'customtitles');
			});
			if(count($transDone) > 0){
				$transCustomTitles = unserialize($transDone->first()->value);
			}
			$transPronouns = [];
			$transDone = $trans->filter(function($item) {
				return ($item->table === 'pronouns');
			});
			if(count($transDone) > 0){
				$transPronouns = unserialize($transDone->first()->value);
			}
			$transUsers = [];
			$transDone = $trans->filter(function($item) {
				return ($item->table === 'users');
			});
			if(count($transDone) > 0){
				$transUsers = unserialize($transDone->first()->value);
			}
			$transPersonas = [];
			$transDone = $trans->filter(function($item) {
				return ($item->table === 'personas');
			});
			if(count($transDone) > 0){
				$transPersonas = unserialize($transDone->first()->value);
			}
			$transEvents = [];
			$transDone = $trans->filter(function($item) {
				return ($item->table === 'events');
			});
			if(count($transDone) > 0){
				$transEvents = unserialize($transDone->first()->value);
			}
			$transEventDetails = [];
			$transDone = $trans->filter(function($item) {
				return ($item->table === 'eventDetails');
			});
			if(count($transDone) > 0){
				$transEventDetails = unserialize($transDone->first()->value);
			}
			$transAccounts = [];
			$transDone = $trans->filter(function($item) {
				return ($item->table === 'accounts');
			});
			if(count($transDone) > 0){
				$transAccounts = unserialize($transDone->first()->value);
			}
			$transMeetups = [];
			$transDone = $trans->filter(function($item) {
				return ($item->table === 'meetups');
			});
			if(count($transDone) > 0){
				$transMeetups = unserialize($transDone->first()->value);
			}
			$transGenericAttendances = [];
			$transDone = $trans->filter(function($item) {
				return ($item->table === 'genericAttendances');
			});
			if(count($transDone) > 0){
				$transGenericAttendances = unserialize($transDone->first()->value);
			}
			$transTournaments = [];
			$transDone = $trans->filter(function($item) {
				return ($item->table === 'tournaments');
			});
			if(count($transDone) > 0){
				$transTournaments = unserialize($transDone->first()->value);
			}
			$transTransactions = [];
			$transDone = $trans->filter(function($item) {
				return ($item->table === 'transactions');
			});
			if(count($transDone) > 0){
				$transTransactions = unserialize($transDone->first()->value);
			}
			$transDues = [];
			$transDone = $trans->filter(function($item) {
				return ($item->table === 'dues');
			});
			if(count($transDone) > 0){
				$transDues = unserialize($transDone->first()->value);
			}
			$transMembers = [];
			$transDone = $trans->filter(function($item) {
				return ($item->table === 'members');
			});
			if(count($transDone) > 0){
				$transMembers = unserialize($transDone->first()->value);
			}
			$transOfficers = [];
			$transDone = $trans->filter(function($item) {
				return ($item->table === 'officers');
			});
			if(count($transDone) > 0){
				$transOfficers = unserialize($transDone->first()->value);
			}
			$transRecommendations = [];
			$transReconciliations = [];
			$transSplits = [];
			
			//what we know
// 			$ropLadders = [243, 239, 25, 26, 23, 24, 21, 22, 27]; //the ids in ork3 of awards that are standardized
// 			$ropTitles = [1,2,3,4,5,6,12,13,14,15,16,17,18,19,20,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,203,240,241,242,244,245,]; //the ids in the ork3 of titles that are standardized
			$knownCollectiveGDs = [16, 21, 17, 10];//the ids in ork3 of kingdoms with Grand Duchies that are collective.
			//TODO: convert any of their GD's into 'kingdoms'
// 			$knownAwards = [
// 					'Order of the Flame' => [
// 							1 => [
// 									'name' => 'The Flame',
// 									'is_ladder' => 0
// 							],
// 							3 => [
// 									'name' => 'Flame',
// 									'is_ladder' => 0
// 							],
// 							4 => [
// 									'name' => 'Order of the Flame',
// 									'is_ladder' => 0
// 							],
// 							5 => [
// 									'name' => 'Order of the Flame',
// 									'is_ladder' => 0
// 							],
// 							6 => [
// 									'name' => 'Order of the Flame',
// 									'is_ladder' => 0
// 							],
// 							7 => [
// 									'name' => 'Order of the Flame',
// 									'is_ladder' => 0
// 							],
// 							10 => [
// 									'name' => 'Order of the Flame',
// 									'is_ladder' => 0
// 							],
// 							11 => [
// 									'name' => 'Order of the Flame',
// 									'is_ladder' => 0
// 							],
// 							12 => [
// 									'name' => 'Order of the Flame',
// 									'is_ladder' => 0
// 							],
// 							14 => [
// 									'name' => 'Order of the Flame',
// 									'is_ladder' => 0
// 							],
// 							16 => [
// 									'name' => 'Order of the Flame',
// 									'is_ladder' => 0
// 							],
// 							17 => [
// 									'name' => 'Order of the Flame',
// 									'is_ladder' => 0
// 							],
// 							18 => [
// 									'name' => 'Order of the Flame',
// 									'is_ladder' => 0
// 							],
// 							19 => [
// 									'name' => 'Order of the Flame',
// 									'is_ladder' => 0
// 							],
// 							20 => [
// 									'name' => 'Order of the Flame',
// 									'is_ladder' => 0
// 							],
// 							21 => [
// 									'name' => 'Order of the Flame',
// 									'is_ladder' => 0
// 							],
// 							22 => [
// 									'name' => 'Order of the Flame',
// 									'is_ladder' => 0
// 							],
// 							24 => [
// 									'name' => 'Order of the Flame',
// 									'is_ladder' => 0
// 							],
// 							25 => [
// 									'name' => 'Order of the Flame',
// 									'is_ladder' => 0
// 							],
// 							27 => [
// 									'name' => 'Flame',
// 									'is_ladder' => 0
// 							],
// 							31 => [
// 									'name' => 'Flame',
// 									'is_ladder' => 0
// 							],
// 							36 => [
// 									'name' => 'Order of the Flame',
// 									'is_ladder' => 0
// 							],
// 							38 => [
// 									'name' => 'Order of the Flame',
// 									'is_ladder' => 0
// 							]
// 					],
// 					'Order of the Griffin' => [
// 							1 => [
// 									'name' => 'Order of the Griffin',
// 									'is_ladder' => 1
// 							],
// 							3 => [
// 									'name' => 'Order of the Griffin',
// 									'is_ladder' => 1
// 							],
// 							4 => [
// 									'name' => 'Order of the Griffin',
// 									'is_ladder' => 1
// 							],
// 							5 => [
// 									'name' => 'Order of the Griffin',
// 									'is_ladder' => 1
// 							],
// 							6 => [
// 									'name' => 'Order of the Griffin',
// 									'is_ladder' => 1
// 							],
// 							7 => [
// 									'name' => 'Order of the Griffon|Order of the Gryphon',
// 									'is_ladder' => 1
// 							],
// 							10 => [
// 									'name' => 'Order of the Griffin',
// 									'is_ladder' => 1
// 							],
// 							11 => [
// 									'name' => 'Order of the Gryphon',
// 									'is_ladder' => 1
// 							],
// 							12 => [
// 									'name' => 'Order of the Griffin',
// 									'is_ladder' => 1
// 							],
// 							14 => [
// 									'name' => 'Order of the Griffon|Order of the Gryphon',
// 									'is_ladder' => 1
// 							],
// 							16 => [
// 									'name' => 'Order of the Griffon|Order of the Gryphon',
// 									'is_ladder' => 1
// 							],
// 							17 => [
// 									'name' => 'Order of the Griffon',
// 									'is_ladder' => 1
// 							],
// 							18 => [
// 									'name' => 'Order of the Gryphon',
// 									'is_ladder' => 1
// 							],
// 							19 => [
// 									'name' => 'Order of the Griffon|Order of the Gryphon',
// 									'is_ladder' => 1
// 							],
// 							20 => [
// 									'name' => 'Order of the Griffin',
// 									'is_ladder' => 1
// 							],
// 							21 => [
// 									'name' => 'Order of the Griffon',
// 									'is_ladder' => 1
// 							],
// 							22 => [
// 									'name' => 'Order of the Griffin',
// 									'is_ladder' => 1
// 							],
// 							24 => [
// 									'name' => 'Order of the Griffon',
// 									'is_ladder' => 1
// 							],
// 							25 => [
// 									'name' => 'Order of the Griffon|Order of the Gryphon',
// 									'is_ladder' => 1
// 							],
// 							27 => [
// 									'name' => 'Order of the Griffon|Order of the Gryphon',
// 									'is_ladder' => 1
// 							],
// 							31 => [
// 									'name' => 'Griffon',
// 									'is_ladder' => 1
// 							],
// 							36 => [
// 									'name' => 'Order of the Griffon',
// 									'is_ladder' => 1
// 							],
// 							38 => [
// 									'name' => 'Order of the Griffin',
// 									'is_ladder' => 1
// 							]
// 					],
// 					'Order of the Hydra' => [
// 							1 => [
// 									'name' => 'Order of the Hydra',
// 									'is_ladder' => 1
// 							],
// 							3 => [
// 									'name' => 'Hydra',
// 									'is_ladder' => 1
// 							],
// 							4 => [
// 									'name' => 'Order of the Hydra',
// 									'is_ladder' => 1
// 							],
// 							5 => [
// 									'name' => 'Order of the Hydra',
// 									'is_ladder' => 1
// 							],
// 							6 => [
// 									'name' => 'Order of the Hydra',
// 									'is_ladder' => 1
// 							],
// 							7 => [
// 									'name' => 'Order of the Hydra',
// 									'is_ladder' => 1
// 							],
// 							10 => null,
// 							11 => null,
// 							12 => [
// 									'name' => 'Order of the Hydra',
// 									'is_ladder' => 1
// 							],
// 							14 => [
// 									'name' => 'Order of the Hydra',
// 									'is_ladder' => 1
// 							],
// 							16 => [
// 									'name' => 'Order of the Hydra',
// 									'is_ladder' => 1
// 							],
// 							17 => null,
// 							18 => [
// 									'name' => 'Order of the Hydra',
// 									'is_ladder' => 1
// 							],
// 							19 => null,
// 							20 => [
// 									'name' => 'Order of the Hydra',
// 									'is_ladder' => 1
// 							],
// 							21 => null,
// 							22 => [
// 									'name' => 'Order of the Hydra',
// 									'is_ladder' => 1
// 							],
// 							24 => [
// 									'name' => 'Order of the Hydra',
// 									'is_ladder' => 1
// 							],
// 							25 => [
// 									'name' => 'Order of the Hydra',
// 									'is_ladder' => 1
// 							],
// 							27 => [
// 									'name' => 'Hydra',
// 									'is_ladder' => 1
// 							],
// 							31 => [
// 									'name' => 'Hydra',
// 									'is_ladder' => 1
// 							],
// 							36 => [
// 									'name' => 'Order of the Hydra',
// 									'is_ladder' => 1
// 							],
// 							38 => null
// 					],
// 					'Order of the Jovius' => [
// 							1 => [
// 									'name' => 'Order of the Jovious',
// 									'is_ladder' => 1
// 							],
// 							3 => [
// 									'name' => 'Jovious',
// 									'is_ladder' => 1
// 							],
// 							4 => [
// 									'name' => 'Order of the Jovious',
// 									'is_ladder' => 1
// 							],
// 							5 => [
// 									'name' => 'Order of the Jovious',
// 									'is_ladder' => 1
// 							],
// 							6 => [
// 									'name' => 'Order of the Jovious',
// 									'is_ladder' => 1
// 							],
// 							7 => [
// 									'name' => 'Order of the Jovious',
// 									'is_ladder' => 1
// 							],
// 							10 => [
// 									'name' => 'Order of the Jovious',
// 									'is_ladder' => 1
// 							],
// 							11 => [
// 									'name' => 'Order of the Jovious',
// 									'is_ladder' => 1
// 							],
// 							12 => [
// 									'name' => 'Order of the Jovious',
// 									'is_ladder' => 1
// 							],
// 							14 => [
// 									'name' => 'Order of the Jovious',
// 									'is_ladder' => 1
// 							],
// 							16 => [
// 									'name' => 'Order of the Jovious',
// 									'is_ladder' => 1
// 							],
// 							17 => [
// 									'name' => 'Order of the Jovious',
// 									'is_ladder' => 1
// 							],
// 							18 => [
// 									'name' => 'Order of the Jovious',
// 									'is_ladder' => 1
// 							],
// 							19 => [
// 									'name' => 'Order of the Jovius',
// 									'is_ladder' => 1
// 							],
// 							20 => [
// 									'name' => 'Order of the Jovius',
// 									'is_ladder' => 1
// 							],
// 							21 => [
// 									'name' => 'Order of the Jovious',
// 									'is_ladder' => 1
// 							],
// 							22 => [
// 									'name' => 'Order of the Jovious',
// 									'is_ladder' => 1
// 							],
// 							24 => [
// 									'name' => 'Order of the Jovious',
// 									'is_ladder' => 1
// 							],
// 							25 => [
// 									'name' => 'Order of the Jovious',
// 									'is_ladder' => 1
// 							],
// 							27 => [
// 									'name' => 'Jovious',
// 									'is_ladder' => 1
// 							],
// 							31 => [
// 									'name' => 'Jovious',
// 									'is_ladder' => 1
// 							],
// 							36 => [
// 									'name' => 'Order of the Jovious',
// 									'is_ladder' => 1
// 							],
// 							38 => [
// 									'name' => 'Order of the Jovius',
// 									'is_ladder' => 1
// 							]
// 					],
// 					'Order of the Mask' => [
// 							1 => [
// 									'name' => 'Order of the Mask',
// 									'is_ladder' => 1
// 							],
// 							3 => [
// 									'name' => 'Order of the Mask',
// 									'is_ladder' => 1
// 							],
// 							4 => [
// 									'name' => 'Order of the Mask',
// 									'is_ladder' => 1
// 							],
// 							5 => [
// 									'name' => 'Order of the Mask',
// 									'is_ladder' => 1
// 							],
// 							6 => [
// 									'name' => 'Order of the Mask',
// 									'is_ladder' => 1
// 							],
// 							7 => [
// 									'name' => 'Order of the Mask|Order of the Masque',
// 									'is_ladder' => 1
// 							],
// 							10 => [
// 									'name' => 'Order of the Mask',
// 									'is_ladder' => 1
// 							],
// 							11 => [
// 									'name' => 'Order of the Mask',
// 									'is_ladder' => 1
// 							],
// 							12 => [
// 									'name' => 'Order of the Mask',
// 									'is_ladder' => 1
// 							],
// 							14 => [
// 									'name' => 'Order of the Mask|Order of the Masque',
// 									'is_ladder' => 1
// 							],
// 							16 => [
// 									'name' => 'Order of the Mask|Order of the Masque',
// 									'is_ladder' => 1
// 							],
// 							17 => [
// 									'name' => 'Order of the Mask',
// 									'is_ladder' => 1
// 							],
// 							18 => [
// 									'name' => 'Order of the Mask',
// 									'is_ladder' => 1
// 							],
// 							19 => [
// 									'name' => 'Order of the Mask',
// 									'is_ladder' => 1
// 							],
// 							20 => [
// 									'name' => 'Order of the Mask',
// 									'is_ladder' => 1
// 							],
// 							21 => [
// 									'name' => 'Order of the Mask',
// 									'is_ladder' => 1
// 							],
// 							22 => [
// 									'name' => 'Order of the Mask',
// 									'is_ladder' => 1
// 							],
// 							24 => [
// 									'name' => 'Order of the Mask',
// 									'is_ladder' => 1
// 							],
// 							25 => [
// 									'name' => 'Order of the Mask|Order of the Masque',
// 									'is_ladder' => 1
// 							],
// 							27 => [
// 									'name' => 'Mask',
// 									'is_ladder' => 1
// 							],
// 							31 => [
// 									'name' => 'Mask',
// 									'is_ladder' => 1
// 							],
// 							36 => [
// 									'name' => 'Order of the Mask',
// 									'is_ladder' => 1
// 							],
// 							38 => [
// 									'name' => 'Order of the Mask',
// 									'is_ladder' => 1
// 							]
// 					],
// 					'Order of the Zodiac' => [
// 							1 => [
// 									'name' => 'The Zodiac',
// 									'is_ladder' => 1
// 							],
// 							3 => null,
// 							4 => [
// 									'name' => 'Order of the Zodiac',
// 									'is_ladder' => 1
// 							],
// 							5 => [
// 									'name' => 'Order of the Zodiac',
// 									'is_ladder' => 1
// 							],
// 							6 => [
// 									'name' => 'Order of the Zodiac',
// 									'is_ladder' => 1
// 							],
// 							7 => [
// 									'name' => 'Order of the Zodiac',
// 									'is_ladder' => 1
// 							],
// 							10 => null,
// 							11 => null,
// 							12 => [
// 									'name' => 'Order of the Zodiac',
// 									'is_ladder' => 1
// 							],
// 							14 => [
// 									'name' => 'Order of the Zodiac',
// 									'is_ladder' => 1
// 							],
// 							16 => [
// 									'name' => 'Order of the Zodiac',
// 									'is_ladder' => 1
// 							],
// 							17 => [
// 									'name' => 'Order of the Zodiac',
// 									'is_ladder' => 1
// 							],
// 							18 => [
// 									'name' => 'Order of the Zodiac',
// 									'is_ladder' => 1
// 							],
// 							19 => [
// 									'name' => 'Order of the Zodiac',
// 									'is_ladder' => 1
// 							],
// 							20 => [
// 									'name' => 'Order of the Zodiac',
// 									'is_ladder' => 1
// 							],
// 							21 => [
// 									'name' => 'Order of the Zodiac',
// 									'is_ladder' => 1
// 							],
// 							22 => [
// 									'name' => 'Order of the Zodiac',
// 									'is_ladder' => 1
// 							],
// 							24 => [
// 									'name' => 'Order of the Zodiac',
// 									'is_ladder' => 1
// 							],
// 							25 => [
// 									'name' => 'Order of the Zodiac',
// 									'is_ladder' => 1
// 							],
// 							27 => [
// 									'name' => 'Zodiac',
// 									'is_ladder' => 1
// 							],
// 							31 => [
// 									'name' => 'Zodiac',
// 									'is_ladder' => 1
// 							],
// 							36 => [
// 									'name' => 'Order of the Zodiac',
// 									'is_ladder' => 1
// 							],
// 							38 => [
// 									'name' => 'Order of the Zodiac',
// 									'is_ladder' => 1
// 							]
// 					],
// 					'Order of the Dreamkeeper' => [
// 							1 => null,
// 							3 => null,
// 							4 => null,
// 							5 => null,
// 							6 => [
// 									'name' => 'Dreamkeeper',
// 									'is_ladder' => 1
// 							],
// 							7 => null,
// 							10 => null,
// 							11 => null,
// 							12 => null,
// 							14 => null,
// 							16 => null,
// 							17 => null,
// 							18 => null,
// 							19 => null,
// 							20 => null,
// 							21 => null,
// 							22 => null,
// 							24 => null,
// 							25 => null,
// 							27 => null,
// 							31 => null,
// 							36 => null,
// 							38 => null
// 					],
// 					'Order of the Walker in the Middle' => [
// 							1 => [
// 									'type' => 'award',
// 									'name' => 'Walker in the Middle',
// 									'is_ladder' => 0
// 							],
// 							3 => null,
// 							4 => [
// 									'type' => 'award',
// 									'name' => 'Walker of the Middle',
// 									'is_ladder' => 0
// 							],
// 							5 => [
// 									'type' => 'award',
// 									'name' => 'Order of the Walker in the Middle',
// 									'is_ladder' => 0
// 							],
// 							6 => [
// 									'type' => 'award',
// 									'name' => 'Walker of the Middle',
// 									'is_ladder' => 0
// 							],
// 							7 => [
// 									'type' => 'award',
// 									'name' => 'Order of the Walker of the Middle',
// 									'is_ladder' => 0
// 							],
// 							10 => null,
// 							11 => null,
// 							12 => null,
// 							14 => [
// 									'type' => 'award',
// 									'name' => 'Order of the Walker of the Middle',
// 									'is_ladder' => 0
// 							],
// 							16 => [
// 									'type' => 'award',
// 									'name' => 'Order of the Walker of the Middle',
// 									'is_ladder' => 0
// 							],
// 							17 => [
// 									'type' => 'award',
// 									'name' => 'Order of the Walker of the Middle',
// 									'is_ladder' => 0
// 							],
// 							18 => [
// 									'type' => 'award',
// 									'name' => 'Walker in the Middle',
// 									'is_ladder' => 0
// 							],
// 							19 => [
// 									'type' => 'award',
// 									'name' => 'Walker of the Middle',
// 									'is_ladder' => 0
// 							],
// 							20 => [
// 									'type' => 'award',
// 									'name' => 'Order of the Walker of the Middle',
// 									'is_ladder' => 0
// 							],
// 							21 => null,
// 							22 => null,
// 							24 => null,
// 							25 => null,
// 							27 => null,
// 							31 => null,
// 							36 => null,
// 							38 => null
// 					],
// 			];
			//titles as they appear in ork3 with kingdom-specific details, as per my best reading of their corpora.  It's kinda a nightmare.
// 			$knownTitles = [
// 					'Master Jovius' => [
// 							1 => [
// 									'name' => 'Master Jovious',
// 									'reign_limit' => null,
// 									'rank' => 10,
// 									'is_active' => 0,
// 									'peerage' => 'Master'
// 							],
// 							3 => null,
// 							4 => null,
// 							5 => [
// 									'name' => 'Master Thespian',
// 									'reign_limit' => null,
// 									'rank' => 10,
// 									'is_active' => 1,
// 									'peerage' => 'Master'
// 							],
// 							6 => [
// 									'name' => 'Master Jovious',
// 									'reign_limit' => null,
// 									'rank' => 10,
// 									'is_active' => 1,
// 									'peerage' => 'Master'
// 							],
// 							7 => null,
// 							10 => null,
// 							11 => [
// 									'name' => 'Master Jovious',
// 									'reign_limit' => null,
// 									'rank' => 10,
// 									'is_active' => 1,
// 									'peerage' => 'Master'
// 							],
// 							12 => [
// 									'name' => 'Master Jovious',
// 									'reign_limit' => null,
// 									'rank' => 10,
// 									'is_active' => 1,
// 									'peerage' => 'Master'
// 							],
// 							14 => null,
// 							16 => null,
// 							17 => [
// 									'name' => 'Master Jovious',
// 									'reign_limit' => null,
// 									'rank' => 10,
// 									'is_active' => 1,
// 									'peerage' => 'Master'
// 							],
// 							18 => null,
// 							19 => null,
// 							20 => null,
// 							21 => null,
// 							22 => null,
// 							24 => [
// 									'name' => 'Master Thespian',
// 									'reign_limit' => null,
// 									'rank' => 10,
// 									'is_active' => 1,
// 									'peerage' => 'Master'
// 							],
// 							25 => null,
// 							27 => null,
// 							31 => null,
// 							36 => [
// 									'name' => 'Master Jovious',
// 									'reign_limit' => null,
// 									'rank' => 10,
// 									'is_active' => 1,
// 									'peerage' => 'Master'
// 							],
// 							38 => null
// 					],
// 					'Master Zodiac' => [
// 							1 => null,
// 							3 => null,
// 							4 => null,
// 							5 => [
// 									'name' => 'Master Zodiac',
// 									'reign_limit' => null,
// 									'rank' => 10,
// 									'is_active' => 1,
// 									'peerage' => 'Master'
// 							],
// 							6 => [
// 									'name' => 'Master Zodiac',
// 									'reign_limit' => null,
// 									'rank' => 10,
// 									'is_active' => 1,
// 									'peerage' => 'Master'
// 							],
// 							7 => null,
// 							10 => null,
// 							11 => null,
// 							12 => [
// 									'name' => 'Master Zodiac',
// 									'reign_limit' => null,
// 									'rank' => 10,
// 									'is_active' => 1,
// 									'peerage' => 'Master'
// 							],
// 							14 => null,
// 							16 => null,
// 							17 => [
// 									'name' => 'Master Zodiac',
// 									'reign_limit' => null,
// 									'rank' => 10,
// 									'is_active' => 1,
// 									'peerage' => 'Master'
// 							],
// 							18 => null,
// 							19 => null,
// 							20 => null,
// 							21 => null,
// 							22 => null,
// 							24 => [
// 									'name' => 'Master Zodiac',
// 									'reign_limit' => null,
// 									'rank' => 10,
// 									'is_active' => 1,
// 									'peerage' => 'Master'
// 							],
// 							25 => [
// 									'name' => 'Master Zodiac',
// 									'reign_limit' => null,
// 									'rank' => 10,
// 									'is_active' => 1,
// 									'peerage' => 'Master'
// 							],
// 							27 => null,
// 							31 => null,
// 							36 => null,
// 							38 => null
// 					],
// 					'Master Mask' => [
// 							1 => [
// 									'name' => 'Master Mask|Master Thespian',
// 									'reign_limit' => null,
// 									'rank' => 10,
// 									'is_active' => 0,
// 									'peerage' => 'Master'
// 							],
// 							3 => [
// 									'name' => 'Master Mask',
// 									'reign_limit' => null,
// 									'rank' => 10,
// 									'is_active' => 1,
// 									'peerage' => 'Master'
// 							],
// 							4 => [
// 									'name' => 'Master Mask',
// 									'reign_limit' => null,
// 									'rank' => 10,
// 									'is_active' => 1,
// 									'peerage' => 'Master'
// 							],
// 							5 => [
// 									'name' => 'Master Thespian',
// 									'reign_limit' => null,
// 									'rank' => 10,
// 									'is_active' => 1,
// 									'peerage' => 'Master'
// 							],
// 							6 => [
// 									'name' => 'Master Mask',
// 									'reign_limit' => null,
// 									'rank' => 10,
// 									'is_active' => 1,
// 									'peerage' => 'Master'
// 							],
// 							7 => null,
// 							10 => null,
// 							11 => [
// 									'name' => 'Master Mask',
// 									'reign_limit' => null,
// 									'rank' => 10,
// 									'is_active' => 1,
// 									'peerage' => 'Master'
// 							],
// 							12 => [
// 									'name' => 'Master Mask',
// 									'reign_limit' => null,
// 									'rank' => 10,
// 									'is_active' => 1,
// 									'peerage' => 'Master'
// 							],
// 							14 => null,
// 							16 => null,
// 							17 => [
// 									'name' => 'Master Mask',
// 									'reign_limit' => null,
// 									'rank' => 10,
// 									'is_active' => 1,
// 									'peerage' => 'Master'
// 							],
// 							18 => null,
// 							19 => null,
// 							20 => null,
// 							21 => null,
// 							22 => null,
// 							24 => [
// 									'name' => 'Master Thespian',
// 									'reign_limit' => null,
// 									'rank' => 10,
// 									'is_active' => 1,
// 									'peerage' => 'Master'
// 							],
// 							25 => null,
// 							27 => null,
// 							31 => null,
// 							36 => [
// 									'name' => 'Master Mask',
// 									'reign_limit' => null,
// 									'rank' => 10,
// 									'is_active' => 1,
// 									'peerage' => 'Master'
// 							],
// 							38 => null
// 					],
// 					'Master Hydra' => [
// 							1 => [
// 									'name' => 'Master Hydra',
// 									'reign_limit' => null,
// 									'rank' => 10,
// 									'is_active' => 1,
// 									'peerage' => 'Master'
// 							],
// 							3 => null,
// 							4 => [
// 									'name' => 'Master Hydra',
// 									'reign_limit' => null,
// 									'rank' => 10,
// 									'is_active' => 1,
// 									'peerage' => 'Master'
// 							],
// 							5 => [
// 									'name' => 'Master Hydra',
// 									'reign_limit' => null,
// 									'rank' => 10,
// 									'is_active' => 1,
// 									'peerage' => 'Master'
// 							],
// 							6 => [
// 									'name' => 'Master Hydra',
// 									'reign_limit' => null,
// 									'rank' => 10,
// 									'is_active' => 1,
// 									'peerage' => 'Master'
// 							],
// 							7 => [
// 									'name' => 'Master Hydra',
// 									'reign_limit' => null,
// 									'rank' => 10,
// 									'is_active' => 1,
// 									'peerage' => 'Master'
// 							],
// 							10 => null,
// 							11 => null,
// 							12 => [
// 									'name' => 'Master Hydra',
// 									'reign_limit' => null,
// 									'rank' => 10,
// 									'is_active' => 1,
// 									'peerage' => 'Master'
// 							],
// 							14 => null,
// 							16 => [
// 									'name' => 'Master Hydra',
// 									'reign_limit' => null,
// 									'rank' => 10,
// 									'is_active' => 1,
// 									'peerage' => 'Master'
// 							],
// 							17 => null,
// 							18 => null,
// 							19 => null,
// 							20 => null,
// 							21 => null,
// 							22 => [
// 									'name' => 'Master Hydra',
// 									'reign_limit' => null,
// 									'rank' => 10,
// 									'is_active' => 1,
// 									'peerage' => 'Master'
// 							],
// 							24 => null,
// 							25 => [
// 									'name' => 'Master Hydra',
// 									'reign_limit' => null,
// 									'rank' => 10,
// 									'is_active' => 1,
// 									'peerage' => 'Master'
// 							],
// 							27 => null,
// 							31 => null,
// 							36 => [
// 									'name' => 'Master Hydra',
// 									'reign_limit' => null,
// 									'rank' => 10,
// 									'is_active' => 1,
// 									'peerage' => 'Master'
// 							],
// 							38 => null
// 					],
// 					'Master Griffin' => [
// 							1 => [
// 									'name' => 'Master Griffin',
// 									'reign_limit' => null,
// 									'rank' => 10,
// 									'is_active' => 1,
// 									'peerage' => 'Master'
// 							],
// 							3 => [
// 									'name' => 'Master Griffin',
// 									'reign_limit' => null,
// 									'rank' => 10,
// 									'is_active' => 1,
// 									'peerage' => 'Master'
// 							],
// 							4 => [
// 									'name' => 'Master Griffin',
// 									'reign_limit' => null,
// 									'rank' => 10,
// 									'is_active' => 1,
// 									'peerage' => 'Master'
// 							],
// 							5 => [
// 									'name' => 'Master Griffin',
// 									'reign_limit' => null,
// 									'rank' => 10,
// 									'is_active' => 1,
// 									'peerage' => 'Master'
// 							],
// 							6 => [
// 									'name' => 'Master Griffin',
// 									'reign_limit' => null,
// 									'rank' => 10,
// 									'is_active' => 1,
// 									'peerage' => 'Master'
// 							],
// 							7 => null,
// 							10 => null,
// 							11 => [
// 									'name' => 'Master Gryphon',
// 									'reign_limit' => null,
// 									'rank' => 10,
// 									'is_active' => 1,
// 									'peerage' => 'Master'
// 							],
// 							12 => [
// 									'name' => 'Master Griffon',
// 									'reign_limit' => null,
// 									'rank' => 10,
// 									'is_active' => 1,
// 									'peerage' => 'Master'
// 							],
// 							14 => null,
// 							16 => [
// 									'name' => 'Master Griffon',
// 									'reign_limit' => null,
// 									'rank' => 10,
// 									'is_active' => 1,
// 									'peerage' => 'Master'
// 							],
// 							17 => [
// 									'name' => 'Master Griffon',
// 									'reign_limit' => null,
// 									'rank' => 10,
// 									'is_active' => 1,
// 									'peerage' => 'Master'
// 							],
// 							18 => null,
// 							19 => null,
// 							20 => null,
// 							21 => null,
// 							22 => [
// 									'name' => 'Master Griffon',
// 									'reign_limit' => null,
// 									'rank' => 10,
// 									'is_active' => 1,
// 									'peerage' => 'Master'
// 							],
// 							24 => null,
// 							25 => [
// 									'name' => 'Master Griffon|Master Gryphon',
// 									'reign_limit' => null,
// 									'rank' => 10,
// 									'is_active' => 1,
// 									'peerage' => 'Master'
// 							],
// 							27 => null,
// 							31 => null,
// 							36 => [
// 									'name' => 'Master Griffon',
// 									'reign_limit' => null,
// 									'rank' => 10,
// 									'is_active' => 1,
// 									'peerage' => 'Master'
// 							],
// 							38 => null
// 					],
// 					'Order of the Walker in the Middle' => [
// 							1 => null,
// 							3 => [
// 									'name' => 'Walker of the Middle',
// 									'reign_limit' => null,
// 									'rank' => 5,
// 									'is_active' => 1,
// 									'peerage' => 'None'
// 							],
// 							4 => null,
// 							5 => null,
// 							6 => null,
// 							7 => null,
// 							10 => [
// 									'name' => 'Walker of the Middle',
// 									'reign_limit' => null,
// 									'rank' => 5,
// 									'is_active' => 1,
// 									'peerage' => 'None'
// 							],
// 							11 => [
// 									'name' => 'Walker of the Middle',
// 									'reign_limit' => null,
// 									'rank' => 5,
// 									'is_active' => 1,
// 									'peerage' => 'None'
// 							],
// 							12 => [
// 									'name' => 'Walker of the Middle',
// 									'reign_limit' => null,
// 									'rank' => 10,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							14 => null,
// 							16 => null,
// 							17 => null,
// 							18 => null,
// 							19 => null,
// 							20 => null,
// 							21 => [
// 									'name' => 'Walker of the Middle',
// 									'reign_limit' => null,
// 									'rank' => 5,
// 									'is_active' => 1,
// 									'peerage' => 'None'
// 							],
// 							22 => [
// 									'name' => 'Walker of the Middle',
// 									'reign_limit' => null,
// 									'rank' => 10,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							24 => [
// 									'name' => 'Walker in the Middle',
// 									'reign_limit' => null,
// 									'rank' => 0,
// 									'is_active' => 1,
// 									'peerage' => 'None'
// 							],
// 							25 => null,
// 							27 => null,
// 							31 => null,
// 							36 => [
// 									'name' => 'Walker of the Middle',
// 									'reign_limit' => null,
// 									'rank' => 10,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							38 => [
// 									'name' => 'Walker of the Middle',
// 									'reign_limit' => null,
// 									'rank' => 5,
// 									'is_active' => 1,
// 									'peerage' => 'None'
// 							]
// 					],
// 					'Weaponmaster' => [
// 							1 => [
// 									'name' => 'Kingdom Weaponmaster',
// 									'reign_limit' => 1,
// 									'rank' => 0,
// 									'is_active' => 1,
// 									'peerage' => 'None'
// 							],
// 							3 => null,
// 							4 => [
// 									'name' => 'Weaponmaster',
// 									'reign_limit' => 1,
// 									'rank' => 0,
// 									'is_active' => 1,
// 									'peerage' => 'None'
// 							],
// 							5 => [
// 									'name' => 'Weaponmaster',
// 									'reign_limit' => 1,
// 									'rank' => 0,
// 									'is_active' => 1,
// 									'peerage' => 'None'
// 							],
// 							6 => [
// 									'name' => 'Weaponmaster',
// 									'reign_limit' => 1,
// 									'rank' => 0,
// 									'is_active' => 1,
// 									'peerage' => 'None'
// 							],
// 							7 => [
// 									'name' => 'Weaponmaster',
// 									'reign_limit' => 1,
// 									'rank' => 0,
// 									'is_active' => 1,
// 									'peerage' => 'None'
// 							],
// 							10 => [
// 									'name' => 'Weaponmaster',
// 									'reign_limit' => 1,
// 									'rank' => 0,
// 									'is_active' => 1,
// 									'peerage' => 'None'
// 							],
// 							11 => null,
// 							12 => [
// 									'name' => 'Weaponmaster',
// 									'reign_limit' => 1,
// 									'rank' => 0,
// 									'is_active' => 1,
// 									'peerage' => 'None'
// 							],
// 							14 => null,
// 							16 => [
// 									'name' => 'Weaponmaster',
// 									'reign_limit' => 1,
// 									'rank' => 0,
// 									'is_active' => 1,
// 									'peerage' => 'None'
// 							],
// 							17 => null,
// 							18 => null,
// 							19 => [
// 									'name' => 'Weaponmaster',
// 									'reign_limit' => 1,
// 									'rank' => 0,
// 									'is_active' => 1,
// 									'peerage' => 'None'
// 							],
// 							20 => [
// 									'name' => 'Weaponmaster',
// 									'reign_limit' => 1,
// 									'rank' => 0,
// 									'is_active' => 1,
// 									'peerage' => 'None'
// 							],
// 							21 => [
// 									'name' => 'Weaponmaster',
// 									'reign_limit' => 1,
// 									'rank' => 0,
// 									'is_active' => 1,
// 									'peerage' => 'None'
// 							],
// 							22 => null,
// 							24 => [
// 									'name' => 'Weaponmaster of Winter\'s Edge',
// 									'reign_limit' => 1,
// 									'rank' => 0,
// 									'is_active' => 1,
// 									'peerage' => 'None'
// 							],
// 							25 => [
// 									'name' => 'Weaponmaster',
// 									'reign_limit' => 1,
// 									'rank' => 0,
// 									'is_active' => 1,
// 									'peerage' => 'None'
// 							],
// 							27 => null,
// 							31 => null,
// 							36 => [
// 									'name' => 'Grand Warmaster',
// 									'reign_limit' => 1,
// 									'rank' => 0,
// 									'is_active' => 1,
// 									'peerage' => 'None'
// 							],
// 							38 => [
// 									'name' => 'Weaponmaster',
// 									'reign_limit' => 1,
// 									'rank' => 0,
// 									'is_active' => 1,
// 									'peerage' => 'None'
// 							]
// 					],
// 					'Dragonmaster' => [
// 							1 => null,
// 							3 => null,
// 							4 => [
// 									'name' => 'Dragonmaster',
// 									'reign_limit' => 1,
// 									'rank' => 0,
// 									'is_active' => 1,
// 									'peerage' => 'None'
// 							],
// 							5 => null,
// 							6 => [
// 									'name' => 'Dragonmaster',
// 									'reign_limit' => 1,
// 									'rank' => 0,
// 									'is_active' => 1,
// 									'peerage' => 'None'
// 							],
// 							7 => [
// 									'name' => 'Burning Lands Arts and Sciences Champion',
// 									'reign_limit' => 1,
// 									'rank' => 0,
// 									'is_active' => 1,
// 									'peerage' => 'None'
// 							],
// 							10 => null,
// 							11 => null,
// 							12 => [
// 									'name' => 'Dragonmaster',
// 									'reign_limit' => 1,
// 									'rank' => 0,
// 									'is_active' => 1,
// 									'peerage' => 'None'
// 							],
// 							14 => null,
// 							16 => [
// 									'name' => 'Arts and Sciences Champion',
// 									'reign_limit' => 1,
// 									'rank' => 0,
// 									'is_active' => 1,
// 									'peerage' => 'None'
// 							],
// 							17 => [
// 									'name' => 'Dragon Master',
// 									'reign_limit' => 1,
// 									'rank' => 0,
// 									'is_active' => 1,
// 									'peerage' => 'None'
// 							],
// 							18 => null,
// 							19 => [
// 									'name' => 'Dragonmaster',
// 									'reign_limit' => 1,
// 									'rank' => 0,
// 									'is_active' => 1,
// 									'peerage' => 'None'
// 							],
// 							20 => [
// 									'name' => 'Dragonmaster',
// 									'reign_limit' => 1,
// 									'rank' => 0,
// 									'is_active' => 1,
// 									'peerage' => 'None'
// 							],
// 							21 => [
// 									'name' => 'Dragonmaster',
// 									'reign_limit' => 1,
// 									'rank' => 0,
// 									'is_active' => 1,
// 									'peerage' => 'None'
// 							],
// 							22 => null,
// 							24 => [
// 									'name' => 'Dragonmaster of Winter\'s Edge',
// 									'reign_limit' => 1,
// 									'rank' => 0,
// 									'is_active' => 1,
// 									'peerage' => 'None'
// 							],
// 							25 => [
// 									'name' => 'Dragonmaster',
// 									'reign_limit' => 1,
// 									'rank' => 0,
// 									'is_active' => 1,
// 									'peerage' => 'None'
// 							],
// 							27 => null,
// 							31 => null,
// 							36 => [
// 									'name' => 'Cultural Champion',
// 									'reign_limit' => 1,
// 									'rank' => 0,
// 									'is_active' => 1,
// 									'peerage' => 'None'
// 							],
// 							38 => [
// 									'name' => 'Dragonmaster',
// 									'reign_limit' => 1,
// 									'rank' => 0,
// 									'is_active' => 1,
// 									'peerage' => 'None'
// 							]
// 					],
// 					'Ducal Defender' => [
// 							1 => [
// 									'name' => 'Ducal Defender',
// 									'reign_limit' => null,
// 									'rank' => 5,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							3 => null,
// 							4 => null,
// 							5 => null,
// 							6 => null,
// 							7 => null,
// 							10 => null,
// 							11 => null,
// 							12 => null,
// 							14 => null,
// 							16 => null,
// 							17 => null,
// 							18 => null,
// 							19 => null,
// 							20 => null,
// 							21 => null,
// 							22 => null,
// 							24 => null,
// 							25 => null,
// 							27 => null,
// 							31 => null,
// 							36 => null,
// 							38 => null
// 					],
// 					'Grand Ducal Defender' => [
// 							1 => [
// 									'name' => 'Grand Ducal Defender',
// 									'reign_limit' => null,
// 									'rank' => 5,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							3 => null,
// 							4 => null,
// 							5 => null,
// 							6 => null,
// 							7 => null,
// 							10 => null,
// 							11 => null,
// 							12 => null,
// 							14 => null,
// 							16 => null,
// 							17 => null,
// 							18 => null,
// 							19 => null,
// 							20 => null,
// 							21 => null,
// 							22 => null,
// 							24 => null,
// 							25 => null,
// 							27 => null,
// 							31 => null,
// 							36 => null,
// 							38 => null
// 					],
// 					'Defender' => [
// 							1 => [
// 									'name' => 'Defender',
// 									'reign_limit' => null,
// 									'rank' => 10,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							3 => [
// 									'name' => 'Defender',
// 									'reign_limit' => null,
// 									'rank' => 10,
// 									'is_active' => 1,
// 									'peerage' => 'None'
// 							],
// 							4 => [
// 									'name' => 'Defender',
// 									'reign_limit' => null,
// 									'rank' => 10,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							5 => [
// 									'name' => 'Defender',
// 									'reign_limit' => null,
// 									'rank' => 10,
// 									'is_active' => 1,
// 									'peerage' => 'Gentry'
// 							],
// 							6 => [
// 									'name' => 'Defender',
// 									'reign_limit' => null,
// 									'rank' => 10,
// 									'is_active' => 1,
// 									'peerage' => 'Gentry'
// 							],
// 							7 => [
// 									'name' => 'Defender',
// 									'reign_limit' => null,
// 									'rank' => 0,
// 									'is_active' => 1,
// 									'peerage' => 'Gentry'
// 							],
// 							10 => [
// 									'name' => 'Defender',
// 									'reign_limit' => null,
// 									'rank' => 10,
// 									'is_active' => 1,
// 									'peerage' => 'None'
// 							],
// 							11 => [
// 									'name' => 'Defender',
// 									'reign_limit' => null,
// 									'rank' => 10,
// 									'is_active' => 1,
// 									'peerage' => 'None'
// 							],
// 							12 => [
// 									'name' => 'Defender',
// 									'reign_limit' => null,
// 									'rank' => 10,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							14 => [
// 									'name' => 'Defender',
// 									'reign_limit' => null,
// 									'rank' => 10,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							16 => [
// 									'name' => 'Defender',
// 									'reign_limit' => null,
// 									'rank' => 0,
// 									'is_active' => 1,
// 									'peerage' => 'Gentry'
// 							],
// 							17 => [
// 									'name' => 'Defender',
// 									'reign_limit' => null,
// 									'rank' => 10,
// 									'is_active' => 1,
// 									'peerage' => 'Gentry'
// 							],
// 							18 => [
// 									'name' => 'Defender',
// 									'reign_limit' => null,
// 									'rank' => 10,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							19 => [
// 									'name' => 'Defender',
// 									'reign_limit' => null,
// 									'rank' => 10,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							20 => [
// 									'name' => 'Defender',
// 									'reign_limit' => null,
// 									'rank' => 0,
// 									'is_active' => 1,
// 									'peerage' => 'Gentry'
// 							],
// 							21 => [
// 									'name' => 'Defender',
// 									'reign_limit' => null,
// 									'rank' => 10,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							22 => [
// 									'name' => 'Defender',
// 									'reign_limit' => null,
// 									'rank' => 10,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							24 => [
// 									'name' => 'Defender',
// 									'reign_limit' => null,
// 									'rank' => 10,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							25 => [
// 									'name' => 'Defender',
// 									'reign_limit' => null,
// 									'rank' => 10,
// 									'is_active' => 1,
// 									'peerage' => 'None'
// 							],
// 							27 => [
// 									'name' => 'Defender',
// 									'reign_limit' => null,
// 									'rank' => 10,
// 									'is_active' => 1,
// 									'peerage' => 'None'
// 							],
// 							31 => [
// 									'name' => 'Defender',
// 									'reign_limit' => null,
// 									'rank' => 10,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							36 => [
// 									'name' => 'Defender',
// 									'reign_limit' => null,
// 									'rank' => 10,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							38 => null
// 					],
// 					'Steward' => [
// 							1 => null,
// 							3 => null,
// 							4 => null,
// 							5 => null,
// 							6 => null,
// 							7 => null,
// 							10 => null,
// 							11 => null,
// 							12 => null,
// 							14 => null,
// 							16 => null,
// 							17 => null,
// 							18 => null,
// 							19 => null,
// 							20 => null,
// 							21 => [
// 									'name' => 'Steward',
// 									'reign_limit' => null,
// 									'rank' => 5,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							22 => null,
// 							24 => null,
// 							25 => null,
// 							27 => null,
// 							31 => null,
// 							36 => null,
// 							38 => null
// 					],
// 					'Protector' => [
// 							1 => null,
// 							3 => null,
// 							4 => null,
// 							5 => null,
// 							6 => [
// 									'name' => 'Protector',
// 									'reign_limit' => null,
// 									'rank' => 5,
// 									'is_active' => 1,
// 									'peerage' => 'Gentry'
// 							],
// 							7 => null,
// 							10 => null,
// 							11 => null,
// 							12 => null,
// 							14 => null,
// 							16 => null,
// 							17 => null,
// 							18 => [
// 									'name' => 'Protector',
// 									'reign_limit' => null,
// 									'rank' => 5,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							19 => null,
// 							20 => null,
// 							21 => null,
// 							22 => null,
// 							24 => null,
// 							25 => null,
// 							27 => null,
// 							31 => null,
// 							36 => null,
// 							38 => null
// 					],
// 					'Dragonrider' => [
// 							1 => null,
// 							3 => null,
// 							4 => null,
// 							5 => null,
// 							6 => null,
// 							7 => null,
// 							10 => null,
// 							11 => null,
// 							12 => [
// 									'name' => 'Dragonrider',
// 									'reign_limit' => null,
// 									'rank' => 0,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							14 => null,
// 							16 => null,
// 							17 => null,
// 							18 => null,
// 							19 => null,
// 							20 => null,
// 							21 => null,
// 							22 => null,
// 							24 => null,
// 							25 => null,
// 							27 => null,
// 							31 => null,
// 							36 => null,
// 							38 => null
// 					],
// 					'Esquire' => [
// 							1 => null,
// 							3 => null,
// 							4 => [
// 									'name' => 'Esquire',
// 									'reign_limit' => null,
// 									'rank' => 5,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							5 => [
// 									'name' => 'Esquire',
// 									'reign_limit' => null,
// 									'rank' => 5,
// 									'is_active' => 1,
// 									'peerage' => 'Gentry'
// 							],
// 							6 => [
// 									'name' => 'Esquire',
// 									'reign_limit' => null,
// 									'rank' => 5,
// 									'is_active' => 1,
// 									'peerage' => 'Gentry'
// 							],
// 							7 => [
// 									'name' => 'Esquire',
// 									'reign_limit' => null,
// 									'rank' => 5,
// 									'is_active' => 1,
// 									'peerage' => 'Gentry'
// 							],
// 							10 => [
// 									'name' => 'Esquire',
// 									'reign_limit' => null,
// 									'rank' => 5,
// 									'is_active' => 1,
// 									'peerage' => 'Gentry'
// 							],
// 							11 => [
// 									'name' => 'Esquire',
// 									'reign_limit' => null,
// 									'rank' => 5,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							12 => null,
// 							14 => null,
// 							16 => [
// 									'name' => 'Esquire',
// 									'reign_limit' => null,
// 									'rank' => 5,
// 									'is_active' => 1,
// 									'peerage' => 'Gentry'
// 							],
// 							17 => [
// 									'name' => 'Esquire',
// 									'reign_limit' => null,
// 									'rank' => 5,
// 									'is_active' => 1,
// 									'peerage' => 'Gentry'
// 							],
// 							18 => [
// 									'name' => 'Esquire',
// 									'reign_limit' => null,
// 									'rank' => 5,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							19 => [
// 									'name' => 'Esquire',
// 									'reign_limit' => null,
// 									'rank' => 5,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							20 => [
// 									'name' => 'Esquire',
// 									'reign_limit' => null,
// 									'rank' => 5,
// 									'is_active' => 1,
// 									'peerage' => 'Gentry'
// 							],
// 							21 => null,
// 							22 => null,
// 							24 => [
// 									'name' => 'Esquire',
// 									'reign_limit' => null,
// 									'rank' => 5,
// 									'is_active' => 1,
// 									'peerage' => 'Gentry'
// 							],
// 							25 => [
// 									'name' => 'Esquire',
// 									'reign_limit' => null,
// 									'rank' => 5,
// 									'is_active' => 1,
// 									'peerage' => 'Gentry'
// 							],
// 							27 => null,
// 							31 => [
// 									'name' => 'Esquire',
// 									'reign_limit' => null,
// 									'rank' => 5,
// 									'is_active' => 1,
// 									'peerage' => 'Gentry'
// 							],
// 							36 => null,
// 							38 => [
// 									'name' => 'Esquire',
// 									'reign_limit' => null,
// 									'rank' => 5,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							]
// 					],
// 					'Master' => [
// 							1 => null,
// 							3 => null,
// 							4 => [
// 									'name' => 'Master|Mistress',
// 									'reign_limit' => null,
// 									'rank' => 5,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							5 => [
// 									'name' => 'Master',
// 									'reign_limit' => null,
// 									'rank' => 5,
// 									'is_active' => 1,
// 									'peerage' => 'Gentry'
// 							],
// 							6 => null,
// 							7 => [
// 									'name' => 'Master',
// 									'reign_limit' => null,
// 									'rank' => 5,
// 									'is_active' => 1,
// 									'peerage' => 'Gentry'
// 							],
// 							10 => [
// 									'name' => 'Master',
// 									'reign_limit' => null,
// 									'rank' => 5,
// 									'is_active' => 1,
// 									'peerage' => 'Gentry'
// 							],
// 							11 => null,
// 							12 => null,
// 							14 => null,
// 							16 => [
// 									'name' => 'Master',
// 									'reign_limit' => null,
// 									'rank' => 5,
// 									'is_active' => 1,
// 									'peerage' => 'Gentry'
// 							],
// 							17 => [
// 									'name' => 'Master',
// 									'reign_limit' => null,
// 									'rank' => 5,
// 									'is_active' => 1,
// 									'peerage' => 'Gentry'
// 							],
// 							18 => null,
// 							19 => [
// 									'name' => 'Master',
// 									'reign_limit' => null,
// 									'rank' => 5,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							20 => [
// 									'name' => 'Master',
// 									'reign_limit' => null,
// 									'rank' => 5,
// 									'is_active' => 1,
// 									'peerage' => 'Gentry'
// 							],
// 							21 => null,
// 							22 => null,
// 							24 => [
// 									'name' => 'Master of the Court|Mistress of the Court',
// 									'reign_limit' => null,
// 									'rank' => 5,
// 									'is_active' => 1,
// 									'peerage' => 'Gentry'
// 							],
// 							25 => [
// 									'name' => 'Master',
// 									'reign_limit' => null,
// 									'rank' => 5,
// 									'is_active' => 1,
// 									'peerage' => 'Gentry'
// 							],
// 							27 => null,
// 							31 => [
// 									'name' => 'Master',
// 									'reign_limit' => null,
// 									'rank' => 5,
// 									'is_active' => 1,
// 									'peerage' => 'Gentry'
// 							],
// 							36 => null,
// 							38 => [
// 									'name' => 'Master',
// 									'reign_limit' => null,
// 									'rank' => 5,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							]
// 					],
// 					'Lord' => [
// 							1 => [
// 									'name' => 'Lord|Lady',
// 									'reign_limit' => null,
// 									'rank' => 30,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							3 => [
// 									'name' => 'Lord|Lady',
// 									'reign_limit' => null,
// 									'rank' => 30,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							4 => [
// 									'name' => 'Lord|Lady',
// 									'reign_limit' => null,
// 									'rank' => 30,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							5 => [
// 									'name' => 'Lord|Lady',
// 									'reign_limit' => null,
// 									'rank' => 30,
// 									'is_active' => 1,
// 									'peerage' => 'Gentry'
// 							],
// 							6 => [
// 									'name' => 'Lord|Lady',
// 									'reign_limit' => null,
// 									'rank' => 30,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							7 => [
// 									'name' => 'Lord|Lady',
// 									'reign_limit' => null,
// 									'rank' => 30,
// 									'is_active' => 1,
// 									'peerage' => 'Gentry'
// 							],
// 							10 => [
// 									'name' => 'Lord|Lady',
// 									'reign_limit' => null,
// 									'rank' => 30,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							11 => [
// 									'name' => 'Lord|Lady',
// 									'reign_limit' => null,
// 									'rank' => 30,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							12 => [
// 									'name' => 'Lady|Lord',
// 									'reign_limit' => null,
// 									'rank' => 30,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							14 => [
// 									'name' => 'Lord|Lady',
// 									'reign_limit' => null,
// 									'rank' => 30,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							16 => [
// 									'name' => 'Lord|Lady',
// 									'reign_limit' => null,
// 									'rank' => 30,
// 									'is_active' => 1,
// 									'peerage' => 'Gentry'
// 							],
// 							17 => [
// 									'name' => 'Lord|Lady',
// 									'reign_limit' => null,
// 									'rank' => 30,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							18 => [
// 									'name' => 'Lord|Lady',
// 									'reign_limit' => null,
// 									'rank' => 30,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							19 => [
// 									'name' => 'Lord|Lady',
// 									'reign_limit' => null,
// 									'rank' => 30,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							20 => [
// 									'name' => 'Lord|Lady',
// 									'reign_limit' => null,
// 									'rank' => 30,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							21 => [
// 									'name' => 'Lord|Lady|Noble',
// 									'reign_limit' => null,
// 									'rank' => 30,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							22 => [
// 									'name' => 'Lord|Lady',
// 									'reign_limit' => null,
// 									'rank' => 30,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							24 => [
// 									'name' => 'Lord|Lady',
// 									'reign_limit' => null,
// 									'rank' => 30,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							25 => [
// 									'name' => 'Lord|Lady',
// 									'reign_limit' => null,
// 									'rank' => 30,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							27 => [
// 									'name' => 'Lord|Lady',
// 									'reign_limit' => null,
// 									'rank' => 30,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							31 => [
// 									'name' => 'Lord|Lady',
// 									'reign_limit' => null,
// 									'rank' => 30,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							36 => [
// 									'name' => 'Lord|Lady',
// 									'reign_limit' => null,
// 									'rank' => 30,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							38 => [
// 									'name' => 'Liege',
// 									'reign_limit' => null,
// 									'rank' => 30,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							]
// 					],
// 					'Baronet' => [
// 							1 => [
// 									'name' => 'Baronet',
// 									'reign_limit' => null,
// 									'rank' => 40,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							3 => [
// 									'name' => 'Baronet',
// 									'reign_limit' => null,
// 									'rank' => 40,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							4 => [
// 									'name' => 'Baronet|Baronetess',
// 									'reign_limit' => null,
// 									'rank' => 40,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							5 => [
// 									'name' => 'Baronet',
// 									'reign_limit' => null,
// 									'rank' => 40,
// 									'is_active' => 1,
// 									'peerage' => 'Gentry'
// 							],
// 							6 => [
// 									'name' => 'Baronet',
// 									'reign_limit' => null,
// 									'rank' => 40,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							7 => [
// 									'name' => 'Baronet',
// 									'reign_limit' => null,
// 									'rank' => 40,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							10 => [
// 									'name' => 'Baronet',
// 									'reign_limit' => null,
// 									'rank' => 40,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							11 => [
// 									'name' => 'Baronet',
// 									'reign_limit' => null,
// 									'rank' => 40,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							12 => [
// 									'name' => 'Baronetess|Baronet',
// 									'reign_limit' => null,
// 									'rank' => 40,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							14 => [
// 									'name' => 'Baronet',
// 									'reign_limit' => null,
// 									'rank' => 40,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							16 => [
// 									'name' => 'Baronet',
// 									'reign_limit' => null,
// 									'rank' => 40,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							17 => [
// 									'name' => 'Baronet|Baronetess',
// 									'reign_limit' => null,
// 									'rank' => 40,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							18 => [
// 									'name' => 'Baronet',
// 									'reign_limit' => null,
// 									'rank' => 40,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							19 => [
// 									'name' => 'Baronet',
// 									'reign_limit' => null,
// 									'rank' => 40,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							20 => [
// 									'name' => 'Baronet',
// 									'reign_limit' => null,
// 									'rank' => 40,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							21 => [
// 									'name' => 'Baronet|Baronetess|Constable',
// 									'reign_limit' => null,
// 									'rank' => 40,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							22 => [
// 									'name' => 'Baronet',
// 									'reign_limit' => null,
// 									'rank' => 40,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							24 => [
// 									'name' => 'Baronet|Baronetess',
// 									'reign_limit' => null,
// 									'rank' => 40,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							25 => [
// 									'name' => 'Baronet|Baronetess',
// 									'reign_limit' => null,
// 									'rank' => 40,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							27 => [
// 									'name' => 'Baronet',
// 									'reign_limit' => null,
// 									'rank' => 40,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							31 => [
// 									'name' => 'Baronet',
// 									'reign_limit' => null,
// 									'rank' => 40,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							36 => [
// 									'name' => 'Baronet|Baronetess',
// 									'reign_limit' => null,
// 									'rank' => 40,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							38 => [
// 									'name' => 'Baronetex',
// 									'reign_limit' => null,
// 									'rank' => 40,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							]
// 					],
// 					'Baron' => [
// 							1 => [
// 									'name' => 'Baron|Baroness',
// 									'reign_limit' => null,
// 									'rank' => 50,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							3 => [
// 									'name' => 'Baron|Baroness',
// 									'reign_limit' => null,
// 									'rank' => 50,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							4 => [
// 									'name' => 'Baron|Baroness',
// 									'reign_limit' => null,
// 									'rank' => 50,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							5 => [
// 									'name' => 'Baron',
// 									'reign_limit' => null,
// 									'rank' => 50,
// 									'is_active' => 1,
// 									'peerage' => 'Gentry'
// 							],
// 							6 => [
// 									'name' => 'Baron|Baroness',
// 									'reign_limit' => null,
// 									'rank' => 50,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							7 => [
// 									'name' => 'Baron|Baroness',
// 									'reign_limit' => null,
// 									'rank' => 50,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							10 => [
// 									'name' => 'Baron|Baroness',
// 									'reign_limit' => null,
// 									'rank' => 50,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							11 => [
// 									'name' => 'Baron|Baroness',
// 									'reign_limit' => null,
// 									'rank' => 50,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							12 => [
// 									'name' => 'Baroness|Baron',
// 									'reign_limit' => null,
// 									'rank' => 50,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							14 => [
// 									'name' => 'Baron|Baroness',
// 									'reign_limit' => null,
// 									'rank' => 50,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							16 => [
// 									'name' => 'Baron|Baroness',
// 									'reign_limit' => null,
// 									'rank' => 50,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							17 => [
// 									'name' => 'Baron|Baroness',
// 									'reign_limit' => null,
// 									'rank' => 50,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							18 => [
// 									'name' => 'Baron|Baroness',
// 									'reign_limit' => null,
// 									'rank' => 50,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							19 => [
// 									'name' => 'Baron|Baroness',
// 									'reign_limit' => null,
// 									'rank' => 50,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							20 => [
// 									'name' => 'Baron|Baroness',
// 									'reign_limit' => null,
// 									'rank' => 50,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							21 => [
// 									'name' => 'Baron|Baroness|Viceroy',
// 									'reign_limit' => null,
// 									'rank' => 50,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							22 => [
// 									'name' => 'Baron|Baroness',
// 									'reign_limit' => null,
// 									'rank' => 50,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							24 => [
// 									'name' => 'Baron|Baroness',
// 									'reign_limit' => null,
// 									'rank' => 50,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							25 => [
// 									'name' => 'Baron|Baroness',
// 									'reign_limit' => null,
// 									'rank' => 50,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							27 => [
// 									'name' => 'Baron|Baroness',
// 									'reign_limit' => null,
// 									'rank' => 50,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							31 => [
// 									'name' => 'Baron',
// 									'reign_limit' => null,
// 									'rank' => 50,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							36 => [
// 									'name' => 'Baron|Baroness',
// 									'reign_limit' => null,
// 									'rank' => 50,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							38 => [
// 									'name' => 'Baronex',
// 									'reign_limit' => null,
// 									'rank' => 50,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							]
// 					],
// 					'Viscount' => [
// 							1 => [
// 									'name' => 'Viscount|Viscountess',
// 									'reign_limit' => null,
// 									'rank' => 60,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							3 => [
// 									'name' => 'Viscount|Viscountess',
// 									'reign_limit' => null,
// 									'rank' => 60,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							4 => [
// 									'name' => 'Viscount|Viscountess',
// 									'reign_limit' => null,
// 									'rank' => 60,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							5 => [
// 									'name' => 'Viscount',
// 									'reign_limit' => null,
// 									'rank' => 60,
// 									'is_active' => 1,
// 									'peerage' => 'Gentry'
// 							],
// 							6 => [
// 									'name' => 'Viscount|Viscountess',
// 									'reign_limit' => null,
// 									'rank' => 60,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							7 => [
// 									'name' => 'Viscount|Viscountess',
// 									'reign_limit' => null,
// 									'rank' => 60,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							10 => [
// 									'name' => 'Viscount|Viscountess',
// 									'reign_limit' => null,
// 									'rank' => 60,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							11 => [
// 									'name' => 'Viscount|Viscountess',
// 									'reign_limit' => null,
// 									'rank' => 60,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							12 => [
// 									'name' => 'Viscountess|Viscount',
// 									'reign_limit' => null,
// 									'rank' => 60,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							14 => [
// 									'name' => 'Viscount|Viscountess',
// 									'reign_limit' => null,
// 									'rank' => 60,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							16 => [
// 									'name' => 'Viscount|Viscountess',
// 									'reign_limit' => null,
// 									'rank' => 60,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							17 => [
// 									'name' => 'Viscount|Viscountess',
// 									'reign_limit' => null,
// 									'rank' => 60,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							18 => [
// 									'name' => 'Viscount|Viscountess',
// 									'reign_limit' => null,
// 									'rank' => 60,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							19 => [
// 									'name' => 'Viscount|Viscountess',
// 									'reign_limit' => null,
// 									'rank' => 60,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							20 => [
// 									'name' => 'Viscount|Viscountess',
// 									'reign_limit' => null,
// 									'rank' => 60,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							21 => [
// 									'name' => 'Viscount|Viscountess|Vicarius',
// 									'reign_limit' => null,
// 									'rank' => 60,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							22 => [
// 									'name' => 'Viscount|Viscountess',
// 									'reign_limit' => null,
// 									'rank' => 60,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							24 => [
// 									'name' => 'Viscount|Viscountess',
// 									'reign_limit' => null,
// 									'rank' => 60,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							25 => [
// 									'name' => 'Viscount|Viscountess',
// 									'reign_limit' => null,
// 									'rank' => 60,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							27 => [
// 									'name' => 'Viscount|Viscountess',
// 									'reign_limit' => null,
// 									'rank' => 60,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							31 => [
// 									'name' => 'Viscount',
// 									'reign_limit' => null,
// 									'rank' => 60,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							36 => [
// 									'name' => 'Viscount|Viscountess',
// 									'reign_limit' => null,
// 									'rank' => 60,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							38 => [
// 									'name' => 'Viscountex',
// 									'reign_limit' => null,
// 									'rank' => 60,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							]
// 					],
// 					'Marquis' => [
// 							1 => [
// 									'name' => 'Marquis|Marquise',
// 									'reign_limit' => null,
// 									'rank' => 80,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							3 => [
// 									'name' => 'Marquis|Marquise',
// 									'reign_limit' => null,
// 									'rank' => 70,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							4 => [
// 									'name' => 'Marquis|Marquise',
// 									'reign_limit' => null,
// 									'rank' => 90,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							5 => [
// 									'name' => 'Marquis',
// 									'reign_limit' => null,
// 									'rank' => 90,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							6 => [
// 									'name' => 'Marquis|Marquise',
// 									'reign_limit' => null,
// 									'rank' => 70,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							7 => [
// 									'name' => 'Marquis|Marquise',
// 									'reign_limit' => null,
// 									'rank' => 70,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							10 => [
// 									'name' => 'Marquis|Marquise',
// 									'reign_limit' => null,
// 									'rank' => 80,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							11 => [
// 									'name' => 'Marquis|Marquise',
// 									'reign_limit' => null,
// 									'rank' => 80,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							12 => [
// 									'name' => 'Marquise|Marquis',
// 									'reign_limit' => null,
// 									'rank' => 70,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							14 => [
// 									'name' => 'Marquis|Marquise',
// 									'reign_limit' => null,
// 									'rank' => 70,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							16 => [
// 									'name' => 'Marquis|Marquise',
// 									'reign_limit' => null,
// 									'rank' => 70,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							17 => [
// 									'name' => 'Marquis|Marquise',
// 									'reign_limit' => null,
// 									'rank' => 70,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							18 => [
// 									'name' => 'Marquis|Marquise',
// 									'reign_limit' => null,
// 									'rank' => 70,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							19 => [
// 									'name' => 'Marquis|Marquise',
// 									'reign_limit' => null,
// 									'rank' => 70,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							20 => [
// 									'name' => 'Marquis',
// 									'reign_limit' => null,
// 									'rank' => 70,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							21 => [
// 									'name' => 'Marquess|Marchioness|Warden',
// 									'reign_limit' => null,
// 									'rank' => 80,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							22 => [
// 									'name' => 'Marquis|Marquise',
// 									'reign_limit' => null,
// 									'rank' => 70,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							24 => [
// 									'name' => 'Marquis|Marchioness',
// 									'reign_limit' => null,
// 									'rank' => 80,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							25 => [
// 									'name' => 'Marquis|Marquise',
// 									'reign_limit' => null,
// 									'rank' => 70,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							27 => [
// 									'name' => 'Marquis|Marquise',
// 									'reign_limit' => null,
// 									'rank' => 70,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							31 => [
// 									'name' => 'Marquis',
// 									'reign_limit' => null,
// 									'rank' => 70,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							36 => [
// 									'name' => 'Marquis|Marquise',
// 									'reign_limit' => null,
// 									'rank' => 70,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							38 => [
// 									'name' => 'Marquex',
// 									'reign_limit' => null,
// 									'rank' => 80,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							]
// 					],
// 					'Count' => [
// 							1 => [
// 									'name' => 'Count|Countess',
// 									'reign_limit' => null,
// 									'rank' => 70,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							3 => [
// 									'name' => 'Count|Countess',
// 									'reign_limit' => null,
// 									'rank' => 80,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							4 => [
// 									'name' => 'Count|Countess',
// 									'reign_limit' => null,
// 									'rank' => 70,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							5 => [
// 									'name' => 'Count',
// 									'reign_limit' => null,
// 									'rank' => 70,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							6 => [
// 									'name' => 'Count|Countess',
// 									'reign_limit' => null,
// 									'rank' => 80,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							7 => [
// 									'name' => 'Count|Countess',
// 									'reign_limit' => null,
// 									'rank' => 80,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							10 => [
// 									'name' => 'Count|Countess',
// 									'reign_limit' => null,
// 									'rank' => 70,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							11 => [
// 									'name' => 'Count|Countess',
// 									'reign_limit' => null,
// 									'rank' => 70,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							12 => [
// 									'name' => 'Countess|Count',
// 									'reign_limit' => null,
// 									'rank' => 80,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							14 => [
// 									'name' => 'Count|Countess',
// 									'reign_limit' => null,
// 									'rank' => 80,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							16 => [
// 									'name' => 'Count|Countess',
// 									'reign_limit' => null,
// 									'rank' => 80,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							17 => [
// 									'name' => 'Count|Countess',
// 									'reign_limit' => null,
// 									'rank' => 80,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							18 => [
// 									'name' => 'Count|Countess',
// 									'reign_limit' => null,
// 									'rank' => 80,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							19 => [
// 									'name' => 'Count|Countess',
// 									'reign_limit' => null,
// 									'rank' => 80,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							20 => [
// 									'name' => 'Count|Countess',
// 									'reign_limit' => null,
// 									'rank' => 80,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							21 => [
// 									'name' => 'Count|Countess|Castellan',
// 									'reign_limit' => null,
// 									'rank' => 70,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							22 => [
// 									'name' => 'Count|Countess|Jarl',
// 									'reign_limit' => null,
// 									'rank' => 80,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							24 => [
// 									'name' => 'Count|Countess',
// 									'reign_limit' => null,
// 									'rank' => 70,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							25 => [
// 									'name' => 'Count|Countess',
// 									'reign_limit' => null,
// 									'rank' => 80,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							27 => [
// 									'name' => 'Count|Countess',
// 									'reign_limit' => null,
// 									'rank' => 80,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							31 => [
// 									'name' => 'Count',
// 									'reign_limit' => null,
// 									'rank' => 80,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							36 => [
// 									'name' => 'Count|Countess',
// 									'reign_limit' => null,
// 									'rank' => 80,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							38 => [
// 									'name' => 'Countex',
// 									'reign_limit' => null,
// 									'rank' => 70,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							]
// 					],
// 					'Duke' => [
// 							1 => [
// 									'name' => 'Duke|Duchess',
// 									'reign_limit' => null,
// 									'rank' => 90,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							3 => [
// 									'name' => 'Duke|Duchess',
// 									'reign_limit' => null,
// 									'rank' => 90,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							4 => [
// 									'name' => 'Duke|Duchess',
// 									'reign_limit' => null,
// 									'rank' => 80,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							5 => [
// 									'name' => 'Duke',
// 									'reign_limit' => null,
// 									'rank' => 80,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							6 => [
// 									'name' => 'Duke|Duchess',
// 									'reign_limit' => null,
// 									'rank' => 90,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							7 => [
// 									'name' => 'Duke|Duchess',
// 									'reign_limit' => null,
// 									'rank' => 90,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							10 => [
// 									'name' => 'Duke|Duchess',
// 									'reign_limit' => null,
// 									'rank' => 90,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							11 => [
// 									'name' => 'Duke|Duchess',
// 									'reign_limit' => null,
// 									'rank' => 90,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							12 => [
// 									'name' => 'Duchess|Duke',
// 									'reign_limit' => null,
// 									'rank' => 90,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							14 => [
// 									'name' => 'Duke|Duchess',
// 									'reign_limit' => null,
// 									'rank' => 90,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							16 => [
// 									'name' => 'Duke|Duchess',
// 									'reign_limit' => null,
// 									'rank' => 90,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							17 => [
// 									'name' => 'Duke|Duchess',
// 									'reign_limit' => null,
// 									'rank' => 90,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							18 => [
// 									'name' => 'Duke|Duchess',
// 									'reign_limit' => null,
// 									'rank' => 90,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							19 => [
// 									'name' => 'Duke|Duchess',
// 									'reign_limit' => null,
// 									'rank' => 90,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							20 => [
// 									'name' => 'Duke|Duchess',
// 									'reign_limit' => null,
// 									'rank' => 90,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							21 => [
// 									'name' => 'Duke|Duchess|Dux',
// 									'reign_limit' => null,
// 									'rank' => 90,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							22 => [
// 									'name' => 'Duke|Duchess',
// 									'reign_limit' => null,
// 									'rank' => 90,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							24 => [
// 									'name' => 'Duke|Duchess',
// 									'reign_limit' => null,
// 									'rank' => 90,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							25 => [
// 									'name' => 'Duke|Duchess',
// 									'reign_limit' => null,
// 									'rank' => 90,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							27 => [
// 									'name' => 'Duke|Duchess',
// 									'reign_limit' => null,
// 									'rank' => 90,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							31 => [
// 									'name' => 'Duke',
// 									'reign_limit' => null,
// 									'rank' => 90,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							36 => [
// 									'name' => 'Duke|Duchess',
// 									'reign_limit' => null,
// 									'rank' => 90,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							38 => [
// 									'name' => 'Dux',
// 									'reign_limit' => null,
// 									'rank' => 90,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							]
// 					],
// 					'Archduke' => [
// 							1 => [
// 									'name' => 'Arch-Duke',
// 									'reign_limit' => null,
// 									'rank' => 100,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							3 => [
// 									'name' => 'Arch Duke|Arch Duchess',
// 									'reign_limit' => null,
// 									'rank' => 100,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							4 => [
// 									'name' => 'Arch Duke|Arch Duchess',
// 									'reign_limit' => null,
// 									'rank' => 100,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							5 => [
// 									'name' => 'ArchDuke',
// 									'reign_limit' => null,
// 									'rank' => 100,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							6 => [
// 									'name' => 'Arch-Duke|Arch-Duchess',
// 									'reign_limit' => null,
// 									'rank' => 100,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							7 => [
// 									'name' => 'Arch Duke',
// 									'reign_limit' => null,
// 									'rank' => 100,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							10 => [
// 									'name' => 'Archduke|Archduchess',
// 									'reign_limit' => null,
// 									'rank' => 100,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							11 => [
// 									'name' => 'Archduke|Archduchess',
// 									'reign_limit' => null,
// 									'rank' => 100,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							12 => [
// 									'name' => 'Archduchess|Archduke',
// 									'reign_limit' => null,
// 									'rank' => 100,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							14 => [
// 									'name' => 'Arch Duke|Arch Duchess',
// 									'reign_limit' => null,
// 									'rank' => 100,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							16 => [
// 									'name' => 'Arch Duke',
// 									'reign_limit' => null,
// 									'rank' => 100,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							17 => [
// 									'name' => 'Archduke|Archduchess',
// 									'reign_limit' => null,
// 									'rank' => 100,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							18 => [
// 									'name' => 'Arch Duke|Arch Duchess',
// 									'reign_limit' => null,
// 									'rank' => 100,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							19 => [
// 									'name' => 'Arch Duke|Arch Duchess',
// 									'reign_limit' => null,
// 									'rank' => 100,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							20 => [
// 									'name' => 'Arch Duke',
// 									'reign_limit' => null,
// 									'rank' => 100,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							21 => [
// 									'name' => 'Arch Duke|Arch Duchess|Arci Dux',
// 									'reign_limit' => null,
// 									'rank' => 100,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							22 => [
// 									'name' => 'Arch Duke|Arch Duchess',
// 									'reign_limit' => null,
// 									'rank' => 100,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							24 => [
// 									'name' => 'Archduke|Archduchess',
// 									'reign_limit' => null,
// 									'rank' => 100,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							25 => [
// 									'name' => 'Archduke|Archduchess',
// 									'reign_limit' => null,
// 									'rank' => 100,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							27 => [
// 									'name' => 'Arch Duke|Arch Duchess',
// 									'reign_limit' => null,
// 									'rank' => 100,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							31 => [
// 									'name' => 'Archduke',
// 									'reign_limit' => null,
// 									'rank' => 100,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							36 => [
// 									'name' => 'Arch Duke|Arch Duchess',
// 									'reign_limit' => null,
// 									'rank' => 100,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							38 => null
// 					],
// 					'Grand Duke' => [
// 							1 => [
// 									'name' => 'Grand Duke',
// 									'reign_limit' => null,
// 									'rank' => 110,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							3 => [
// 									'name' => 'Grand Duke|Grand Duchess',
// 									'reign_limit' => null,
// 									'rank' => 110,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							4 => [
// 									'name' => 'Grand Duke|Grand Duchess',
// 									'reign_limit' => null,
// 									'rank' => 110,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							5 => [
// 									'name' => 'Grand Duke',
// 									'reign_limit' => null,
// 									'rank' => 110,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							6 => [
// 									'name' => 'Grand-Duke|Grand-Duchess',
// 									'reign_limit' => null,
// 									'rank' => 110,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							7 => [
// 									'name' => 'Grand Duke',
// 									'reign_limit' => null,
// 									'rank' => 110,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							10 => [
// 									'name' => 'Grand Duke|Grand Duchess',
// 									'reign_limit' => null,
// 									'rank' => 110,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							11 => [
// 									'name' => 'Grand Duke|Grand Duchess',
// 									'reign_limit' => null,
// 									'rank' => 110,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							12 => [
// 									'name' => 'Grand Duchess|Grand Duke',
// 									'reign_limit' => null,
// 									'rank' => 110,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							14 => [
// 									'name' => 'Grand Duke|Grand Duchess',
// 									'reign_limit' => null,
// 									'rank' => 110,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							16 => [
// 									'name' => 'Grand Duke',
// 									'reign_limit' => null,
// 									'rank' => 110,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							17 => [
// 									'name' => 'Grand Duke|Grand Duchess',
// 									'reign_limit' => null,
// 									'rank' => 110,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							18 => [
// 									'name' => 'Grand Duke|Grand Duchess',
// 									'reign_limit' => null,
// 									'rank' => 110,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							19 => [
// 									'name' => 'Grand Duke|Grand Duchess',
// 									'reign_limit' => null,
// 									'rank' => 110,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							20 => [
// 									'name' => 'Grand Duke',
// 									'reign_limit' => null,
// 									'rank' => 110,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							21 => [
// 									'name' => 'Grand Duke|Grand Duchess|Magnus Dux',
// 									'reign_limit' => null,
// 									'rank' => 110,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							22 => [
// 									'name' => 'Grand Duke|Grand Duchess',
// 									'reign_limit' => null,
// 									'rank' => 110,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							24 => [
// 									'name' => 'Grand Duke|Grand Duchess',
// 									'reign_limit' => null,
// 									'rank' => 110,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							25 => [
// 									'name' => 'Grand Duke|Grand Duchess',
// 									'reign_limit' => null,
// 									'rank' => 110,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							27 => [
// 									'name' => 'Grand Duke|Grand Duchess',
// 									'reign_limit' => null,
// 									'rank' => 110,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							31 => [
// 									'name' => 'Grand Duke',
// 									'reign_limit' => null,
// 									'rank' => 110,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							36 => [
// 									'name' => 'Grand Duke|Grand Duchess',
// 									'reign_limit' => null,
// 									'rank' => 110,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							38 => null
// 					],
// 					'Grand Marquis' => [
// 							1 => null,
// 							3 => null,
// 							4 => [
// 									'name' => 'Grand Marquis|Grand Marquise',
// 									'reign_limit' => null,
// 									'rank' => 120,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							5 => [
// 									'name' => 'Grand Marquis',
// 									'reign_limit' => null,
// 									'rank' => 120,
// 									'is_active' => 1,
// 									'peerage' => 'Nobility'
// 							],
// 							6 => null,
// 							7 => null,
// 							10 => null,
// 							11 => null,
// 							12 => null,
// 							14 => null,
// 							16 => null,
// 							17 => null,
// 							18 => null,
// 							19 => null,
// 							20 => null,
// 							21 => null,
// 							22 => null,
// 							24 => null,
// 							25 => null,
// 							27 => null,
// 							31 => null,
// 							36 => null,
// 							38 => null
// 					],
// 					'Warmaster' => [
// 							1 => null,
// 							3 => null,
// 							4 => [
// 									'name' => 'Warmaster',
// 									'reign_limit' => 1,
// 									'rank' => 0,
// 									'is_active' => 1,
// 									'peerage' => 'None'
// 							],
// 							5 => null,
// 							6 => [
// 									'name' => 'Warmaster',
// 									'reign_limit' => 1,
// 									'rank' => 0,
// 									'is_active' => 1,
// 									'peerage' => 'None'
// 							],
// 							7 => null,
// 							10 => null,
// 							11 => null,
// 							12 => [
// 									'name' => 'Warmaster',
// 									'reign_limit' => 1,
// 									'rank' => 0,
// 									'is_active' => 1,
// 									'peerage' => 'None'
// 							],
// 							14 => null,
// 							16 => [
// 									'name' => 'Warmaster',
// 									'reign_limit' => 1,
// 									'rank' => 0,
// 									'is_active' => 1,
// 									'peerage' => 'None'
// 							],
// 							17 => null,
// 							18 => null,
// 							19 => [
// 									'name' => 'Warmaster',
// 									'reign_limit' => 1,
// 									'rank' => 0,
// 									'is_active' => 1,
// 									'peerage' => 'None'
// 							],
// 							20 => null,
// 							21 => [
// 									'name' => 'Warmaster',
// 									'reign_limit' => 1,
// 									'rank' => 0,
// 									'is_active' => 1,
// 									'peerage' => 'None'
// 							],
// 							22 => null,
// 							24 => null,
// 							25 => null,
// 							27 => null,
// 							31 => null,
// 							36 => null,
// 							38 => null
// 					],
// 					'Weigher of the Scales' => [
// 							1 => null,
// 							3 => [
// 									'name' => 'Weigher of the Scales',
// 									'reign_limit' => null,
// 									'rank' => 5,
// 									'is_active' => 1,
// 									'peerage' => 'None'
// 							],
// 							4 => null,
// 							5 => null,
// 							6 => null,
// 							7 => null,
// 							10 => null,
// 							11 => null,
// 							12 => null,
// 							14 => null,
// 							16 => null,
// 							17 => null,
// 							18 => null,
// 							19 => null,
// 							20 => null,
// 							21 => null,
// 							22 => null,
// 							24 => null,
// 							25 => null,
// 							27 => null,
// 							31 => null,
// 							36 => null,
// 							38 => null
// 					],
// 					'Dreamkeeper' => [
// 							1 => null,
// 							3 => null,
// 							4 => [
// 									'name' => 'Dreamkeeper',
// 									'reign_limit' => null,
// 									'rank' => 10,
// 									'is_active' => 1,
// 									'peerage' => 'None'
// 							],
// 							5 => null,
// 							6 => [
// 									'name' => 'Master Dreamkeeper',
// 									'reign_limit' => null,
// 									'rank' => 10,
// 									'is_active' => 1,
// 									'peerage' => 'Master'
// 							],
// 							7 => null,
// 							10 => [
// 									'name' => 'Dreamkeeper',
// 									'reign_limit' => null,
// 									'rank' => 10,
// 									'is_active' => 1,
// 									'peerage' => 'None'
// 							],
// 							11 => null,
// 							12 => null,
// 							14 => null,
// 							16 => null,
// 							17 => null,
// 							18 => null,
// 							19 => null,
// 							20 => null,
// 							21 => null,
// 							22 => null,
// 							24 => null,
// 							25 => null,
// 							27 => [
// 									'name' => 'Dreamkeeper',
// 									'reign_limit' => null,
// 									'rank' => 10,
// 									'is_active' => 1,
// 									'peerage' => 'None'
// 							],
// 							31 => [
// 									'name' => 'Dreamkeeper',
// 									'reign_limit' => null,
// 									'rank' => 10,
// 									'is_active' => 1,
// 									'peerage' => 'None'
// 							],
// 							36 => null,
// 							38 => null
// 					],
// 					'Master Roach' => [
// 							1 => null,
// 							3 => null,
// 							4 => null,
// 							5 => null,
// 							6 => null,
// 							7 => null,
// 							10 => null,
// 							11 => null,
// 							12 => null,
// 							14 => null,
// 							16 => null,
// 							17 => null,
// 							18 => [
// 									'name' => 'Master Roach',
// 									'reign_limit' => null,
// 									'rank' => 10,
// 									'is_active' => 1,
// 									'peerage' => 'Master'
// 							],
// 							19 => null,
// 							20 => null,
// 							21 => null,
// 							22 => null,
// 							24 => null,
// 							25 => null,
// 							27 => null,
// 							31 => null,
// 							36 => null,
// 							38 => null
// 					],
// 					'Master Mantis' => [
// 							1 => null,
// 							3 => null,
// 							4 => null,
// 							5 => null,
// 							6 => null,
// 							7 => null,
// 							10 => null,
// 							11 => null,
// 							12 => null,
// 							14 => null,
// 							16 => null,
// 							17 => null,
// 							18 => [
// 									'name' => 'Master Mantis',
// 									'reign_limit' => null,
// 									'rank' => 10,
// 									'is_active' => 1,
// 									'peerage' => 'Master'
// 							],
// 							19 => null,
// 							20 => null,
// 							21 => null,
// 							22 => null,
// 							24 => null,
// 							25 => null,
// 							27 => null,
// 							31 => null,
// 							36 => null,
// 							38 => null
// 					],
// 					'Cultural Olympian' => [
// 							1 => null,
// 							3 => null,
// 							4 => null,
// 							5 => null,
// 							6 => null,
// 							7 => null,
// 							10 => null,
// 							11 => null,
// 							12 => null,
// 							14 => null,
// 							16 => null,
// 							17 => null,
// 							18 => null,
// 							19 => null,
// 							20 => null,
// 							21 => null,
// 							22 => null,
// 							24 => null,
// 							25 => null,
// 							27 => null,
// 							31 => null,
// 							36 => null,
// 							38 => null
// 					],
// 					'Grand Olympian' => [
// 							1 => null,
// 							3 => null,
// 							4 => null,
// 							5 => null,
// 							6 => null,
// 							7 => null,
// 							10 => null,
// 							11 => null,
// 							12 => null,
// 							14 => null,
// 							16 => null,
// 							17 => null,
// 							18 => null,
// 							19 => null,
// 							20 => null,
// 							21 => null,
// 							22 => null,
// 							24 => null,
// 							25 => null,
// 							27 => null,
// 							31 => null,
// 							36 => null,
// 							38 => null
// 					],
// 					'War Event Winner' => [
// 							1 => null,
// 							3 => null,
// 							4 => null,
// 							5 => null,
// 							6 => null,
// 							7 => null,
// 							10 => null,
// 							11 => null,
// 							12 => null,
// 							14 => null,
// 							16 => null,
// 							17 => null,
// 							18 => null,
// 							19 => null,
// 							20 => null,
// 							21 => null,
// 							22 => null,
// 							24 => null,
// 							25 => null,
// 							27 => null,
// 							31 => null,
// 							36 => null,
// 							38 => null
// 					],
// 					'War Olympian' => [
// 							1 => null,
// 							3 => null,
// 							4 => null,
// 							5 => null,
// 							6 => null,
// 							7 => null,
// 							10 => null,
// 							11 => null,
// 							12 => null,
// 							14 => null,
// 							16 => null,
// 							17 => null,
// 							18 => null,
// 							19 => null,
// 							20 => null,
// 							21 => null,
// 							22 => null,
// 							24 => null,
// 							25 => null,
// 							27 => null,
// 							31 => null,
// 							36 => null,
// 							38 => null
// 					]
// 			];
			
// 			$knownKingdomParklevelsOffices = [
// 					1 => [
// 							'Kingdom' => [
// 									'Monarch' => [
// 											'duration' => 6,
// 											'order' => 1,
// 											'title' => 'Duke|Duchess'
// 									],
// 									'Regent' => [
// 											'duration' => 6,
// 											'order' => 4,
// 											'title' => 'Count|Countess'
// 									],
// 									'Prime Minister' => [
// 											'duration' => 6,
// 											'order' => 2,
// 											'title' => 'Baron|Baroness'
// 									],
// 									'Champion' => [
// 											'duration' => 6,
// 											'order' => 3,
// 											'title' => 'Defender'
// 									],
// 									'Guildmaster of Knights' => [
// 											'duration' => 6
// 									],
// 									'Guildmaster of Reeves' => [
// 											'duration' => 6,
// 											'order' => 5
// 									],
// 									'Board of Directors Chief Executive Officer' => [
// 											'duration' => 6
// 									],
// 									'Board of Directors Chief Financial Officer' => [
// 											'duration' => 6
// 									],
// 									'Board of Directors Secretary' => [
// 											'duration' => 6
// 									],
// 									'Board of Directors Kingdom Quartermaster' => [
// 											'duration' => 6
// 									],
// 									'Board of Directors Member' => [
// 											'duration' => 12
// 									],
// 									'Royal Guard' => [
// 											'duration' => 6
// 									],
// 									'Captain of the Guard' => [
// 											'duration' => 6
// 									],
// 									'Regent\'s Defender' => [
// 											'duration' => 6
// 									],
// 									'Guildmaster of [Class]' => [
// 											'duration' => 6
// 									]
// 							],
// 							'Outpost' => [
// 									'Sheriff' => [
// 											'duration' => 6,
// 											'order' => 1
// 									],
// 									'Clerk' => [
// 											'duration' => 6,
// 											'order' => 2
// 									]
// 							],
// 							'Shire' => [
// 									'Sheriff' => [
// 											'duration' => 6,
// 											'order' => 1
// 									],
// 									'Shire Regent' => [
// 											'duration' => 6,
// 											'order' => 4
// 									],
// 									'Clerk' => [
// 											'duration' => 6,
// 											'order' => 2
// 									]
// 							],
// 							'Barony' => [
// 									'Baron|Baroness' => [
// 											'duration' => 6,
// 											'order' => 1,
// 											'title' => 'Baronet'
// 									],
// 									'Baronial Regent' => [
// 											'duration' => 6,
// 											'order' => 4
// 									],
// 									'Seneschal' => [
// 											'duration' => 6,
// 											'order' => 2
// 									]
// 							],
// 							'Duchy' => [
// 									'Duke|Duchess' => [
// 											'duration' => 6,
// 											'order' => 1,
// 											'title' => 'Baron|Baroness'
// 									],
// 									'Ducal Regent' => [
// 											'duration' => 6,
// 											'order' => 4
// 									],
// 									'Chancellor' => [
// 											'duration' => 6,
// 											'order' => 2,
// 											'title' => 'Lord|Lady'
// 									],
// 									'Ducal Defender' => [
// 											'duration' => 6,
// 											'order' => 3
// 									]
// 							],
// 							'Grand Duchy' => [
// 									'Grand Duke|Grand Duchess' => [
// 											'duration' => 6,
// 											'order' => 1,
// 											'title' => 'Count|Countess'
// 									],
// 									'Grand Ducal Regent' => [
// 											'duration' => 6,
// 											'order' => 4,
// 											'title' => 'Baron|Baroness'
// 									],
// 									'General Minister' => [
// 											'duration' => 6,
// 											'order' => 2,
// 											'title' => 'Baronet'
// 									],
// 									'Grand Ducal Defender' => [
// 											'duration' => 6,
// 											'order' => 3
// 									]
// 							]
// 					],
// 					3 => [
// 							'Kingdom' => [
// 									'Monarch' => [
// 											'duration' => 6,
// 											'order' => 1,
// 											'title' => 'Duke|Duchess'
// 									],
// 									'Regent' => [
// 											'duration' => 6,
// 											'order' => 4,
// 											'title' => 'Count|Countess'
// 									],
// 									'Prime Minister' => [
// 											'duration' => 6,
// 											'order' => 2,
// 											'title' => 'Count|Countess'
// 									],
// 									'Guildmaster of Reeves' => [
// 											'duration' => 6,
// 											'order' => 5
// 									],
// 									'Champion' => [
// 											'duration' => 6,
// 											'order' => 3,
// 											'title' => 'Defender'
// 									],
// 									'Scribe' => [
// 											'duration' => 6
// 									],
// 									'Herald' => [
// 											'duration' => 6
// 									],
// 									'Rules Representative' => [
// 											'duration' => 6
// 									],
// 									'Historian' => [
// 											'duration' => 6
// 									],
// 									'Senator' => [
// 											'duration' => 6
// 									],
// 									'Guildmaster of [Class]' => [
// 											'duration' => 6
// 									],
// 									'Guildmaster of Knights' => [
// 											'duration' => 6
// 									],
// 									'Board of Directors Elected Director' => [
// 											'duration' => 24
// 									],
// 									'Board of Directors Ex Officio Director' => [
// 											'duration' => 6
// 									]
// 							],
// 							'Shire' => [
// 									'Monarch' => [
// 											'duration' => 6,
// 											'order' => 1
// 									],
// 									'Regent' => [
// 											'duration' => 6,
// 											'order' => 4
// 									],
// 									'Prime Minister' => [
// 											'duration' => 6,
// 											'order' => 2
// 									],
// 									'Guildmaster of Reeves' => [
// 											'duration' => 6,
// 											'order' => 5
// 									],
// 									'Champion' => [
// 											'duration' => 6,
// 											'order' => 3
// 									],
// 									'Herald' => [
// 											'duration' => 6
// 									]
// 							],
// 							'Barony' => [
// 									'Monarch' => [
// 											'duration' => 6,
// 											'order' => 1,
// 											'title' => 'Baronet'
// 									],
// 									'Regent' => [
// 											'duration' => 6,
// 											'order' => 4
// 									],
// 									'Prime Minister' => [
// 											'duration' => 6,
// 											'order' => 2
// 									],
// 									'Guildmaster of Reeves' => [
// 											'duration' => 6,
// 											'order' => 5
// 									],
// 									'Champion' => [
// 											'duration' => 6,
// 											'order' => 3
// 									],
// 									'Herald' => [
// 											'duration' => 6
// 									]
// 							],
// 							'Duchy' => [
// 									'Monarch' => [
// 											'duration' => 6,
// 											'order' => 1,
// 											'title' => 'Baron|Baroness'
// 									],
// 									'Regent' => [
// 											'duration' => 6,
// 											'order' => 4,
// 											'title' => 'Baronet'
// 									],
// 									'Prime Minister' => [
// 											'duration' => 6,
// 											'order' => 2,
// 											'title' => 'Baronet'
// 									],
// 									'Guildmaster of Reeves' => [
// 											'duration' => 6,
// 											'order' => 5
// 									],
// 									'Champion' => [
// 											'duration' => 6,
// 											'order' => 3
// 									],
// 									'Herald' => [
// 											'duration' => 6
// 									]
// 							],
// 							'Principality' => [
// 									'Monarch' => [
// 											'duration' => 6,
// 											'order' => 1
// 									],
// 									'Regent' => [
// 											'duration' => 6,
// 											'order' => 4
// 									],
// 									'Prime Minister' => [
// 											'duration' => 6,
// 											'order' => 2
// 									],
// 									'Guildmaster of Reeves' => [
// 											'duration' => 6,
// 											'order' => 5
// 									],
// 									'Champion' => [
// 											'duration' => 6,
// 											'order' => 3
// 									],
// 									'Herald' => [
// 											'duration' => 6
// 									],
// 									'Board of Directors Member' => [
// 											'duration' => 6
// 									]
// 							]
// 					],
// 					4 => [
// 							'Kingdom' => [
// 									'Monarch' => [
// 											'duration' => 6,
// 											'order' => 1,
// 											'title' => 'Duke|Duchess'
// 									],
// 									'Royal Consort' => [
// 											'duration' => 6,
// 											'order' => 4,
// 											'title' => 'Count|Countess'
// 									],
// 									'Prime Minister' => [
// 											'duration' => 6,
// 											'order' => 2,
// 											'title' => 'Baron|Baroness'
// 									],
// 									'Champion of the Realm' => [
// 											'duration' => 6,
// 											'order' => 3,
// 											'title' => 'Defender'
// 									],
// 									'Board of Directors Member' => [
// 											'duration' => 12
// 									],
// 									'Board of Directors Secretary' => [
// 											'duration' => 12
// 									],
// 									'Board of Directors Treasurer' => [
// 											'duration' => 12
// 									],
// 									'Scribe' => [
// 											'duration' => 6
// 									],
// 									'Captain of the Monarch\'s Guard' => [
// 											'duration' => 6
// 									],
// 									'Guildmaster of [Class]' => [
// 											'duration' => 6
// 									],
// 									'Guildmaster of Reeves' => [
// 											'duration' => 6,
// 											'order' => 5
// 									],
// 									'Monarch\'s Guard' => [
// 											'duration' => 6
// 									],
// 									'Consort\'s Defender' => [
// 											'duration' => 6
// 									],
// 									'Court Bard' => [
// 											'duration' => 6
// 									],
// 									'Court Jester' => [
// 											'duration' => 6
// 									]
// 							],
// 							'Shire' => [
// 									'Sheriff' => [
// 											'duration' => 6,
// 											'order' => 1
// 									],
// 									'Regent' => [
// 											'duration' => 6,
// 											'order' => 4
// 									],
// 									'Chancellor' => [
// 											'duration' => 6,
// 											'order' => 2
// 									],
// 									'Shire Champion' => [
// 											'duration' => 6,
// 											'order' => 3
// 									]
// 							],
// 							'Barony' => [
// 									'Baron|Baroness' => [
// 											'duration' => 6,
// 											'order' => 1
// 									],
// 									'Baronial Regent' => [
// 											'duration' => 6,
// 											'order' => 4
// 									],
// 									'Chancellor' => [
// 											'duration' => 6,
// 											'order' => 2
// 									],
// 									'Baronial Champion' => [
// 											'duration' => 6,
// 											'order' => 3
// 									]
// 							],
// 							'Duchy' => [
// 									'Duke|Duchess' => [
// 											'duration' => 6,
// 											'order' => 1
// 									],
// 									'Ducal Consort' => [
// 											'duration' => 6,
// 											'order' => 4
// 									],
// 									'Chancellor' => [
// 											'duration' => 6,
// 											'order' => 2
// 									],
// 									'Ducal Champion' => [
// 											'duration' => 6,
// 											'order' => 3
// 									]
// 							]
// 					],
// 					5 => [
// 							'Kingdom' => [
// 									'Monarch' => [
// 											'duration' => 6,
// 											'order' => 1,
// 											'title' => 'Duke|Duchess'
// 									],
// 									'Regent' => [
// 											'duration' => 6,
// 											'order' => 4,
// 											'title' => 'Baron|Baroness'
// 									],
// 									'Prime Minister' => [
// 											'duration' => 6,
// 											'order' => 2,
// 											'title' => 'Count|Countess'
// 									],
// 									'Champion of the Realm' => [
// 											'duration' => 6,
// 											'order' => 3,
// 											'title' => 'Defender'
// 									],
// 									'Kingdom Guildmaster of Reeves' => [
// 											'duration' => 6,
// 											'order' => 5
// 									],
// 									'Captain of the King\'s Guard' => [
// 											'duration' => 6
// 									],
// 									'King\'s Guard' => [
// 											'duration' => 6
// 									],
// 									'Regent\'s Protector' => [
// 											'duration' => 6
// 									],
// 									'Guildmaster of [Class]' => [
// 											'duration' => 6
// 									],
// 									'Principal Herald' => [
// 											'duration' => 6
// 									],
// 									'Royal Historian' => [
// 											'duration' => 6
// 									],
// 									'Board of Directors Member' => [
// 											'duration' => 12
// 									],
// 									'Board of Directors Treasurer' => [
// 											'duration' => 12
// 									],
// 									'Board of Directors Secretary' => [
// 											'duration' => 12
// 									],
// 									'Board of Directors Vice President' => [
// 											'duration' => 12
// 									],
// 									'Board of Directors President' => [
// 											'duration' => 12
// 									]
// 							],
// 							'Shire' => [
// 									'Sheriff' => [
// 											'duration' => 6,
// 											'order' => 1,
// 											'title' => 'Lord|Lady'
// 									],
// 									'Regent' => [
// 											'duration' => 6,
// 											'order' => 4,
// 											'title' => 'Esquire'
// 									],
// 									'Chancellor' => [
// 											'duration' => 6,
// 											'order' => 2,
// 											'title' => 'Master|Mistress'
// 									],
// 									'Champion' => [
// 											'duration' => 6,
// 											'order' => 3,
// 											'title' => 'Esquire'
// 									],
// 									'Guildmaster of Reeves' => [
// 											'duration' => 6,
// 											'order' => 5
// 									]
// 							],
// 							'Barony' => [
// 									'Baron|Baroness' => [
// 											'duration' => 6,
// 											'order' => 1,
// 											'title' => 'Baronet'
// 									],
// 									'Regent' => [
// 											'duration' => 6,
// 											'order' => 4,
// 											'title' => 'Master|Mistress'
// 									],
// 									'Chancellor' => [
// 											'duration' => 6,
// 											'order' => 2,
// 											'title' => 'Lord|Lady'
// 									],
// 									'Champion' => [
// 											'duration' => 6,
// 											'order' => 3,
// 											'title' => 'Esquire'
// 									],
// 									'Guildmaster of Reeves' => [
// 											'duration' => 6,
// 											'order' => 5
// 									]
// 							],
// 							'Duchy' => [
// 									'Duke|Duchess' => [
// 											'duration' => 6,
// 											'order' => 1,
// 											'title' => 'Baron|Baroness'
// 									],
// 									'Regent' => [
// 											'duration' => 6,
// 											'order' => 4,
// 											'title' => 'Lord|Lady'
// 									],
// 									'Chancellor' => [
// 											'duration' => 6,
// 											'order' => 2,
// 											'title' => 'Baronet'
// 									],
// 									'Champion' => [
// 											'duration' => 6,
// 											'order' => 3,
// 											'title' => 'Master|Mistress'
// 									],
// 									'Guildmaster of Reeves' => [
// 											'duration' => 6,
// 											'order' => 5
// 									]
// 							],
// 							'Grand Duchy' => [
// 									'Grand Duke|Grand Duchess' => [
// 											'duration' => 6,
// 											'order' => 1,
// 											'title' => 'Count|Countess'
// 									],
// 									'Regent' => [
// 											'duration' => 6,
// 											'order' => 4,
// 											'title' => 'Baronet'
// 									],
// 									'Chancellor' => [
// 											'duration' => 6,
// 											'order' => 2,
// 											'title' => 'Baron|Baroness'
// 									],
// 									'Champion' => [
// 											'duration' => 6,
// 											'order' => 3,
// 											'title' => 'Lord|Lady'
// 									],
// 									'Guildmaster of Reeves' => [
// 											'duration' => 6,
// 											'order' => 5
// 									]
// 							],
// 							'Principality' => [
// 									'Prince|Princess' => [
// 											'duration' => 6,
// 											'order' => 1
// 									],
// 									'Regent' => [
// 											'duration' => 6,
// 											'order' => 4
// 									],
// 									'Chancellor' => [
// 											'duration' => 6,
// 											'order' => 2
// 									],
// 									'Champion' => [
// 											'duration' => 6,
// 											'order' => 3
// 									],
// 									'Guildmaster of Reeves' => [
// 											'duration' => 6,
// 											'order' => 5
// 									]
// 							]
// 					],
// 					6 => [
// 							'Kingdom' => [
// 									'Monarch' => [
// 											'duration' => 6,
// 											'order' => 1,
// 											'title' => 'Duke|Duchess'
// 									],
// 									'Regent' => [
// 											'duration' => 6,
// 											'order' => 4,
// 											'title' => 'Count|Countess'
// 									],
// 									'Prime Minster' => [
// 											'duration' => 6,
// 											'order' => 2,
// 											'title' => 'Baron|Baroness'
// 									],
// 									'Champion' => [
// 											'duration' => 6,
// 											'order' => 3,
// 											'title' => 'Defender'
// 									],
// 									'Guildmaster of Reeves' => [
// 											'duration' => 6,
// 											'order' => 5
// 									],
// 									'Board of Directors Member' => [
// 											'duration' => 12
// 									],
// 									'Board of Directors President' => [
// 											'duration' => null
// 									],
// 									'Board of Directors Vice President' => [
// 											'duration' => null
// 									],
// 									'Board of Directors Secretary' => [
// 											'duration' => null
// 									],
// 									'Board of Directors Treasurer' => [
// 											'duration' => null
// 									],
// 									'Interkingdom Rules Representative' => [
// 											'duration' => null
// 									],
// 									'Guildmaster of [A&S]' => [
// 											'duration' => 6
// 									],
// 									'Guildmaster of [Class]' => [
// 											'duration' => 6
// 									],
// 									'Guildmaster of Knights' => [
// 											'duration' => 6
// 									],
// 									'Circle of Monarchs Representative' => [
// 											'duration' => 6
// 									],
// 									'Head of Security' => [
// 											'duration' => 6
// 									],
// 									'Security' => [
// 											'duration' => 6
// 									],
// 									'Captain of the Guard' => [
// 											'duration' => 6
// 									],
// 									'Crown\'s Guard' => [
// 											'duration' => 6
// 									],
// 									'Regent\'s Defender' => [
// 											'duration' => 6
// 									],
// 									'Scribe' => [
// 											'duration' => 6
// 									],
// 									'Court Bard' => [
// 											'duration' => 6
// 									],
// 									'Court Jester' => [
// 											'duration' => 6
// 									],
// 									'Heir Apparent' => [
// 											'duration' => 6
// 									]
// 							],
// 							'Shire' => [
// 									'Sheriff' => [
// 											'duration' => 6,
// 											'order' => 1,
// 											'title' => 'Lord|Lady'
// 									],
// 									'Shire Regent' => [
// 											'duration' => 6,
// 											'order' => 4,
// 											'title' => 'Esquire'
// 									],
// 									'Chancellor' => [
// 											'duration' => 6,
// 											'order' => 2,
// 											'title' => 'Esquire'
// 									],
// 									'Shire Champion' => [
// 											'duration' => 6,
// 											'order' => 3,
// 											'title' => 'Protector'
// 									],
// 									'Guildmaster of Reeves' => [
// 											'duration' => 6,
// 											'order' => 5
// 									]
// 							],
// 							'Barony' => [
// 									'Baron|Baroness' => [
// 											'duration' => 6,
// 											'order' => 1,
// 											'title' => 'Baronet'
// 									],
// 									'Baronial Regent' => [
// 											'duration' => 6,
// 											'order' => 4,
// 											'title' => 'Lord|Lady'
// 									],
// 									'Chancellor' => [
// 											'duration' => 6,
// 											'order' => 2,
// 											'title' => 'Esquire'
// 									],
// 									'Baronial Champion' => [
// 											'duration' => 6,
// 											'order' => 3,
// 											'title' => 'Protector'
// 									],
// 									'Guildmaster of Reeves' => [
// 											'duration' => 6,
// 											'order' => 5
// 									]
// 							],
// 							'Duchy' => [
// 									'Duke|Duchess' => [
// 											'duration' => 6,
// 											'order' => 1,
// 											'title' => 'Baron|Baroness'
// 									],
// 									'Duchy Regent' => [
// 											'duration' => 6,
// 											'order' => 4,
// 											'title' => 'Baronet'
// 									],
// 									'Chancellor' => [
// 											'duration' => 6,
// 											'order' => 2,
// 											'title' => 'Lord|Lady'
// 									],
// 									'Duchy Champion' => [
// 											'duration' => 6,
// 											'order' => 3,
// 											'title' => 'Protector'
// 									],
// 									'Guildmaster of Reeves' => [
// 											'duration' => 6,
// 											'order' => 5
// 									]
// 							]
// 					],
// 					7 => [
// 							'Kingdom' => [
// 									'Monarch' => [
// 											'duration' => 6,
// 											'order' => 1,
// 											'title' => 'Duke|Duchess'
// 									],
// 									'Regent|Consort|Prince|Princess' => [
// 											'duration' => 6,
// 											'order' => 4,
// 											'title' => 'Count|Countess'
// 									],
// 									'Prime Minster' => [
// 											'duration' => 6,
// 											'order' => 2,
// 											'title' => 'Baron|Baroness'
// 									],
// 									'Champion of the Realm' => [
// 											'duration' => 6,
// 											'order' => 3,
// 											'title' => 'Defender'
// 									],
// 									'Board of Directors Member' => [
// 											'duration' => 12
// 									],
// 									'Board of Directors Secretary' => [
// 											'duration' => 12
// 									],
// 									'Board of Directors Treasurer' => [
// 											'duration' => 12
// 									],
// 									'Scribe' => [
// 											'duration' => 6
// 									],
// 									'Guildmaster of Reeves' => [
// 											'duration' => 6,
// 											'order' => 5
// 									],
// 									'Captain of the Monarch\'s Guard' => [
// 											'duration' => 6
// 									],
// 									'Glass Guildmaster' => [
// 											'duration' => 6
// 									],
// 									'Guildmaster of [A&S]' => [
// 											'duration' => 6
// 									],
// 									'Monarch\'s & Consort\'s Guard' => [
// 											'duration' => 6
// 									],
// 									'Circle of Steel Member' => [
// 											'duration' => 6
// 									],
// 									'Consort/Regent\'s Defender' => [
// 											'duration' => 6
// 									],
// 									'Court Bard' => [
// 											'duration' => 6
// 									],
// 									'Court Jester' => [
// 											'duration' => 6
// 									],
// 									'Rules Representative' => [
// 											'duration' => 6
// 									]
// 							],
// 							'Shire' => [
// 									'Sheriff' => [
// 											'duration' => 6,
// 											'order' => 1
// 									],
// 									'Regent' => [
// 											'duration' => 6,
// 											'order' => 4
// 									],
// 									'Chancellor' => [
// 											'duration' => 6,
// 											'order' => 2
// 									],
// 									'Shire Champion' => [
// 											'duration' => 6,
// 											'order' => 3
// 									]
// 							],
// 							'Barony' => [
// 									'Baron|Baroness' => [
// 											'duration' => 6,
// 											'order' => 1
// 									],
// 									'Baronial Regent' => [
// 											'duration' => 6,
// 											'order' => 4
// 									],
// 									'Chancellor' => [
// 											'duration' => 6,
// 											'order' => 2
// 									],
// 									'Baronial Champion' => [
// 											'duration' => 6,
// 											'order' => 3
// 									]
// 							],
// 							'Duchy' => [
// 									'Duke|Duchess' => [
// 											'duration' => 6,
// 											'order' => 1
// 									],
// 									'Ducal Consort' => [
// 											'duration' => 6,
// 											'order' => 4
// 									],
// 									'Chancellor' => [
// 											'duration' => 6,
// 											'order' => 2
// 									],
// 									'Ducal Champion' => [
// 											'duration' => 6,
// 											'order' => 3
// 									]
// 							]
// 					],
// 					8 => [
// 							'Freehold' => [
// 									'Sheriff' => [
// 											'duration' => 6,
// 											'order' => 1
// 									],
// 									'Regent' => [
// 											'duration' => 6,
// 											'order' => 4
// 									],
// 									'Chancellor' => [
// 											'duration' => 6,
// 											'order' => 2
// 									],
// 									'Shire Champion' => [
// 											'duration' => 6,
// 											'order' => 3
// 									]
// 							]
// 					],
// 					10 => [
// 							'Kingdom' => [
// 									'Guildmaster of Knights' => [
// 											'duration' => 6
// 									],
// 									'Guildmaster of Reeves' => [
// 											'duration' => 6,
// 											'order' => 5
// 									],
// 									'Kingdom Monarch' => [
// 											'duration' => 6,
// 											'order' => 1,
// 											'title' => 'Duke|Duchess'
// 									],
// 									'Kingdom Regent' => [
// 											'duration' => 6,
// 											'order' => 4,
// 											'title' => 'Count|Countess'
// 									],
// 									'Kingdom Prime Minister' => [
// 											'duration' => 6,
// 											'order' => 2
// 									],
// 									'Kingdom Champion' => [
// 											'duration' => 6,
// 											'order' => 3,
// 											'title' => 'Defender'
// 									],
// 									'Kingdom Quartermaster' => [
// 											'duration' => 12
// 									],
// 									'Kingdom Storyteller' => [
// 											'duration' => 6
// 									],
// 									'Board of Directors Member' => [
// 											'duration' => 12
// 									],
// 									'Board of Directors Treasurer' => [
// 											'duration' => 12
// 									],
// 									'Board of Directors Quartermaster' => [
// 											'duration' => 12
// 									],
// 									'Board of Directors Chairperson' => [
// 											'duration' => 12
// 									],
// 									'Board of Directors Vice Chairperson' => [
// 											'duration' => 12
// 									],
// 									'Board of Directors Case Analyst' => [
// 											'duration' => 12
// 									],
// 									'Board of Directors Secretary' => [
// 											'duration' => 12
// 									]
// 							],
// 							'Shire' => [
// 									'Sheriff' => [
// 											'duration' => 6,
// 											'order' => 1,
// 											'title' => 'Lord|Lady'
// 									],
// 									'Regent' => [
// 											'duration' => 6,
// 											'order' => 4,
// 											'title' => 'Master'
// 									],
// 									'Champion' => [
// 											'duration' => 6,
// 											'order' => 3,
// 											'title' => 'Esquire'
// 									],
// 									'Prime Minister' => [
// 											'duration' => 6,
// 											'order' => 2,
// 											'title' => 'Esquire'
// 									]
// 							],
// 							'Barony' => [
// 									'Baron|Baroness' => [
// 											'duration' => 6,
// 											'order' => 1,
// 											'title' => 'Baronet'
// 									],
// 									'Regent' => [
// 											'duration' => 6,
// 											'order' => 4,
// 											'title' => 'Lord|Lady'
// 									],
// 									'Champion' => [
// 											'duration' => 6,
// 											'order' => 3,
// 											'title' => 'Esquire'
// 									],
// 									'Prime Minister' => [
// 											'duration' => 6,
// 											'order' => 2,
// 											'title' => 'Master'
// 									]
// 							],
// 							'Duchy' => [
// 									'Duke|Duchess' => [
// 											'duration' => 6,
// 											'order' => 1,
// 											'title' => 'Baron|Baroness'
// 									],
// 									'Regent' => [
// 											'duration' => 6,
// 											'order' => 4,
// 											'title' => 'Baronet'
// 									],
// 									'Champion' => [
// 											'duration' => 6,
// 											'order' => 3,
// 											'title' => 'Master'
// 									],
// 									'Prime Minister' => [
// 											'duration' => 6,
// 											'order' => 2,
// 											'title' => 'Lord|Lady'
// 									]
// 							],
// 							'Grand Duchy' => [
// 									'Grand Duke|Grand Duchess' => [
// 											'duration' => 6,
// 											'order' => 1,
// 											'title' => 'Marquis|Marquess'
// 									],
// 									'Regent' => [
// 											'duration' => 6,
// 											'order' => 4,
// 											'title' => 'Baron|Baroness'
// 									],
// 									'Champion' => [
// 											'duration' => 6,
// 											'order' => 3,
// 											'title' => 'Master'
// 									],
// 									'Prime Minister' => [
// 											'duration' => 6,
// 											'order' => 2,
// 											'title' => 'Baronet'
// 									]
// 							],
// 							'Principality' => [
// 									'Prince|Princess' => [
// 											'duration' => 6,
// 											'order' => 1,
// 											'title' => 'Count|Countess'
// 									],
// 									'Regent' => [
// 											'duration' => 6,
// 											'order' => 4,
// 											'title' => 'Marquis|Marquess'
// 									],
// 									'Champion' => [
// 											'duration' => 6,
// 											'order' => 3,
// 											'title' => 'Master'
// 									],
// 									'Prime Minister' => [
// 											'duration' => 6,
// 											'order' => 2,
// 											'title' => 'Baronet'
// 									]
// 							]
// 					],
// 					11 => [
// 							'Kingdom' => [
// 									'Monarch' => [
// 											'duration' => 6,
// 											'order' => 1,
// 											'title' => 'Duke|Duchess'
// 									],
// 									'Regent' => [
// 											'duration' => 6,
// 											'order' => 4,
// 											'title' => 'Count|Countess'
// 									],
// 									'Prime Minster' => [
// 											'duration' => 6,
// 											'order' => 2,
// 											'title' => 'Marquis|Marquess'
// 									],
// 									'Champion' => [
// 											'duration' => 6,
// 											'order' => 3,
// 											'title' => 'Defender'
// 									],
// 									'Guildmaster of Reeves' => [
// 											'duration' => 6,
// 											'order' => 5
// 									],
// 									'Circle of Monarchs Secretary' => [
// 											'duration' => 6
// 									],
// 									'Guildmaster of Knights' => [
// 											'duration' => 6
// 									],
// 									'Guildmaster of Reeves' => [
// 											'duration' => 6,
// 											'order' => 5
// 									],
// 									'Board of Directors Member' => [
// 											'duration' => 6
// 									],
// 									'Board of Directors Treasurer' => [
// 											'duration' => 6
// 									],
// 									'Guildmaster of [Class]' => [
// 											'duration' => 6
// 									],
// 									'Crown Guard' => [
// 											'duration' => 6
// 									],
// 									'Court Bard' => [
// 											'duration' => 6
// 									],
// 									'Court Jester' => [
// 											'duration' => 6
// 									],
// 									'Court Herald' => [
// 											'duration' => 6
// 									],
// 									'Prime Minister\'s Scribe' => [
// 											'duration' => 6
// 									],
// 									'Regent\'s Defender' => [
// 											'duration' => 6
// 									]
// 							],
// 							'Shire' => [
// 									'Monarch' => [
// 											'duration' => 6,
// 											'order' => 1,
// 											'title' => 'Lord|Lady'
// 									],
// 									'Regent' => [
// 											'duration' => 6,
// 											'order' => 4,
// 											'title' => 'Esquire'
// 									],
// 									'Prime Minster' => [
// 											'duration' => 6,
// 											'order' => 2,
// 											'title' => 'Esquire'
// 									],
// 									'Champion' => [
// 											'duration' => 6,
// 											'order' => 3,
// 											'title' => 'Esquire'
// 									]
// 							],
// 							'Barony' => [
// 									'Monarch' => [
// 											'duration' => 6,
// 											'order' => 1,
// 											'title' => 'Baronet'
// 									],
// 									'Regent' => [
// 											'duration' => 6,
// 											'order' => 4,
// 											'title' => 'Lord|Lady'
// 									],
// 									'Prime Minster' => [
// 											'duration' => 6,
// 											'order' => 2,
// 											'title' => 'Lord|Lady'
// 									],
// 									'Champion' => [
// 											'duration' => 6,
// 											'order' => 3,
// 											'title' => 'Lord|Lady'
// 									]
// 							],
// 							'County' => [
// 									'Monarch' => [
// 											'duration' => 6,
// 											'order' => 1,
// 											'title' => 'Baron|Baroness'
// 									],
// 									'Regent' => [
// 											'duration' => 6,
// 											'order' => 4,
// 											'title' => 'Baronet'
// 									],
// 									'Prime Minster' => [
// 											'duration' => 6,
// 											'order' => 2,
// 											'title' => 'Baronet'
// 									],
// 									'Champion' => [
// 											'duration' => 6,
// 											'order' => 3,
// 											'title' => 'Baronet'
// 									]
// 							],
// 							'Duchy' => [
// 									'Monarch' => [
// 											'duration' => 6,
// 											'order' => 1,
// 											'title' => 'Viscount|Viscountess'
// 									],
// 									'Regent' => [
// 											'duration' => 6,
// 											'order' => 4,
// 											'title' => 'Baron|Baroness'
// 									],
// 									'Prime Minster' => [
// 											'duration' => 6,
// 											'order' => 2,
// 											'title' => 'Baron|Baroness'
// 									],
// 									'Champion' => [
// 											'duration' => 6,
// 											'order' => 3,
// 											'title' => 'Baron|Baroness'
// 									]
// 							],
// 							'Grand Duchy' => [
// 									'Monarch' => [
// 											'duration' => 6,
// 											'order' => 1,
// 											'title' => 'Marquis|Marquess'
// 									],
// 									'Regent' => [
// 											'duration' => 6,
// 											'order' => 4,
// 											'title' => 'Viscount|Viscountess'
// 									],
// 									'Prime Minster' => [
// 											'duration' => 6,
// 											'order' => 2,
// 											'title' => 'Viscount|Viscountess'
// 									],
// 									'Champion' => [
// 											'duration' => 6,
// 											'order' => 3,
// 											'title' => 'Viscount|Viscountess'
// 									]
// 							]
// 					],
// 					12 => [
// 							'Kingdom' => [
// 									'Monarch' => [
// 											'duration' => 6,
// 											'order' => 1,
// 											'title' => 'Duke|Duchess'
// 									],
// 									'Regent' => [
// 											'duration' => 6,
// 											'order' => 4,
// 											'title' => 'Count|Countess'
// 									],
// 									'Prime Minster' => [
// 											'duration' => 6,
// 											'order' => 2,
// 											'title' => 'Baron|Baroness'
// 									],
// 									'Champion' => [
// 											'duration' => 6,
// 											'order' => 3,
// 											'title' => 'Defender'
// 									],
// 									'Guildmaster of Reeves' => [
// 											'duration' => 6,
// 											'order' => 5
// 									],
// 									'Heir Apparent' => [
// 											'duration' => 6
// 									],
// 									'Captain of the Royal Guard' => [
// 											'duration' => 6
// 									],
// 									'Royal Guard' => [
// 											'duration' => 6
// 									],
// 									'Regent\'s Defender' => [
// 											'duration' => 6
// 									],
// 									'Guildmaster of Knights' => [
// 											'duration' => 6
// 									],
// 									'Guildmaster of Smiths' => [
// 											'duration' => 6
// 									],
// 									'Guildmaster of Garbers' => [
// 											'duration' => 6
// 									],
// 									'Guildmaster of Engineers' => [
// 											'duration' => 6
// 									],
// 									'Guildmaster of [Class]' => [
// 											'duration' => 6
// 									],
// 									'Scribe' => [
// 											'duration' => 6
// 									],
// 									'Circle of Steel Representative' => [
// 											'duration' => 6
// 									],
// 									'Court Herald' => [
// 											'duration' => 6
// 									],
// 									'Guildmaster of [A&S]' => [
// 											'duration' => 6
// 									],
// 									'Board of Directors Member' => [
// 											'duration' => 12
// 									],
// 									'Board of Directors President' => [
// 											'duration' => 12
// 									],
// 									'Board of Directors Vice President' => [
// 											'duration' => 12
// 									],
// 									'Board of Directors Treasurer' => [
// 											'duration' => 12
// 									],
// 									'Board of Directors Liaison Officer' => [
// 											'duration' => 12
// 									],
// 									'Board of Directors Secretary' => [
// 											'duration' => 12
// 									]
// 							],
// 							'Shire' => [
// 									'Sheriff' => [
// 											'duration' => 6,
// 											'order' => 1
// 									],
// 									'Regent' => [
// 											'duration' => 6,
// 											'order' => 4
// 									],
// 									'Prime Minster' => [
// 											'duration' => 6,
// 											'order' => 2
// 									],
// 									'Champion' => [
// 											'duration' => 6,
// 											'order' => 3
// 									]
// 							],
// 							'Barony' => [
// 									'Baron|Baroness' => [
// 											'duration' => 6,
// 											'order' => 1,
// 											'title' => 'Lord/Lady'
// 									],
// 									'Regent' => [
// 											'duration' => 6,
// 											'order' => 4
// 									],
// 									'Prime Minster' => [
// 											'duration' => 6,
// 											'order' => 2
// 									],
// 									'Champion' => [
// 											'duration' => 6,
// 											'order' => 3
// 									]
// 							],
// 							'Duchy' => [
// 									'Duke|Duchess' => [
// 											'duration' => 6,
// 											'order' => 1,
// 											'title' => 'Baron|Baroness'
// 									],
// 									'Regent' => [
// 											'duration' => 6,
// 											'order' => 4,
// 											'title' => 'Lord/Lady'
// 									],
// 									'Prime Minster' => [
// 											'duration' => 6,
// 											'order' => 2
// 									],
// 									'Champion' => [
// 											'duration' => 6,
// 											'order' => 3
// 									]
// 							],
// 							'Principality' => [
// 									'Prince|Princess' => [
// 											'duration' => 6,
// 											'order' => 1,
// 											'title' => 'Count|Countess'
// 									],
// 									'Regent' => [
// 											'duration' => 6,
// 											'order' => 4,
// 											'title' => 'Baron|Baroness'
// 									],
// 									'Prime Minster' => [
// 											'duration' => 6,
// 											'order' => 2
// 									],
// 									'Champion' => [
// 											'duration' => 6,
// 											'order' => 3,
// 											'title' => 'Defender'
// 									]
// 							]
// 					],
// 					14 => [
// 							'Kingdom' => [
// 									'Monarch' => [
// 											'duration' => 6,
// 											'order' => 1,
// 											'title' => 'Duke|Duchess'
// 									],
// 									'Regent' => [
// 											'duration' => 6,
// 											'order' => 4,
// 											'title' => 'Count|Countess'
// 									],
// 									'Prime Minister' => [
// 											'duration' => 6,
// 											'order' => 2,
// 											'title' => 'Marquis|Marquess'
// 									],
// 									'Champion' => [
// 											'duration' => 6,
// 											'order' => 3,
// 											'title' => 'Defender'
// 									],
// 									'Guildmaster of Reeves' => [
// 											'duration' => 6,
// 											'order' => 5
// 									],
// 									'Senator' => [
// 											'duration' => 12
// 									],
// 									'Guildmaster of Knights' => [
// 											'duration' => 6
// 									],
// 									'Rules Representative' => [
// 											'duration' => 12
// 									],
// 									'Captain of the Guard' => [
// 											'duration' => 6
// 									],
// 									'Regent\'s Defender' => [
// 											'duration' => 6
// 									],
// 									'Crown Guard' => [
// 											'duration' => 6
// 									],
// 									'Scribe' => [
// 											'duration' => 6
// 									],
// 									'Crown Bard' => [
// 											'duration' => 6
// 									],
// 									'Crown Herald' => [
// 											'duration' => 6
// 									],
// 									'Crown Jester' => [
// 											'duration' => 6
// 									],
// 									'Board of Directors Member' => [
// 											'duration' => 12
// 									],
// 									'Board of Directors President' => [
// 											'duration' => 12
// 									],
// 									'Board of Directors Secretary' => [
// 											'duration' => 12
// 									],
// 									'Board of Directors Treasurer' => [
// 											'duration' => 12
// 									],
// 									'Board of Directors Membership Officer' => [
// 											'duration' => 12
// 									],
// 									'Board of Directors Monarch Alternate' => [
// 											'duration' => 12
// 									],
// 									'Board of Directors Prime Minister Alternate' => [
// 											'duration' => 12
// 									]
// 							],
// 							'Shire' => [
// 									'Sheriff|Mayor' => [
// 											'duration' => 6,
// 											'order' => 1
// 									]
// 							],
// 							'Barony' => [
// 									'Baron|Baroness' => [
// 											'duration' => 6,
// 											'order' => 1,
// 											'title' => 'Baronet'
// 									],
// 									'Baronial Regent' => [
// 											'duration' => 6,
// 											'order' => 4
// 									],
// 									'Baronial Champion' => [
// 											'duration' => 6,
// 											'order' => 3
// 									],
// 									'Baronial Seneschal' => [
// 											'duration' => 6,
// 											'order' => 2
// 									]
// 							],
// 							'Duchy' => [
// 									'Duke|Duchess' => [
// 											'duration' => 6,
// 											'order' => 1,
// 											'title' => 'Baron|Baroness'
// 									],
// 									'Ducal Regent' => [
// 											'duration' => 6,
// 											'order' => 4
// 									],
// 									'Ducal Champion' => [
// 											'duration' => 6,
// 											'order' => 3
// 									],
// 									'Ducal Seneschal' => [
// 											'duration' => 6,
// 											'order' => 2,
// 											'title' => 'Lord|Lady'
// 									]
// 							],
// 							'Grand Duchy' => [
// 									'Grand Duke|Grand Duchess' => [
// 											'duration' => 6,
// 											'order' => 1
// 									],
// 									'Grand Ducal Regent' => [
// 											'duration' => 6,
// 											'order' => 4
// 									],
// 									'Grand Ducal Champion' => [
// 											'duration' => 6,
// 											'order' => 3
// 									],
// 									'Grand Ducal Seneschal' => [
// 											'duration' => 6,
// 											'order' => 2,
// 											'title' => 'Baronet'
// 									]
// 							],
// 							'Principality' => [
// 									'Crown Prince|Crown Princess' => [
// 											'duration' => 6,
// 											'order' => 1,
// 											'title' => 'Count|Countess'
// 									],
// 									'Crown Regent' => [
// 											'duration' => 6,
// 											'order' => 4,
// 											'title' => 'Baron|Baroness'
// 									],
// 									'Crown Champion' => [
// 											'duration' => 6,
// 											'order' => 3
// 									],
// 									'Crown Seneschal' => [
// 											'duration' => 6,
// 											'order' => 2,
// 											'title' => 'Baronet'
// 									]
// 							]
// 					],
// 					16 => [
// 							'Kingdom' => [
// 									'Monarch' => [
// 											'duration' => 6,
// 											'order' => 1,
// 											'title' => 'Duke|Duchess'
// 									],
// 									'Regent|Consort' => [
// 											'duration' => 6,
// 											'order' => 4,
// 											'title' => 'Count|Countess'
// 									],
// 									'Prime Minster' => [
// 											'duration' => 6,
// 											'order' => 2,
// 											'title' => 'Baron|Baroness'
// 									],
// 									'Champion of the Realm' => [
// 											'duration' => 6,
// 											'order' => 3,
// 											'title' => 'Defender'
// 									],
// 									'Board of Directors Member' => [
// 											'duration' => 12
// 									],
// 									'Board of Directors Secretary' => [
// 											'duration' => 12
// 									],
// 									'Board of Directors Treasurer' => [
// 											'duration' => 12
// 									],
// 									'Board of Directors Member' => [
// 											'duration' => 12
// 									],
// 									'Board of Directors Member' => [
// 											'duration' => 12
// 									],
// 									'Board of Directors Member' => [
// 											'duration' => 12
// 									],
// 									'Scribe' => [
// 											'duration' => 6
// 									],
// 									'Guildmaster of Reeves' => [
// 											'duration' => 6,
// 											'order' => 5
// 									],
// 									'Captain of the Monarch\'s Guard' => [
// 											'duration' => 6
// 									],
// 									'Guildmaster of [Class]' => [
// 											'duration' => 6
// 									],
// 									'Guildmaster of [A&S]' => [
// 											'duration' => 6
// 									],
// 									'Monarch\'s/Consort\'s Guard' => [
// 											'duration' => 6
// 									],
// 									'Circle of Steel Member' => [
// 											'duration' => 6
// 									],
// 									'Regent/Consort\'s Defender' => [
// 											'duration' => 6
// 									],
// 									'Court Bard' => [
// 											'duration' => 6
// 									],
// 									'Court Jester' => [
// 											'duration' => 6
// 									],
// 									'Rules Representative' => [
// 											'duration' => null
// 									]
// 							],
// 							'Shire' => [
// 									'Sheriff' => [
// 											'duration' => 6,
// 											'order' => 1
// 									],
// 									'Regent' => [
// 											'duration' => 6,
// 											'order' => 4
// 									],
// 									'Chancellor' => [
// 											'duration' => 6,
// 											'order' => 2
// 									],
// 									'Champion' => [
// 											'duration' => 6,
// 											'order' => 3
// 									]
// 							],
// 							'Barony' => [
// 									'Baron|Baroness' => [
// 											'duration' => 6,
// 											'order' => 1
// 									],
// 									'Baronial Regent' => [
// 											'duration' => 6,
// 											'order' => 4
// 									],
// 									'Chancellor' => [
// 											'duration' => 6,
// 											'order' => 2
// 									],
// 									'Champion' => [
// 											'duration' => 6,
// 											'order' => 3
// 									]
// 							],
// 							'Duchy' => [
// 									'Duke|Duchess' => [
// 											'duration' => 6,
// 											'order' => 1
// 									],
// 									'Ducal Consort' => [
// 											'duration' => 6,
// 											'order' => 4
// 									],
// 									'Chancellor' => [
// 											'duration' => 6,
// 											'order' => 2
// 									],
// 									'Ducal Champion' => [
// 											'duration' => 6,
// 											'order' => 3
// 									]
// 							],
// 							'Principality' => [
// 									'Prince|Princess' => [
// 											'duration' => 6,
// 											'order' => 1
// 									],
// 									'Prince Regent' => [
// 											'duration' => 6,
// 											'order' => 4
// 									],
// 									'Prime Minster' => [
// 											'duration' => 6,
// 											'order' => 2
// 									],
// 									'Prince Champion' => [
// 											'duration' => 6,
// 											'order' => 3
// 									]
// 							],
// 							'Grand Duchy' => [
// 									'Grand Duke|Grand Duchess' => [
// 											'duration' => 6,
// 											'order' => 1
// 									],
// 									'Grand Ducal Regent' => [
// 											'duration' => 6,
// 											'order' => 4
// 									],
// 									'Prime Minster' => [
// 											'duration' => 6,
// 											'order' => 2
// 									],
// 									'Grand Ducal Champion' => [
// 											'duration' => 6,
// 											'order' => 3
// 									]
// 							]
// 					],
// 					17 => [
// 							'Kingdom' => [
// 									'Board of Directors Member' => [
// 											'duration' => 36
// 									],
// 									'Board of Directors Trustee' => [
// 											'duration' => null
// 									],
// 									'Board of Directors Trustee Program Liason' => [
// 											'duration' => 12
// 									],
// 									'Board of Directors President' => [
// 											'duration' => 24
// 									],
// 									'Board of Directors Vice-President' => [
// 											'duration' => 24
// 									],
// 									'Board of Directors Secretary' => [
// 											'duration' => 24
// 									],
// 									'Board of Directors Treasurer' => [
// 											'duration' => 24
// 									],
// 									'Monarch' => [
// 											'duration' => 6,
// 											'order' => 1,
// 											'title' => 'Duke|Duchess'
// 									],
// 									'Regent' => [
// 											'duration' => 6,
// 											'order' => 4,
// 											'title' => 'Count|Countess'
// 									],
// 									'Prime Minster' => [
// 											'duration' => 6,
// 											'order' => 2,
// 											'title' => 'Count|Countess'
// 									],
// 									'Champion' => [
// 											'duration' => 6,
// 											'order' => 3,
// 											'title' => 'Defender'
// 									],
// 									'Guildmaster of Reeves' => [
// 											'duration' => 6,
// 											'order' => 5
// 									],
// 									'Senator' => [
// 											'duration' => 12,
// 											'title' => 'Count|Countess'
// 									],
// 									'Guildmaster of [Class]' => [
// 											'duration' => 6
// 									],
// 									'Guildmaster of Knights' => [
// 											'duration' => 6
// 									],
// 									'Rules Representative' => [
// 											'duration' => null
// 									],
// 									'Corpora Comittee Chair' => [
// 											'duration' => 6
// 									],
// 									'Corpora Comittee Member' => [
// 											'duration' => 6
// 									],
// 									'Guildmaster of Masks' => [
// 											'duration' => 6
// 									],
// 									'Court Herald' => [
// 											'duration' => 6
// 									],
// 									'Guard' => [
// 											'duration' => 6
// 									],
// 									'Court Chronicler' => [
// 											'duration' => 6
// 									],
// 									'Royal Commissioner (Recruiting/Retention)' => [
// 											'duration' => 6
// 									],
// 									'Royal Commissioner (Diversity/Inclusion)' => [
// 											'duration' => 6
// 									],
// 									'Guildmaster of Novices' => [
// 											'duration' => 6
// 									],
// 									'Kingdom Spotlight' => [
// 											'duration' => 6
// 									]
// 							],
// 							'Shire' => [
// 									'Sheriff' => [
// 											'duration' => 6,
// 											'order' => 1
// 									],
// 									'Regent' => [
// 											'duration' => 6,
// 											'order' => 4,
// 											'title' => 'Master|Mistress'
// 									],
// 									'Prime Minster' => [
// 											'duration' => 6,
// 											'order' => 2,
// 											'title' => 'Esquire'
// 									],
// 									'Champion' => [
// 											'duration' => 6,
// 											'order' => 3
// 									]
// 							],
// 							'Barony' => [
// 									'Baron|Baroness' => [
// 											'duration' => 6,
// 											'order' => 1,
// 											'title' => 'Baronet|Baronetess'
// 									],
// 									'Regent' => [
// 											'duration' => 6,
// 											'order' => 4
// 									],
// 									'Prime Minster' => [
// 											'duration' => 6,
// 											'order' => 2,
// 											'title' => 'Master|Mistress'
// 									],
// 									'Champion' => [
// 											'duration' => 6,
// 											'order' => 3,
// 											'title' => 'Esquire'
// 									]
// 							],
// 							'Duchy' => [
// 									'Duke|Duchess' => [
// 											'duration' => 6,
// 											'order' => 1,
// 											'title' => 'Baron|Baroness'
// 									],
// 									'Regent' => [
// 											'duration' => 6,
// 											'order' => 4,
// 											'title' => 'Baronet|Baronetess'
// 									],
// 									'Prime Minster' => [
// 											'duration' => 6,
// 											'order' => 2,
// 											'title' => 'Baronet|Baronetess'
// 									],
// 									'Champion' => [
// 											'duration' => 6,
// 											'order' => 3,
// 											'title' => 'Master|Mistress'
// 									]
// 							],
// 							'Grand Duchy' => [
// 									'Grand Duke|Grand Duchess' => [
// 											'duration' => 6,
// 											'order' => 1,
// 											'title' => 'Baron|Baroness'
// 									],
// 									'Regent' => [
// 											'duration' => 6,
// 											'order' => 4,
// 											'title' => 'Baronet|Baronetess'
// 									],
// 									'Prime Minster' => [
// 											'duration' => 6,
// 											'order' => 2,
// 											'title' => 'Baronet|Baronetess'
// 									],
// 									'Champion' => [
// 											'duration' => 6,
// 											'order' => 3,
// 											'title' => 'Master|Mistress'
// 									]
// 							],
// 							'Principality' => [
// 									'Prince|Princess' => [
// 											'duration' => 6,
// 											'order' => 1,
// 											'title' => 'Baron|Baroness'
// 									],
// 									'Regent' => [
// 											'duration' => 6,
// 											'order' => 4,
// 											'title' => 'Baronet|Baronetess'
// 									],
// 									'Prime Minster' => [
// 											'duration' => 6,
// 											'order' => 2,
// 											'title' => 'Baronet|Baronetess'
// 									],
// 									'Champion' => [
// 											'duration' => 6,
// 											'order' => 3,
// 											'title' => 'Master|Mistress'
// 									]
// 							]
// 					],
// 					18 => [
// 							'Kingdom' => [
// 									'Monarch' => [
// 											'duration' => 6,
// 											'order' => 1,
// 											'title' => 'Duke|Duchess'
// 									],
// 									'Regent' => [
// 											'duration' => 6,
// 											'order' => 4,
// 											'title' => 'Count|Countess'
// 									],
// 									'Champion' => [
// 											'duration' => 6,
// 											'order' => 3,
// 											'title' => 'Defender'
// 									],
// 									'Prime Minister' => [
// 											'duration' => 6,
// 											'order' => 2,
// 											'title' => 'Viscount|Viscountess'
// 									],
// 									'Guildmaster of Reeves' => [
// 											'duration' => 6,
// 											'order' => 5
// 									],
// 									'Captain of the Guard' => [
// 											'duration' => 6
// 									],
// 									'Guard Member' => [
// 											'duration' => 6
// 									],
// 									'Regent Defender' => [
// 											'duration' => 6
// 									],
// 									'Court Herald' => [
// 											'duration' => 6
// 									],
// 									'Guildmaster of [Class]' => [
// 											'duration' => 6
// 									],
// 									'Guildmaster of [A&S]' => [
// 											'duration' => 6
// 									],
// 									'Heir Apparent' => [
// 											'duration' => 6
// 									],
// 									'Marshall' => [
// 											'duration' => 6
// 									],
// 									'Quartermaster' => [
// 											'duration' => 6
// 									],
// 									'Representative to AI' => [
// 											'duration' => 6
// 									],
// 									'Rules Representative to AI' => [
// 											'duration' => 6
// 									],
// 									'Guildmaster of Knights' => [
// 											'duration' => 6
// 									],
// 									'Circle of Steel Representative' => [
// 											'duration' => 6
// 									],
// 									'Event Committee Member' => [
// 											'duration' => 12
// 									],
// 									'Event Committee Head' => [
// 											'duration' => 12
// 									],
// 									'Event Committee Treasurer' => [
// 											'duration' => 12
// 									],
// 									'Fundraiser Committee Member' => [
// 											'duration' => 12
// 									],
// 									'Board of Directors Member' => [
// 											'duration' => 24
// 									],
// 									'Board of Directors Chairman of the Board' => [
// 											'duration' => 12
// 									],
// 									'Board of Directors Vice-Chairman of the Board' => [
// 											'duration' => 12
// 									],
// 									'Board of Directors Treasurer' => [
// 											'duration' => 12
// 									],
// 									'Board of Directors Liason Officer' => [
// 											'duration' => 12
// 									]
// 							],
// 							'Shire' => [
// 									'Sheriff' => [
// 											'duration' => 6,
// 											'order' => 1,
// 											'title' => 'Esquire'
// 									],
// 									'Regent' => [
// 											'duration' => 6,
// 											'order' => 4
// 									],
// 									'Prime Minster' => [
// 											'duration' => 6,
// 											'order' => 2
// 									],
// 									'Champion' => [
// 											'duration' => 6,
// 											'order' => 3,
// 											'title' => 'Protector'
// 									]
// 							],
// 							'Barony' => [
// 									'Baron|Baroness' => [
// 											'duration' => 6,
// 											'order' => 1,
// 											'title' => 'Baronet'
// 									],
// 									'Regent' => [
// 											'duration' => 6,
// 											'order' => 4,
// 											'title' => 'Lord|Lady'
// 									],
// 									'Prime Minster' => [
// 											'duration' => 6,
// 											'order' => 2,
// 											'title' => 'Lord|Lady'
// 									],
// 									'Champion' => [
// 											'duration' => 6,
// 											'order' => 3,
// 											'title' => 'Protector'
// 									]
// 							],
// 							'Duchy' => [
// 									'Duke|Duchess' => [
// 											'duration' => 6,
// 											'order' => 1,
// 											'title' => 'Baron|Baroness'
// 									],
// 									'Regent' => [
// 											'duration' => 6,
// 											'order' => 4,
// 											'title' => 'Baronet'
// 									],
// 									'Prime Minster' => [
// 											'duration' => 6,
// 											'order' => 2,
// 											'title' => 'Baronet'
// 									],
// 									'Champion' => [
// 											'duration' => 6,
// 											'order' => 3,
// 											'title' => 'Protector'
// 									]
// 							],
// 							'Principality' => [
// 									'Prince|Princess' => [
// 											'duration' => 6,
// 											'order' => 1
// 									],
// 									'Regent' => [
// 											'duration' => 6,
// 											'order' => 4
// 									],
// 									'Prime Minster' => [
// 											'duration' => 6,
// 											'order' => 2
// 									],
// 									'Champion' => [
// 											'duration' => 6,
// 											'order' => 3,
// 											'title' => 'Protector'
// 									]
// 							]
// 					],
// 					19 => [
// 							'Kingdom' => [
// 									'Monarch' => [
// 											'duration' => 6,
// 											'order' => 1,
// 											'title' => 'Duke|Duchess'
// 									],
// 									'Regent' => [
// 											'duration' => 6,
// 											'order' => 4,
// 											'title' => 'Count|Countess'
// 									],
// 									'Prime Minister' => [
// 											'duration' => 6,
// 											'order' => 2,
// 											'title' => 'Marquis|Marquess'
// 									],
// 									'Champion' => [
// 											'duration' => 6,
// 											'order' => 3,
// 											'title' => 'Defender'
// 									],
// 									'Guildmaster of Reeves' => [
// 											'duration' => 6,
// 											'order' => 5
// 									],
// 									'Ambassador of Tal Dagore' => [
// 											'duration' => 12
// 									],
// 									'Rules Representative of Tal Dagore' => [
// 											'duration' => 12
// 									],
// 									'V9 Representative of Tal Dagore' => [
// 											'duration' => 12
// 									],
// 									'Board of Directors Member' => [
// 											'duration' => 12
// 									],
// 									'Board of Directors Board President' => [
// 											'duration' => 12
// 									],
// 									'Board of Directors Vice President' => [
// 											'duration' => 12
// 									],
// 									'Board of Directors Secretary' => [
// 											'duration' => 12
// 									],
// 									'Board of Directors Treasurer' => [
// 											'duration' => 12
// 									]
// 							],
// 							'Shire' => [
// 									'Sheriff' => [
// 											'duration' => 6,
// 											'order' => 1,
// 											'title' => 'Lord|Lady'
// 									],
// 									'Regent' => [
// 											'duration' => 6,
// 											'order' => 4
// 									],
// 									'Prime Minster' => [
// 											'duration' => 6,
// 											'order' => 2
// 									],
// 									'Champion' => [
// 											'duration' => 6,
// 											'order' => 3
// 									]
// 							],
// 							'Barony' => [
// 									'Baron|Baroness' => [
// 											'duration' => 6,
// 											'order' => 1,
// 											'title' => 'Baronet'
// 									],
// 									'Regent' => [
// 											'duration' => 6,
// 											'order' => 4,
// 											'title' => 'Lord|Lady'
// 									],
// 									'Prime Minster' => [
// 											'duration' => 6,
// 											'order' => 2
// 									],
// 									'Champion' => [
// 											'duration' => 6,
// 											'order' => 3
// 									]
// 							],
// 							'Duchy' => [
// 									'Duke|Duchess' => [
// 											'duration' => 6,
// 											'order' => 1,
// 											'title' => 'Baron|Baroness'
// 									],
// 									'Regent' => [
// 											'duration' => 6,
// 											'order' => 4,
// 											'title' => 'Baronet'
// 									],
// 									'Prime Minster' => [
// 											'duration' => 6,
// 											'order' => 2,
// 											'title' => 'Lord|Lady'
// 									],
// 									'Champion' => [
// 											'duration' => 6,
// 											'order' => 3
// 									]
// 							],
// 							'Principality' => [
// 									'Monarch' => [
// 											'duration' => 6,
// 											'order' => 1
// 									],
// 									'Regent' => [
// 											'duration' => 6,
// 											'order' => 4
// 									],
// 									'Prime Minster' => [
// 											'duration' => 6,
// 											'order' => 2
// 									],
// 									'Champion' => [
// 											'duration' => 6,
// 											'order' => 3
// 									],
// 									'Board of Directors Member' => [
// 											'duration' => 6
// 									]
// 							]
// 					],
// 					20 => [
// 							'Kingdom' => [
// 									'Monarch' => [
// 											'duration' => 6,
// 											'order' => 1,
// 											'title' => 'Duke|Duchess'
// 									],
// 									'Regent' => [
// 											'duration' => 6,
// 											'order' => 4,
// 											'title' => 'Count|Countess'
// 									],
// 									'Prime Minister' => [
// 											'duration' => 6,
// 											'order' => 2,
// 											'title' => 'Baron|Baroness'
// 									],
// 									'Champion of the Realm' => [
// 											'duration' => 6,
// 											'order' => 3,
// 											'title' => 'Defender'
// 									],
// 									'Guildmaster of Reeves' => [
// 											'duration' => 6,
// 											'order' => 5
// 									],
// 									'Board of Directors Member' => [
// 											'duration' => 12
// 									],
// 									'Board of Directors President' => [
// 											'duration' => 12
// 									],
// 									'Board of Directors Secretary' => [
// 											'duration' => 12
// 									],
// 									'Board of Directors Treasurer' => [
// 											'duration' => 12
// 									],
// 									'Board of Directors Member' => [
// 											'duration' => 12
// 									],
// 									'Guildmaster of [Class]' => [
// 											'duration' => 6
// 									],
// 									'Rules Representative' => [
// 											'duration' => 12
// 									],
// 									'Chief Herald of the College of Arms' => [
// 											'duration' => 6
// 									],
// 									'Speaker of Knights' => [
// 											'duration' => 6
// 									],
// 									'Food Fight Representative' => [
// 											'duration' => 12
// 									]
// 							],
// 							'Shire' => [
// 									'Sheriff' => [
// 											'duration' => 6,
// 											'order' => 1,
// 											'title' => 'Lord|Lady'
// 									],
// 									'Regent' => [
// 											'duration' => 6,
// 											'order' => 4,
// 											'title' => 'Master|Mistress'
// 									],
// 									'Chancellor' => [
// 											'duration' => 6,
// 											'order' => 2,
// 											'title' => 'Esquire'
// 									],
// 									'Champion' => [
// 											'duration' => 6,
// 											'order' => 3,
// 											'title' => 'Esquire'
// 									]
// 							],
// 							'Barony' => [
// 									'Baron|Baroness' => [
// 											'duration' => 6,
// 											'order' => 1,
// 											'title' => 'Baronet'
// 									],
// 									'Regent' => [
// 											'duration' => 6,
// 											'order' => 4,
// 											'title' => 'Lord|Lady'
// 									],
// 									'Chancellor' => [
// 											'duration' => 6,
// 											'order' => 2,
// 											'title' => 'Master|Mistress'
// 									],
// 									'Champion' => [
// 											'duration' => 6,
// 											'order' => 3,
// 											'title' => 'Esquire'
// 									]
// 							],
// 							'Duchy' => [
// 									'Duke|Duchess' => [
// 											'duration' => 6,
// 											'order' => 1,
// 											'title' => 'Baron|Baroness'
// 									],
// 									'Regent' => [
// 											'duration' => 6,
// 											'order' => 4,
// 											'title' => 'Baronet'
// 									],
// 									'Chancellor' => [
// 											'duration' => 6,
// 											'order' => 2,
// 											'title' => 'Lord|Lady'
// 									],
// 									'Champion' => [
// 											'duration' => 6,
// 											'order' => 3,
// 											'title' => 'Master|Mistress'
// 									]
// 							],
// 							'Principality' => [
// 									'Prince|Princess' => [
// 											'duration' => 6,
// 											'order' => 1
// 									],
// 									'Regent' => [
// 											'duration' => 6,
// 											'order' => 4
// 									],
// 									'Chancellor' => [
// 											'duration' => 6,
// 											'order' => 2
// 									],
// 									'Champion' => [
// 											'duration' => 6,
// 											'order' => 3
// 									]
// 							]
// 					],
// 					21 => [
// 							'Kingdom' => [
// 									'Monarch' => [
// 											'duration' => 6,
// 											'order' => 1,
// 											'title' => 'Duke|Duchess'
// 									],
// 									'Regent' => [
// 											'duration' => 6,
// 											'order' => 4,
// 											'title' => 'Count|Countess'
// 									],
// 									'Prime Minister' => [
// 											'duration' => 6,
// 											'order' => 2,
// 											'title' => 'Steward'
// 									],
// 									'Champion' => [
// 											'duration' => 6,
// 											'order' => 3,
// 											'title' => 'Defender'
// 									],
// 									'Guildmaster of Reeves' => [
// 											'duration' => 6,
// 											'order' => 5,
// 											'title' => 'Steward'
// 									],
// 									'Heir Apparent' => [
// 											'duration' => 6
// 									],
// 									'Guildmaster of Knights' => [
// 											'duration' => 6
// 									],
// 									'Captain of the Royal Guard' => [
// 											'duration' => 6
// 									],
// 									'Royal Guard' => [
// 											'duration' => 6
// 									],
// 									'Regent\'s Defender' => [
// 											'duration' => 6
// 									],
// 									'Scribe' => [
// 											'duration' => 6
// 									],
// 									'Board of Directors Member' => [
// 											'duration' => 12
// 									],
// 									'Board of Directors President' => [
// 											'duration' => 12
// 									],
// 									'Board of Directors Vice President' => [
// 											'duration' => 12
// 									],
// 									'Board of Directors Treasurer' => [
// 											'duration' => 12
// 									],
// 									'Board of Directors Liason Officer' => [
// 											'duration' => 12
// 									],
// 									'Board of Directors Secretary' => [
// 											'duration' => 12
// 									]
// 							],
// 							'Shire' => [
// 									'Sheriff' => [
// 											'duration' => 6,
// 											'order' => 1
// 									],
// 									'Regent' => [
// 											'duration' => 6,
// 											'order' => 4
// 									],
// 									'Chancellor' => [
// 											'duration' => 6,
// 											'order' => 2
// 									],
// 									'Champion' => [
// 											'duration' => 6,
// 											'order' => 3
// 									]
// 							],
// 							'Barony' => [
// 									'Baron|Baroness' => [
// 											'duration' => 6,
// 											'order' => 1,
// 											'title' => 'Lord|Lady'
// 									],
// 									'Regent' => [
// 											'duration' => 6,
// 											'order' => 4
// 									],
// 									'Chancellor' => [
// 											'duration' => 6,
// 											'order' => 2
// 									],
// 									'Champion' => [
// 											'duration' => 6,
// 											'order' => 3
// 									]
// 							],
// 							'Duchy' => [
// 									'Duke|Duchess' => [
// 											'duration' => 6,
// 											'order' => 1,
// 											'title' => 'Baron|Baroness'
// 									],
// 									'Regent' => [
// 											'duration' => 6,
// 											'order' => 4,
// 											'title' => 'Lord|Lady'
// 									],
// 									'Chancellor' => [
// 											'duration' => 6,
// 											'order' => 2
// 									],
// 									'Champion' => [
// 											'duration' => 6,
// 											'order' => 3
// 									]
// 							],
// 							'Grand Duchy' => [
// 									'Monarch' => [
// 											'duration' => 6,
// 											'order' => 1
// 									],
// 									'Regent' => [
// 											'duration' => 6,
// 											'order' => 4
// 									],
// 									'Chancellor' => [
// 											'duration' => 6,
// 											'order' => 2
// 									],
// 									'Champion' => [
// 											'duration' => 6,
// 											'order' => 3
// 									]
// 							],
// 							'Principality' => [
// 									'Prince|Princess' => [
// 											'duration' => 6,
// 											'order' => 1,
// 											'title' => 'Marquis|Marquess'
// 									],
// 									'Regent' => [
// 											'duration' => 6,
// 											'order' => 4,
// 											'title' => 'Baron|Baroness'
// 									],
// 									'Chancellor' => [
// 											'duration' => 6,
// 											'order' => 2,
// 											'title' => 'Steward'
// 									],
// 									'Champion' => [
// 											'duration' => 6,
// 											'order' => 3,
// 											'title' => 'Defender'
// 									],
// 									'Board of Directors Member' => [
// 											'duration' => 12
// 									],
// 									'Board of Directors President' => [
// 											'duration' => 12
// 									],
// 									'Board of Directors Vice President' => [
// 											'duration' => 12
// 									],
// 									'Board of Directors Treasurer' => [
// 											'duration' => 12
// 									],
// 									'Board of Directors Liason Officer' => [
// 											'duration' => 12
// 									],
// 									'Board of Directors Secretary' => [
// 											'duration' => 12
// 									]
// 							]
// 					],
// 					22 => [
// 							'Kingdom' => [
// 									'Emperor|Empress' => [
// 											'duration' => 6,
// 											'order' => 1,
// 											'title' => 'Duke|Duchess'
// 									],
// 									'Imperial Regent' => [
// 											'duration' => 6,
// 											'order' => 4,
// 											'title' => 'Count|Countess'
// 									],
// 									'Imperial Prime Minister' => [
// 											'duration' => 6,
// 											'order' => 2,
// 											'title' => 'Count|Countess'
// 									],
// 									'Imperial Champion' => [
// 											'duration' => 6,
// 											'order' => 3,
// 											'title' => 'Defender'
// 									],
// 									'Guildmaster of Reeves' => [
// 											'duration' => 6,
// 											'order' => 5
// 									],
// 									'Guildmaster of Knights' => [
// 											'duration' => 6
// 									],
// 									'InterKingdom Rules Committee Representative' => [
// 											'duration' => 6
// 									],
// 									'Captain of the Guard' => [
// 											'duration' => 6
// 									],
// 									'Guard Member' => [
// 											'duration' => 6
// 									],
// 									'Regent Defender' => [
// 											'duration' => 6
// 									],
// 									'Court Scribe' => [
// 											'duration' => 6
// 									],
// 									'Guildmaster of [Class]' => [
// 											'duration' => 6
// 									],
// 									'Guildmaster of [A&S]' => [
// 											'duration' => 6
// 									],
// 									'Board of Directors Member' => [
// 											'duration' => 12
// 									],
// 									'Board of Directors President' => [
// 											'duration' => 12
// 									],
// 									'Board of Directors Secretary' => [
// 											'duration' => 12
// 									]
// 							],
// 							'Shire' => [
// 									'Sheriff' => [
// 											'duration' => 6,
// 											'order' => 1
// 									],
// 									'Provincial Regent' => [
// 											'duration' => 6,
// 											'order' => 4
// 									],
// 									'Provincial Prime Minister' => [
// 											'duration' => 6,
// 											'order' => 2
// 									],
// 									'Provincial Treasurer' => [
// 											'duration' => 6
// 									],
// 									'Provincial Champion' => [
// 											'duration' => 6,
// 											'order' => 3
// 									],
// 									'Provincial Guildmaster of Reeves' => [
// 											'duration' => 6,
// 											'order' => 5
// 									]
// 							],
// 							'Barony' => [
// 									'Baron|Baroness' => [
// 											'duration' => 6,
// 											'order' => 1,
// 											'title' => 'Baronet'
// 									],
// 									'Provincial Regent' => [
// 											'duration' => 6,
// 											'order' => 4
// 									],
// 									'Provincial Prime Minister' => [
// 											'duration' => 6,
// 											'order' => 2
// 									],
// 									'Provincial Treasurer' => [
// 											'duration' => 6
// 									],
// 									'Provincial Champion' => [
// 											'duration' => 6,
// 											'order' => 3
// 									],
// 									'Provincial Guildmaster of Reeves' => [
// 											'duration' => 6,
// 											'order' => 5
// 									]
// 							],
// 							'Duchy' => [
// 									'Duke|Duchess' => [
// 											'duration' => 6,
// 											'order' => 1,
// 											'title' => 'Baron|Baroness'
// 									],
// 									'Provincial Regent' => [
// 											'duration' => 6,
// 											'order' => 4,
// 											'title' => 'Baronet'
// 									],
// 									'Provincial Prime Minister' => [
// 											'duration' => 6,
// 											'order' => 2,
// 											'title' => 'Baronet'
// 									],
// 									'Provincial Treasurer' => [
// 											'duration' => 6
// 									],
// 									'Provincial Champion' => [
// 											'duration' => 6,
// 											'order' => 3
// 									],
// 									'Provincial Guildmaster of Reeves' => [
// 											'duration' => 6,
// 											'order' => 5
// 									]
// 							],
// 							'Principality' => [
// 									'Prince|Princess' => [
// 											'duration' => 6,
// 											'order' => 1
// 									],
// 									'Principality Regent' => [
// 											'duration' => 6,
// 											'order' => 4
// 									],
// 									'Principality Prime Minister' => [
// 											'duration' => 6,
// 											'order' => 2
// 									],
// 									'Principality Treasurer' => [
// 											'duration' => 6
// 									],
// 									'Principality Champion' => [
// 											'duration' => 6,
// 											'order' => 3
// 									],
// 									'Principality Guildmaster of Reeves' => [
// 											'duration' => 6,
// 											'order' => 5
// 									]
// 							]
// 					],
// 					24 => [
// 							'Kingdom' => [
// 									'Monarch' => [
// 											'duration' => 6,
// 											'order' => 1,
// 											'title' => 'Duke|Duchess'
// 									],
// 									'Regent' => [
// 											'duration' => 6,
// 											'order' => 4,
// 											'title' => 'Baron|Baroness'
// 									],
// 									'Prime Minister' => [
// 											'duration' => 6,
// 											'order' => 2,
// 											'title' => 'Count|Countess'
// 									],
// 									'Champion' => [
// 											'duration' => 6,
// 											'order' => 3,
// 											'title' => 'Defender'
// 									],
// 									'Guildmaster of Reeves' => [
// 											'duration' => 6,
// 											'order' => 5,
// 											'title' => 'Baronet|Baronetess'
// 									],
// 									'Captain of the Guard' => [
// 											'duration' => 6
// 									],
// 									'Regent\'s Apprentice' => [
// 											'duration' => 6
// 									],
// 									'Crown Guard Member' => [
// 											'duration' => 6
// 									],
// 									'Principal Herald' => [
// 											'duration' => 6
// 									],
// 									'Court Herald' => [
// 											'duration' => 6
// 									],
// 									'Scribe' => [
// 											'duration' => 6
// 									],
// 									'Guildmaster of [Class]' => [
// 											'duration' => 6
// 									],
// 									'Senator' => [
// 											'duration' => 6
// 									],
// 									'Board of Directors Member' => [
// 											'duration' => 12
// 									],
// 									'Board of Directors President' => [
// 											'duration' => 12
// 									],
// 									'Board of Directors Vice President' => [
// 											'duration' => 12
// 									],
// 									'Board of Directors Secretary' => [
// 											'duration' => 12
// 									],
// 									'Board of Directors Treasurer' => [
// 											'duration' => 12
// 									],
// 									'Board of Directors Surrogate' => [
// 											'duration' => 12
// 									],
// 									'Board of Directors Alternate' => [
// 											'duration' => 12
// 									]
// 							],
// 							'Shire' => [
// 									'Sheriff' => [
// 											'duration' => 6,
// 											'order' => 1,
// 											'title' => 'Lord|Lady'
// 									],
// 									'Regent' => [
// 											'duration' => 6,
// 											'order' => 4,
// 											'title' => 'Esquire'
// 									],
// 									'Chancellor' => [
// 											'duration' => 6,
// 											'order' => 2,
// 											'title' => 'Master|Mistress'
// 									],
// 									'Champion' => [
// 											'duration' => 6,
// 											'order' => 3,
// 											'title' => 'Esquire'
// 									],
// 									'Guildmaster of Reeves' => [
// 											'duration' => 6,
// 											'order' => 5,
// 											'title' => 'Esquire'
// 									]
// 							],
// 							'Barony' => [
// 									'Baron|Baroness' => [
// 											'duration' => 6,
// 											'order' => 1,
// 											'title' => 'Baronet|Baronetess'
// 									],
// 									'Regent' => [
// 											'duration' => 6,
// 											'order' => 4,
// 											'title' => 'Master|Mistress'
// 									],
// 									'Chancellor' => [
// 											'duration' => 6,
// 											'order' => 2,
// 											'title' => 'Lord|Lady'
// 									],
// 									'Champion' => [
// 											'duration' => 6,
// 											'order' => 3,
// 											'title' => 'Esquire'
// 									],
// 									'Guildmaster of Reeves' => [
// 											'duration' => 6,
// 											'order' => 5,
// 											'title' => 'Esquire'
// 									]
// 							],
// 							'Duchy' => [
// 									'Duke|Duchess' => [
// 											'duration' => 6,
// 											'order' => 1,
// 											'title' => 'Baron|Baroness'
// 									],
// 									'Regent' => [
// 											'duration' => 6,
// 											'order' => 4,
// 											'title' => 'Lord|Lady'
// 									],
// 									'Chancellor' => [
// 											'duration' => 6,
// 											'order' => 2,
// 											'title' => 'Baronet|Baronetess'
// 									],
// 									'Champion' => [
// 											'duration' => 6,
// 											'order' => 3,
// 											'title' => 'Master|Mistress'
// 									],
// 									'Guildmaster of Reeves' => [
// 											'duration' => 6,
// 											'order' => 5,
// 											'title' => 'Master|Mistress'
// 									]
// 							],
// 							'Grand Duchy' => [
// 									'Grand Duke|Grand Duchess' => [
// 											'duration' => 6,
// 											'order' => 1,
// 											'title' => 'Count|Countess'
// 									],
// 									'Regent' => [
// 											'duration' => 6,
// 											'order' => 4,
// 											'title' => 'Baronet|Baronetess'
// 									],
// 									'Chancellor' => [
// 											'duration' => 6,
// 											'order' => 2,
// 											'title' => 'Baron|Baroness'
// 									],
// 									'Champion' => [
// 											'duration' => 6,
// 											'order' => 3,
// 											'title' => 'Lord|Lady'
// 									],
// 									'Guildmaster of Reeves' => [
// 											'duration' => 6,
// 											'order' => 5,
// 											'title' => 'Lord|Lady'
// 									]
// 							],
// 							'Principality' => [
// 									'Prince|Princess' => [
// 											'duration' => 6,
// 											'order' => 1,
// 											'title' => 'Count|Countess'
// 									],
// 									'Regent' => [
// 											'duration' => 6,
// 											'order' => 4,
// 											'title' => 'Baronet|Baronetess'
// 									],
// 									'Supreme Chancellor' => [
// 											'duration' => 6,
// 											'order' => 2,
// 											'title' => 'Baron|Baroness'
// 									],
// 									'Champion' => [
// 											'duration' => 6,
// 											'order' => 3,
// 											'title' => 'Lord|Lady'
// 									],
// 									'Guildmaster of Reeves' => [
// 											'duration' => 6,
// 											'order' => 5,
// 											'title' => 'Lord|Lady'
// 									]
// 							]
// 					],
// 					25 => [
// 							'Kingdom' => [
// 									'Monarch' => [
// 											'duration' => 6,
// 											'order' => 1,
// 											'title' => 'Viscount|Viscountess'
// 									],
// 									'Regent' => [
// 											'duration' => 6,
// 											'order' => 4,
// 											'title' => 'Viscount|Viscountess'
// 									],
// 									'Champion of the Realm' => [
// 											'duration' => 6,
// 											'order' => 3,
// 											'title' => 'Defender'
// 									],
// 									'Prime Minister' => [
// 											'duration' => 6,
// 											'order' => 2,
// 											'title' => 'Viscount|Viscountess'
// 									],
// 									'Guildmaster of Reeves' => [
// 											'duration' => 6,
// 											'order' => 5
// 									],
// 									'Board of Directors Operations Officer' => [
// 											'duration' => 6
// 									],
// 									'Board of Directors Financial Officer' => [
// 											'duration' => 6
// 									],
// 									'Board of Directors Member' => [
// 											'duration' => 12
// 									],
// 									'Board of Directors President' => [
// 											'duration' => 6
// 									],
// 									'Board of Directors Secretary' => [
// 											'duration' => 6
// 									],
// 									'Board of Directors Treasurer' => [
// 											'duration' => 6
// 									],
// 									'Operations Officer' => [
// 											'duration' => 6
// 									],
// 									'Assistant Operations Officer' => [
// 											'duration' => 6
// 									],
// 									'Adjudication Chief' => [
// 											'duration' => 6
// 									],
// 									'Quartermaster' => [
// 											'duration' => 6
// 									],
// 									'Guildmaster of [Class]' => [
// 											'duration' => 6
// 									],
// 									'Kingdom Rules Representative' => [
// 											'duration' => 6
// 									],
// 									'Viridian Outlands Corpora Clarification Committee Member' => [
// 											'duration' => 6
// 									],
// 									'Viridian Outlands Corpora Clarification Committee Board Member' => [
// 											'duration' => null
// 									],
// 									'Guildmaster of Knights' => [
// 											'duration' => 6
// 									]
// 							],
// 							'Shire' => [
// 									'Sheriff' => [
// 											'duration' => 6,
// 											'order' => 1,
// 											'title' => 'Lord|Lady'
// 									],
// 									'Regent' => [
// 											'duration' => 6,
// 											'order' => 4,
// 											'title' => 'Master'
// 									],
// 									'Chancellor' => [
// 											'duration' => 6,
// 											'order' => 2,
// 											'title' => 'Esquire'
// 									],
// 									'Champion' => [
// 											'duration' => 6,
// 											'order' => 3,
// 											'title' => 'Esquire'
// 									]
// 							],
// 							'Barony' => [
// 									'Baron|Baroness' => [
// 											'duration' => 6,
// 											'order' => 1,
// 											'title' => 'Baronet|Baronetess'
// 									],
// 									'Regent' => [
// 											'duration' => 6,
// 											'order' => 4,
// 											'title' => 'Lord|Lady'
// 									],
// 									'Chancellor' => [
// 											'duration' => 6,
// 											'order' => 2,
// 											'title' => 'Master'
// 									],
// 									'Champion' => [
// 											'duration' => 6,
// 											'order' => 3,
// 											'title' => 'Master'
// 									]
// 							],
// 							'Duchy' => [
// 									'Duke|Duchess' => [
// 											'duration' => 6,
// 											'order' => 1,
// 											'title' => 'Baron|Baroness'
// 									],
// 									'Regent' => [
// 											'duration' => 6,
// 											'order' => 4,
// 											'title' => 'Baronet|Baronetess'
// 									],
// 									'Chancellor' => [
// 											'duration' => 6,
// 											'order' => 2,
// 											'title' => 'Lord|Lady'
// 									],
// 									'Champion' => [
// 											'duration' => 6,
// 											'order' => 3,
// 											'title' => 'Lord|Lady'
// 									]
// 							],
// 							'Principality' => [
// 									'Monarch' => [
// 											'duration' => 6,
// 											'order' => 1,
// 											'title' => 'Count|Countess'
// 									],
// 									'Regent' => [
// 											'duration' => 6,
// 											'order' => 4,
// 											'title' => 'Marquis|Marquess'
// 									],
// 									'Chancellor' => [
// 											'duration' => 6,
// 											'order' => 2,
// 											'title' => 'Baron|Baroness'
// 									],
// 									'Champion' => [
// 											'duration' => 6,
// 											'order' => 3,
// 											'title' => 'Baron|Baroness'
// 									]
// 							]
// 					],
// 					27 => [
// 							'Kingdom' => [
// 									'Monarch' => [
// 											'duration' => 6,
// 											'order' => 1,
// 											'title' => 'Duke|Duchess'
// 									],
// 									'Regent' => [
// 											'duration' => 6,
// 											'order' => 4,
// 											'title' => 'Count|Countess'
// 									],
// 									'Prime Minister' => [
// 											'duration' => 6,
// 											'order' => 2,
// 											'title' => 'Count|Countess'
// 									],
// 									'Champion' => [
// 											'duration' => 6,
// 											'order' => 3,
// 											'title' => 'Defender'
// 									],
// 									'Guildmaster of Reeves' => [
// 											'duration' => 6,
// 											'order' => 5
// 									],
// 									'Board of Directors Member' => [
// 											'duration' => 24
// 									],
// 									'Board of Directors Ex Officio' => [
// 											'duration' => 24
// 									],
// 									'Board of Directors President' => [
// 											'duration' => 12
// 									],
// 									'Board of Directors Treasurer' => [
// 											'duration' => 12
// 									],
// 									'Board of Directors Secretary' => [
// 											'duration' => 12
// 									],
// 									'The Rules Representative' => [
// 											'duration' => 12
// 									],
// 									'The Kingdom Senator' => [
// 											'duration' => 12
// 									]
// 							],
// 							'Outpost' => [
// 									'Monarch' => [
// 											'duration' => 6,
// 											'order' => 1
// 									],
// 									'Regent' => [
// 											'duration' => 6,
// 											'order' => 4
// 									],
// 									'Prime Minister' => [
// 											'duration' => 6,
// 											'order' => 2
// 									],
// 									'Champion' => [
// 											'duration' => 6,
// 											'order' => 3
// 									],
// 									'Guildmaster of Reeves' => [
// 											'duration' => 6,
// 											'order' => 5
// 									]
// 							],
// 							'Shire' => [
// 									'Monarch' => [
// 											'duration' => 6,
// 											'order' => 1
// 									],
// 									'Regent' => [
// 											'duration' => 6,
// 											'order' => 4
// 									],
// 									'Prime Minister' => [
// 											'duration' => 6,
// 											'order' => 2
// 									],
// 									'Champion' => [
// 											'duration' => 6,
// 											'order' => 3
// 									],
// 									'Guildmaster of Reeves' => [
// 											'duration' => 6,
// 											'order' => 5
// 									]
// 							],
// 							'Barony' => [
// 									'Monarch' => [
// 											'duration' => 6,
// 											'order' => 1,
// 											'title' => 'Baronet'
// 									],
// 									'Regent' => [
// 											'duration' => 6,
// 											'order' => 4
// 									],
// 									'Prime Minister' => [
// 											'duration' => 6,
// 											'order' => 2
// 									],
// 									'Champion' => [
// 											'duration' => 6,
// 											'order' => 3
// 									],
// 									'Guildmaster of Reeves' => [
// 											'duration' => 6,
// 											'order' => 5
// 									]
// 							],
// 							'Duchy' => [
// 									'Monarch' => [
// 											'duration' => 6,
// 											'order' => 1,
// 											'title' => 'Baron|Baroness'
// 									],
// 									'Regent' => [
// 											'duration' => 6,
// 											'order' => 4,
// 											'title' => 'Baronet'
// 									],
// 									'Prime Minister' => [
// 											'duration' => 6,
// 											'order' => 2,
// 											'title' => 'Baronet'
// 									],
// 									'Champion' => [
// 											'duration' => 6,
// 											'order' => 3
// 									],
// 									'Guildmaster of Reeves' => [
// 											'duration' => 6,
// 											'order' => 5
// 									]
// 							],
// 							'Grand Duchy' => [
// 									'Monarch' => [
// 											'duration' => 6,
// 											'order' => 1
// 									],
// 									'Regent' => [
// 											'duration' => 6,
// 											'order' => 4
// 									],
// 									'Prime Minister' => [
// 											'duration' => 6,
// 											'order' => 2
// 									],
// 									'Champion' => [
// 											'duration' => 6,
// 											'order' => 3
// 									],
// 									'Guildmaster of Reeves' => [
// 											'duration' => 6,
// 											'order' => 5
// 									]
// 							]
// 					],
// 					31 => [
// 							'Kingdom' => [
// 									'Monarch' => [
// 											'duration' => 6,
// 											'order' => 1,
// 											'title' => 'Duke|Duchess'
// 									],
// 									'Regent' => [
// 											'duration' => 6,
// 											'order' => 4,
// 											'title' => 'Count|Countess'
// 									],
// 									'Chancellor' => [
// 											'duration' => 6,
// 											'order' => 2,
// 											'title' => 'Count|Countess'
// 									],
// 									'Champion' => [
// 											'duration' => 6,
// 											'order' => 3,
// 											'title' => 'Defender'
// 									],
// 									'Guildmaster of Reeves' => [
// 											'duration' => 6,
// 											'order' => 5
// 									],
// 									'Guildmaster of [Class]' => [
// 											'duration' => 6
// 									],
// 									'Board of Directors Member' => [
// 											'duration' => 24
// 									],
// 									'Board of Directors CEO' => [
// 											'duration' => 24
// 									],
// 									'Board of Directors CFO' => [
// 											'duration' => 24
// 									],
// 									'Board of Directors Secretary' => [
// 											'duration' => 24
// 									],
// 									'The Rules Representative' => [
// 											'duration' => 6
// 									]
// 							],
// 							'Shire' => [
// 									'Monarch' => [
// 											'duration' => 6,
// 											'order' => 1,
// 											'title' => 'Lord|Lady'
// 									],
// 									'Regent' => [
// 											'duration' => 6,
// 											'order' => 4,
// 											'title' => 'Master|Mistress'
// 									],
// 									'Chancellor' => [
// 											'duration' => 6,
// 											'order' => 2,
// 											'title' => 'Esquire'
// 									],
// 									'Champion' => [
// 											'duration' => 6,
// 											'order' => 3,
// 											'title' => 'Esquire'
// 									],
// 									'Guildmaster of Reeves' => [
// 											'duration' => 6,
// 											'order' => 5,
// 											'title' => 'Esquire'
// 									],
// 									'Guildmaster of [Class]' => [
// 											'duration' => 6
// 									]
// 							],
// 							'Barony' => [
// 									'Monarch' => [
// 											'duration' => 6,
// 											'order' => 1,
// 											'title' => 'Baronet'
// 									],
// 									'Regent' => [
// 											'duration' => 6,
// 											'order' => 4,
// 											'title' => 'Lord|Lady'
// 									],
// 									'Chancellor' => [
// 											'duration' => 6,
// 											'order' => 2,
// 											'title' => 'Master|Mistress'
// 									],
// 									'Champion' => [
// 											'duration' => 6,
// 											'order' => 3,
// 											'title' => 'Esquire'
// 									],
// 									'Guildmaster of Reeves' => [
// 											'duration' => 6,
// 											'order' => 5,
// 											'title' => 'Esquire'
// 									],
// 									'Guildmaster of [Class]' => [
// 											'duration' => 6
// 									]
// 							],
// 							'Duchy' => [
// 									'Monarch' => [
// 											'duration' => 6,
// 											'order' => 1,
// 											'title' => 'Baron|Baroness'
// 									],
// 									'Regent' => [
// 											'duration' => 6,
// 											'order' => 4,
// 											'title' => 'Baronet'
// 									],
// 									'Chancellor' => [
// 											'duration' => 6,
// 											'order' => 2,
// 											'title' => 'Lord|Lady'
// 									],
// 									'Champion' => [
// 											'duration' => 6,
// 											'order' => 3,
// 											'title' => 'Master|Mistress'
// 									],
// 									'Guildmaster of Reeves' => [
// 											'duration' => 6,
// 											'order' => 5,
// 											'title' => 'Master|Mistress'
// 									],
// 									'Guildmaster of [Class]' => [
// 											'duration' => 6
// 									]
// 							]
// 					],
// 					34 => [
// 							'Kingdom' => [
// 									'Champion of Hats' => [
// 											'duration' => 6,
// 											'order' => 1,
// 											'title' => 'Duke|Duchess'
// 									],
// 									'Champion of Art' => [
// 											'duration' => 6,
// 											'order' => 4,
// 											'title' => 'Count|Countess'
// 									],
// 									'Champion of Wacks' => [
// 											'duration' => 6,
// 											'order' => 3,
// 											'title' => 'Defender'
// 									],
// 									'Champion of Records' => [
// 											'duration' => 6,
// 											'order' => 2
// 									],
// 									'Champion of Rules' => [
// 											'duration' => 6,
// 											'order' => 5
// 									],
// 									'Champion of Knights' => [
// 											'duration' => 6
// 									]
// 							],
// 							'Burg' => [
// 									'Monarch' => [
// 											'duration' => 6,
// 											'order' => 1
// 									],
// 									'Regent' => [
// 											'duration' => 6,
// 											'order' => 4
// 									],
// 									'Prime Minister' => [
// 											'duration' => 6,
// 											'order' => 2
// 									],
// 									'Champion' => [
// 											'duration' => 6,
// 											'order' => 3
// 									]
// 							],
// 							'Shire' => [
// 									'Monarch' => [
// 											'duration' => 6,
// 											'order' => 1
// 									],
// 									'Regent' => [
// 											'duration' => 6,
// 											'order' => 4
// 									],
// 									'Prime Minister' => [
// 											'duration' => 6,
// 											'order' => 2
// 									],
// 									'Champion' => [
// 											'duration' => 6,
// 											'order' => 3
// 									]
// 							],
// 							'Barony' => [
// 									'Monarch' => [
// 											'duration' => 6,
// 											'order' => 1
// 									],
// 									'Regent' => [
// 											'duration' => 6,
// 											'order' => 4
// 									],
// 									'Prime Minister' => [
// 											'duration' => 6,
// 											'order' => 2
// 									],
// 									'Champion' => [
// 											'duration' => 6,
// 											'order' => 3
// 									]
// 							],
// 							'Duchy' => [
// 									'Monarch' => [
// 											'duration' => 6,
// 											'order' => 1
// 									],
// 									'Regent' => [
// 											'duration' => 6,
// 											'order' => 4
// 									],
// 									'Prime Minister' => [
// 											'duration' => 6,
// 											'order' => 2
// 									],
// 									'Champion' => [
// 											'duration' => 6,
// 											'order' => 3
// 									]
// 							],
// 							'Grand Duchy' => [
// 									'Monarch' => [
// 											'duration' => 6,
// 											'order' => 1
// 									],
// 									'Regent' => [
// 											'duration' => 6,
// 											'order' => 4
// 									],
// 									'Prime Minister' => [
// 											'duration' => 6,
// 											'order' => 2
// 									],
// 									'Champion' => [
// 											'duration' => 6,
// 											'order' => 3
// 									]
// 							]
// 					],
// 					36 => [
// 							'Kingdom' => [
// 									'Kingdom Monarch' => [
// 											'duration' => 6,
// 											'order' => 1,
// 											'title' => 'Duke|Duchess'
// 									],
// 									'Kingdom Prime Minister' => [
// 											'duration' => 6,
// 											'order' => 2,
// 											'title' => 'Baronet|Barnetess'
// 									],
// 									'Kingdom Regent' => [
// 											'duration' => 6,
// 											'order' => 4,
// 											'title' => 'Count|Countess'
// 									],
// 									'Kingdom Champion' => [
// 											'duration' => 6,
// 											'order' => 3,
// 											'title' => 'Defender'
// 									],
// 									'Kingdom Guildmaster of Reeves' => [
// 											'duration' => 6,
// 											'order' => 5,
// 											'title' => 'Baronet|Barnetess'
// 									],
// 									'Heir Apparent' => [
// 											'duration' => 6
// 									],
// 									'Captain of the Guard' => [
// 											'duration' => 6
// 									],
// 									'Members of the Guard' => [
// 											'duration' => 6
// 									],
// 									'Regent\'s Defender' => [
// 											'duration' => 6
// 									],
// 									'Guildmaster of [A&S]' => [
// 											'duration' => 6
// 									],
// 									'Guildmaster of [Class]' => [
// 											'duration' => 6
// 									],
// 									'Scribe' => [
// 											'duration' => 6
// 									],
// 									'Court Herald' => [
// 											'duration' => 6
// 									],
// 									'Guildmaster of Knights' => [
// 											'duration' => 6
// 									],
// 									'Circle of Steel Representative' => [
// 											'duration' => 6
// 									],
// 									'Ambassador' => [
// 											'duration' => 6
// 									],
// 									'Grand Librarian' => [
// 											'duration' => 6
// 									],
// 									'Chief Executive Officer' => [
// 											'duration' => 24
// 									],
// 									'Regional Executive Officer' => [
// 											'duration' => 6
// 									],
// 									'Administrative Officer' => [
// 											'duration' => 24
// 									],
// 									'Board of Directors President' => [
// 											'duration' => 24
// 									],
// 									'Board of Directors Secretary-Treasurer' => [
// 											'duration' => 24
// 									],
// 									'Board of Directors Vice President' => [
// 											'duration' => 6
// 									],
// 									'Board of Directors Board Liaison' => [
// 											'duration' => 6
// 									]
// 							],
// 							'Shire' => [
// 									'Sheriff' => [
// 											'duration' => 6,
// 											'order' => 1
// 									],
// 									'Regent' => [
// 											'duration' => 6,
// 											'order' => 4
// 									],
// 									'Chancellor' => [
// 											'duration' => 6,
// 											'order' => 2
// 									],
// 									'Champion' => [
// 											'duration' => 6,
// 											'order' => 3
// 									],
// 									'Guildmaster of Reeves' => [
// 											'duration' => 6,
// 											'order' => 5
// 									]
// 							],
// 							'Barony' => [
// 									'Baron|Baroness' => [
// 											'duration' => 6,
// 											'order' => 1
// 									],
// 									'Regent' => [
// 											'duration' => 6,
// 											'order' => 4
// 									],
// 									'Chancellor' => [
// 											'duration' => 6,
// 											'order' => 2
// 									],
// 									'Champion' => [
// 											'duration' => 6,
// 											'order' => 3
// 									],
// 									'Guildmaster of Reeves' => [
// 											'duration' => 6,
// 											'order' => 5
// 									]
// 							],
// 							'Duchy' => [
// 									'Duke|Duchess' => [
// 											'duration' => 6,
// 											'order' => 1
// 									],
// 									'Regent' => [
// 											'duration' => 6,
// 											'order' => 4
// 									],
// 									'Chancellor' => [
// 											'duration' => 6,
// 											'order' => 2
// 									],
// 									'Champion' => [
// 											'duration' => 6,
// 											'order' => 3
// 									],
// 									'Guildmaster of Reeves' => [
// 											'duration' => 6,
// 											'order' => 5
// 									]
// 							],
// 							'Grand Duchy' => [
// 									'Grand Duke|Grand Duchess' => [
// 											'duration' => 6,
// 											'order' => 1
// 									],
// 									'Regent' => [
// 											'duration' => 6,
// 											'order' => 4
// 									],
// 									'Chancellor' => [
// 											'duration' => 6,
// 											'order' => 2
// 									],
// 									'Champion' => [
// 											'duration' => 6,
// 											'order' => 3
// 									],
// 									'Guildmaster of Reeves' => [
// 											'duration' => 6,
// 											'order' => 5
// 									]
// 							]
// 					],
// 					38 => [
// 							'Kingdom' => [
// 									'Kingdom Monarch' => [
// 											'duration' => 6,
// 											'order' => 1,
// 											'title' => 'Duke|Duchess'
// 									],
// 									'Kingdom Prime Minister' => [
// 											'duration' => 6,
// 											'order' => 2,
// 											'title' => 'Marquis|Marquess'
// 									],
// 									'Kingdom Guildmaster of Reeves' => [
// 											'duration' => 6,
// 											'order' => 5,
// 											'title' => 'Count|Countess'
// 									],
// 									'Kingdom Regent' => [
// 											'duration' => 6,
// 											'order' => 4,
// 											'title' => 'Viscount|Viscountess'
// 									],
// 									'Kingdom Champion' => [
// 											'duration' => 6,
// 											'order' => 3,
// 											'title' => 'Viscount|Viscountess'
// 									],
// 									'Kingdom Ambassador' => [
// 											'duration' => 6
// 									],
// 									'Guildmaster of Knights' => [
// 											'duration' => 6
// 									],
// 									'Board of Directors Member' => [
// 											'duration' => 48
// 									]
// 							],
// 							'Shire' => [
// 									'Monarch' => [
// 											'duration' => 6,
// 											'order' => 1,
// 											'title' => 'Lord|Lady'
// 									],
// 									'Prime Minister' => [
// 											'duration' => 6,
// 											'order' => 2,
// 											'title' => 'Master|Mistress'
// 									]
// 							],
// 							'Barony' => [
// 									'Monarch' => [
// 											'duration' => 6,
// 											'order' => 1,
// 											'title' => 'Baronet'
// 									],
// 									'Prime Minister' => [
// 											'duration' => 6,
// 											'order' => 2,
// 											'title' => 'Lord|Lady'
// 									],
// 									'Guildmaster of Reeves' => [
// 											'duration' => 6,
// 											'order' => 5,
// 											'title' => 'Lord|Lady'
// 									]
// 							],
// 							'Duchy' => [
// 									'Monarch' => [
// 											'duration' => 6,
// 											'order' => 1,
// 											'title' => 'Baron|Baroness'
// 									],
// 									'Prime Minister' => [
// 											'duration' => 6,
// 											'order' => 2,
// 											'title' => 'Baronet'
// 									],
// 									'Guildmaster of Reeves' => [
// 											'duration' => 6,
// 											'order' => 5,
// 											'title' => 'Lord|Lady'
// 									],
// 									'Regent' => [
// 											'duration' => 6,
// 											'order' => 4,
// 											'title' => 'Lord|Lady'
// 									],
// 									'Champion' => [
// 											'duration' => 6,
// 											'order' => 3,
// 											'title' => 'Lord|Lady'
// 									]
// 							],
// 							'Principality' => [
// 									'Monarch' => [
// 											'duration' => 6,
// 											'order' => 1,
// 											'title' => 'Marquis|Marquess'
// 									],
// 									'Prime Minister' => [
// 											'duration' => 6,
// 											'order' => 2,
// 											'title' => 'Count|Countess'
// 									],
// 									'Guildmaster of Reeves' => [
// 											'duration' => 6,
// 											'order' => 5,
// 											'title' => 'Viscount|Viscountess'
// 									],
// 									'Regent' => [
// 											'duration' => 6,
// 											'order' => 4,
// 											'title' => 'Baronet'
// 									],
// 									'Champion' => [
// 											'duration' => 6,
// 											'order' => 3,
// 											'title' => 'Baronet'
// 									]
// 							]
// 					]
// 			];

			//archetypes
// 			$this->info('Importing Archetypes...');
// 			$oldArchetypes = $backupConnect->table('ork_class')->get()->toArray();
// 			DB::table('archetypes')->truncate();
// 			if (count($oldArchetypes) > 0) {
// 				$bar1 = $this->output->createProgressBar(count($oldArchetypes));
// 				$bar1->start();
// 				foreach ($oldArchetypes as $oldArchetype) {
// 					$archetypeId = DB::table('archetypes')->insertGetId([
// 							'name' => $oldArchetype->name, 
// 							'is_active' => $oldArchetype->active
// 					]);
// 					$transArchetypes[$oldArchetype->class_id] = $archetypeId;
// 					$bar1->advance();
// 				}
// 				$bar1->finish();
// 				$this->info('');
// 			}
// 			//TODO: delete these
// 			DB::table('trans')->insert([
// 					'table' => 'archetypes',
// 					'value' => serialize($transArchetypes)
// 			]);
			
// 			//kingdoms
// 			$this->info('Importing Kingdoms...');
// 			$oldKingdoms = $backupConnect->table('ork_kingdom')->get()->toArray();
// 			DB::table('kingdoms')->truncate();
// 			$freeholds = null;
// 			if (count($oldKingdoms) > 0) {
// 				$bar2 = $this->output->createProgressBar(count($oldKingdoms));
// 				$bar2->start();
// 				foreach ($oldKingdoms as $oldKingdom) {
// 					//nope this guy
// 					if($oldKingdom->name === '&THORN;e Olde Records Empire'){
// 						$deadRecords['Kingdoms'][$oldKingdom->kingdom_id] = $oldKingdom;
// 						//we're moving them to freeholds
// 						$transKingdoms[$oldKingdom->kingdom_id] = $freeholds;
// 					}
// 					$kingdomId = DB::table('kingdoms')->insertGetId([
// 							'parent_id' => $oldKingdom->parent_kingdom_id === 0 ? null : $transKingdoms[$oldKingdom->parent_kingdom_id],
// 							'name' => $oldKingdom->name,
// 							'abbreviation' => $oldKingdom->abbreviation,
// 							'heraldry' => $oldKingdom->has_heraldry === 1 ? sprintf('%04d.jpg', $oldKingdom->kingdom_id) : null,
// 							'is_active' => $oldKingdom->active === 'Active' ? 1 : 0,
// 							'created_at' => $oldKingdom->modified,
// 							'updated_at' => $oldKingdom->modified
// 					]);
// 					if($oldKingdom->name === 'The Freeholds of Amtgard'){
// 						$freeholds = $kingdomId;
// 					}
// 					$transKingdoms[$oldKingdom->kingdom_id] = $kingdomId;
// 					$bar2->advance();
// 				}
// 				$bar2->finish();
// 				$this->info('');
// 			}
// 			DB::table('trans')->insert([
// 					'table' => 'kingdoms',
// 					'value' => serialize($transKingdoms)
// 			]);
			
// 			//parkranks
// 			$this->info('Importing Parkranks...');
// 			$backupConnect->table('ork_parktitle')
// 				->where('kingdom_id', 16)
// 				->orWhere('title', 'Shire')
// 				->update(['class' => 20]);
// 			$backupConnect->table('ork_parktitle')
// 				->where('kingdom_id', 16)
// 				->orWhere('title', 'Barony')
// 				->update(['class' => 30]);
// 			$oldParkranks = $backupConnect->table('ork_parktitle')->get()->toArray();
// 			$parkrankId = 0;
// 			$known = $knownKingdomParklevelsOffices;
// 			DB::table('parkranks')->truncate();
// 			if (isset($oldParkranks)) {
// 				$bar3 = $this->output->createProgressBar(count($oldParkranks) + 43);
// 				$bar3->start();
// 				foreach ($oldParkranks as $oldParkrank) {
// 					if (!array_key_exists($oldParkrank->kingdom_id, $transKingdoms)) {
// 						$kingdomId = DB::table('kingdoms')->insertGetId([
// 							'parent_id' => null,
// 							'name' => 'Deleted Kingdom ' . $oldParkrank->kingdom_id,
// 							'abbreviation' => 'DK' . $oldParkrank->kingdom_id,
// 							'heraldry' => null,
// 							'is_active' => 0
// 						]);
// 						$transKingdoms[$oldParkrank->kingdom_id] = $kingdomId;
// 						DB::table('trans')->where('table', 'kingdoms')->update([
// 								'value' => serialize($transKingdoms)
// 						]);
// 					}
// 					//If it's one of our known kingdoms, 
// 					if(array_key_exists($oldParkrank->kingdom_id, $known)){
// 						//and it's not in the known array (or 'Kingdom', thanks for that DS), 
// 						if(!array_key_exists($oldParkrank->title, $known[$oldParkrank->kingdom_id]) || $oldParkrank->title == "Kingdom"){
// 							//don't add this one.
// 							switch($oldParkrank->parktitle_id){
// 								case 56:
// 									$transParkRanks[$oldParkrank->parktitle_id] = (int)$parkrankId + 1;
// 									break;
// 								case 31:
// 									$transParkRanks[$oldParkrank->parktitle_id] = (int)$parkrankId + 1;
// 									break;
// 								case 35:
// 									$transParkRanks[$oldParkrank->parktitle_id] = (int)$parkrankId;
// 									break;
// 								default: 
// 							}
// 							$deadRecords['ParkTitles'][$oldParkrank->parktitle_id] = $oldParkrank;
// 							continue;
// 						}else{
// 							unset($known[$oldParkrank->kingdom_id][$oldParkrank->title]);
// 						}
// 					}
// 					$parkrankId = DB::table('parkranks')->insertGetId([
// 							'kingdom_id' => $transKingdoms[$oldParkrank->kingdom_id],
// 							'name' => $oldParkrank->title,
// 							'rank' => $oldParkrank->class,
// 							'minimumattendance' => $oldParkrank->minimumattendance,
// 							'minimumcutoff' => $oldParkrank->minimumcutoff
// 					]);
// 					$transParkRanks[$oldParkrank->parktitle_id] = $parkrankId;
// 					$bar3->advance();
// 				}
// 			}
			
// 			//now add what's missing
// 			foreach($known as $kid => $kingdomParkRanks){
// 				foreach($kingdomParkRanks as $knownParkrank => $offices){
// 					if($knownParkrank != 'Kingdom'){
// 						$parkrankId = DB::table('parkranks')->insertGetId([
// 							'kingdom_id' => $transKingdoms[$kid],
// 							'name' => $knownParkrank,
// 							'rank' => $knownParkrank === 'Principality' ? 50 : 35,
// 							'minimumattendance' => $knownParkrank === 'Principality' ? 60 : 21,
// 							'minimumcutoff' => $knownParkrank === 'Principality' ? 56 : 19
// 						]);
// 						$bar3->advance();
// 					}
// 				}
// 			}
// 			$bar3->finish();
// 			$this->info('');
// 			DB::table('trans')->insert([
// 					'table' => 'parkranks',
// 					'value' => serialize($transParkRanks)
// 			]);
			
// 			//parks
// 			$this->info('Importing Parks...');
// 			$oldParks = $backupConnect->table('ork_park')->get()->toArray();
// 			DB::table('parks')->truncate();
// 			if (isset($oldParks)) {
// 				$bar4 = $this->output->createProgressBar(count($oldParks));
// 				$bar4->start();
// 				foreach ($oldParks as $oldPark) {
// 					if (!array_key_exists($oldPark->kingdom_id, $transKingdoms)) {
// 						$kingdomId = DB::table('kingdoms')->insertGetId([
// 								'parent_id' => null,
// 								'name' => 'Deleted Kingdom ' . $oldPark->kingdom_id,
// 								'abbreviation' => 'DK' . $oldPark->kingdom_id,
// 								'heraldry' => null,
// 								'is_active' => 0
// 						]);
// 						$transKingdoms[$oldPark->kingdom_id] = $kingdomId;
// 						DB::table('trans')->where('table', 'kingdoms')->update([
// 								'value' => serialize($transKingdoms)
// 						]);
// 					}
// 					$locationID = DB::table('locations')->insertGetId([
// 							'address' => $this->locationClean($oldPark->address),
// 							'city' => $this->locationClean($oldPark->city),
// 							'province' => $this->locationClean($oldPark->province),
// 							'postal_code' => $this->locationClean($oldPark->postal_code),
// 							'google_geocode' => $this->geocodeClean($oldPark->google_geocode),
// 							'latitude' => $this->locationClean($oldPark->latitude),
// 							'longitude' => $this->locationClean($oldPark->longitude),
// 							'location' => $this->locationClean($oldPark->location),
// 							'map_url' => $this->locationClean($oldPark->map_url),
// 							'description' => $this->locationClean($oldPark->description),
// 							'directions' => $this->locationClean($oldPark->directions)
// 					]);
// 					if($oldPark->parktitle_id === 186){//inactive is being removed
// 						$lowestParkrank = Parkrank::where('kingdom_id', $transKingdoms[$oldPark->kingdom_id])->orderBy('rank', 'ASC')->first();
// 					}
// 					$parkID = DB::table('parks')->insertGetId([
// 							'kingdom_id' => $transKingdoms[$oldPark->kingdom_id],
// 							'parkrank_id' => $oldPark->parktitle_id === 186 ? $lowestParkrank->id : $transParkRanks[$oldPark->parktitle_id],
// 							'location_id' => $locationID,
// 							'name' => trim($oldPark->name),
// 							'abbreviation' => $oldPark->abbreviation,
// 							'heraldry' => $oldPark->has_heraldry === 1 ? sprintf('%05d.jpg', $oldPark->park_id) : null,
// 							'url' => $oldPark->url,
// 							'is_active' => $oldPark->active != 'Active' || $oldPark->parktitle_id === 186 ? 0 : 1,
// 							'created_at' => $oldPark->modified,
// 							'updated_at' => $oldPark->modified
// 					]);
// 					$transParks[$oldPark->park_id] = $parkID;
// 					$bar4->advance();
// 				}
// 				$bar4->finish();
// 				$this->info('');
// 			}
// 			DB::table('trans')->insert([
// 					'table' => 'parks',
// 					'value' => serialize($transParks)
// 			]);
			
			//units
// 			$this->info('Importing Units...');
// 			$oldUnits = $backupConnect->table('ork_unit')->get()->toArray();
// 			DB::table('units')->truncate();
// 			if (count($oldUnits) > 0) {
// 				$bar5 = $this->output->createProgressBar(count($oldUnits));
// 				$bar5->start();
// 				foreach ($oldUnits as $oldUnit) {
// 					if ($oldUnit->type != '') {
// 						$unitId = DB::table('units')->insertGetId([
// 								'type' => $oldUnit->type,
// 								'name' => $oldUnit->name != '' ? trim($oldUnit->name) : 'Unknown ' . $oldUnit->type,
// 								'heraldry' => $oldUnit->has_heraldry === 1 ? sprintf('%05d.jpg', $oldUnit->unit_id) : null,
// 								'description' => $oldUnit->description,
// 								'history' => $oldUnit->history,
// 								'url' => $oldUnit->url,
// 								'created_at' => $oldUnit->modified,
// 								'updated_at' => $oldUnit->modified
// 						]);
// 						$transUnits[$oldUnit->unit_id] = $unitId;
// 					}else{
// 						$deadRecords['Units'][$oldUnit->unit_id] = $oldUnit;
// 					}
// 					$bar5->advance();
// 				}
// 				$bar5->finish();
// 				$this->info('');
// 			}
// 			DB::table('trans')->insert([
// 					'table' => 'units',
// 					'value' => serialize($transUnits)
// 			]);
			
			//awards
// 			$this->info('Importing Awards...');
// 			DB::table('awards')->truncate();
			
// 			//Common awards first
// 			$backupConnect->table('ork_award')
// 				->where('name', 'Order of the Walker in the Middle')
// 				->update(['is_ladder' => 1]);
// 			$oldAwards = $backupConnect->table('ork_award')->where('is_ladder', 1)->get()->toArray();
// 			if (count($oldAwards) > 0) {
// 				$bar6 = $this->output->createProgressBar(216);
// 				$bar6->start();
// 				foreach ($oldAwards as $oldAward) {
// 					$nameClean = trim($oldAward->name);
// 					//the awards that aren't expressly defined in the RoP are no longer 'common'.  Make one for each kingdom, as appropriate
// 					if(!in_array($oldAward->award_id, $ropLadders)){
// 						if($nameClean === 'Order of the Walker in the Middle'){
// 							foreach($knownAwards[$nameClean] as $kid => $info){
// 								if($info){
// 									$awardId = DB::table('awards')->insertGetId([
// 											'awardable_type' => 'Kingdom',
// 											'awardable_id' => $transKingdoms[$kid],
// 											'name' => $info['name'],
// 											'is_ladder' => 0,
// 											'deleted_by' => null,
// 											'deleted_at' => null
// 									]);
// 									$transGenericAwards[$oldAward->award_id][$kid] = $awardId;
// 								}
// 							}
// 						}else{
// 							foreach($knownAwards[$nameClean] as $kid => $info){
// 								if($info){
// 									$awardId = DB::table('awards')->insertGetId([
// 											'awardable_type' => 'Kingdom',
// 											'awardable_id' => $transKingdoms[$kid],
// 											'name' => $info['name'],
// 											'is_ladder' => $info['is_ladder'],
// 											'deleted_by' => null,
// 											'deleted_at' => null
// 									]);
// 									$transGenericAwards[$oldAward->award_id][$kid] = $awardId;
// 								}
// 							}
// 						}
// 						$bar6->advance();
// 						continue;
// 					}
// 					$awardId = DB::table('awards')->insertGetId([
// 							'awardable_type' => 'Kingdom',
// 							'awardable_id' => null,
// 							'name' => $nameClean,
// 							'is_ladder' => 1,
// 							'deleted_by' => $oldAward->deprecate === 1 ? 1 : null,
// 							'deleted_at' => $oldAward->deprecate === 1 ? $now : null
// 					]);
// 					$transGenericAwards[$oldAward->award_id] = $awardId;
// 					$bar6->advance();
// 				}
// 				$bar6->finish();
// 				$this->info('');
// 			}
// 			DB::table('trans')->insert([
// 					'table' => 'genericawards',
// 					'value' => serialize($transGenericAwards)
// 			]);

// 			//record the loss of 'Custom Award' award
// 			$oldCustom = $backupConnect->table('ork_award')->where('name', 'LIKE', '%Award%')->get()->toArray();
// 			$deadRecords['Awards'][94] = $oldCustom[0];
			
// 			//custom awards next
// 			$this->info('Importing Custom Awards...');
// 			$oldCustomAwards = $backupConnect->table('ork_kingdomaward')
// 				->where(function($q) {
// 					$q->where('award_id', 94)->orWhere('award_id', 0);
// 				})
// 				->where(function($q) {
// 					$q->where('name', '')->orWhere('name', 'LIKE', '%Antigriffin%')->orWhere('name', 'LIKE', '%typhoon%')->orWhere('name', 'LIKE', '%tsunami%')->orWhere('name', 'LIKE', '%Hellrider%')->orWhere('name', 'LIKE', '%Dreamkeeper%')->orWhere('name', 'LIKE', '%Cyclone%')->orWhere('name', 'LIKE', '%Emerald%')->orWhere('name', 'LIKE', 'Order %');
// 				})->get()->toArray();
// 			if (count($oldCustomAwards) > 0) {
// 				$bar7 = $this->output->createProgressBar(count($oldCustomAwards));
// 				$bar7->start();
// 				foreach ($oldCustomAwards as $oldCustomAward) {
// 					$foundAward = DB::table('awards')->where('name', $oldCustomAward->name)->first();
// 					if(!$foundAward){
// 						$customAwardId = DB::table('awards')->insertGetId([
// 								'awardable_type' => 'Kingdom',
// 								'awardable_id' => $transKingdoms[$oldCustomAward->kingdom_id],
// 								'name' => $oldCustomAward->name != '' ? trim($oldCustomAward->name) : 'Unknown Award',
// 								'is_ladder' => strpos($oldCustomAward->name, 'dreamkeeper') > -1 || strpos($oldCustomAward->name, 'hell') > -1 ? 0 : 1
// 						]);
// 						$kingdomawardsProcessed[$oldCustomAward->kingdomaward_id] = $customAwardId;
// 						$transCustomAwards[$oldCustomAward->kingdomaward_id] = $customAwardId;
// 					}else{
// 						$kingdomawardsProcessed[$oldCustomAward->kingdomaward_id] = $foundAward->id;
// 						$transCustomAwards[$oldCustomAward->kingdomaward_id] = $foundAward->id;
// 					}
// 					$bar7->advance();
// 				}
// 				$bar7->finish();
// 				$this->info('');
// 			}
// 			DB::table('trans')->insert([
// 					'table' => 'customawards',
// 					'value' => serialize($transCustomAwards)
// 			]);
// 			DB::table('trans')->where('table', 'kingdomawardsprocessed')->update([
// 					'value' => serialize($kingdomawardsProcessed)
// 			]);
			
// 			//titles
// 			$this->info('Importing Titles...');
// 			$backupConnect->table('ork_award')
// 				->where('name', 'Apprentice')
// 				->orWhere('name', 'Master')
// 				->orWhere('name', 'Esquire')
// 				->orWhere('name', 'Cultural Olympian')
// 				->orWhere('name', 'Grand Olympian')
// 				->orWhere('name', 'War Event Winner')
// 				->orWhere('name', 'War Olympian')
// 				->orWhere('name', 'Warmaster')
// 				->orWhere('name', 'LIKE', '%Defender%')
// 				->orWhere('name', 'Order of the Walker in the Middle')
// 				->update(['is_title' => 1, 'is_ladder' => 0]);
// 			$oldTitles = $backupConnect->table('ork_award')->where('is_title', 1)->get()->toArray();
// 			DB::table('titles')->truncate();
// 			if (count($oldTitles) > 0) {
// 				$bar8 = $this->output->createProgressBar(392);
// 				$bar8->start();
// 				$titleId = 0;
				
// 				//first the RoP titles
// 				foreach ($oldTitles as $otID => $oldTitle) {
// 					if(in_array($oldTitle->award_id, $ropTitles)){
// 						$rank = $oldTitle->title_class;
// 						$cleanName = trim($oldTitle->name);
// 						$titleCheck = null;
						
// 						//if it exists, let's not remake it
// 						$titleCheck = Title::where('name', $cleanName)->orWhere('name', 'LIKE', $cleanName . '|%')->orWhere('name', 'LIKE', '%|' . $cleanName)->whereNull('titleable_id')->first();
// 						if($titleCheck){
// 							$transTitles[$oldTitle->award_id] = $titleCheck->id;
// 							unset($oldTitles[$otID]);
// 							$bar8->advance();
// 							continue;
// 						}
// 						if($cleanName === 'Paragon Reeve'){
// 							$rank = 10;
// 							$peerage = 'Paragon';
// 						}
// 						if($cleanName === 'Lord\'s Page'){
// 							$cleanName = 'Page';
// 							$peerage = 'Retainer';
// 						}
// 						if($cleanName === 'Man-at-Arms'){
// 							$cleanName = 'At-Arms|Man-at-Arms|Woman-at-Arms|Comrade-at-Arms|Sword-at-Arms|Shieldmaiden|Shield Brother';
// 							$peerage = 'Retainer';
// 						}
						
// 						switch($oldTitle->peerage){
// 							case 'None':
// 								if(strpos($cleanName, 'Master ') > -1){
// 									$peerage = 'Master';
// 								}else if($cleanName === 'Apprentice'){
// 									$peerage = 'Retainer';
// 								}else{
// 									$peerage = 'None';
// 								}
// 								break;
// 							case 'Lords-Page':
// 								$peerage = 'Retainer';
// 								break;
// 							case 'Man-At-Arms':
// 								$peerage = 'Retainer';
// 								break;
// 							case 'Page':
// 								$peerage = 'Retainer';
// 								break;
// 							default:
// 								$peerage = $oldTitle->peerage;
// 						}
// 						$titleId = DB::table('titles')->insertGetId([
// 								'name' => $cleanName,
// 								'rank' => $rank,
// 								'peerage' => $peerage,
// 								'is_roaming' => 0,
// 								'is_active' => $cleanName === 'Paragon Raider' ? 0 : 1
// 						]);
// 						$transTitles[$oldTitle->award_id] = $titleId;
// 						unset($oldTitles[$otID]);
// 						$bar8->advance();
// 					}
// 				}
				
// 				//now the known titles
// 				foreach($knownTitles as $title => $kingdomInfo){
// 					//find the $oldTitle with name === $title
// 					$foundTitle = null;
// 					$foundOtID = null;
// 					foreach($oldTitles as $otID => $ot){
// 						if($ot->name === $title){
// 							$foundTitle = $ot;
// 							$foundOtID = $otID;
// 							break;
// 						}
// 					}
					
// 					foreach($kingdomInfo as $kid => $info){
// 						if($info){
// 							$titleId = DB::table('titles')->insertGetId([
// 									'titleable_type' => 'Kingdom',
// 									'titleable_id' => $transKingdoms[$kid],
// 									'name' => $info['name'],
// 									'rank' => $info['rank'],
// 									'peerage' => $info['peerage'],
// 									'is_roaming' => $info['reign_limit'] ? 1 : 0,
// 									'is_active' => $info['is_active']
// 							]);
// 							if($foundTitle){
// 								$transTitles[$foundTitle->award_id][$kid] = $titleId;
// 								unset($oldTitles[$foundOtID]);
// 							}
							
// 							//translate the fem into this one
// 							if($title === 'Lord'){
// 								foreach($oldTitles as $otID => $ot){
// 									if($ot->name === 'Lady'){
// 										$transTitles[$ot->award_id][$kid] = $titleId;
// 										unset($oldTitles[$otID]);
// 										break;
// 									}
// 								}
// 							}else if($title === 'Baron'){
// 								foreach($oldTitles as $otID => $ot){
// 									if($ot->name === 'Baroness'){
// 										$transTitles[$ot->award_id][$kid] = $titleId;
// 										unset($oldTitles[$otID]);
// 										break;
// 									}
// 								}
// 							}else if($title === 'Baronet'){
// 								foreach($oldTitles as $otID => $ot){
// 									if($ot->name === 'Baronetess'){
// 										$transTitles[$ot->award_id][$kid] = $titleId;
// 										unset($oldTitles[$otID]);
// 										break;
// 									}
// 								}
// 							}else if($title === 'Count'){
// 								foreach($oldTitles as $otID => $ot){
// 									if($ot->name === 'Countess'){
// 										$transTitles[$ot->award_id][$kid] = $titleId;
// 										unset($oldTitles[$otID]);
// 										break;
// 									}
// 								}
// 							}else if($title === 'Duke'){
// 								foreach($oldTitles as $otID => $ot){
// 									if($ot->name === 'Duchess'){
// 										$transTitles[$ot->award_id][$kid] = $titleId;
// 										unset($oldTitles[$otID]);
// 										break;
// 									}
// 								}
// 							}else if($title === 'Archduke'){
// 								foreach($oldTitles as $otID => $ot){
// 									if($ot->name === 'Archduchess'){
// 										$transTitles[$ot->award_id][$kid] = $titleId;
// 										unset($oldTitles[$otID]);
// 										break;
// 									}
// 								}
// 							}else if($title === 'Grand Duke'){
// 								foreach($oldTitles as $otID => $ot){
// 									if($ot->name === 'Grand Duchess'){
// 										$transTitles[$ot->award_id][$kid] = $titleId;
// 										unset($oldTitles[$otID]);
// 										break;
// 									}
// 								}
// 							}else if($title === 'Marquis'){
// 								foreach($oldTitles as $otID => $ot){
// 									if($ot->name === 'Marquess'){
// 										$transTitles[$ot->award_id][$kid] = $titleId;
// 										unset($oldTitles[$otID]);
// 										break;
// 									}
// 								}
// 							}else if($title === 'Viscount'){
// 								foreach($oldTitles as $otID => $ot){
// 									if($ot->name === 'Viscountess'){
// 										$transTitles[$ot->award_id][$kid] = $titleId;
// 										unset($oldTitles[$otID]);
// 										break;
// 									}
// 								}
// 							}else if($title === 'Grand Marquis'){
// 								foreach($oldTitles as $otID => $ot){
// 									if($ot->name === 'Grand Marquess'){
// 										$transTitles[$ot->award_id][$kid] = $titleId;
// 										unset($oldTitles[$otID]);
// 										break;
// 									}
// 								}
// 							}
// 							$bar8->advance();
// 						}
// 					}
// 				}
				
// 				//whatever is left
// 				foreach ($oldTitles as $oldTitle) {
// 					$cleanName = trim($oldTitle->name);
// 					//the titles that aren't expressly defined in the RoP need to be put into the trans array
// 					if(!in_array($oldTitle->award_id, $ropTitles)){
// 						foreach($knownTitles[$cleanName] as $kid => $info){
// 							if($info){
// 								$titleId = DB::table('titles')->insertGetId([
// 										'titleable_type' => 'Kingdom',
// 										'titleable_id' => $transKingdoms[$kid],
// 										'name' => $info['name'],
// 										'rank' => $info['rank'],
// 										'peerage' => $info['peerage'],
// 										'is_roaming' => $info['reign_limit'] ? 1 : 0,
// 										'is_active' => $info['is_active']
// 								]);
// 								$transTitles[$oldTitle->award_id][$kid] = $titleId;
// 							}
// 						}
// 						continue;
// 					}
// 				}
// 				$bar8->finish();
// 				$this->info('');
// 			}
// 			DB::table('trans')->insert([
// 					'table' => 'titles',
// 					'value' => serialize($transTitles)
// 			]);
			
// 			//custom titles next
// 			$this->info('Importing Custom Titles...');
// 			$oldCustomTitles = $backupConnect->table('ork_kingdomaward')
// 				->where(function($q) {
// 					$q->where('award_id', 94)->orWhere('award_id', 0);
// 				})
// 				->where('name', '!=', '')
// 				->where('name', '!=', 'Antigriffin')
// 				->where('name', '!=', 'typhoon')
// 				->where('name', '!=', 'tsunami')
// 				->where('name', '!=', 'Hydra')
// 				->where('name', '!=', 'Hellrider')
// 				->where('name', '!=', 'Dreamkeeper')
// 				->where('name', '!=', 'Cyclone')
// 				->where('name', '!=', 'Emerald')
// 				->where('name', '!=', 'Hellrider')
// 				->where('name', 'NOT LIKE', 'Order %')
// 				->where('name', '!=', 'Custom Award')
// 				->where('name', 'NOT LIKE', '%GMR')
// 				->where('name', 'NOT LIKE', '%Board%')
// 				->where('name', 'NOT LIKE', '%qualified')
// 				->where('name', 'NOT LIKE', '%Guild%')
// 				->where('name', 'NOT LIKE', '%for life%')
// 				->where('name', 'NOT LIKE', '%monarch%')
// 				->where('name', 'NOT LIKE', '%champion%')
// 				->where('name', 'NOT LIKE', '%prime minister%')
// 				->where('name', 'NOT LIKE', '%regent%')
// 				->where('name', 'NOT LIKE', '%spotlight%')
// 				->where('name', 'NOT LIKE', '%PM%')
// 				->where('name', '!=', 'scribe')
// 				->where('name', 'NOT LIKE', 'speaker%')
// 				->where('name', 'NOT LIKE', 'knight%')
// 				->where('name', '!=', 'Nonnoble Title')
// 				->get()->toArray();
// 			if (count($oldCustomTitles) > 0) {
// 				$bar9 = $this->output->createProgressBar(count($oldCustomTitles));
// 				$bar9->start();
// 				foreach ($oldCustomTitles as $oldCustomTitle) {
// 					$customTitleId = null;
// 					$nameClean = trim($oldCustomTitle->name);
// 					if($nameClean === 'Master Monster'){
// 						$nameClean = 'Paragon Monster';
// 					}
// 					if($nameClean === 'Grand Marquess'){
// 						$nameClean = 'Grand Marquise';
// 					}
// 					if($nameClean === 'Man Behind the Curtains'){
// 						$nameClean = 'The Man Behind the Curtain';
// 					}
					
// 					//check to see if this one exists yet
// 					$titleExists = Title::where('name', $nameClean)->orWhere('name', 'LIKE', $nameClean . '|%')->orWhere('name', 'LIKE', '%|' . $nameClean)->where(function($query) use($oldCustomTitle, $transKingdoms){
// 						$query->whereNull('titleable_id');
// 						$query->orWhere('titleable_id', $transKingdoms[$oldCustomTitle->kingdom_id]);
// 					})->first();
					
// 					if(!$titleExists){
// 						//work out the peerage & rank
// 						$peerage = null;
// 						$rank = null;
// 						if($nameClean === 'Arcuarius'){
// 							$peerage = 'Master';
// 							$rank = 10;
// 						}else if($nameClean === 'Master' || $nameClean === 'Mistress'){
// 							$nameClean = 'Master|Mistress';
// 							$peerage = 'Gentry';
// 							$rank = 0;
// 						}else if($nameClean === 'Esquire'){
// 							$peerage = 'Gentry';
// 							$rank = 0;
// 						}else{
// 							$peerage = 'None';
// 							$rank = 0;
// 						}
// 						$customTitleId = DB::table('titles')->insertGetId([
// 								'titleable_type' => $nameClean === 'Valkyrie\'s Chosen' ? 'Park' : 'Kingdom',
// 								'titleable_id' => $nameClean === 'Valkyrie\'s Chosen' ? $transParks[907] : $transKingdoms[$oldCustomTitle->kingdom_id],
// 								'name' => $nameClean,
// 								'rank' => $rank,
// 								'peerage' => $peerage,
// 								'is_roaming' => 0,
// 								'is_active' => $nameClean === 'Master' || $nameClean === 'Esquire' ? 0 : 1
// 						]);
// 						$transCustomTitles[$oldCustomTitle->kingdomaward_id] = $customTitleId;
// 					}else{
// 						$transCustomTitles[$oldCustomTitle->kingdomaward_id] = $titleExists->id;
// 					}
// 					$kingdomawardsProcessed[$oldCustomTitle->kingdomaward_id] = $customTitleId ? $customTitleId : $titleExists->id;
// 					$bar9->advance();
// 				}
// 				$bar9->finish();
// 				$this->info('');
// 			}
// 			DB::table('trans')->insert([
// 					'table' => 'customtitles',
// 					'value' => serialize($transCustomTitles)
// 			]);
// 			DB::table('trans')->where('table', 'kingdomawardsprocessed')->update([
// 					'value' => serialize($kingdomawardsProcessed)
// 			]);
			
			//offices
// 			$this->info('Creating Offices...');
// 			$count = 0;
// 			foreach($knownKingdomParklevelsOffices as $d){
// 				$count = $count + array_sum(array_map("count", $d));
// 			}
// 			$bar10 = $this->output->createProgressBar($count);
// 			$bar10->start();
// 			DB::table('offices')->truncate();
// 			//create from known offices (that was a lot of corpora reading I just did)
// 			foreach($knownKingdomParklevelsOffices as $kid => $knownKingdomParklevelsOffice){
// 				foreach($knownKingdomParklevelsOffice as $parkRank => $offices){
// 					$officeableType = $parkRank != 'Kingdom' ? 'Parkrank' : 'Kingdom';
// 					$officeableID = $officeableType === 'Kingdom' ? $transKingdoms[$kid] : null;
// 					if(!$officeableID){
// 						$parkRankArray = Parkrank::where('kingdom_id', $transKingdoms[$kid])->where('name', $parkRank)->first();
// 						if(!$parkRankArray){
// 							//this shouldn't happen.  Tell me if it does.
// 							dd(array(
// 									$kid,
// 									$transKingdoms[$kid],
// 									$parkRank
// 							));
// 						}
// 						$officeableID = $parkRankArray->id;
// 					}
// 					foreach($offices as $office => $officeData){
// 						$officeId = DB::table('offices')->insertGetId(
// 								[
// 										'officeable_type' => $officeableType,
// 										'officeable_id' => $officeableID,
// 										'name' => $office,
// 										'duration' => $officeData['duration'],
// 										'order' => array_key_exists('order', $officeData) ? $officeData['order'] : null
// 							]);
// 						$bar10->advance();
// 					}
// 				}
// 			}
// 			$bar10->finish();
// 			$this->info('');

// 			//pronouns
// 			$this->info('Importing Pronouns...');
// 			$oldPronouns = $backupConnect->table('ork_pronoun')->get()->toArray();
// 			DB::table('pronouns')->truncate();
// 			if (count($oldPronouns) > 0) {
// 				$bar12 = $this->output->createProgressBar(count($oldPronouns));
// 				$bar12->start();
// 				foreach ($oldPronouns as $oldPronoun) {
// 					$pronounId = DB::table('pronouns')->insertGetId([
// 							'subject' => $oldPronoun->subject,
// 							'object' => $oldPronoun->object,
// 							'possessive' => $oldPronoun->possessive,
// 							'possessivepronoun' => $oldPronoun->possessivepronoun,
// 							'reflexive' => $oldPronoun->reflexive
// 					]);
// 					$transPronouns[$oldPronoun->pronoun_id] = $pronounId;
// 					$bar12->advance();
// 				}
// 				$bar12->finish();
// 				$this->info('');
// 			}
// 			DB::table('trans')->insert([
// 					'table' => 'pronouns',
// 					'value' => serialize($transPronouns)
// 			]);

			//users
			//TOOD: there are 13K of these users that have NOTHING, not even a single credit, note, or anything.  Many thousands of them do have email addresses, tho...Add them to attendees?  Make attendees?
// 			SELECT Parents.* FROM ork_mundane Parents
// 			LEFT JOIN ork_attendance Childs0 ON Parents.mundane_id = Childs0.mundane_id
// 			LEFT JOIN ork_authorization Childs1 ON Parents.mundane_id = Childs1.mundane_id
// 			LEFT JOIN ork_awards Childs2 ON Parents.mundane_id = Childs2.mundane_id
// 			LEFT JOIN ork_class_reconciliation Childs3 ON Parents.mundane_id = Childs3.mundane_id
// 			LEFT JOIN ork_dues Childs4 ON Parents.mundane_id = Childs4.mundane_id
// 			LEFT JOIN ork_event Childs5 ON Parents.mundane_id = Childs5.mundane_id
// 			LEFT JOIN ork_mundane_note Childs6 ON Parents.mundane_id = Childs6.mundane_id
// 			LEFT JOIN ork_officer Childs7 ON Parents.mundane_id = Childs7.mundane_id
// 			LEFT JOIN ork_recommendations Childs8 ON Parents.mundane_id = Childs8.mundane_id
// 			LEFT JOIN ork_unit_mundane Childs9 ON Parents.mundane_id = Childs9.mundane_id
// 			WHERE Childs0.attendance_id IS NULL
// 			AND Childs1.authorization_id IS NULL
// 			AND Childs2.awards_id IS NULL
// 			AND Childs3.class_reconciliation_id IS NULL
// 			AND Childs4.dues_id IS NULL
// 			AND Childs5.event_id IS NULL
// 			AND Childs6.mundane_note_id IS NULL
// 			AND Childs7.officer_id IS NULL
// 			AND Childs8.recommendations_id IS NULL
// 			AND Childs9.unit_mundane_id IS NULL
// 			$this->info('Importing Users/Personas/Memberships/Suspensions/Waivers...');
// 			$backupConnect->table('ork_mundane')
// 				->where('mundane_id', 1)
// 				->update(['email' => 'admin@nowhere.net']);
// 			$oldUsers = $backupConnect->table('ork_mundane')->get()->toArray();
// 			$usedEmails = [];
// 			DB::table('users')->truncate();
// 			DB::table('personas')->truncate();
// 			DB::table('members')->truncate();
// 			DB::table('suspensions')->truncate();
// 			DB::table('waivers')->truncate();
// 			if (count($oldUsers) > 0) {
// 				$bar13 = $this->output->createProgressBar(count($oldUsers));
// 				$bar13->start();
// 				foreach ($oldUsers as $i => $oldUser) {
// 					$pronounId = null;
// 					$userId = null;
// 					//user data
// 					if(filter_var($oldUser->email, FILTER_VALIDATE_EMAIL)){
// 						if(!in_array(strtolower($oldUser->email), $usedEmails)){
// 							$userId = DB::table('users')->insertGetId(
// 								[
// 									'email' => $i === 0 ? 'nobody@nowhere.net' : strtolower($oldUser->email),
// 									'email_verified_at' => null,
// 									'password' => bin2hex(openssl_random_pseudo_bytes(4)),
// 									'remember_token' => null,
// 									'is_restricted' => $oldUser->restricted === 1 ? 1 : 0,
// 									'created_at' => $oldUser->modified,
// 									'updated_at' => $oldUser->modified
// 								]
// 							);
// 							//assign role
// 							$user = User::find($userId);
// 							//park_id === 0 && kingdom_id === $oldUser->kingdom_id && mundane_id === $oldUser->mundane_id
// 							//park_id === $oldUser->park_id && mundane_id === $oldUser->mundane_id
// 							$offices = $backupConnect->table('ork_officer')->where(function($query) use($oldUser) {
// 								$query->where('park_id', 0)
// 									->where('kingdom_id', $oldUser->kingdom_id)
// 									->where('mundane_id', $oldUser->mundane_id);
// 							})->orWhere(function($query2) use($oldUser) {
// 								$query2->where('park_id', $oldUser->park_id)
// 									->where('mundane_id', $oldUser->mundane_id);
// 							})->get()->toArray();
// 							if($userId === 1){
// 								$user->assignRole('admin');
// 							}else if(count($offices) > 0){
// 								$user->assignRole('officer');
// 							}else{
// 								$user->assignRole('player');
// 							}
// 							$usedEmails[] = strtolower($oldUser->email);
// 							$transUsers[$oldUser->mundane_id] = $userId;
// 						}else{
// 							$deadRecords['Users'][$oldUser->mundane_id] = 'Duplicate Email';
// 						}
// 					}
					
// 					if($oldUser->pronoun_id < 1){
// 						$detector = new \GenderDetector\GenderDetector();
// 						$gender = $detector->getGender(trim($oldUser->given_name), 'US');
						
// 						if($gender){
// 							if($gender->name === 'Male' || $gender->name === 'MostlyMale'){
// 								$pronounId = 2;
// 							}else if($gender->name === 'Female' || $gender->name === 'MostlyFemale'){
// 								$pronounId = 4;
// 							}else if($gender->name === 'Unisex'){
// 								$pronounId = null;
// 							}else{
// 								//this shouldn't happen.  Let me know if it does.
// 								dd(array($oldUser->given_name, $gender));
// 							}
// 						}else{
// 							$pronounId = null;
// 						}
// 					}else{
// 						$pronounId = $oldUser->pronoun_id;
// 					}
					
// 					//clean up the persona name
// 					if($this->cleanPersona($oldUser->persona, trim($oldUser->given_name) . ' ' . trim($oldUser->surname)) && $this->cleanPersona($oldUser->persona, trim($oldUser->given_name) . ' ' . trim($oldUser->surname)) != ''){
// 						$personaName = $this->cleanPersona($oldUser->persona, trim($oldUser->given_name) . ' ' . trim($oldUser->surname));
// 						$personaName = $this->stripTitles($personaName);
// 					}else{
// 						$personaName = null;
// 					}

// 					//persona data
// 					$personaId = DB::table('personas')->insertGetId([
// 							'park_id' => $oldUser->park_id === 0 ? 317 : $transParks[$oldUser->park_id],
// 							'user_id' => $userId,
// 							'pronoun_id' => $pronounId,
// 							'mundane' => trim($oldUser->given_name) != '' || trim($oldUser->surname) != '' ? str_ireplace('zzz', '', trim($oldUser->given_name)) . ' ' . str_ireplace('zzz', '', trim($oldUser->surname)) : null,
// 							'name' => $personaName,
// 							'heraldry' => $oldUser->has_heraldry === 1 ? sprintf('%06d.jpg', $oldUser->mundane_id) : null,
// 							'image' => $oldUser->has_image === 1 ? sprintf('%06d.jpg', $oldUser->mundane_id) : null,
// 							'is_active' => $oldUser->active === 1 ? 1 : 0,
// 							'reeve_qualified_expires_at' => $oldUser->reeve_qualified != 1 ? null : ($oldUser->reeve_qualified_until === '0000-00-00' ? date('Y-m-d', strtotime('+20 years')) : $oldUser->reeve_qualified_until),
// 							'corpora_qualified_expires_at' => $oldUser->corpora_qualified != 1 ? null : ($oldUser->corpora_qualified_until === '0000-00-00' ? date('Y-m-d', strtotime('+20 years')) : $oldUser->corpora_qualified_until),
// 							'joined_park_at' => $oldUser->park_member_since === '0000-00-00' ? null : $oldUser->park_member_since,
// 							'created_at' => $oldUser->modified,
// 							'updated_at' => $oldUser->modified
// 					]);
// 					$transPersonas[$oldUser->mundane_id] = $personaId;

// 					//unit membership data
// 					//TODO: note to new users that these will need updating manually
// 					if ($oldUser->company_id > 0) {
// 						if (array_key_exists($oldUser->company_id, $transUnits)) {
// 							$memberId = DB::table('members')->insertGetId(
// 								[
// 									'unit_id' => $transUnits[$oldUser->company_id],
// 									'persona_id' => $personaId,
// 									'role' => 'Member',
// 									'title' => null,
// 									'is_active' => 1,
// 									'created_at' => $oldUser->modified,
// 									'updated_at' => $oldUser->modified
// 								]
// 							);
// 							$transMembers[$oldUser->mundane_id] = $memberId;
// 						}else{
// 							$deadRecords['Units'][$oldUser->company_id] = 'Deleted';
// 						}
// 					}

// 					//suspensions data
// 					if($oldUser->suspended > 0){
// 						if (!$oldUser->suspended_by_id || $oldUser->suspended_by_id < $oldUser->mundane_id) {
// 							DB::table('suspensions')->insertGetId(
// 								[
// 									'persona_id' => $personaId,
// 									'kingdom_id' => $transKingdoms[$oldUser->kingdom_id],
// 									'suspended_by' => $oldUser->suspended_by_id ? $transPersonas[$oldUser->suspended_by_id] : 1,
// 									'suspended_at' => !$oldUser->suspended_at || $oldUser->suspended_at === '0000-00-00' ? $oldUser->modified : $oldUser->suspended_at,
// 									'expires_at' => $oldUser->suspended_until && $oldUser->suspended_until > date('Y-m-d', strtotime('+5 years')) ? null : $oldUser->suspended_until,
// 									'is_propogating' => stripos($oldUser->suspension, 'COC') > -1 || stripos($oldUser->suspension, 'Code of Conduct') > -1 || stripos($oldUser->suspension, 'Registe') > -1 || (stripos($oldUser->suspension, 'Prop') > -1 && stripos($oldUser->suspension, ' not ') < 1 ) || stripos($oldUser->suspension, 'inter') > -1 || stripos($oldUser->suspension, 'triggers') > -1 || stripos($oldUser->suspension, 'applies') > -1 || stripos($oldUser->suspension, 'spans') > -1 ? 1 : 0,
// 									'cause' => $oldUser->suspension && $oldUser->suspension != '' ? $oldUser->suspension : 'Unknown',
// 									'created_at' => !$oldUser->suspended_at || $oldUser->suspended_at === '0000-00-00' ? $oldUser->modified : $oldUser->suspended_at,
// 									'updated_at' => !$oldUser->suspended_at || $oldUser->suspended_at === '0000-00-00' ? $oldUser->modified : $oldUser->suspended_at
// 								]
// 							);
// 						}else{
// 							$suspensionsWaitList[] = $oldUser;
// 						}
// 					}else{
// 						if($oldUser->penalty_box === 1){
// 							$deadRecords['PenaltyBox'][$oldUser->mundane_id] = $oldUser;
// 						}
// 					}
	  
// 					//waiver data
// 					if($oldUser->waivered > 0 && (trim($oldUser->given_name) != '' || trim($oldUser->surname) != '')){
// 						DB::table('waivers')->insertGetId([
// 								'pronoun_id' => null,
// 								'persona_id' => $personaId,
// 								'waiverable_type' => 'Park',
// 								'waiverable_id' => $oldUser->park_id === 0 ? 317 : $transParks[$oldUser->park_id],
// 								'file' => $oldUser->waiver_ext != '' ? sprintf('%06d.' . $oldUser->waiver_ext, $oldUser->mundane_id) : null,
// 								'player' => trim($oldUser->given_name . ' ' . $oldUser->surname),
// 								'email' => null,
// 								'phone' => null,
// 								'location_id' => null,
// 								'dob' => null,
// 								'age_verified_at' => null,
// 								'age_verified_by' => null,
// 								'guardian' => null,
// 								'emergency_contact_name' => null,
// 								'emergency_contact_phone' => null,
// 								'signed_at' => $oldUser->park_member_since != '' && $oldUser->park_member_since != '0000-00-00' ? $oldUser->park_member_since : $oldUser->modified,
// 								'created_at' => $oldUser->park_member_since != '' && $oldUser->park_member_since != '0000-00-00' ? $oldUser->park_member_since : $oldUser->modified,
// 								'updated_at' => $oldUser->park_member_since != '' && $oldUser->park_member_since != '0000-00-00' ? $oldUser->park_member_since : $oldUser->modified
// 						]);	
// 					}
// 					$bar13->advance();
// 				}
// 				$bar13->finish();
// 				$this->info('');
// 			}
// 			if(count($suspensionsWaitList) > 0){
// 				$this->info('Finishing Up Suspensions...');
// 				$bar14 = $this->output->createProgressBar(count($suspensionsWaitList));
// 				$bar14->start();
// 				foreach($suspensionsWaitList as $oldUser){
// 					DB::table('suspensions')->insertGetId([
// 							'persona_id' => $personaId,
// 							'kingdom_id' => $transKingdoms[$oldUser->kingdom_id],
// 							'suspended_by' => $oldUser->suspended_by_id ? $transPersonas[$oldUser->suspended_by_id] : 1,
// 							'suspended_at' => !$oldUser->suspended_at || $oldUser->suspended_at === '0000-00-00' ? $oldUser->modified : $oldUser->suspended_at,
// 							'expires_at' => $oldUser->suspended_until && $oldUser->suspended_until > date('Y-m-d', strtotime('+5 years')) ? null : $oldUser->suspended_until,
// 							'is_propogating' => stripos($oldUser->suspension, 'COC') > -1 || stripos($oldUser->suspension, 'Code of Conduct') > -1 || stripos($oldUser->suspension, 'Registe') > -1 || (stripos($oldUser->suspension, 'Prop') > -1 && stripos($oldUser->suspension, ' not ') < 1 ) || stripos($oldUser->suspension, 'inter') > -1 || stripos($oldUser->suspension, 'triggers') > -1 || stripos($oldUser->suspension, 'applies') > -1 || stripos($oldUser->suspension, 'spans') > -1 ? 1 : 0,
// 							'cause' => $oldUser->suspension && $oldUser->suspension != '' ? $oldUser->suspension : 'Unknown',
// 							'created_at' => !$oldUser->suspended_at || $oldUser->suspended_at === '0000-00-00' ? $oldUser->modified : $oldUser->suspended_at,
// 							'updated_at' => !$oldUser->suspended_at || $oldUser->suspended_at === '0000-00-00' ? $oldUser->modified : $oldUser->suspended_at
// 					]);
// 					$bar14->advance();
// 				}
// 				$bar14->finish();
// 				$this->info('');
// 			}
// 			DB::table('trans')->insert([
// 					'table' => 'personas',
// 					'value' => serialize($transPersonas)
// 			]);
// 			DB::table('trans')->insert([
// 					'table' => 'members',
// 					'value' => serialize($transMembers)
// 			]);
// 			DB::table('trans')->insert([
// 					'table' => 'users',
// 					'value' => serialize($transUsers)
// 			]);

// 			//events
// 			$this->info('Importing Events/Crats...');
// 			$oldEvents = $backupConnect->table('ork_event_calendardetail')
// 				->join('ork_event', 'ork_event_calendardetail.event_id', '=', 'ork_event.event_id')
// 				->select('ork_event_calendardetail.*', 'ork_event.*', 'ork_event.modified as modified_1', 'ork_event_calendardetail.modified as modified_2')
// 				->get()->toArray();
// 			DB::table('events')->truncate();
// 			if (count($oldEvents) > 0) {
// 				$bar15 = $this->output->createProgressBar(count($oldEvents));
// 				$bar15->start();
// 				$burningLands = Park::where('name', 'Burning Lands')->first();
// 				foreach ($oldEvents as $oldEvent) {
// 					$locationID = null;
// 					$eventable_type = $oldEvent->unit_id > 0 ? 'Unit' : ($oldEvent->mundane_id > 0 && ($oldEvent->kingdom_id === 0 && $oldEvent->park_id === 0) ? 'Persona' : ($oldEvent->park_id > 0 && $oldEvent->kingdom_id === 0 ? 'Park' : 'Kingdom'));
// 					if($oldEvent->kingdom_id && $oldEvent->kingdom_id != 0 && !array_key_exists($oldEvent->kingdom_id, $transKingdoms)){
// 						$kingdomId = DB::table('kingdoms')->insertGetId(
// 							[
// 								'parent_id' => null,
// 								'name' => 'Deleted Kingdom ' . $oldEvent->kingdom_id,
// 								'abbreviation' => 'DK' . $oldEvent->kingdom_id,
// 								'heraldry' => null,
// 								'is_active' => 0
// 							]
// 						);
// 						$transKingdoms[$oldEvent->kingdom_id] = $kingdomId;
// 						DB::table('trans')->where('table', 'kingdoms')->update([
// 								'value' => serialize($transKingdoms)
// 						]);
// 					}
// 					if($oldEvent->mundane_id && $oldEvent->mundane_id != 0 && !array_key_exists($oldEvent->mundane_id, $transPersonas)){
// 						$personaId = DB::table('personas')->insertGetId(
// 							[
// 								'park_id' => $oldEvent->park_id === 0 ? $burningLands->id : $transParks[$oldEvent->park_id],
// 								'user_id' => null,
// 								'pronoun_id' => null,
// 								'mundane' => null,
// 								'name' => 'Deleted Persona ' . $oldEvent->mundane_id,
// 								'heraldry' => null,
// 								'image' => null,
// 								'is_active' => 0
// 							]
// 						);
// 						$transPersonas[$oldEvent->mundane_id] = $personaId;
// 						DB::table('trans')->where('table', 'personas')->update([
// 								'value' => serialize($transPersonas)
// 						]);
// 					}
// 					switch($eventable_type){
// 						case 'Unit':
// 							$eventable_id = $transUnits[$oldEvent->unit_id];
// 							break;
// 						case 'Persona':
// 							$eventable_id = $transPersonas[$oldEvent->mundane_id];
// 							break;
// 						case 'Park':
// 							$eventable_id = $transParks[$oldEvent->park_id];
// 							break;
// 						case 'Kingdom':
// 							$eventable_id = $transKingdoms[$oldEvent->kingdom_id];
// 							break;
// 						default:
// 							$eventable_id = null;
// 							break;
// 					}
// 					if(($oldEvent->address != '' && $oldEvent->address != '1') || ($oldEvent->province != '' && $oldEvent->province != '1') || ($oldEvent->postal_code != '' && $oldEvent->postal_code != '1') || ($oldEvent->city != '' && $oldEvent->city != '1') || ($oldEvent->country != '' && $oldEvent->country != '1') || ($oldEvent->map_url != '' && $oldEvent->map_url != '1')){
// 						$location = Location::where('address', $oldEvent->address)
// 							->where('province', $oldEvent->province)
// 							->where('postal_code', $oldEvent->postal_code)
// 							->where('city', $oldEvent->city)
// 							->first();
// 						$locationID = $location ? $location->id : null;
// 						if(!$locationID){
// 							$locationID = DB::table('locations')->insertGetId([
// 								'address' => $this->locationClean($oldEvent->address),
// 								'city' => $this->locationClean($oldEvent->city),
// 								'province' => $this->locationClean($oldEvent->province),
// 								'postal_code' => $this->locationClean($oldEvent->postal_code),
// 								'google_geocode' => $this->geocodeClean($oldEvent->google_geocode),
// 								'latitude' => $this->locationClean($oldEvent->latitude),
// 								'longitude' => $this->locationClean($oldEvent->longitude),
// 								'location' => $this->locationClean($oldEvent->location),
// 								'map_url' => $this->locationClean($oldEvent->map_url),
// 								'description' => $this->locationClean($oldEvent->map_url_name),
// 								'directions' => null,
// 								'created_at' => min($oldEvent->modified_1, $oldEvent->modified_2),
// 								'updated_at' => max($oldEvent->modified_1, $oldEvent->modified_2)
// 							]);
// 						}
// 					}
// 					$eventId = DB::table('events')->insertGetId([
// 							'eventable_type' => $eventable_type,
// 							'eventable_id' => $eventable_id,
// 							'location_id' => $locationID ? $locationID : null,
// 							'name' => trim($oldEvent->name),
// 							'description' => trim($oldEvent->description),
// 							'is_active' => $oldEvent->current,
// 							'image' => $oldEvent->has_heraldry === 1 ? sprintf('%05d.jpg', $oldEvent->event_id) : null,
// 							'event_start' => $oldEvent->event_start > '0001-01-01 00:00:01' ? $oldEvent->event_start : min($oldEvent->modified_1, $oldEvent->modified_2),
// 							'event_end' => $oldEvent->event_end > '0001-01-01 00:00:01' ? $oldEvent->event_end : max($oldEvent->modified_1, $oldEvent->modified_2),
// 							'price' => $oldEvent->price,
// 							'url' => $oldEvent->url,
// 							'created_at' => min($oldEvent->modified_1, $oldEvent->modified_2),
// 							'updated_at' => max($oldEvent->modified_1, $oldEvent->modified_2)
// 					]);
// 					if($oldEvent->mundane_id != 0){
// 						//make the crat
// 						DB::table('crats')->insertGetId([
// 								'event_id' => $eventId,
// 								'persona_id' => $transPersonas[$oldEvent->mundane_id],
// 								'role' => 'Autocrat',
// 								'is_autocrat' => 1
// 						]);
// 					}
// 					if($oldEvent->url_name != ''){
// 						$deadRecords['EventUrlNames'][$oldEvent->event_calendardetail_id] = $oldEvent;
// 					}
// 					$transEvents[$oldEvent->event_id] = $eventId;
// 					$transEventDetails[$oldEvent->event_calendardetail_id] = $eventId;
// 					$bar15->advance();
// 				}
// 				$bar15->finish();
// 				$this->info('');
// 			}
// 			DB::table('trans')->insert([
// 					'table' => 'events',
// 					'value' => serialize($transEvents)
// 			]);
// 			DB::table('trans')->insert([
// 					'table' => 'eventDetails',
// 					'value' => serialize($transEventDetails)
// 			]);
			
			//accounts
// 			$this->info('Importing Accounts...');
// 			$oldAccounts = $backupConnect->table('ork_account')->get()->toArray();
// 			DB::table('accounts')->truncate();
// 			if (count($oldAccounts) > 0) {
// 				$bar16 = $this->output->createProgressBar(count($oldAccounts));
// 				$bar16->start();
// 				foreach ($oldAccounts as $oldAccount) {
// 					$accountable_type = $oldAccount->unit_id > 0 ? 'Unit' : ($oldAccount->event_id > 0 ? 'Event' : ($oldAccount->park_id > 0 ? 'Park' : 'Kingdom'));
// 					switch($accountable_type){
// 						case 'Unit':
// 							$accountable_id = $transUnits[$oldAccount->unit_id];
// 							break;
// 						case 'Event':
// 							$accountable_id = $transEvents[$oldAccount->event_id];
// 							break;
// 						case 'Park':
// 							$accountable_id = $transParks[$oldAccount->park_id];
// 							break;
// 						case 'Kingdom':
// 							$accountable_id = $transKingdoms[$oldAccount->kingdom_id];
// 							break;
// 						default:
// 							$accountable_id = null;
// 							break;
// 					}
// 					$accountId = DB::table('accounts')->insertGetId([
// 							'parent_id' => $oldAccount->parent_id > 0 ? $transAccounts[$oldAccount->parent_id] : null,
// 							'accountable_type' => $accountable_type,
// 							'accountable_id' => $accountable_id,
// 							'name' => trim($oldAccount->name),
// 							'type' => $oldAccount->type
// 					]);
// 					$transAccounts[$oldAccount->account_id] = $accountId;
// 					$bar16->advance();
// 				}
// 				$bar16->finish();
// 				$this->info('');
// 			}
// 			DB::table('trans')->insert([
// 					'table' => 'accounts',
// 					'value' => serialize($transAccounts)
// 			]);

// 			//meetups
// 			$this->info('Importing Meetups...');
// 			$oldMeetups = $backupConnect->table('ork_parkday')->get()->toArray();
// 			DB::table('meetups')->truncate();
// 			if (count($oldMeetups) > 0) {
// 				$bar17 = $this->output->createProgressBar(count($oldMeetups));
// 				$bar17->start();
// 				$meetupMap = [
// 					'weekly' => 'Weekly',
// 					'monthly' => 'Monthly',
// 					'week-of-month' => 'Week-of-Month',
// 					'park-day' => 'Park Day',
// 					'fighter-practice' => 'Fighter Practice',
// 					'arts-day' => 'A&S Gathering',
// 					'other' => 'Other'
// 				];
// 				foreach ($oldMeetups as $oldMeetup) {
// 					$location = Location::where('address', $oldMeetup->address)->first();
// 					$locationID = $location ? $location->id : null;
// 					if(!$locationID){
// 						$locationID = DB::table('locations')->insertGetId([
// 								'address' => $this->locationClean($oldMeetup->address),
// 								'city' => $this->locationClean($oldMeetup->city),
// 								'province' => $this->locationClean($oldMeetup->province),
// 								'postal_code' => $this->locationClean($oldMeetup->postal_code),
// 								'google_geocode' => $this->geocodeClean($oldMeetup->google_geocode),
// 								'latitude' => $this->locationClean($oldMeetup->latitude),
// 								'longitude' => $this->locationClean($oldMeetup->longitude),
// 								'location' => $this->locationClean($oldMeetup->location),
// 								'map_url' => $this->locationClean($oldMeetup->map_url),
// 								'description' => $this->locationClean($oldMeetup->description),
// 								'directions' => null
// 						]);
// 						$location = Location::where('address', $oldMeetup->address)->first();
// 					}
// 					$altChecks = Meetup::where('park_id', $transParks[$oldMeetup->park_id])
// 						->where('recurrence', $oldMeetup->recurrence)
// 						->where('week_of_month', $oldMeetup->week_of_month)
// 						->where('week_day', $oldMeetup->week_day)
// 						->where('month_day', $oldMeetup->month_day)
// 						->where('occurs_at', $oldMeetup->time)
// 						->where('purpose', $oldMeetup->purpose)
// 						->whereHas('location', function ($query) use($oldMeetup) {
// 							$query->where('address', '!=', $oldMeetup->address);
// 						})
// 						->get()
// 						->toArray();
// 					if(count($altChecks) > 0){
// 						$meetup = array_shift($altChecks);
// 						$meetup->alt_location_id = $locationID;
// 						$meetup->save();
// 						if(count($altChecks) > 0){
// 							for($i=0; $i<count($altChecks); $i++){
// 								$deadRecords['ParkdayAlternates'][$oldMeetup->parkday_id] = $oldMeetup;
// 							}
// 						}
// 					}else{
// 						$meetupId = DB::table('meetups')->insertGetId([
// 								'park_id' => $oldMeetup->park_id,
// 								'location_id' => $locationID,
// 								'alt_location_id' => null,
// 								'url' => filter_var($oldMeetup->location_url, FILTER_VALIDATE_URL) ? $oldMeetup->location_url : null,
// 								'recurrence' => $meetupMap[$oldMeetup->recurrence],
// 								'week_of_month' => $oldMeetup->week_of_month > 0 ? $oldMeetup->week_of_month : null,
// 								'week_day' => $oldMeetup->week_day,
// 								'month_day' => $oldMeetup->month_day > 0 ? $oldMeetup->month_day : null,
// 								'occurs_at' => $oldMeetup->time,
// 								'purpose' => $meetupMap[$oldMeetup->purpose],
// 								'description' => trim($oldMeetup->description) != '' ? trim($oldMeetup->description) : null
// 						]);
// 						if($oldMeetup->location_url != '' && !filter_var($oldMeetup->location_url, FILTER_VALIDATE_URL)){
// 							$deadRecords['ParkdayUrl'][$oldMeetup->parkday_id] = $oldMeetup->location_url;
// 						}
// 						$transMeetups[$oldMeetup->parkday_id] = $meetupId;
// 					}
// 					$bar17->advance();
// 				}
// 				$bar17->finish();
// 				$this->info('');
// 			}
// 			DB::table('trans')->insert([
// 					'table' => 'meetups',
// 					'value' => serialize($transMeetups)
// 			]);
			
			//attendances
			$this->info('Importing Attendances...');
			$oldAttendances = $backupConnect->table('ork_attendance')->get()->toArray();
			DB::table('attendances')->truncate();
			DB::table('reconciliations')->truncate();
			$kingdoms = Kingdom::all()->toArray();
			$parks = Park::all()->toArray();
			if (count($oldAttendances) > 0) {
				$meetups = null;
				$meetupId = null;
				$bar18 = $this->output->createProgressBar(count($oldAttendances));
				$bar18->start();
				foreach ($oldAttendances as $oldAttendance) {
					
					$locationID = null;
					//work out archetype stuff
					$archetypeId = null;
					if($oldAttendance->flavor != ''){
						$flavorClean = $oldAttendance->flavor === 'Newbie' ? 'Undeclared' : trim($oldAttendance->flavor);
						$archetype = Archetype::where('name', $flavorClean)->first();
						if(!$archetype){
							$archetypeId = DB::table('archetypes')->insertGetId(
								[
										'name' => $flavorClean,
										'is_active' => $flavorClean === 'Undeclared' ? 1 : 0
								]
							);
						}else{
							$archetypeId = $archetype->id;
						}
					}else{
						$archetypeId = $transArchetypes[$oldAttendance->class_id];
					}
					
					//no persona
					$persona = null;
					if($oldAttendance->mundane_id === 0){
						$pairing = null;
						$fromPark = null;
						//those that just won't happen
						if($oldAttendance->persona === '' || $oldAttendance->flavor === '' && ($oldAttendance->note === '' || $oldAttendance->note === 'unknown' || $oldAttendance->note === '**' || $oldAttendance->note === '-' || $oldAttendance->note === '--' || $oldAttendance->note === '---' || $oldAttendance->note === '----' || $oldAttendance->note === '?' || $oldAttendance->note === '??' || $oldAttendance->note === '?? ??' || $oldAttendance->note === '??-??' || $oldAttendance->note === '??-???' || $oldAttendance->note === '???' || $oldAttendance->note === '????' || $oldAttendance->note === '-?' || $oldAttendance->note === 'Undeclaired' || $oldAttendance->note === 'Unk' || $oldAttendance->note === 'unknown' || $oldAttendance->note === 'unkwn' || $oldAttendance->note === 'visitor')){
							$deadRecords['HeadlessAttendances'][$oldAttendance->attendance_id] = $oldAttendance;
							continue;
						}else{
							//figure out if it's somebody
							if(strpos($oldAttendance->note, '--') > -1){
								$pairing = explode('--', $oldAttendance->note);
								$fromKingdom = array_search($pairing[0], array_column($kingdoms, 'abbreviation')) ? $kingdoms[array_search($pairing[0], array_column($kingdoms, 'abbreviation'))] : null;
								$fromParks = array_keys(array_column($parks, 'abbreviation'), $pairing[1]);
								$fromPark = $fromKingdom && array_search($fromKingdom, array_column($fromParks, 'kingdom_id')) ? $parks[array_search($fromKingdom, array_column($fromParks, 'kingdom_id'))] : null;
							}else if(strpos($oldAttendance->note, '-') > -1){
								$pairing = explode('-', $oldAttendance->note);
								$fromKingdom = array_search($pairing[0], array_column($kingdoms, 'abbreviation')) ? $kingdoms[array_search($pairing[0], array_column($kingdoms, 'abbreviation'))] : null;
								$fromParks = array_keys(array_column($parks, 'abbreviation'), $pairing[1]);
								$fromPark = $fromKingdom && array_search($fromKingdom, array_column($fromParks, 'kingdom_id')) ? $parks[array_search($fromKingdom, array_column($fromParks, 'kingdom_id'))] : null;
							}else if(strpos($oldAttendance->note, '/') > -1){
								$pairing = explode('/', $oldAttendance->note);
								$fromKingdom = array_search($pairing[0], array_column($kingdoms, 'abbreviation')) ? $kingdoms[array_search($pairing[0], array_column($kingdoms, 'abbreviation'))] : null;
								$fromParks = array_keys(array_column($parks, 'abbreviation'), $pairing[1]);
								$fromPark = $fromKingdom && array_search($fromKingdom, array_column($fromParks, 'kingdom_id')) ? $parks[array_search($fromKingdom, array_column($fromParks, 'kingdom_id'))] : null;
							}else if(strpos($oldAttendance->note, ':') > -1){
								$pairing = explode(':', $oldAttendance->note);
								$fromKingdom = array_search($pairing[0], array_column($kingdoms, 'abbreviation')) ? $kingdoms[array_search($pairing[0], array_column($kingdoms, 'abbreviation'))] : null;
								$fromParks = array_keys(array_column($parks, 'abbreviation'), $pairing[1]);
								$fromPark = $fromKingdom && array_search($fromKingdom, array_column($fromParks, 'kingdom_id')) ? $parks[array_search($fromKingdom, array_column($fromParks, 'kingdom_id'))] : null;
							}else{
								$fromPark = array_search($oldAttendance->note, array_column($parks, 'name')) ? $parks[array_search($oldAttendance->note, array_column($parks, 'name'))] : 
								(
									array_search(str_replace('.', '', $oldAttendance->note), array_column($parks, 'abbreviation')) ? $parks[array_search(str_replace('.', '', $oldAttendance->note), array_column($parks, 'abbreviation'))] : 
									null
								);
							}
							if($fromPark && trim($oldAttendance->persona)){
								$persona = Persona::where('name', 'LIKE', '%' . $oldAttendance->persona . '%')->where('park_id', $fromPark)->first();
								$personaID = $persona ? $persona->id : null;
							}else{
								$deadRecords['HeadlessAttendances'][$oldAttendance->attendance_id] = $oldAttendance;
								continue;
							}
							if(!$personaID){
								$personaID = DB::table('personas')->insertGetId([
										'park_id' => $fromPark['id'],
										'user_id' => null,
										'pronoun_id' => null,
										'mundane' => null,
										'name' => $this->cleanPersona($oldAttendance->persona, null),
										'heraldry' => null,
										'image' => null,
										'is_active' => 0,
										'reeve_qualified_expires_at' => null,
										'corpora_qualified_expires_at' => null,
										'joined_park_at' => null
								]);
								$transPersonas[$oldAttendance->mundane_id] = $personaID;
								DB::table('trans')->where('table', 'personas')->update([
										'value' => serialize($transPersonas)
								]);
							}
						}
					//get it
					}else{
						if(array_key_exists($oldAttendance->mundane_id, $transPersonas)){
						  $persona = Persona::where('id', $transPersonas[$oldAttendance->mundane_id])->first();
						}
						if(!$persona){
							$parkID = null;
							//try to work out their main park...the one with the most attendances
							$mostAttendeds = $backupConnect->table('ork_attendance')
								->where('mundane_id', $oldAttendance->mundane_id)
								->where('park_id', '!=', '0')
								->select('park_id', DB::raw('count(*) as total'))
								->groupBy('park_id')
								->orderBy('total', 'DESC')
								->get()->toArray();
							if(count($mostAttendeds) > 0){
								foreach($mostAttendeds as $mostAttended){
									if(array_key_exists($mostAttended->park_id, $transParks)){
										$parkID = $transParks[$mostAttended->park_id];
										break;
									}
								}
							}else{
								$deadRecords['HeadlessAttendances'][$oldAttendance->attendance_id] = $oldAttendance;
								continue;
							}
							$personaID = DB::table('personas')->insertGetId(
								[
									'park_id' => $parkID,
									'user_id' => null,
									'pronoun_id' => null,
									'mundane' => null,
									'name' => $this->cleanPersona($oldAttendance->persona, null) ? $this->cleanPersona($oldAttendance->persona, null) : 'Deleted Persona ' . $oldAttendance->mundane_id,
									'heraldry' => null,
									'image' => null,
									'is_active' => 0,
									'reeve_qualified_expires_at' => null,
									'corpora_qualified_expires_at' => null,
									'joined_park_at' => null
								]
							);
							$transPersonas[$oldAttendance->mundane_id] = $personaID;
							DB::table('trans')->where('table', 'personas')->update([
									'value' => serialize($transPersonas)
							]);
						}else{
							$personaID = $persona->id;
						}
					}
					
					//no park, kingdom, or event (ie, reconciliation)
					if($oldAttendance->park_id === 0 && $oldAttendance->kingdom_id === 0 && $oldAttendance->event_id === 0 && $oldAttendance->event_calendardetail_id === 0){
						DB::table('reconciliations')->insertGetId(
							[
								'archetype_id' => $archetypeId,
								'persona_id' => $oldAttendance->mundane_id > 0 ? $transPersonas[$oldAttendance->mundane_id] : $personaID,
								'credits' => $oldAttendance->credits
							]
						);
						$deadRecords['AttendancesReconciled'][$oldAttendance->attendance_id] = $oldAttendance;
					//no event and no date (ie, reconciliation)
					}else if($oldAttendance->event_id === 0 && $oldAttendance->event_calendardetail_id === 0 && $oldAttendance->entered_at === '0000-00-00 00:00:00' && $oldAttendance->date === '0000-00-00'){
						DB::table('reconciliations')->insertGetId(
							[
								'archetype_id' => $archetypeId,
								'persona_id' => $oldAttendance->mundane_id > 0 ? $transPersonas[$oldAttendance->mundane_id] : $personaID,
								'credits' => $oldAttendance->credits
							]
						);
						$deadRecords['AttendancesReconciled'][$oldAttendance->attendance_id] = $oldAttendance;
					//if the date is before Feb 01 1983, it's a reconciliation
					}else if($oldAttendance->date < '1983-02-01'){
						DB::table('reconciliations')->insertGetId(
							[
								'archetype_id' => $archetypeId,
								'persona_id' => $oldAttendance->mundane_id > 0 ? $transPersonas[$oldAttendance->mundane_id] : $personaID,
								'credits' => $oldAttendance->credits
							]
							);
						$deadRecords['AttendancesReconciled'][$oldAttendance->attendance_id] = $oldAttendance;
					//if the date is missing the month or day, reconcile it
					}else if(strpos($oldAttendance->date, '-00') > -1){
						DB::table('reconciliations')->insertGetId(
							[
								'archetype_id' => $archetypeId,
								'persona_id' => $oldAttendance->mundane_id > 0 ? $transPersonas[$oldAttendance->mundane_id] : $personaID,
								'credits' => $oldAttendance->credits
							]
							);
						$deadRecords['AttendancesReconciled'][$oldAttendance->attendance_id] = $oldAttendance;
					//if it's more than 2 credits and no event, it's a reconcilliation
					}else if($oldAttendance->credits > 2.9 && $oldAttendance->event_id === 0 && $oldAttendance->event_calendardetail_id === 0){
						DB::table('reconciliations')->insertGetId(
							[
								'archetype_id' => $archetypeId,
								'persona_id' => $oldAttendance->mundane_id > 0 ? $transPersonas[$oldAttendance->mundane_id] : $personaID,
								'credits' => $oldAttendance->credits
							]
							);
						$deadRecords['AttendancesReconciled'][$oldAttendance->attendance_id] = $oldAttendance;
					}else{
						if($oldAttendance->event_id === 0 && $oldAttendance->event_calendardetail_id === 0){
							//is there a meetup?
							$meetups = Meetup::where('park_id', $oldAttendance->park_id)->get()->toArray();
							if(count($meetups) > 0){
								//if the day of week for the meetup and the attendance match, this is it
								$meetupSelected = array_search(date('l', strtotime($oldAttendance->date)), array_column($meetups, 'week_day')) ? array_search(date('l', strtotime($oldAttendance->date)), array_column($meetups, 'week_day')) : 
								(
									//else if it's < 1 credit and class != 6, go with the fighter-practice one
									$oldAttendance->credits < 1 && $oldAttendance->class_id != 6 && array_search('Fighter Practice', array_column($meetups, 'purpose')) ? array_search('Fighter Practice', array_column($meetups, 'purpose')) : 
									(
										//else if it's < 1 credit and class === 6, go with the arts-day one
										$oldAttendance->credits < 1 && $oldAttendance->class_id === 6 && array_search('A&S Gathering', array_column($meetups, 'purpose')) ? array_search('A&S Gathering', array_column($meetups, 'purpose')) :
										(
											//else if it's > .9 credits, go with the park-day one
											$oldAttendance->credits > .9 && array_search('Park Day', array_column($meetups, 'purpose')) ? array_search('Park Day', array_column($meetups, 'purpose')) : 
											//else just the first one, I guess?
											0
										)
									)
								);
								$meetupId = $meetups[$meetupSelected]['id'];
							}else{
								//make it
								$meetupId = DB::table('meetups')->insertGetId(
									[
										'park_id' => $oldAttendance->park_id,
										'location_id' => $locationID ? $locationID : null,
										'alt_location_id' => null,
										'url' => null,
										'recurrence' => 'Weekly',
										'week_of_month' => null,
										'week_day' => date('l', strtotime($oldAttendance->date)),
										'month_day' => null,
										'occurs_at' => '13:00:00',
										'purpose' => 'Park Day',
										'description' => 'This Meetup has been generated.  Please review it and correct as appropriate.'
									]
								);
							}
						//check to make sure the event exists
						}else if($oldAttendance->event_calendardetail_id != 0){
							if(!array_key_exists($oldAttendance->event_calendardetail_id, $transEventDetails)){
								//make it
								if($oldAttendance->event_id > 0){
									$parentEvent = $backupConnect->table('ork_event')->where('event_id', $oldAttendance->event_id)->first();
									$eventable_type = $parentEvent->unit_id > 0 ? 'Unit' : ($parentEvent->kingdom_id === 0 && $parentEvent->park_id === 0 ? 'Persona' : ($parentEvent->park_id > 0 && $parentEvent->kingdom_id === 0 ? 'Park' : 'Kingdom'));
									switch($eventable_type){
										case 'Unit':
											$eventable_id = $transUnits[$parentEvent->unit_id];
											break;
										case 'Persona':
											$eventable_id = $transPersonas[$parentEvent->mundane_id];
											break;
										case 'Park':
											$eventable_id = $transParks[$parentEvent->park_id];
											break;
										case 'Kingdom':
											$eventable_id = $transKingdoms[$parentEvent->kingdom_id];
											break;
										default:
											$eventable_id = null;
											break;
									}
									$eventId = DB::table('events')->insertGetId(
										[
											'eventable_type' => $eventable_type,
											'eventable_id' => $eventable_id,
											'location_id' => $locationID ? $locationID : null,
											'name' => trim($parentEvent->name),
											'description' => 'This event was generated from related records.  Please correct it.',
											'is_active' => 0,
											'image' => null,
											'event_start' => $oldAttendance->date,
											'event_end' => $oldAttendance->date,
											'price' => null,
											'url' => null
										]
									);
									$transEvents[$oldAttendance->event_id] = $eventId;
									DB::table('trans')->where('table', 'events')->update([
											'value' => serialize($transEvents)
									]);
									$transEventDetails[$oldAttendance->event_calendardetail_id] = $eventId;
									DB::table('trans')->where('table', 'eventDetails')->update([
											'value' => serialize($transEventDetails)
									]);
								}else{
									//deadrecords it since there's no event data
									$deadRecords['HeadlessAttendances'][$oldAttendance->attendance_id] = $oldAttendance;
								}
							}
						}
						//check by_whom
						if($oldAttendance->by_whom_id != 0 && !array_key_exists($oldAttendance->by_whom_id, $transUsers)){
							//somebody lost their user...we'll have to make one up
							$userId = DB::table('users')->insertGetId([
								'email' => 'deletedUser' . $oldAttendance->by_whom_id . '@nowhere.net',
								'email_verified_at' => null,
								'password' => 'generated',
								'remember_token' => null,
								'is_restricted' => 1
							]);
							$transUsers[$oldAttendance->by_whom_id] = $userId;
							DB::table('trans')->where('table', 'users')->update([
									'value' => serialize($transUsers)
							]);
							$persona = Persona::where('id', $transPersonas[$oldAttendance->mundane_id])->first();
							$persona->user_id = $userId;
							$persona->save();
						}
						$attendanceId = DB::table('attendances')->insertGetId(
							[
								'persona_id' => $oldAttendance->mundane_id > 0 ? $transPersonas[$oldAttendance->mundane_id] : $personaID,
								'archetype_id' => $archetypeId,
								'attendable_type' => $oldAttendance->event_calendardetail_id > 0 ? 'Event' : 'Meetup',  //Meetup, Event
								'attendable_id' => $oldAttendance->event_calendardetail_id > 0 ? $transEventDetails[$oldAttendance->event_calendardetail_id] : $meetupId,
								'attended_at' => $oldAttendance->date,
								'credits' => $oldAttendance->credits,
								'created_by' => $oldAttendance->by_whom_id != 0 ? $transUsers[$oldAttendance->by_whom_id] : 1,
								'created_at' => $oldAttendance->entered_at != '0000-00-00 00:00:00' ? $oldAttendance->entered_at : $oldAttendance->date
							]
						);
						$transGenericAttendances[$oldAttendance->attendance_id] = $attendanceId;
					}
					$bar18->advance();
				}
				$bar18->finish();
				$this->info('');
			}
			DB::table('trans')->insert([
					'table' => 'genericAttendances',
					'value' => serialize($transGenericAttendances)
			]);
			dd('check attendances');

			//tournaments
			$this->info('Importing Tournaments...');
			$oldTournaments = $backupConnect->table('ork_tournament')->get()->toArray();
			DB::table('tournaments')->truncate();
			if (count($oldTournaments) > 0) {
				$bar19 = $this->output->createProgressBar(count($oldTournaments));
				$bar19->start();
				foreach ($oldTournaments as $oldTournament) {
					if($oldTournament->kingdom_id === 0 && $oldTournament->park_id === 0 && $oldTournament->event_calendardetail_id === 0 && $oldTournament->event_id === 0){
						$deadRecords['Tournaments'][$oldTournament->tournament_id] = $oldTournament;
						continue;
					}
					$abletype = $oldTournament->kingdom_id > 0 ? 'Kingdom' : ($oldTournament->park_id > 0 ? 'Park' : 'Event');
					if($abletype === 'Kingdom'){
						$ableid = $transKingdoms[$oldTournament->kingdom_id];
					}elseif($abletype === 'Park'){
						$ableid = $transParks[$oldTournament->park_id];
					}else{
						if($oldTournament->event_calendardetail_id > 0){
							if(!array_key_exists($oldTournament->event_calendardetail_id, $transEventDetails)){
								$deadRecords['Tournaments'][$oldTournament->tournament_id] = $oldTournament;
								continue;
							}else{
								$ableid = $transEventDetails[$oldTournament->event_calendardetail_id];
							}
						}else{
							//these are all garbage, so goodby
							$deadRecords['Tournaments'][$oldTournament->tournament_id] = $oldTournament;
							continue;
						}
					}
					$tournamentId = DB::table('tournaments')->insertGetId([
							'tournamentable_type' => $abletype,
							'tournamentable_id' => $ableid,
							'name' => $oldTournament->name,
							'description' => $oldTournament->description,
							'url' => $oldTournament->url,
							'occured_at' => $oldTournament->date_time
					]);
					$transTournaments[$oldTournament->tournament_id] = $tournamentId;
					$bar19->advance();
				}
				$bar19->finish();
				$this->info('');
			}
			DB::table('trans')->insert([
					'table' => 'tournaments',
					'value' => serialize($transTournaments)
			]);
			dd('check tournaments');

			//configurations
			$this->info('Importing Configurations...');
			$oldConfigurations = $backupConnect->table('ork_configuration')->get()->toArray();
			if (count($oldConfigurations) > 0) {
				$bar20 = $this->output->createProgressBar(count($oldConfigurations));
				$bar20->start();
				foreach ($oldConfigurations as $oldConfiguration) {
					if($oldConfiguration->key === 'AccountPointers'){
						$deadRecords['Configurations'][$oldConfiguration->configuration_id] = $oldConfiguration;
					}else{
						//update the kingdom
						$kingdom = Kingdom::where('id', $transKingdoms[$oldConfiguration->id])->first();
						$cleanValue = utf8_encode(stripslashes($oldConfiguration->value));
						$cleanNoQuotes = str_replace('"', '', $cleanValue);
						switch($oldConfiguration->key){
							case 'AtlasColor':
								$kingdom->color = $cleanNoQuotes;
								break;
							case 'AttendanceCreditMinimum':
								$kingdom->credit_minimum = $cleanNoQuotes;
								break;
							case 'AttendanceDailyMinimum':
								$kingdom->daily_minimum = $cleanNoQuotes === 'null' ? 0 : $cleanNoQuotes;
								break;
							case 'AttendanceWeeklyMinimum':
								$kingdom->weekly_minimum = $cleanNoQuotes === 'null' ? 0 : $cleanNoQuotes;
								break;
							case 'AveragePeriod':
								$data = json_decode($cleanValue);
								$kingdom->average_period_type = $data->Type != '' && $data->Type != '-' ? ucfirst($data->Type) : 'Month';
								$kingdom->average_period = $data->Period != 'null' && $data->Period != '' ? ucfirst($data->Period) : 0;
								break;
							case 'DuesAmount':
								$kingdom->dues_amount = $cleanNoQuotes;
								break;
							case 'DuesPeriod':
								$data = json_decode($cleanValue);
								$kingdom->dues_intervals_type = $data->Type != '' ? ucfirst($data->Type) : 'Month';
								$kingdom->dues_intervals = $data->Period != 'null' && $data->Period != '' ? ucfirst($data->Period) : 6;
								break;
							case 'KingdomDuesTake':
								$kingdom->dues_take = $cleanNoQuotes;
								break;
							case 'MonthlyCreditMaximum':
								$kingdom->credit_maximum = $cleanNoQuotes === 'null' || $cleanNoQuotes > 100 ? null : $cleanNoQuotes;
								break;
						}
						$deadRecords['Configurations'][$oldConfiguration->configuration_id] = $oldConfiguration;
						$kingdom->save();
					}
					$bar20->advance();
				}
				$bar20->finish();
				$this->info('');
			}
			dd('check configs');

			//transactions
			$this->info('Importing Transactions...');
			$oldTransactions = $backupConnect->table('ork_transaction')->get()->toArray();
			DB::table('transactions')->truncate();
			if (count($oldTransactions) > 0) {
				$bar21 = $this->output->createProgressBar(count($oldTransactions));
				$bar21->start();
				foreach ($oldTransactions as $oldTransaction) {
					if($oldTransaction->recorded_by != 0 && !array_key_exists($oldTransaction->recorded_by, $transUsers)){
						//somebody lost their user...we'll have to make one up
						$userId = DB::table('users')->insertGetId([
							'email' => $oldTransaction->recorded_by . '@nowhere.net',
							'email_verified_at' => null,
							'password' => 'generated',
							'remember_token' => null,
							'is_restricted' => 1
						]);
						$transUsers[$oldTransaction->recorded_by] = $userId;
						DB::table('trans')->where('table', 'users')->update([
								'value' => serialize($transUsers)
						]);
					}
					$transactionId = DB::table('transactions')->insertGetId([
							'description' => $oldTransaction->description,
							'memo' => $oldTransaction->memo,
							'transaction_at' => $oldTransaction->transaction_date <= '1969-12-31' ? $oldTransaction->date_created : $oldTransaction->transaction_date,
							'created_by' => $oldTransaction->recorded_by != 0 ? $transUsers[$oldTransaction->recorded_by] : 1,
							'created_at' => $oldTransaction->date_created
					]);
					$transTransactions[$oldTransaction->transaction_id] = $transactionId;
					$bar21->advance();
				}
				$bar21->finish();
				$this->info('');
			}
			DB::table('trans')->insert([
					'table' => 'transactions',
					'value' => serialize($transTransactions)
			]);
			dd('check transactions');
			
			//splits
			$this->info('Importing Splits...');
			$oldSplits = $backupConnect->table('ork_split')->get()->toArray();
			DB::table('splits')->truncate();
			if (count($oldSplits) > 0) {
				$bar27 = $this->output->createProgressBar(count($oldSplits));
				$bar27->start();
				foreach ($oldSplits as $oldSplit) {
					//account was deleted...sigh.  Not sure there's enough of these to justify the time it'd take me to make the script rebuild it, and I'm not sure I even could.  So, without further adeau...
					if(!array_key_exists($oldSplit->account_id, $transAccounts)){
						$deadRecords['Splits'][$oldSplit->split_id] = $oldSplit;
						continue;
					}
					//transaction was deleted
					if(!array_key_exists($oldSplit->transaction_id, $transTransactions)){
						$deadRecords['Splits'][$oldSplit->split_id] = $oldSplit;
						continue;
					}
					//persona was deleted
					if(!array_key_exists($oldSplit->src_mundane_id, $transPersonas)){
						$deadRecords['Splits'][$oldSplit->split_id] = $oldSplit;
						continue;
					}
					$SplitId = DB::table('splits')->insertGetId([
							'account_id' => $oldSplit->account_id > 0 ? $transAccounts[$oldSplit->account_id] : null,
							'transaction_id' => $transTransactions[$oldSplit->transaction_id],
							'persona_id' => $transPersonas[$oldSplit->src_mundane_id],
							'amount' => $oldSplit->amount
					]);
					$transSplits[$oldSplit->split_id] = $SplitId;
					$bar27->advance();
				}
				$bar27->finish();
				$this->info('');
			}
			DB::table('trans')->insert([
					'table' => 'splits',
					'value' => serialize($transSplits)
			]);
			dd('check splits');

			//dues
			//https://github.com/scottlaurent/accounting - we'll be updating to that.  For now, just pass the data over.
			$this->info('Importing Dues');
			$oldDues = $backupConnect->table('ork_dues')->get()->toArray();
			$oldTransaction = null;
			DB::table('dues')->truncate();
			if (count($oldDues) > 0) {
				$bar22 = $this->output->createProgressBar(count($oldDues));
				$bar22->start();
				foreach ($oldDues as $oldDue) {
					$thisSplit = null;
					$thisTransaction = null;
					$earned = null;
					$duesFrom = null;
					$kingdom = null;
					if($oldDue->kingdom_id === 0 || !array_key_exists($oldDue->mundane_id, $transPersonas)){
						//looks like these are the victims of related deletions.  So sad.
						$deadRecords['Dues'][$oldDue->dues_id] = $oldDue;
						$bar22->advance();
						continue;
					}
					if($oldDue->created_on > date('Y-m-d hh:mm:ss', strtotime('tomorrow'))){
						//it's just bad data, not much I can do
						$deadRecords['Dues'][$oldDue->dues_id] = $oldDue;
						$bar22->advance();
						continue;
					}else{
						if($oldDue->import_transaction_id === 0 || !array_key_exists($oldDue->import_transaction_id, $transTransactions)){
							//make the transaction
							$persona = Persona::where('id', $transPersonas[$oldDue->mundane_id])->first();
							$transactionId = DB::table('transactions')->insertGetId([
								'description' => 'Dues Paid for ' . $persona->mundane,
								'memo' => 'Dues Paid for ' . $persona->mundane,
								'transaction_at' => $oldDue->created_on,
								'created_by' => $transUsers[$oldDue->created_by],
								'created_at' => $oldDue->created_on
							]);
							$transTransactions[$oldDue->import_transaction_id] = $transactionId;
							DB::table('trans')->where('table', 'transactions')->update([
									'value' => serialize($transTransactions)
							]);
						}else{
							$transactionId = $transTransactions[$oldDue->import_transaction_id];
						}
					}
					//if the dues_from is before 1998-07-01, we need to figure out what it REALLY is, and set the floor at Feb 01, 1983 (Our birth month)
					if(strtotime($oldDue->dues_from) < strtotime('1998-07-01')){
						$thisSplit = $backupConnect->table('ork_split')->where('transaction_id', $oldDue->import_transaction_id)->where('is_dues', 1)->first();
						if(!$thisSplit){
							//damn.  Guess this one is toast.
							$deadRecords['Dues'][$oldDue->dues_id] = $oldDue;
							$bar22->advance();
							continue;
						}
						$thisTransaction = $backupConnect->table('ork_transaction')->where('transaction_id', $thisSplit->transaction_id)->first();
						if($thisTransaction){
							$duesFrom = $thisTransaction->date_created;
						}else{
							$kingdom = Kingdom::where('id', $transKingdoms[$oldDue->kingdom_id])->first();
							$earned = $thisSplit->amount / $kingdom->dues_amount;
							$duesFrom = date('Y-m-d H:i:s', strtotime('-' . round($earned) . ' months', strtotime($thisSplit->dues_through)));
						}
						if($duesFrom < date('Y-m-d H:i:s', strtotime('Feb 01, 1983'))){
							$duesFrom = date('Y-m-d H:i:s', strtotime('Feb 01, 1983'));
						}
					}else{
						$duesFrom = date('Y-m-d H:i:s', strtotime($oldDue->dues_from));
					}
					//check creating user
					if(!array_key_exists($oldDue->created_by, $transUsers)){
						if(array_key_exists($oldDue->created_by, $transPersonas)){
							//make the user with a bogus email
							$oldUser = $backupConnect->table('ork_mundane')->where('mundane_id', $oldDue->created_by)->first();
							$userId = DB::table('users')->insertGetId(
								[
									'email' => $oldDue->created_by . '@nowhere.net',
									'email_verified_at' => null,
									'password' => $oldUser->password_salt,
									'remember_token' => null,
									'is_restricted' => $oldUser->restricted === 1 ? 1 : 0,
									'created_at' => $oldUser->modified,
									'updated_at' => $oldUser->modified
								]
							);
							$transUsers[$oldDue->created_by] = $userId;
							DB::table('trans')->where('table', 'users')->update([
									'value' => serialize($transUsers)
							]);
							$persona = Persona::where('id', $transPersonas[$oldDue->created_by])->first();
							$persona->user_id = $userId;
							$persona->save();
						}else{
							//nothing I can do...
							$deadRecords['Dues'][$oldDue->dues_id] = $oldDue;
							$bar22->advance();
							continue;
						}
					}
					if($oldDue->revoked_by && !array_key_exists($oldDue->revoked_by, $transUsers)){
						if(array_key_exists($oldDue->revoked_by, $transPersonas)){
							//make the user with a bogus email
							$oldUser = $backupConnect->table('ork_mundane')->where('mundane_id', $oldDue->revoked_by)->first();
							$userId = DB::table('users')->insertGetId(
									[
											'email' => $oldDue->revoked_by . '@nowhere.net',
											'email_verified_at' => null,
											'password' => $oldUser->password_salt,
											'remember_token' => null,
											'is_restricted' => $oldUser->restricted === 1 ? 1 : 0,
											'created_at' => $oldUser->modified,
											'updated_at' => $oldUser->modified
									]
									);
							$transUsers[$oldDue->revoked_by] = $userId;
							DB::table('trans')->where('table', 'users')->update([
									'value' => serialize($transUsers)
							]);
							$persona = Persona::where('id', $transPersonas[$oldDue->revoked_by])->first();
							$persona->user_id = $userId;
							$persona->save();
						}else{
							//nothing I can do...
							$deadRecords['Dues'][$oldDue->dues_id] = $oldDue;
							$bar22->advance();
							continue;
						}
					}
					//work out the intervals
					//dues_until - dues_from in months / 6
					$date1 = $duesFrom;
					$date2 = $oldDue->dues_until;
					$ts1 = strtotime($date1);
					$ts2 = strtotime($date2);
					$year1 = date('Y', $ts1);
					$year2 = date('Y', $ts2);
					$month1 = date('m', $ts1);
					$month2 = date('m', $ts2);
					$monthsDiff = (($year2 - $year1) * 12) + ($month2 - $month1);
					$intervals = $monthsDiff/6;
					if($oldDue->dues_until != date('Y-m-d', strtotime($duesFrom. '+ ' . $intervals . ' months'))){
						//this shouldn't happen.  let me know
						dd(array(
								$duesFrom,
								$oldDue->dues_until,
								date('Y-m-d', strtotime($duesFrom. '+ ' . $intervals . ' months')),
								$intervals
						));
					}
					$dueId = DB::table('dues')->insertGetId(
						[
							'persona_id' => $transPersonas[$oldDue->mundane_id],
							'transaction_id' => $transactionId,
							'dues_on' => date('Y-m-d', strtotime($duesFrom)),
							'intervals' => $intervals,
							'created_at' => $duesFrom, 
							'created_by' => $transUsers[$oldDue->created_by],
							'deleted_at' => $oldDue->revoked === 1 ? date('Y-m-d H:i:s', strtotime($oldDue->revoked_on)) : null,
							'deleted_by' => $oldDue->revoked === 1 ? $transUsers[$oldDue->revoked_by] : null
						]
					);
					$transDues[$oldDue->dues_id] = $dueId;
					$bar22->advance();
				}
				$bar22->finish();
				$this->info('');
			}
			DB::table('trans')->insert([
					'table' => 'dues',
					'value' => serialize($transDues)
			]);
			dd('check dues');

			//members 
			$this->info('Importing Members...');
			$oldMembers = $backupConnect->table('ork_unit_mundane')->get()->toArray();
			DB::table('members')->truncate();
			if (count($oldMembers) > 0) {
				$bar23 = $this->output->createProgressBar(count($oldMembers));
				$bar23->start();
				foreach ($oldMembers as $oldMember) {
					//check to see if entry exists already, and if so, update
					$memberCheck = Member::where('unit_id', $transUnits[$oldMember->unit_id])->where('persona_id', $transPersonas[$oldMember->mundane_id])->first();
					if($memberCheck){
						$memberCheck->role = ucfirst($oldMember->role);
						$memberCheck->title = trim($oldMember->title) != '' ? trim($oldMember->title) : null;
						$memberCheck->is_active = $oldMember->active === 'Active' ? 1 : 0;
						$memberCheck->save();
					}else{
						$memberId = DB::table('members')->insertGetId([
								'unit_id' => $transUnits[$oldMember->unit_id],
								'persona_id' => $transPersonas[$oldMember->mundane_id],
								'role' => ucfirst($oldMember->role),
								'title' => trim($oldMember->title) != '' ? trim($oldMember->title) : null,
								'is_active' => $oldMember->active === 'Active' ? 1 : 0
						]);
					}
					$transMembers[$oldMember->mundane_id] = $memberId;
					$bar23->advance();
				}
				$bar23->finish();
				$this->info('');
			}
			DB::table('trans')->insert([
					'table' => 'members',
					'value' => serialize($transMembers)
			]);
			dd('check members, particularly trans for duplicate & proper totals started with 543');
			
			//officers/reigns
			//TODO: move this up with the rest of the vars
			$knownCurrentReigns = [
					1 => [
							'label' => 'Reign LV',
							'begins' => '2023-06-02',
							'midreign' => '2023-08-25',
							'ends' => '2023-12-10'
					],
					3 => [
							'label' => '64th Reign',
							'begins' => '2023-06-01',
							'midreign' => '2023-09-01',
							'ends' => '2023-12-01'
					],
					4 => [
							'label' => 'Reign 57',
							'begins' => '2023-09-01',
							'midreign' => '2023-12-01',
							'ends' => '2024-03-01'
					],
					5 => [
							'label' => null,
							'begins' => '2023-08-25',
							'midreign' => '2023-11-11',
							'ends' => '2024-01-27'
					],
					6 => [
							'label' => null,
							'begins' => '2023-06-01',
							'midreign' => '2023-09-22',
							'ends' => '2023-12-01'
					],
					7 => [
							'label' => null,
							'begins' => '2023-10-01',
							'midreign' => '2024-01-01',
							'ends' => '2024-04-01'
					],
					10 => [
							'label' => null,
							'begins' => '2023-09-01',
							'midreign' => '2023-12-01',
							'ends' => '2023-03-01'
					],
					11 => [
							'label' => 'Reign #64',
							'begins' => '2023-09-01',
							'midreign' => '2023-12-01',
							'ends' => '2023-03-01'
					],
					12 => [
							'label' => null,
							'begins' => '2023-05-12',
							'midreign' => '2023-09-01',
							'ends' => '2023-12-10'
					],
					14 => [
							'label' => 'Reign 67',
							'begins' => '2023-11-11',
							'midreign' => '2024-02-04',
							'ends' => '2024-05-26'
					],
					16 => [
							'label' => null,
							'begins' => '2023-09-01',
							'midreign' => '2023-12-01',
							'ends' => '2024-03-01'
					],
					17 => [
							'label' => null,
							'begins' => '2023-10-01',
							'midreign' => '2024-01-01',
							'ends' => '2024-04-01'
					],
					18 => [
							'label' => null,
							'begins' => '2023-11-11',
							'midreign' => '2024-02-04',
							'ends' => '2024-05-26'
					],
					19 => [
							'label' => null,
							'begins' => '2023-07-01',
							'midreign' => '2023-10-28',
							'ends' => '2024-01-01'
					],
					20 => [
							'label' => null,
							'begins' => '2023-09-23',
							'midreign' => '2023-12-30',
							'ends' => '2024-03-23'
					],
					21 => [
							'label' => 'Reign XXXIII',
							'begins' => '2023-11-01',
							'midreign' => '2024-02-01',
							'ends' => '2024-05-01'
					],
					22 => [
							'label' => null,
							'begins' => '2023-09-01',
							'midreign' => '2023-12-01',
							'ends' => '2024-03-01'
					],
					24 => [
							'label' => null,
							'begins' => '2023-10-20',
							'midreign' => '2024-02-16',
							'ends' => '2024-04-14'
					],
					25 => [
							'label' => null,
							'begins' => '2023-10-01',
							'midreign' => '2024-02-01',
							'ends' => '2024-04-01'
					],
					27 => [
							'label' => 'Reign # 13',
							'begins' => '2023-08-01',
							'midreign' => '2023-11-01',
							'ends' => '2024-02-01'
					],
					31 => [
							'label' => 'Reign #27',
							'begins' => '2023-08-01',
							'midreign' => '2023-11-01',
							'ends' => '2024-02-01'
					],
					36 => [
							'label' => null,
							'begins' => '2023-08-01',
							'midreign' => '2023-11-01',
							'ends' => '2024-02-01'
					],
					38 => [
							'label' => null,
							'begins' => '2023-10-01',
							'midreign' => '2024-02-01',
							'ends' => '2024-04-01'
					]
			];
			//TODO: check Plagueservant of Peasants
			$this->info('Importing Officers...');
			$oldOfficers = $backupConnect->table('ork_officer')->get()->toArray();
			DB::table('officers')->truncate();
			if (count($oldOfficers) > 0) {
				$bar24 = $this->output->createProgressBar(count($oldOfficers));
				$bar24->start();
				foreach ($oldOfficers as $oldOfficer) {
					//work out or make the office id
					$officeID = null;
					$label = null;
					$order = null;
					switch($oldOfficer->role){
						case 'Monarch':
							$order = 1;
							break;
						case 'Regent':
							$order = 4;
							break;
						case 'Prime Minister':
							$order = 2;
							break;
						case 'Champion':
							$order = 3;
							break;
						case 'GMR':
							$order = 5;
							break;
					}
					if($order){
						if($oldOfficer->park_id != 0){
							$park = Park::where('id', $transParks[$oldOfficer->park_id])->first();
							$office = Office::where('officeable_type', 'Parkrank')->where('officeable_id', $park->parkrank_id)->where('order', 1)->first();
							$officeID = $office->id;
							if(strpos($park->name, '|') > -1){
								//assign custom term by gender (if known) Also, I'm sorry I'm defaulting to male.  I don't feel like I have a choice.  Please forgive me.
								$officeNames = explode('|', $office->name);
								if($park->parkrank->rank < 30){
									if($oldOfficer->kingdom_id == 14){
										$label = $officeNames[1];
									}else{
										$label = $officeNames[0];
									}
								}else{
									$persona = Persona::where('id', $transPersonas[$oldOfficer->mundane_id])->first();
									if($persona->pronoun && $persona->pronoun->subject === 'she'){
										$label = $officeNames[1];
									}elseif($persona->pronoun && $persona->pronoun->subject === 'he'){
										$label = $officeNames[0];
									}
								}
							}
						}else{
							$kingdom = Kingdom::where('id', $transKingdoms[$oldOfficer->kingdom_id])->first();
							$office = Office::where('officeable_type', 'Kingdom')->where('officeable_id', $kingdom->kingdom_id)->where('order', 1)->first();
							$officeID = $office->id;
							$persona = Persona::where('id', $transPersonas[$oldOfficer->mundane_id])->first();
							if($persona->pronoun && $persona->pronoun->subject === 'she'){
								$label = $officeNames[1];
							}elseif($persona->pronoun && $persona->pronoun->subject === 'he'){
								$label = $officeNames[0];
							}
						}
					}else{
						//this shouldn't happen.  Tell me if it does
						dd($oldOfficer);
					}
					
					//reign?
					$getReign = DB::table('reigns')->where('reignable_type', $oldOfficer->park_id != 0 ? 'Park' : 'Kingdom')->where('reignable_id', $oldOfficer->park_id != 0 ? $transParks[$oldOfficer->park_id] : $transKingdoms[$oldOfficer->kingdom_id])->orderBy('ends_on', 'DESC')->first();
					if($getReign){
						$reignID = $getReign->id;
					}else{
						if(!array_key_exists($oldOfficer->kingdom_id, $knownCurrentReigns)){
							//this shouldn't happen.  let me know if it does
							dd($oldOfficer);
						}
						$reignID = DB::table('reigns')->insertGetId([
								'reignable_type' => $oldOfficer->park_id != 0 ? 'Park' : 'Kingdom',
								'reignable_id' => $oldOfficer->park_id != 0 ? $transParks[$oldOfficer->park_id] : $transKingdoms[$oldOfficer->kingdom_id],
								'name' => $knownCurrentReigns[$oldOfficer->kingdom_id]['label'],
								'starts_on' => $order === 2 || $order === 5 ? $knownCurrentReigns[$oldOfficer->kingdom_id]['midreign'] : $knownCurrentReigns[$oldOfficer->kingdom_id]['begins'],
								'ends_on' => $order === 2 || $order === 5 ? date('Y-m-d', strtotime($knownCurrentReigns[$oldOfficer->kingdom_id]['midreign'] . '+6 months')) : $knownCurrentReigns[$oldOfficer->kingdom_id]['begins']
						]);
					}
					$officerId = DB::table('officers')->insertGetId([
							'officerable_type' => 'Reign',
							'officerable_id' => $reignID,
							'office_id' => $officeID,
							'persona_id' => $transPersonas[$oldOfficer->mundane_id],
							'label' => $label ? $label : null,
							'starts_on' => null,
							'ends_on' => null
					]);
					$transOfficers[$oldOfficer->class_id] = $officerId;
					$bar24->advance();
				}
				$bar24->finish();
				$this->info('');
			}
			DB::table('trans')->insert([
					'table' => 'officers',
					'value' => serialize($transOfficers)
			]);
			dd('check officers and reigns');
			
			//recommendations
			$this->info('Importing Recommendations...');
			$oldRecommendations = $backupConnect->table('ork_recommendations')->get()->toArray();
			DB::table('recommendations')->truncate();
			if (count($oldRecommendations) > 0) {
				$bar25 = $this->output->createProgressBar(count($oldRecommendations));
				$bar25->start();
				foreach ($oldRecommendations as $oldRecommendation) {
					$RecommendationId = DB::table('recommendations')->insertGetId([
							'persona_id' => $transPersonas[$oldRecommendation->mundane_id],
							'award_id' => array_key_exists($oldRecommendation->award_id) ? $transGenericAwards[$oldRecommendation->award_id] : $transCustomAwards[$oldRecommendation->kingdomaward_id],
							'rank' => $oldRecommendation->rank > 0 ? $oldRecommendation->rank : null,
							'is_anonymous' => $oldRecommendation->mask_giver,
							'reason' => $oldRecommendation->reason,
							'created_by' => $transPersonas[$oldRecommendation->recommended_by_id],
							'created_at' => $oldRecommendation->date_recommended
					]);
					$transRecommendations[$oldRecommendation->recommendation_id] = $RecommendationId;
					$bar25->advance();
				}
				$bar25->finish();
				$this->info('');
			}
			
			//reconciliations
			$this->info('Importing Reconciliations...');
			$oldReconciliations = $backupConnect->table('ork_class_reconciliation')->get()->toArray();
			DB::table('reconciliations')->truncate();
			if (count($oldReconciliations) > 0) {
				$bar26 = $this->output->createProgressBar(count($oldReconciliations));
				$bar26->start();
				foreach ($oldReconciliations as $oldReconciliation) {
					if($oldReconciliation->reconciled === 0){
						$deadRecords['Reconciliations'][$oldReconciliation->reconciliation_id] = $oldReconciliation;
					}
					$ReconciliationId = DB::table('reconciliations')->insertGetId([
							'archetype_id' => $transArchetypes[$oldReconciliation->class_id],
							'persona_id' => $oldReconciliation->mundane_id,
							'credits' => $oldReconciliation->reconciled
					]);
					$transReconciliations[$oldReconciliation->reconciliation_id] = $ReconciliationId;
					$bar26->advance();
				}
				$bar26->finish();
				$this->info('');
			}
			
			//suspensions
			
			//notes
			
			//issuances
				//walker in the middle is a title someplaces, and an award others.  work out where, and what they call it
				//124 Walker in the Middle
				// 			138 Master Monster
				// 			161 Grand Duke
				// 			187 Dragonmaster (and more, is 'custom award')
				//autocrat & subcrat not issuances, but instead 'crats'
				//			218 Autocrat
				//			219 Subcrat
			//persona name titles  //go thru the personas
			//duplicate personas (move this up towards the top)
			//custom titles hidden in ork_awards...specifically, those for kingdomaward_id 6036.  Make the custom titles.
			//custom officers (award data)

			//notes //get what you can, record what's left
			//TODO: wiki fields
			//TODO: website fields
			//TODO: rename 'parks' to 'chapters'
			//TODO: add 'notes' style fields (like description) to titles, offices, and whatever else they're using 'notes' for
			//TODO: awardable to awarder
			//TODO: add minimum


			$this->info(count($deadRecords['Parkranks']) . ' Parkranks lost due to a missing Kingdom');
			$this->info(count($deadRecords['Units']) . ' Units lost due to a missing Type or having been deleted');
			$this->info(count($oldCustomAwards) . ' Awards created from \'Custom Award\'');
			$this->info(count($oldCustomTitles) . ' Titles created from \'Custom Award\'');
			$this->info(count($oldCustomOffices) . ' Offices created from \'Custom Award\'');
			$this->info(count($deadRecords['Users']) . ' Users (login only, not Persona data) not created due to duplicate emails');
			$this->info(count($deadRecords['PenaltyBox']) . ' Users in the Penalty Box but NOT suspended are now free');
			$this->info(count($deadRecords['EventUrlNames']) . ' Event URL names were tossed due to being unnecessary');
			$this->info(count($deadRecords['ParkdayAlternates']) . ' Parkday alternate locations dropped.');
			$this->info(count($deadRecords['ParkdayUrl']) . ' Parkday urls tossed for not being a url');
			$this->info(count($deadRecords['HeadlessAttendances']) . ' Attendances without a viable persona were lost');
			$this->info(count($deadRecords['AttendancesReconciled']) . ' Attendances made into Reconciliations due to missing critical data (date, park/event, etc)');
			$this->info(count($deadRecords['Dues']) . ' Dues lost due to no park/kingdom or terms');
			$this->info(count($deadRecords['IssuancesNoAward']) . ' Award/Title Issuances lost due to no award id');
			$this->info(count($deadRecords['Tournaments']) . ' Tournaments lost due to no kingdom/park/event data');
			$this->info(count($deadRecords['Reconciliations']) . ' Reconciliations lost due to 0 value reconciled');
			$this->info(count($deadRecords['Configurations']) . ' Configurations moved to db functionality');
			$this->info(count($deadRecords['Splits']) . ' Splits lost due to deleted Account, Persona, or Transactiom');
			
			Schema::enableForeignKeyConstraints();

			//log all the dead records

			$this->info('All done!');
			// dd($deadRecords);
		} catch (Throwable $e) {
			$trace = $e->getTrace()[AppHelper::instance()->search_multi_array(__FILE__, 'file', $e->getTrace())];
			Log::error($e->getMessage() . ' (' . $trace['file'] . ':' . $trace['line'] . ')\r\n' . '[stacktrace]' . '\r\n' . $e->getTraceAsString());
			$this->error(sprintf('%s:%d - ' . $e->getMessage(), $e->getFile(), $e->getLine()));
// 			dd(array(
// 					$transEventDetails,
// 					$transEvents,
// 					$oldTournament
// 			));
		}
	}
	
	private function stripTitles($personaName){
		$personaName = str_ireplace(', Defender of the North', '', $personaName);
		$personaName = str_ireplace(', Defender of the Valley, Butcher of the Valley, Stranger of Treachery', '', $personaName);
		$personaName = str_ireplace(', Defender of the Iron Mountains', '', $personaName);
		$personaName = str_ireplace(', Defender of the Rising Winds', '', $personaName);
		$personaName = str_ireplace(', Defender of Crystal Groves', '', $personaName);
		$personaName = str_ireplace(', Defender of CG', '', $personaName);
		$personaName = str_ireplace(', Defender of Goldenvale', '', $personaName);
		$personaName = str_ireplace(' Defender of Rivermoor', '', $personaName);
		$personaName = str_ireplace(', Defender of Dragonspine', '', $personaName);
		$personaName = str_ireplace(', Master Assassin', '', $personaName);
		$personaName = str_ireplace(', Paragon Healer', '', $personaName);
		$personaName = str_ireplace(', Paragon Scout', '', $personaName);
		$personaName = str_ireplace(', Paragon Warrior', '', $personaName);
		$personaName = str_ireplace(', Saint Sir', '', $personaName);
		$personaName = str_ireplace(', Sir Duke', '', $personaName);
		$personaName = str_ireplace(', Sir (Home Slice)', '', $personaName);
		$personaName = str_ireplace(', Woman at Arm\'s', '', $personaName);
		$personaName = str_ireplace('...Esquire', '', $personaName);
		$personaName = str_ireplace(', Esq', '', $personaName);
		$personaName = str_ireplace(', Esquire', '', $personaName);
		$personaName = str_ireplace(' Esquire', '', $personaName);
		$personaName = str_ireplace('Esquire ', '', $personaName);
		$personaName = str_ireplace(', Master', '', $personaName);
		$personaName = str_ireplace(', Lord', '', $personaName);
		$personaName = str_ireplace(', Lord-Defender', '', $personaName);
		$personaName = str_ireplace(', Lady', '', $personaName);
		$personaName = str_ireplace(', Lady and Master', '', $personaName);
		$personaName = str_ireplace(', Baronet', '', $personaName);
		$personaName = str_ireplace(', Baron', '', $personaName);
		$personaName = str_ireplace(', Baroness', '', $personaName);
		$personaName = str_ireplace(', Countess', '', $personaName);
		$personaName = str_ireplace(' IM,DM', '', $personaName);
		$personaName = str_ireplace('Battlemaster ', '', $personaName);
		if(strpos($personaName, 'Master ') > -1){
			if(strpos($personaName, 'Master of') === false){
				$personaName = str_replace('Master ', '', $personaName);
			}
		}
		$personaName = str_ireplace('Paragon ', '', $personaName);
		$personaName = str_ireplace('Defender ', '', $personaName);
		if(strpos($personaName, 'Steward ') > -1){
			if(strpos($personaName, 'Steward of') === false){
				$personaName = str_replace('Steward ', '', $personaName);
			}
		}
		if(strpos($personaName, 'Protector ') > -1){
			if(strpos($personaName, 'Protector of') === false){
				$personaName = str_replace('Protector ', '', $personaName);
			}
		}
		$personaName = str_ireplace('MaA ', '', $personaName);
		$personaName = str_ireplace('Woman at Arms ', '', $personaName);
		$personaName = str_ireplace('Man at Arms ', '', $personaName);
		$personaName = str_ireplace('Wo/Man At Arms ', '', $personaName);
		$personaName = str_ireplace(', Woman at Arm\'s', '', $personaName);
		$personaName = str_ireplace('Man-At-Arms ', '', $personaName);
		$personaName = str_ireplace('Woman-at-Arms ', '', $personaName);
		$personaName = str_ireplace(' Shieldmaiden', '', $personaName);
		$personaName = str_ireplace('Shieldmaiden ', '', $personaName);
		$personaName = str_ireplace('Apprentice ', '', $personaName);
		$personaName = str_replace('Page ', '', $personaName);
		$personaName = str_ireplace('Sir ', '', $personaName);
		$personaName = str_ireplace('Dame ', '', $personaName);
		$personaName = str_ireplace('Squire ', '', $personaName);
		if(strpos($personaName, 'Lord ') > -1){
			if(strpos($personaName, 'Lord of ') === false && strpos($personaName, 'Lord UltraSluff of ') === false && strpos($personaName, 'Son of Lord ') === false && strpos($personaName, 'Turtle Lord ') === false ){
				$personaName = str_replace('The Honorable Lord ', '', $personaName);
				$personaName = str_replace('Peasant Lord ', '', $personaName);
				$personaName = str_replace('Time Lord ', '', $personaName);
				$personaName = str_replace('Overlord ', '', $personaName);
				$personaName = str_replace('elden lord ', '', $personaName);
				$personaName = str_replace('Lord ', '', $personaName);
			}
		}
		if(strpos($personaName, 'Lady ') > -1){
			if(strpos($personaName, 'Lady of ') === false && strpos($personaName, ', Lady Grimmwulff') === false){
				$personaName = str_replace('Great Lady ', '', $personaName);
				$personaName = str_replace('The Lady ', '', $personaName);
				$personaName = str_replace('Lady ', '', $personaName);
			}
		}
		$personaName = str_replace('Baron ', '', $personaName);
		$personaName = str_replace('Baroness ', '', $personaName);
		$personaName = str_replace('Baronet ', '', $personaName);
		$personaName = str_replace('Baronetess ', '', $personaName);
		$personaName = str_replace('Viscount ', '', $personaName);
		$personaName = str_replace('Grand Marquis ', '', $personaName);
		$personaName = str_replace('/The Marquis ', '', $personaName);
		$personaName = str_replace('Marquis ', '', $personaName);
		$personaName = str_replace('Marquise ', '', $personaName);
		$personaName = str_replace('Marquess ', '', $personaName);
		$personaName = str_replace('Marquessa ', '', $personaName);
		$personaName = str_replace('Count ', '', $personaName);
		$personaName = str_replace('Grand Duke ', '', $personaName);
		$personaName = str_replace('Grand Duchess ', '', $personaName);
		$personaName = str_replace('Duke ', '', $personaName);
		$personaName = str_replace('Duchess ', '', $personaName);
		$personaName = str_replace('Arch Duchess ', '', $personaName);
		$personaName = str_replace('Arch Duke ', '', $personaName);
		$personaName = str_ireplace('Arch-duke ', '', $personaName);
		$personaName = str_ireplace('Arch-duchess ', '', $personaName);
		$personaName = str_ireplace('Archduke ', '', $personaName);
		$personaName = str_ireplace('Archduchess ', '', $personaName);
		return $personaName;
	}
	
	private function cleanPersona($personaName, $mundaneName){
		$personaName = str_replace('_', ' ', $personaName);
		$personaName = str_replace('.', '', $personaName);
		$personaName = str_replace('(', '', $personaName);
		$personaName = str_replace(')', '', $personaName);
		$personaName = str_replace('*', '', $personaName);
		$personaName = str_replace('-', '', $personaName);
		$personaName = str_replace('\'', '', $personaName);
		$personaName = str_replace('"', '', $personaName);
		$personaName = str_replace('zzscXXIII', '', $personaName);
		$personaName = str_ireplace('ZZSC ', '', $personaName);
		$personaName = str_ireplace('ZZFM ', '', $personaName);
		$personaName = str_ireplace('zzzsp', '', $personaName);
		$personaName = str_ireplace('Zzc2e2', '', $personaName);
		$personaName = str_replace('ZPC', '', $personaName);
		$personaName = str_ireplace('zzz', '', $personaName);
		$personaName = str_ireplace('zz ', '', $personaName);
		while(substr($personaName, 0, 1) === 'z'){
			$personaName = ltrim($personaName, 'z');
		}
		if(substr($personaName, 0, 1) === 'Zz'){
			$personaName = ltrim($personaName, 'Zz');
		}
		$personaName = trim($personaName);
		if($personaName === $mundaneName){
			$personaName = null;
		}
		return $personaName === '' ? null : $personaName;
	}
	
	private function locationClean($value){
		return $value === '' || $value === 'null' || $value === '1' || $value === 1 || $value === '0'|| $value === 0 || $value === 'Google Maps' || $value === 'google' || $value === 'na' || $value === 'n/a' ? null : $value;
	}
	
	private function geocodeClean($value){
		if($value === ''){
			return null;
		}
		$value = str_replace('\n', '', $value);
		$decoded = json_decode($value);
		if(!is_array($decoded)){
			return null;
		}
		if($decoded['status' === 'ZERO_RESULTS']){
			return null;
		}
		if(array_key_exists('error_message', $decoded)){
			return null;
		}
		return $value;
	}
}