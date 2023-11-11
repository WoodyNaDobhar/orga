<?php

namespace app\Console\Commands;

use Illuminate\Support\Facades\Log;
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
use App\Models\Chapter;
use App\Models\Chaptertype;
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

			//testing area
			// $oldEvents = $backupConnect->table('ork_event_calendardetail')
			// 	->join('ork_event', 'ork_event_calendardetail.event_id', '=', 'ork_event.event_id')
			// 	->select('ork_event_calendardetail.*', 'ork_event.*', 'ork_event.modified as modified_1', 'ork_event_calendardetail.modified as modified_2')
			// 	->get()->toArray();
// 			dd($uses);

			//clear out
			DB::table('locations')->truncate();
			DB::table('permissions')->truncate();
			DB::table('roles')->truncate();
			DB::table('role_has_permissions')->truncate();

			//Make a default 'unknown' location
			$defaultLocationId = DB::table('locations')->insertGetId([
				'address' => 'Lost to the Ages',
				'country' => null
			]);

			//roles and permissions
			$this->info('Setting Roles & Permissions...');
		
			// Reset cached roles and permissions
			app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

			// create permissions
			Permission::create(['name' => 'list accounts', 'guard_name' => 'api']);
			Permission::create(['name' => 'store accounts', 'guard_name' => 'api']);
			Permission::create(['name' => 'display accounts', 'guard_name' => 'api']);
			Permission::create(['name' => 'displayOwn accounts', 'guard_name' => 'api']);
			Permission::create(['name' => 'displayRelated accounts', 'guard_name' => 'api']);
			Permission::create(['name' => 'update accounts', 'guard_name' => 'api']);
			Permission::create(['name' => 'updateOwn accounts', 'guard_name' => 'api']);
			Permission::create(['name' => 'updateRelated accounts', 'guard_name' => 'api']);
			Permission::create(['name' => 'remove accounts', 'guard_name' => 'api']);
			Permission::create(['name' => 'removeOwn accounts', 'guard_name' => 'api']);
			Permission::create(['name' => 'removeRelated accounts', 'guard_name' => 'api']);
			Permission::create(['name' => 'list archetypes', 'guard_name' => 'api']);
			Permission::create(['name' => 'store archetypes', 'guard_name' => 'api']);
			Permission::create(['name' => 'display archetypes', 'guard_name' => 'api']);
			Permission::create(['name' => 'displayOwn archetypes', 'guard_name' => 'api']);
			Permission::create(['name' => 'displayRelated archetypes', 'guard_name' => 'api']);
			Permission::create(['name' => 'update archetypes', 'guard_name' => 'api']);
			Permission::create(['name' => 'updateOwn archetypes', 'guard_name' => 'api']);
			Permission::create(['name' => 'updateRelated archetypes', 'guard_name' => 'api']);
			Permission::create(['name' => 'remove archetypes', 'guard_name' => 'api']);
			Permission::create(['name' => 'removeOwn archetypes', 'guard_name' => 'api']);
			Permission::create(['name' => 'removeRelated archetypes', 'guard_name' => 'api']);
			Permission::create(['name' => 'list attendances', 'guard_name' => 'api']);
			Permission::create(['name' => 'store attendances', 'guard_name' => 'api']);
			Permission::create(['name' => 'display attendances', 'guard_name' => 'api']);
			Permission::create(['name' => 'displayOwn attendances', 'guard_name' => 'api']);
			Permission::create(['name' => 'displayRelated attendances', 'guard_name' => 'api']);
			Permission::create(['name' => 'update attendances', 'guard_name' => 'api']);
			Permission::create(['name' => 'updateOwn attendances', 'guard_name' => 'api']);
			Permission::create(['name' => 'updateRelated attendances', 'guard_name' => 'api']);
			Permission::create(['name' => 'remove attendances', 'guard_name' => 'api']);
			Permission::create(['name' => 'removeOwn attendances', 'guard_name' => 'api']);
			Permission::create(['name' => 'removeRelated attendances', 'guard_name' => 'api']);
			Permission::create(['name' => 'list awards', 'guard_name' => 'api']);
			Permission::create(['name' => 'store awards', 'guard_name' => 'api']);
			Permission::create(['name' => 'display awards', 'guard_name' => 'api']);
			Permission::create(['name' => 'displayOwn awards', 'guard_name' => 'api']);
			Permission::create(['name' => 'displayRelated awards', 'guard_name' => 'api']);
			Permission::create(['name' => 'update awards', 'guard_name' => 'api']);
			Permission::create(['name' => 'updateOwn awards', 'guard_name' => 'api']);
			Permission::create(['name' => 'updateRelated awards', 'guard_name' => 'api']);
			Permission::create(['name' => 'remove awards', 'guard_name' => 'api']);
			Permission::create(['name' => 'removeOwn awards', 'guard_name' => 'api']);
			Permission::create(['name' => 'removeRelated awards', 'guard_name' => 'api']);
			Permission::create(['name' => 'list chapters', 'guard_name' => 'api']);
			Permission::create(['name' => 'store chapters', 'guard_name' => 'api']);
			Permission::create(['name' => 'display chapters', 'guard_name' => 'api']);
			Permission::create(['name' => 'displayOwn chapters', 'guard_name' => 'api']);
			Permission::create(['name' => 'displayRelated chapters', 'guard_name' => 'api']);
			Permission::create(['name' => 'update chapters', 'guard_name' => 'api']);
			Permission::create(['name' => 'updateOwn chapters', 'guard_name' => 'api']);
			Permission::create(['name' => 'updateRelated chapters', 'guard_name' => 'api']);
			Permission::create(['name' => 'remove chapters', 'guard_name' => 'api']);
			Permission::create(['name' => 'removeOwn chapters', 'guard_name' => 'api']);
			Permission::create(['name' => 'removeRelated chapters', 'guard_name' => 'api']);
			Permission::create(['name' => 'list chaptertypes', 'guard_name' => 'api']);
			Permission::create(['name' => 'store chaptertypes', 'guard_name' => 'api']);
			Permission::create(['name' => 'display chaptertypes', 'guard_name' => 'api']);
			Permission::create(['name' => 'displayOwn chaptertypes', 'guard_name' => 'api']);
			Permission::create(['name' => 'displayRelated chaptertypes', 'guard_name' => 'api']);
			Permission::create(['name' => 'update chaptertypes', 'guard_name' => 'api']);
			Permission::create(['name' => 'remove chaptertypes', 'guard_name' => 'api']);
			Permission::create(['name' => 'list crats', 'guard_name' => 'api']);
			Permission::create(['name' => 'store crats', 'guard_name' => 'api']);
			Permission::create(['name' => 'display crats', 'guard_name' => 'api']);
			Permission::create(['name' => 'displayOwn crats', 'guard_name' => 'api']);
			Permission::create(['name' => 'displayRelated crats', 'guard_name' => 'api']);
			Permission::create(['name' => 'update crats', 'guard_name' => 'api']);
			Permission::create(['name' => 'updateOwn crats', 'guard_name' => 'api']);
			Permission::create(['name' => 'updateRelated crats', 'guard_name' => 'api']);
			Permission::create(['name' => 'remove crats', 'guard_name' => 'api']);
			Permission::create(['name' => 'removeOwn crats', 'guard_name' => 'api']);
			Permission::create(['name' => 'removeRelated crats', 'guard_name' => 'api']);
			Permission::create(['name' => 'list dues', 'guard_name' => 'api']);
			Permission::create(['name' => 'store dues', 'guard_name' => 'api']);
			Permission::create(['name' => 'display dues', 'guard_name' => 'api']);
			Permission::create(['name' => 'displayOwn dues', 'guard_name' => 'api']);
			Permission::create(['name' => 'displayRelated dues', 'guard_name' => 'api']);
			Permission::create(['name' => 'update dues', 'guard_name' => 'api']);
			Permission::create(['name' => 'updateOwn dues', 'guard_name' => 'api']);
			Permission::create(['name' => 'updateRelated dues', 'guard_name' => 'api']);
			Permission::create(['name' => 'remove dues', 'guard_name' => 'api']);
			Permission::create(['name' => 'removeOwn dues', 'guard_name' => 'api']);
			Permission::create(['name' => 'removeRelated dues', 'guard_name' => 'api']);
			Permission::create(['name' => 'list events', 'guard_name' => 'api']);
			Permission::create(['name' => 'store events', 'guard_name' => 'api']);
			Permission::create(['name' => 'display events', 'guard_name' => 'api']);
			Permission::create(['name' => 'displayOwn events', 'guard_name' => 'api']);
			Permission::create(['name' => 'displayRelated events', 'guard_name' => 'api']);
			Permission::create(['name' => 'update events', 'guard_name' => 'api']);
			Permission::create(['name' => 'updateOwn events', 'guard_name' => 'api']);
			Permission::create(['name' => 'updateRelated events', 'guard_name' => 'api']);
			Permission::create(['name' => 'remove events', 'guard_name' => 'api']);
			Permission::create(['name' => 'removeOwn events', 'guard_name' => 'api']);
			Permission::create(['name' => 'removeRelated events', 'guard_name' => 'api']);
			Permission::create(['name' => 'list issuances', 'guard_name' => 'api']);
			Permission::create(['name' => 'store issuances', 'guard_name' => 'api']);
			Permission::create(['name' => 'display issuances', 'guard_name' => 'api']);
			Permission::create(['name' => 'displayOwn issuances', 'guard_name' => 'api']);
			Permission::create(['name' => 'displayRelated issuances', 'guard_name' => 'api']);
			Permission::create(['name' => 'update issuances', 'guard_name' => 'api']);
			Permission::create(['name' => 'updateOwn issuances', 'guard_name' => 'api']);
			Permission::create(['name' => 'updateRelated issuances', 'guard_name' => 'api']);
			Permission::create(['name' => 'remove issuances', 'guard_name' => 'api']);
			Permission::create(['name' => 'removeOwn issuances', 'guard_name' => 'api']);
			Permission::create(['name' => 'removeRelated issuances', 'guard_name' => 'api']);
			Permission::create(['name' => 'list kingdoms', 'guard_name' => 'api']);
			Permission::create(['name' => 'store kingdoms', 'guard_name' => 'api']);
			Permission::create(['name' => 'display kingdoms', 'guard_name' => 'api']);
			Permission::create(['name' => 'displayOwn kingdoms', 'guard_name' => 'api']);
			Permission::create(['name' => 'displayRelated kingdoms', 'guard_name' => 'api']);
			Permission::create(['name' => 'update kingdoms', 'guard_name' => 'api']);
			Permission::create(['name' => 'updateOwn kingdoms', 'guard_name' => 'api']);
			Permission::create(['name' => 'updateRelated kingdoms', 'guard_name' => 'api']);
			Permission::create(['name' => 'remove kingdoms', 'guard_name' => 'api']);
			Permission::create(['name' => 'removeOwn kingdoms', 'guard_name' => 'api']);
			Permission::create(['name' => 'removeRelated kingdoms', 'guard_name' => 'api']);
			Permission::create(['name' => 'list locations', 'guard_name' => 'api']);
			Permission::create(['name' => 'store locations', 'guard_name' => 'api']);
			Permission::create(['name' => 'display locations', 'guard_name' => 'api']);
			Permission::create(['name' => 'displayOwn locations', 'guard_name' => 'api']);
			Permission::create(['name' => 'displayRelated locations', 'guard_name' => 'api']);
			Permission::create(['name' => 'update locations', 'guard_name' => 'api']);
			Permission::create(['name' => 'updateOwn locations', 'guard_name' => 'api']);
			Permission::create(['name' => 'updateRelated locations', 'guard_name' => 'api']);
			Permission::create(['name' => 'remove locations', 'guard_name' => 'api']);
			Permission::create(['name' => 'removeOwn locations', 'guard_name' => 'api']);
			Permission::create(['name' => 'removeRelated locations', 'guard_name' => 'api']);
			Permission::create(['name' => 'list meetups', 'guard_name' => 'api']);
			Permission::create(['name' => 'store meetups', 'guard_name' => 'api']);
			Permission::create(['name' => 'display meetups', 'guard_name' => 'api']);
			Permission::create(['name' => 'displayOwn meetups', 'guard_name' => 'api']);
			Permission::create(['name' => 'displayRelated meetups', 'guard_name' => 'api']);
			Permission::create(['name' => 'update meetups', 'guard_name' => 'api']);
			Permission::create(['name' => 'updateOwn meetups', 'guard_name' => 'api']);
			Permission::create(['name' => 'updateRelated meetups', 'guard_name' => 'api']);
			Permission::create(['name' => 'remove meetups', 'guard_name' => 'api']);
			Permission::create(['name' => 'removeOwn meetups', 'guard_name' => 'api']);
			Permission::create(['name' => 'removeRelated meetups', 'guard_name' => 'api']);
			Permission::create(['name' => 'list members', 'guard_name' => 'api']);
			Permission::create(['name' => 'store members', 'guard_name' => 'api']);
			Permission::create(['name' => 'display members', 'guard_name' => 'api']);
			Permission::create(['name' => 'displayOwn members', 'guard_name' => 'api']);
			Permission::create(['name' => 'displayRelated members', 'guard_name' => 'api']);
			Permission::create(['name' => 'update members', 'guard_name' => 'api']);
			Permission::create(['name' => 'updateOwn members', 'guard_name' => 'api']);
			Permission::create(['name' => 'updateRelated members', 'guard_name' => 'api']);
			Permission::create(['name' => 'remove members', 'guard_name' => 'api']);
			Permission::create(['name' => 'removeOwn members', 'guard_name' => 'api']);
			Permission::create(['name' => 'removeRelated members', 'guard_name' => 'api']);
			Permission::create(['name' => 'list officers', 'guard_name' => 'api']);
			Permission::create(['name' => 'store officers', 'guard_name' => 'api']);
			Permission::create(['name' => 'display officers', 'guard_name' => 'api']);
			Permission::create(['name' => 'displayOwn officers', 'guard_name' => 'api']);
			Permission::create(['name' => 'displayRelated officers', 'guard_name' => 'api']);
			Permission::create(['name' => 'update officers', 'guard_name' => 'api']);
			Permission::create(['name' => 'updateOwn officers', 'guard_name' => 'api']);
			Permission::create(['name' => 'updateRelated officers', 'guard_name' => 'api']);
			Permission::create(['name' => 'remove officers', 'guard_name' => 'api']);
			Permission::create(['name' => 'removeOwn officers', 'guard_name' => 'api']);
			Permission::create(['name' => 'removeRelated officers', 'guard_name' => 'api']);
			Permission::create(['name' => 'list offices', 'guard_name' => 'api']);
			Permission::create(['name' => 'store offices', 'guard_name' => 'api']);
			Permission::create(['name' => 'display offices', 'guard_name' => 'api']);
			Permission::create(['name' => 'displayOwn offices', 'guard_name' => 'api']);
			Permission::create(['name' => 'displayRelated offices', 'guard_name' => 'api']);
			Permission::create(['name' => 'update offices', 'guard_name' => 'api']);
			Permission::create(['name' => 'updateOwn offices', 'guard_name' => 'api']);
			Permission::create(['name' => 'updateRelated offices', 'guard_name' => 'api']);
			Permission::create(['name' => 'remove offices', 'guard_name' => 'api']);
			Permission::create(['name' => 'removeOwn offices', 'guard_name' => 'api']);
			Permission::create(['name' => 'removeRelated offices', 'guard_name' => 'api']);
			Permission::create(['name' => 'list personas', 'guard_name' => 'api']);
			Permission::create(['name' => 'store personas', 'guard_name' => 'api']);
			Permission::create(['name' => 'display personas', 'guard_name' => 'api']);
			Permission::create(['name' => 'displayOwn personas', 'guard_name' => 'api']);
			Permission::create(['name' => 'displayRelated personas', 'guard_name' => 'api']);
			Permission::create(['name' => 'update personas', 'guard_name' => 'api']);
			Permission::create(['name' => 'updateOwn personas', 'guard_name' => 'api']);
			Permission::create(['name' => 'updateRelated personas', 'guard_name' => 'api']);
			Permission::create(['name' => 'remove personas', 'guard_name' => 'api']);
			Permission::create(['name' => 'removeOwn personas', 'guard_name' => 'api']);
			Permission::create(['name' => 'removeRelated personas', 'guard_name' => 'api']);
			Permission::create(['name' => 'list pronouns', 'guard_name' => 'api']);
			Permission::create(['name' => 'store pronouns', 'guard_name' => 'api']);
			Permission::create(['name' => 'display pronouns', 'guard_name' => 'api']);
			Permission::create(['name' => 'displayOwn pronouns', 'guard_name' => 'api']);
			Permission::create(['name' => 'displayRelated pronouns', 'guard_name' => 'api']);
			Permission::create(['name' => 'update pronouns', 'guard_name' => 'api']);
			Permission::create(['name' => 'updateOwn pronouns', 'guard_name' => 'api']);
			Permission::create(['name' => 'updateRelated pronouns', 'guard_name' => 'api']);
			Permission::create(['name' => 'remove pronouns', 'guard_name' => 'api']);
			Permission::create(['name' => 'removeOwn pronouns', 'guard_name' => 'api']);
			Permission::create(['name' => 'removeRelated pronouns', 'guard_name' => 'api']);
			Permission::create(['name' => 'list recommendations', 'guard_name' => 'api']);
			Permission::create(['name' => 'store recommendations', 'guard_name' => 'api']);
			Permission::create(['name' => 'display recommendations', 'guard_name' => 'api']);
			Permission::create(['name' => 'displayOwn recommendations', 'guard_name' => 'api']);
			Permission::create(['name' => 'displayRelated recommendations', 'guard_name' => 'api']);
			Permission::create(['name' => 'update recommendations', 'guard_name' => 'api']);
			Permission::create(['name' => 'updateOwn recommendations', 'guard_name' => 'api']);
			Permission::create(['name' => 'updateRelated recommendations', 'guard_name' => 'api']);
			Permission::create(['name' => 'remove recommendations', 'guard_name' => 'api']);
			Permission::create(['name' => 'removeOwn recommendations', 'guard_name' => 'api']);
			Permission::create(['name' => 'removeRelated recommendations', 'guard_name' => 'api']);
			Permission::create(['name' => 'list reconciliations', 'guard_name' => 'api']);
			Permission::create(['name' => 'store reconciliations', 'guard_name' => 'api']);
			Permission::create(['name' => 'display reconciliations', 'guard_name' => 'api']);
			Permission::create(['name' => 'displayOwn reconciliations', 'guard_name' => 'api']);
			Permission::create(['name' => 'displayRelated reconciliations', 'guard_name' => 'api']);
			Permission::create(['name' => 'update reconciliations', 'guard_name' => 'api']);
			Permission::create(['name' => 'updateOwn reconciliations', 'guard_name' => 'api']);
			Permission::create(['name' => 'updateRelated reconciliations', 'guard_name' => 'api']);
			Permission::create(['name' => 'remove reconciliations', 'guard_name' => 'api']);
			Permission::create(['name' => 'removeOwn reconciliations', 'guard_name' => 'api']);
			Permission::create(['name' => 'removeRelated reconciliations', 'guard_name' => 'api']);
			Permission::create(['name' => 'list reigns', 'guard_name' => 'api']);
			Permission::create(['name' => 'store reigns', 'guard_name' => 'api']);
			Permission::create(['name' => 'display reigns', 'guard_name' => 'api']);
			Permission::create(['name' => 'displayOwn reigns', 'guard_name' => 'api']);
			Permission::create(['name' => 'displayRelated reigns', 'guard_name' => 'api']);
			Permission::create(['name' => 'update reigns', 'guard_name' => 'api']);
			Permission::create(['name' => 'updateOwn reigns', 'guard_name' => 'api']);
			Permission::create(['name' => 'updateRelated reigns', 'guard_name' => 'api']);
			Permission::create(['name' => 'remove reigns', 'guard_name' => 'api']);
			Permission::create(['name' => 'removeOwn reigns', 'guard_name' => 'api']);
			Permission::create(['name' => 'removeRelated reigns', 'guard_name' => 'api']);
			Permission::create(['name' => 'list splits', 'guard_name' => 'api']);
			Permission::create(['name' => 'store splits', 'guard_name' => 'api']);
			Permission::create(['name' => 'display splits', 'guard_name' => 'api']);
			Permission::create(['name' => 'displayOwn splits', 'guard_name' => 'api']);
			Permission::create(['name' => 'displayRelated splits', 'guard_name' => 'api']);
			Permission::create(['name' => 'update splits', 'guard_name' => 'api']);
			Permission::create(['name' => 'updateOwn splits', 'guard_name' => 'api']);
			Permission::create(['name' => 'updateRelated splits', 'guard_name' => 'api']);
			Permission::create(['name' => 'remove splits', 'guard_name' => 'api']);
			Permission::create(['name' => 'removeOwn splits', 'guard_name' => 'api']);
			Permission::create(['name' => 'removeRelated splits', 'guard_name' => 'api']);
			Permission::create(['name' => 'list suspensions', 'guard_name' => 'api']);
			Permission::create(['name' => 'store suspensions', 'guard_name' => 'api']);
			Permission::create(['name' => 'display suspensions', 'guard_name' => 'api']);
			Permission::create(['name' => 'displayOwn suspensions', 'guard_name' => 'api']);
			Permission::create(['name' => 'displayRelated suspensions', 'guard_name' => 'api']);
			Permission::create(['name' => 'update suspensions', 'guard_name' => 'api']);
			Permission::create(['name' => 'updateOwn suspensions', 'guard_name' => 'api']);
			Permission::create(['name' => 'updateRelated suspensions', 'guard_name' => 'api']);
			Permission::create(['name' => 'remove suspensions', 'guard_name' => 'api']);
			Permission::create(['name' => 'removeOwn suspensions', 'guard_name' => 'api']);
			Permission::create(['name' => 'removeRelated suspensions', 'guard_name' => 'api']);
			Permission::create(['name' => 'list titles', 'guard_name' => 'api']);
			Permission::create(['name' => 'store titles', 'guard_name' => 'api']);
			Permission::create(['name' => 'display titles', 'guard_name' => 'api']);
			Permission::create(['name' => 'displayOwn titles', 'guard_name' => 'api']);
			Permission::create(['name' => 'displayRelated titles', 'guard_name' => 'api']);
			Permission::create(['name' => 'update titles', 'guard_name' => 'api']);
			Permission::create(['name' => 'updateOwn titles', 'guard_name' => 'api']);
			Permission::create(['name' => 'updateRelated titles', 'guard_name' => 'api']);
			Permission::create(['name' => 'remove titles', 'guard_name' => 'api']);
			Permission::create(['name' => 'removeOwn titles', 'guard_name' => 'api']);
			Permission::create(['name' => 'removeRelated titles', 'guard_name' => 'api']);
			Permission::create(['name' => 'list tournaments', 'guard_name' => 'api']);
			Permission::create(['name' => 'store tournaments', 'guard_name' => 'api']);
			Permission::create(['name' => 'display tournaments', 'guard_name' => 'api']);
			Permission::create(['name' => 'displayOwn tournaments', 'guard_name' => 'api']);
			Permission::create(['name' => 'displayRelated tournaments', 'guard_name' => 'api']);
			Permission::create(['name' => 'update tournaments', 'guard_name' => 'api']);
			Permission::create(['name' => 'updateOwn tournaments', 'guard_name' => 'api']);
			Permission::create(['name' => 'updateRelated tournaments', 'guard_name' => 'api']);
			Permission::create(['name' => 'remove tournaments', 'guard_name' => 'api']);
			Permission::create(['name' => 'removeOwn tournaments', 'guard_name' => 'api']);
			Permission::create(['name' => 'removeRelated tournaments', 'guard_name' => 'api']);
			Permission::create(['name' => 'list transactions', 'guard_name' => 'api']);
			Permission::create(['name' => 'store transactions', 'guard_name' => 'api']);
			Permission::create(['name' => 'display transactions', 'guard_name' => 'api']);
			Permission::create(['name' => 'displayOwn transactions', 'guard_name' => 'api']);
			Permission::create(['name' => 'displayRelated transactions', 'guard_name' => 'api']);
			Permission::create(['name' => 'update transactions', 'guard_name' => 'api']);
			Permission::create(['name' => 'updateOwn transactions', 'guard_name' => 'api']);
			Permission::create(['name' => 'updateRelated transactions', 'guard_name' => 'api']);
			Permission::create(['name' => 'remove transactions', 'guard_name' => 'api']);
			Permission::create(['name' => 'removeOwn transactions', 'guard_name' => 'api']);
			Permission::create(['name' => 'removeRelated transactions', 'guard_name' => 'api']);
			Permission::create(['name' => 'list units', 'guard_name' => 'api']);
			Permission::create(['name' => 'store units', 'guard_name' => 'api']);
			Permission::create(['name' => 'display units', 'guard_name' => 'api']);
			Permission::create(['name' => 'displayOwn units', 'guard_name' => 'api']);
			Permission::create(['name' => 'displayRelated units', 'guard_name' => 'api']);
			Permission::create(['name' => 'update units', 'guard_name' => 'api']);
			Permission::create(['name' => 'updateOwn units', 'guard_name' => 'api']);
			Permission::create(['name' => 'updateRelated units', 'guard_name' => 'api']);
			Permission::create(['name' => 'remove units', 'guard_name' => 'api']);
			Permission::create(['name' => 'removeOwn units', 'guard_name' => 'api']);
			Permission::create(['name' => 'removeRelated units', 'guard_name' => 'api']);
			Permission::create(['name' => 'list users', 'guard_name' => 'api']);
			Permission::create(['name' => 'store users', 'guard_name' => 'api']);
			Permission::create(['name' => 'display users', 'guard_name' => 'api']);
			Permission::create(['name' => 'displayOwn users', 'guard_name' => 'api']);
			Permission::create(['name' => 'displayRelated users', 'guard_name' => 'api']);
			Permission::create(['name' => 'update users', 'guard_name' => 'api']);
			Permission::create(['name' => 'updateOwn users', 'guard_name' => 'api']);
			Permission::create(['name' => 'updateRelated users', 'guard_name' => 'api']);
			Permission::create(['name' => 'remove users', 'guard_name' => 'api']);
			Permission::create(['name' => 'removeOwn users', 'guard_name' => 'api']);
			Permission::create(['name' => 'removeRelated users', 'guard_name' => 'api']);
			Permission::create(['name' => 'list waivers', 'guard_name' => 'api']);
			Permission::create(['name' => 'store waivers', 'guard_name' => 'api']);
			Permission::create(['name' => 'display waivers', 'guard_name' => 'api']);
			Permission::create(['name' => 'displayOwn waivers', 'guard_name' => 'api']);
			Permission::create(['name' => 'displayRelated waivers', 'guard_name' => 'api']);
			Permission::create(['name' => 'update waivers', 'guard_name' => 'api']);
			Permission::create(['name' => 'updateOwn waivers', 'guard_name' => 'api']);
			Permission::create(['name' => 'updateRelated waivers', 'guard_name' => 'api']);
			Permission::create(['name' => 'remove waivers', 'guard_name' => 'api']);
			Permission::create(['name' => 'removeOwn waivers', 'guard_name' => 'api']);
			Permission::create(['name' => 'removeRelated waivers', 'guard_name' => 'api']);

			// create roles and assign created permissions
			$role = Role::create(['name' => 'admin', 'guard_name' => 'api']);
			// gets all permissions via Gate::before rule; see AuthServiceProvider

			$role = Role::create(['name' => 'officer', 'guard_name' => 'api']);
			$role->givePermissionTo('list accounts');
			$role->givePermissionTo('store accounts');
			$role->givePermissionTo('displayOwn accounts');
			$role->givePermissionTo('displayRelated accounts');
			$role->givePermissionTo('updateOwn accounts');
			$role->givePermissionTo('updateRelated accounts');
			$role->givePermissionTo('removeOwn accounts');
			$role->givePermissionTo('removeRelated accounts');
			$role->givePermissionTo('list archetypes');
			$role->givePermissionTo('display archetypes');
			$role->givePermissionTo('displayOwn archetypes');
			$role->givePermissionTo('displayRelated archetypes');
			$role->givePermissionTo('list attendances');
			$role->givePermissionTo('store attendances');
			$role->givePermissionTo('display attendances');
			$role->givePermissionTo('displayOwn attendances');
			$role->givePermissionTo('displayRelated attendances');
			$role->givePermissionTo('updateOwn attendances');
			$role->givePermissionTo('updateRelated attendances');
			$role->givePermissionTo('removeOwn attendances');
			$role->givePermissionTo('removeRelated attendances');
			$role->givePermissionTo('list awards');
			$role->givePermissionTo('store awards');
			$role->givePermissionTo('display awards');
			$role->givePermissionTo('displayOwn awards');
			$role->givePermissionTo('displayRelated awards');
			$role->givePermissionTo('updateOwn awards');
			$role->givePermissionTo('updateRelated awards');
			$role->givePermissionTo('removeOwn awards');
			$role->givePermissionTo('removeRelated awards');
			$role->givePermissionTo('list chapters');
			$role->givePermissionTo('store chapters');
			$role->givePermissionTo('display chapters');
			$role->givePermissionTo('displayOwn chapters');
			$role->givePermissionTo('displayRelated chapters');
			$role->givePermissionTo('updateOwn chapters');
			$role->givePermissionTo('updateRelated chapters');
			$role->givePermissionTo('removeOwn chapters');
			$role->givePermissionTo('removeRelated chapters');
			$role->givePermissionTo('list chaptertypes');
			$role->givePermissionTo('store chaptertypes');
			$role->givePermissionTo('display chaptertypes');
			$role->givePermissionTo('displayOwn chaptertypes');
			$role->givePermissionTo('displayRelated chaptertypes');
			$role->givePermissionTo('list crats');
			$role->givePermissionTo('store crats');
			$role->givePermissionTo('display crats');
			$role->givePermissionTo('displayOwn crats');
			$role->givePermissionTo('displayRelated crats');
			$role->givePermissionTo('updateOwn crats');
			$role->givePermissionTo('updateRelated crats');
			$role->givePermissionTo('removeOwn crats');
			$role->givePermissionTo('removeRelated crats');
			$role->givePermissionTo('list dues');
			$role->givePermissionTo('store dues');
			$role->givePermissionTo('display dues');
			$role->givePermissionTo('displayOwn dues');
			$role->givePermissionTo('displayRelated dues');
			$role->givePermissionTo('updateOwn dues');
			$role->givePermissionTo('updateRelated dues');
			$role->givePermissionTo('removeOwn dues');
			$role->givePermissionTo('removeRelated dues');
			$role->givePermissionTo('list events');
			$role->givePermissionTo('store events');
			$role->givePermissionTo('display events');
			$role->givePermissionTo('displayOwn events');
			$role->givePermissionTo('displayRelated events');
			$role->givePermissionTo('updateOwn events');
			$role->givePermissionTo('updateRelated events');
			$role->givePermissionTo('removeOwn events');
			$role->givePermissionTo('removeRelated events');
			$role->givePermissionTo('list issuances');
			$role->givePermissionTo('store issuances');
			$role->givePermissionTo('display issuances');
			$role->givePermissionTo('displayOwn issuances');
			$role->givePermissionTo('displayRelated issuances');
			$role->givePermissionTo('updateOwn issuances');
			$role->givePermissionTo('updateRelated issuances');
			$role->givePermissionTo('removeOwn issuances');
			$role->givePermissionTo('removeRelated issuances');
			$role->givePermissionTo('list kingdoms');
			$role->givePermissionTo('display kingdoms');
			$role->givePermissionTo('displayOwn kingdoms');
			$role->givePermissionTo('displayRelated kingdoms');
			$role->givePermissionTo('updateOwn kingdoms');
			$role->givePermissionTo('updateRelated kingdoms');
			$role->givePermissionTo('list locations');
			$role->givePermissionTo('store locations');
			$role->givePermissionTo('display locations');
			$role->givePermissionTo('displayOwn locations');
			$role->givePermissionTo('displayRelated locations');
			$role->givePermissionTo('updateOwn locations');
			$role->givePermissionTo('updateRelated locations');
			$role->givePermissionTo('removeOwn locations');
			$role->givePermissionTo('removeRelated locations');
			$role->givePermissionTo('list meetups');
			$role->givePermissionTo('store meetups');
			$role->givePermissionTo('display meetups');
			$role->givePermissionTo('displayOwn meetups');
			$role->givePermissionTo('displayRelated meetups');
			$role->givePermissionTo('updateOwn meetups');
			$role->givePermissionTo('updateRelated meetups');
			$role->givePermissionTo('removeOwn meetups');
			$role->givePermissionTo('removeRelated meetups');
			$role->givePermissionTo('list members');
			$role->givePermissionTo('store members');
			$role->givePermissionTo('display members');
			$role->givePermissionTo('displayOwn members');
			$role->givePermissionTo('displayRelated members');
			$role->givePermissionTo('updateOwn members');
			$role->givePermissionTo('updateRelated members');
			$role->givePermissionTo('removeOwn members');
			$role->givePermissionTo('removeRelated members');
			$role->givePermissionTo('list officers');
			$role->givePermissionTo('store officers');
			$role->givePermissionTo('display officers');
			$role->givePermissionTo('displayOwn officers');
			$role->givePermissionTo('displayRelated officers');
			$role->givePermissionTo('updateOwn officers');
			$role->givePermissionTo('updateRelated officers');
			$role->givePermissionTo('removeOwn officers');
			$role->givePermissionTo('removeRelated officers');
			$role->givePermissionTo('list offices');
			$role->givePermissionTo('store offices');
			$role->givePermissionTo('display offices');
			$role->givePermissionTo('displayOwn offices');
			$role->givePermissionTo('displayRelated offices');
			$role->givePermissionTo('updateOwn offices');
			$role->givePermissionTo('updateRelated offices');
			$role->givePermissionTo('removeOwn offices');
			$role->givePermissionTo('removeRelated offices');
			$role->givePermissionTo('list personas');
			$role->givePermissionTo('store personas');
			$role->givePermissionTo('display personas');
			$role->givePermissionTo('displayOwn personas');
			$role->givePermissionTo('displayRelated personas');
			$role->givePermissionTo('updateOwn personas');
			$role->givePermissionTo('updateRelated personas');
			$role->givePermissionTo('removeOwn personas');
			$role->givePermissionTo('removeRelated personas');
			$role->givePermissionTo('list pronouns');
			$role->givePermissionTo('display pronouns');
			$role->givePermissionTo('displayOwn pronouns');
			$role->givePermissionTo('displayRelated pronouns');
			$role->givePermissionTo('list recommendations');
			$role->givePermissionTo('store recommendations');
			$role->givePermissionTo('display recommendations');
			$role->givePermissionTo('displayOwn recommendations');
			$role->givePermissionTo('displayRelated recommendations');
			$role->givePermissionTo('updateOwn recommendations');
			$role->givePermissionTo('updateRelated recommendations');
			$role->givePermissionTo('removeOwn recommendations');
			$role->givePermissionTo('removeRelated recommendations');
			$role->givePermissionTo('list reconciliations');
			$role->givePermissionTo('store reconciliations');
			$role->givePermissionTo('display reconciliations');
			$role->givePermissionTo('displayOwn reconciliations');
			$role->givePermissionTo('displayRelated reconciliations');
			$role->givePermissionTo('updateOwn reconciliations');
			$role->givePermissionTo('updateRelated reconciliations');
			$role->givePermissionTo('removeOwn reconciliations');
			$role->givePermissionTo('removeRelated reconciliations');
			$role->givePermissionTo('list reigns');
			$role->givePermissionTo('store reigns');
			$role->givePermissionTo('display reigns');
			$role->givePermissionTo('displayOwn reigns');
			$role->givePermissionTo('displayRelated reigns');
			$role->givePermissionTo('updateOwn reigns');
			$role->givePermissionTo('updateRelated reigns');
			$role->givePermissionTo('removeOwn reigns');
			$role->givePermissionTo('removeRelated reigns');
			$role->givePermissionTo('list splits');
			$role->givePermissionTo('store splits');
			$role->givePermissionTo('display splits');
			$role->givePermissionTo('displayOwn splits');
			$role->givePermissionTo('displayRelated splits');
			$role->givePermissionTo('updateOwn splits');
			$role->givePermissionTo('updateRelated splits');
			$role->givePermissionTo('removeOwn splits');
			$role->givePermissionTo('removeRelated splits');
			$role->givePermissionTo('list suspensions');
			$role->givePermissionTo('store suspensions');
			$role->givePermissionTo('display suspensions');
			$role->givePermissionTo('displayOwn suspensions');
			$role->givePermissionTo('displayRelated suspensions');
			$role->givePermissionTo('updateOwn suspensions');
			$role->givePermissionTo('updateRelated suspensions');
			$role->givePermissionTo('removeOwn suspensions');
			$role->givePermissionTo('removeRelated suspensions');
			$role->givePermissionTo('list titles');
			$role->givePermissionTo('store titles');
			$role->givePermissionTo('display titles');
			$role->givePermissionTo('displayOwn titles');
			$role->givePermissionTo('displayRelated titles');
			$role->givePermissionTo('updateOwn titles');
			$role->givePermissionTo('updateRelated titles');
			$role->givePermissionTo('removeOwn titles');
			$role->givePermissionTo('removeRelated titles');
			$role->givePermissionTo('list tournaments');
			$role->givePermissionTo('store tournaments');
			$role->givePermissionTo('display tournaments');
			$role->givePermissionTo('displayOwn tournaments');
			$role->givePermissionTo('displayRelated tournaments');
			$role->givePermissionTo('updateOwn tournaments');
			$role->givePermissionTo('updateRelated tournaments');
			$role->givePermissionTo('removeOwn tournaments');
			$role->givePermissionTo('removeRelated tournaments');
			$role->givePermissionTo('list transactions');
			$role->givePermissionTo('store transactions');
			$role->givePermissionTo('displayOwn transactions');
			$role->givePermissionTo('displayRelated transactions');
			$role->givePermissionTo('updateOwn transactions');
			$role->givePermissionTo('updateRelated transactions');
			$role->givePermissionTo('removeOwn transactions');
			$role->givePermissionTo('removeRelated transactions');
			$role->givePermissionTo('list units');
			$role->givePermissionTo('store units');
			$role->givePermissionTo('display units');
			$role->givePermissionTo('displayOwn units');
			$role->givePermissionTo('displayRelated units');
			$role->givePermissionTo('updateOwn units');
			$role->givePermissionTo('updateRelated units');
			$role->givePermissionTo('removeOwn units');
			$role->givePermissionTo('removeRelated units');
			$role->givePermissionTo('list users');
			$role->givePermissionTo('store users');
			$role->givePermissionTo('display users');
			$role->givePermissionTo('displayOwn users');
			$role->givePermissionTo('displayRelated users');
			$role->givePermissionTo('updateOwn users');
			$role->givePermissionTo('updateRelated users');
			$role->givePermissionTo('removeOwn users');
			$role->givePermissionTo('removeRelated users');
			$role->givePermissionTo('list waivers');
			$role->givePermissionTo('store waivers');
			$role->givePermissionTo('display waivers');
			$role->givePermissionTo('displayOwn waivers');
			$role->givePermissionTo('displayRelated waivers');
			$role->givePermissionTo('updateOwn waivers');
			$role->givePermissionTo('updateRelated waivers');
			$role->givePermissionTo('removeOwn waivers');
			$role->givePermissionTo('removeRelated waivers');

			$role = Role::create(['name' => 'player', 'guard_name' => 'api']);
			$role->givePermissionTo('list archetypes');
			$role->givePermissionTo('display archetypes');
			$role->givePermissionTo('list attendances');
			$role->givePermissionTo('store attendances');
			$role->givePermissionTo('display attendances');
			$role->givePermissionTo('displayOwn attendances');
			$role->givePermissionTo('displayRelated attendances');
			$role->givePermissionTo('list awards');
			$role->givePermissionTo('display awards');
			$role->givePermissionTo('displayOwn awards');
			$role->givePermissionTo('displayRelated awards');
			$role->givePermissionTo('list chaptertypes');
			$role->givePermissionTo('list chapters');
			$role->givePermissionTo('display chapters');
			$role->givePermissionTo('displayOwn chapters');
			$role->givePermissionTo('displayRelated chapters');
			$role->givePermissionTo('display chaptertypes');
			$role->givePermissionTo('displayOwn chaptertypes');
			$role->givePermissionTo('displayRelated chaptertypes');
			$role->givePermissionTo('list crats');
			$role->givePermissionTo('store crats');
			$role->givePermissionTo('display crats');
			$role->givePermissionTo('displayOwn crats');
			$role->givePermissionTo('displayRelated crats');
			$role->givePermissionTo('updateOwn crats');
			$role->givePermissionTo('removeOwn crats');
			$role->givePermissionTo('list dues');
			$role->givePermissionTo('display dues');
			$role->givePermissionTo('displayOwn dues');
			$role->givePermissionTo('displayRelated dues');
			$role->givePermissionTo('list events');
			$role->givePermissionTo('display events');
			$role->givePermissionTo('displayOwn events');
			$role->givePermissionTo('displayRelated events');
			$role->givePermissionTo('updateOwn events');
			$role->givePermissionTo('list issuances');
			$role->givePermissionTo('display issuances');
			$role->givePermissionTo('displayOwn issuances');
			$role->givePermissionTo('displayRelated issuances');
			$role->givePermissionTo('list kingdoms');
			$role->givePermissionTo('display kingdoms');
			$role->givePermissionTo('list locations');
			$role->givePermissionTo('store locations');
			$role->givePermissionTo('display locations');
			$role->givePermissionTo('displayOwn locations');
			$role->givePermissionTo('displayRelated locations');
			$role->givePermissionTo('updateOwn locations');
			$role->givePermissionTo('removeOwn locations');
			$role->givePermissionTo('list meetups');
			$role->givePermissionTo('display meetups');
			$role->givePermissionTo('displayOwn meetups');
			$role->givePermissionTo('displayRelated meetups');
			$role->givePermissionTo('list members');
			$role->givePermissionTo('store members');
			$role->givePermissionTo('display members');
			$role->givePermissionTo('displayOwn members');
			$role->givePermissionTo('displayRelated members');
			$role->givePermissionTo('updateOwn members');
			$role->givePermissionTo('removeOwn members');
			$role->givePermissionTo('list officers');
			$role->givePermissionTo('display officers');
			$role->givePermissionTo('displayOwn officers');
			$role->givePermissionTo('displayRelated officers');
			$role->givePermissionTo('list offices');
			$role->givePermissionTo('display offices');
			$role->givePermissionTo('displayOwn offices');
			$role->givePermissionTo('displayRelated offices');
			$role->givePermissionTo('list personas');
			$role->givePermissionTo('display personas');
			$role->givePermissionTo('displayOwn personas');
			$role->givePermissionTo('displayRelated personas');
			$role->givePermissionTo('updateOwn personas');
			$role->givePermissionTo('list pronouns');
			$role->givePermissionTo('display pronouns');
			$role->givePermissionTo('displayOwn pronouns');
			$role->givePermissionTo('displayRelated pronouns');
			$role->givePermissionTo('updateOwn pronouns');
			$role->givePermissionTo('removeOwn pronouns');
			$role->givePermissionTo('list recommendations');
			$role->givePermissionTo('store recommendations');
			$role->givePermissionTo('display recommendations');
			$role->givePermissionTo('displayOwn recommendations');
			$role->givePermissionTo('displayRelated recommendations');
			$role->givePermissionTo('updateOwn recommendations');
			$role->givePermissionTo('removeOwn recommendations');
			$role->givePermissionTo('list reconciliations');
			$role->givePermissionTo('display reconciliations');
			$role->givePermissionTo('displayOwn reconciliations');
			$role->givePermissionTo('displayRelated reconciliations');
			$role->givePermissionTo('list reigns');
			$role->givePermissionTo('display reigns');
			$role->givePermissionTo('displayOwn reigns');
			$role->givePermissionTo('displayRelated reigns');
			$role->givePermissionTo('list suspensions');
			$role->givePermissionTo('display suspensions');
			$role->givePermissionTo('displayOwn suspensions');
			$role->givePermissionTo('displayRelated suspensions');
			$role->givePermissionTo('list titles');
			$role->givePermissionTo('display titles');
			$role->givePermissionTo('displayOwn titles');
			$role->givePermissionTo('displayRelated titles');
			$role->givePermissionTo('list tournaments');
			$role->givePermissionTo('store tournaments');
			$role->givePermissionTo('display tournaments');
			$role->givePermissionTo('displayOwn tournaments');
			$role->givePermissionTo('displayRelated tournaments');
			$role->givePermissionTo('updateOwn tournaments');
			$role->givePermissionTo('removeOwn tournaments');
			$role->givePermissionTo('list units');
			$role->givePermissionTo('store units');
			$role->givePermissionTo('display units');
			$role->givePermissionTo('displayOwn units');
			$role->givePermissionTo('displayRelated units');
			$role->givePermissionTo('update units');
			$role->givePermissionTo('updateOwn units');
			$role->givePermissionTo('remove units');
			$role->givePermissionTo('removeOwn units');
			$role->givePermissionTo('list users');
			$role->givePermissionTo('store users');
			$role->givePermissionTo('display users');
			$role->givePermissionTo('displayOwn users');
			$role->givePermissionTo('displayRelated users');
			$role->givePermissionTo('updateOwn users');
			$role->givePermissionTo('removeOwn users');
			$role->givePermissionTo('list waivers');
			$role->givePermissionTo('display waivers');
			$role->givePermissionTo('displayOwn waivers');
			$role->givePermissionTo('displayRelated waivers');

			app('cache')
				->store(config('permission.cache.store') != 'default' ? config('permission.cache.store') : null)
				->forget(config('permission.cache.key'));

			//TODO: delete this
// 			$trans = DB::table('trans')->get();
			
			//various holders
			$deadRecords = [];
			$transArchetypes = [];
			$transKingdoms = [];
			$transChaptertypes = [];
			$transChapters = [];
			$transUnits = [];
			$transGenericAwards = [];
			$transKingdomawards = [];
			$transTitles = [];
			$transCustomTitles = [];
			$transPronouns = [];
			$transUsers = [];
			$transPersonas = [];
			$transEvents = [];
			$transEventDetails = [];
			$transAccounts = [];
			$transMeetups = [];
			$transGenericAttendances = [];
			$transTournaments = [];
			$transTransactions = [];
			$transDues = [];
			$transMembers = [];
			$transOfficers = [];
			$transRecommendations = [];
			$transReconciliations = [];
			$transSplits = [];
			
			//TODO: delete these
// 			$transDone = $trans->filter(function($item) {
// 				return ($item->table === 'kingdomawardsprocessed');
// 			});
// 			if($transDone->first()){
// 				$kingdomawardsProcessed = unserialize($transDone->first()->value);
// 			}else{
// 				DB::table('trans')->insert([
// 						'table' => 'kingdomawardsprocessed',
// 						'value' => serialize([])
// 				]);
// 				$kingdomawardsProcessed = [];
// 			}
// 			$transDone = $trans->filter(function($item) {
// 				return ($item->table === 'archetypes');
// 			});
// 			if(count($transDone) > 0){
// 				$transArchetypes = unserialize($transDone->first()->value);
// 			}
// 			$transDone = $trans->filter(function($item) {
// 				return ($item->table === 'kingdoms');
// 			});
// 			if(count($transDone) > 0){
// 				$transKingdoms = unserialize($transDone->first()->value);
// 			}
// 			$transDone = $trans->filter(function($item) {
// 				return ($item->table === 'chaptertypes');
// 			});
// 			if(count($transDone) > 0){
// 				$transChaptertypes = unserialize($transDone->first()->value);
// 			}
// 			$transDone = $trans->filter(function($item) {
// 				return ($item->table === 'chapters');
// 			});
// 			if(count($transDone) > 0){
// 				$transChapters = unserialize($transDone->first()->value);
// 			}
// 			$transDone = $trans->filter(function($item) {
// 				return ($item->table === 'units');
// 			});
// 			if(count($transDone) > 0){
// 				$transUnits = unserialize($transDone->first()->value);
// 			}
// 			$transDone = $trans->filter(function($item) {
// 				return ($item->table === 'genericawards');
// 			});
// 			if(count($transDone) > 0){
// 				$transGenericAwards = unserialize($transDone->first()->value);
// 			}
// 			$transDone = $trans->filter(function($item) {
// 				return ($item->table === 'customawards');
// 			});
// 			if(count($transDone) > 0){
// 				$transKingdomawards = unserialize($transDone->first()->value);
// 			}
// 			$transDone = $trans->filter(function($item) {
// 				return ($item->table === 'titles');
// 			});
// 			if(count($transDone) > 0){
// 				$transTitles = unserialize($transDone->first()->value);
// 			}
// 			$transDone = $trans->filter(function($item) {
// 				return ($item->table === 'customtitles');
// 			});
// 			if(count($transDone) > 0){
// 				$transCustomTitles = unserialize($transDone->first()->value);
// 			}
// 			$transDone = $trans->filter(function($item) {
// 				return ($item->table === 'pronouns');
// 			});
// 			if(count($transDone) > 0){
// 				$transPronouns = unserialize($transDone->first()->value);
// 			}
// 			$transDone = $trans->filter(function($item) {
// 				return ($item->table === 'users');
// 			});
// 			if(count($transDone) > 0){
// 				$transUsers = unserialize($transDone->first()->value);
// 			}
// 			$transDone = $trans->filter(function($item) {
// 				return ($item->table === 'personas');
// 			});
// 			if(count($transDone) > 0){
// 				$transPersonas = unserialize($transDone->first()->value);
// 			}
// 			$transDone = $trans->filter(function($item) {
// 				return ($item->table === 'events');
// 			});
// 			if(count($transDone) > 0){
// 				$transEvents = unserialize($transDone->first()->value);
// 			}
// 			$transDone = $trans->filter(function($item) {
// 				return ($item->table === 'eventDetails');
// 			});
// 			if(count($transDone) > 0){
// 				$transEventDetails = unserialize($transDone->first()->value);
// 			}
// 			$transDone = $trans->filter(function($item) {
// 				return ($item->table === 'accounts');
// 			});
// 			if(count($transDone) > 0){
// 				$transAccounts = unserialize($transDone->first()->value);
// 			}
// 			$transDone = $trans->filter(function($item) {
// 				return ($item->table === 'meetups');
// 			});
// 			if(count($transDone) > 0){
// 				$transMeetups = unserialize($transDone->first()->value);
// 			}
// 			$transDone = $trans->filter(function($item) {
// 				return ($item->table === 'genericAttendances');
// 			});
// 			if(count($transDone) > 0){
// 				$transGenericAttendances = unserialize($transDone->first()->value);
// 			}
// 			$transDone = $trans->filter(function($item) {
// 				return ($item->table === 'tournaments');
// 			});
// 			if(count($transDone) > 0){
// 				$transTournaments = unserialize($transDone->first()->value);
// 			}]
// 			$transDone = $trans->filter(function($item) {
// 				return ($item->table === 'transactions');
// 			});
// 			if(count($transDone) > 0){
// 				$transTransactions = unserialize($transDone->first()->value);
// 			}
// 			$transDone = $trans->filter(function($item) {
// 				return ($item->table === 'dues');
// 			});
// 			if(count($transDone) > 0){
// 				$transDues = unserialize($transDone->first()->value);
// 			};
// 			$transDone = $trans->filter(function($item) {
// 				return ($item->table === 'members');
// 			});
// 			if(count($transDone) > 0){
// 				$transMembers = unserialize($transDone->first()->value);
// 			}
// 			$transDone = $trans->filter(function($item) {
// 				return ($item->table === 'officers');
// 			});
// 			if(count($transDone) > 0){
// 				$transOfficers = unserialize($transDone->first()->value);
// 			}
// 			$transDone = $trans->filter(function($item) {
// 				return ($item->table === 'recommendations');
// 			});
// 			if(count($transDone) > 0){
// 				$transRecommendations = unserialize($transDone->first()->value);
// 			}
// 			$transDone = $trans->filter(function($item) {
// 				return ($item->table === 'reconciliations');
// 			});
// 			if(count($transDone) > 0){
// 				$transReconciliations = unserialize($transDone->first()->value);
// 			}
			
			//TODO: convert any of their GD's into 'kingdoms'
			
			//what we know
			include 'known.php';

			//archetypes
			$this->info('Importing Archetypes...');
			$oldArchetypes = $backupConnect->table('ork_class')->get()->toArray();
			DB::table('archetypes')->truncate();
			if (count($oldArchetypes) > 0) {
				$bar1 = $this->output->createProgressBar(count($oldArchetypes));
				$bar1->start();
				foreach ($oldArchetypes as $oldArchetype) {
					$archetypeId = DB::table('archetypes')->insertGetId([
							'name' => $oldArchetype->name, 
							'is_active' => $oldArchetype->active
					]);
					$transArchetypes[$oldArchetype->class_id] = $archetypeId;
					$bar1->advance();
				}
				$bar1->finish();
				$this->info('');
			}
			//TODO: delete these
// 			DB::table('trans')->insert([
// 					'table' => 'archetypes',
// 					'value' => serialize($transArchetypes)
// 			]);
			
			//kingdoms
			$this->info('Importing Kingdoms...');
			$oldKingdoms = $backupConnect->table('ork_kingdom')->orderBy('kingdom_id', 'ASC')->get()->toArray();
			DB::table('kingdoms')->truncate();
			$freeholds = null;
			if (count($oldKingdoms) > 0) {
				$bar2 = $this->output->createProgressBar(count($oldKingdoms));
				$bar2->start();
				foreach ($oldKingdoms as $oldKingdom) {
					//nope this guy
					if($oldKingdom->name === '&THORN;e Olde Records Empire'){
						$deadRecords['Kingdoms'][$oldKingdom->kingdom_id] = $oldKingdom;
						//we're moving them to freeholds
						$transKingdoms[$oldKingdom->kingdom_id] = $freeholds;
					}
					$kingdomId = DB::table('kingdoms')->insertGetId([
							'parent_id' => $oldKingdom->parent_kingdom_id == 0 ? null : $transKingdoms[$oldKingdom->parent_kingdom_id],
							'name' => $oldKingdom->name,
							'abbreviation' => $oldKingdom->abbreviation,
							'heraldry' => $oldKingdom->has_heraldry === 1 ? sprintf('%04d.jpg', $oldKingdom->kingdom_id) : null,
							'is_active' => $oldKingdom->active === 'Active' ? 1 : 0,
							'created_at' => $oldKingdom->modified,
							'updated_at' => $oldKingdom->modified
					]);
					if($oldKingdom->name === 'The Freeholds of Amtgard'){
						$freeholds = $kingdomId;
					}
					$transKingdoms[$oldKingdom->kingdom_id] = $kingdomId;
					$bar2->advance();
				}
				$bar2->finish();
				$this->info('');
			}
// 			DB::table('trans')->insert([
// 					'table' => 'kingdoms',
// 					'value' => serialize($transKingdoms)
// 			]);
			
			//chaptertypes
			$this->info('Importing Chaptertypes...');
			$backupConnect->table('ork_parktitle')
				->where('kingdom_id', 16)
				->orWhere('title', 'Shire')
				->update(['class' => 20]);
			$backupConnect->table('ork_parktitle')
				->where('kingdom_id', 16)
				->orWhere('title', 'Barony')
				->update(['class' => 30]);
			$oldChaptertypes = $backupConnect->table('ork_parktitle')->get()->toArray();
			$chaptertypeId = 0;
			$known = $knownKingdomChaptertypesOffices;
			DB::table('chaptertypes')->truncate();
			if (isset($oldChaptertypes)) {
				$bar3 = $this->output->createProgressBar(count($oldChaptertypes) + 43);
				$bar3->start();
				foreach ($oldChaptertypes as $oldChaptertype) {
					if (!array_key_exists($oldChaptertype->kingdom_id, $transKingdoms)) {
						$kingdomId = DB::table('kingdoms')->insertGetId([
							'parent_id' => null,
							'name' => 'Deleted Kingdom ' . $oldChaptertype->kingdom_id,
							'abbreviation' => 'DK' . $oldChaptertype->kingdom_id,
							'heraldry' => null,
							'is_active' => 0
						]);
						$transKingdoms[$oldChaptertype->kingdom_id] = $kingdomId;
// 						DB::table('trans')->where('table', 'kingdoms')->update([
// 								'value' => serialize($transKingdoms)
// 						]);
					}
					//If it's one of our known kingdoms, 
					if(array_key_exists($oldChaptertype->kingdom_id, $known)){
						//and it's not in the known array (or 'Kingdom', thanks for that DS), 
						if(!array_key_exists($oldChaptertype->title, $known[$oldChaptertype->kingdom_id]) || $oldChaptertype->title == "Kingdom"){
							//don't add this one.
							switch($oldChaptertype->parktitle_id){
								case 56:
									$transChaptertypes[$oldChaptertype->parktitle_id] = (int)$chaptertypeId + 1;
									break;
								case 31:
									$transChaptertypes[$oldChaptertype->parktitle_id] = (int)$chaptertypeId + 1;
									break;
								case 35:
									$transChaptertypes[$oldChaptertype->parktitle_id] = (int)$chaptertypeId;
									break;
								default: 
							}
							$deadRecords['Chaptertypes'][$oldChaptertype->parktitle_id] = $oldChaptertype;
							$bar3->advance();
							continue;
						}else{
							unset($known[$oldChaptertype->kingdom_id][$oldChaptertype->title]);
						}
					}
					$chaptertypeId = DB::table('chaptertypes')->insertGetId([
							'kingdom_id' => $transKingdoms[$oldChaptertype->kingdom_id],
							'name' => $oldChaptertype->title,
							'rank' => $oldChaptertype->class,
							'minimumattendance' => $oldChaptertype->minimumattendance,
							'minimumcutoff' => $oldChaptertype->minimumcutoff
					]);
					$transChaptertypes[$oldChaptertype->parktitle_id] = $chaptertypeId;
					$bar3->advance();
				}
			}
			
			//now add what's missing
			foreach($known as $kid => $kingdomChaptertypes){
				foreach($kingdomChaptertypes as $knownChaptertype => $offices){
					if($knownChaptertype != 'Kingdom'){
						$chaptertypeId = DB::table('chaptertypes')->insertGetId([
							'kingdom_id' => $transKingdoms[$kid],
							'name' => $knownChaptertype,
							'rank' => $knownChaptertype === 'Principality' ? 50 : 35,
							'minimumattendance' => $knownChaptertype === 'Principality' ? 60 : 21,
							'minimumcutoff' => $knownChaptertype === 'Principality' ? 56 : 19
						]);
						$bar3->advance();
					}
				}
			}
			$bar3->finish();
			$this->info('');
// 			DB::table('trans')->insert([
// 					'table' => 'chaptertypes',
// 					'value' => serialize($transChaptertypes)
// 			]);
			
			//chapters
			$this->info('Importing Chapters...');
			$oldChapters = $backupConnect->table('ork_park')->get()->toArray();
			DB::table('chapters')->truncate();
			if (isset($oldChapters)) {
				$bar4 = $this->output->createProgressBar(count($oldChapters));
				$bar4->start();
				foreach ($oldChapters as $oldChapter) {
					if (!array_key_exists($oldChapter->kingdom_id, $transKingdoms)) {
						$kingdomId = DB::table('kingdoms')->insertGetId([
								'parent_id' => null,
								'name' => 'Deleted Kingdom ' . $oldChapter->kingdom_id,
								'abbreviation' => 'DK' . $oldChapter->kingdom_id,
								'heraldry' => null,
								'is_active' => 0
						]);
						$transKingdoms[$oldChapter->kingdom_id] = $kingdomId;
// 						DB::table('trans')->where('table', 'kingdoms')->update([
// 								'value' => serialize($transKingdoms)
// 						]);
					}
					$locationID = DB::table('locations')->insertGetId([
							'address' => $this->locationClean($oldChapter->address),
							'city' => $this->locationClean($oldChapter->city),
							'province' => $this->locationClean($oldChapter->province),
							'postal_code' => $this->locationClean($oldChapter->postal_code),
							'google_geocode' => $this->geocodeClean($oldChapter->google_geocode),
							'latitude' => $this->locationClean($oldChapter->latitude),
							'longitude' => $this->locationClean($oldChapter->longitude),
							'location' => $this->locationClean($oldChapter->location),
							'map_url' => $this->locationClean($oldChapter->map_url),
							'description' => $this->locationClean($oldChapter->description),
							'directions' => $this->locationClean($oldChapter->directions)
					]);
					if($oldChapter->parktitle_id == 186){//inactive is being removed
						$lowestChaptertype = Chaptertype::where('kingdom_id', $transKingdoms[$oldChapter->kingdom_id])->orderBy('rank', 'ASC')->first();
					}
					$chapterID = DB::table('chapters')->insertGetId([
							'kingdom_id' => $transKingdoms[$oldChapter->kingdom_id],
							'chaptertype_id' => $oldChapter->parktitle_id == 186 ? $lowestChaptertype->id : $transChaptertypes[$oldChapter->parktitle_id],
							'location_id' => $locationID,
							'name' => trim($oldChapter->name),
							'abbreviation' => $oldChapter->abbreviation,
							'heraldry' => $oldChapter->has_heraldry === 1 ? sprintf('%05d.jpg', $oldChapter->park_id) : null,
							'url' => $this->cleanURL($oldChapter->url),
							'is_active' => $oldChapter->active != 'Active' || $oldChapter->parktitle_id == 186 ? 0 : 1,
							'created_at' => $oldChapter->modified,
							'updated_at' => $oldChapter->modified
					]);
					$transChapters[$oldChapter->park_id] = $chapterID;
					$bar4->advance();
				}
				$bar4->finish();
				$this->info('');
			}
// 			DB::table('trans')->insert([
// 					'table' => 'chapters',
// 					'value' => serialize($transChapters)
// 			]);
			
			//units
			$this->info('Importing Units...');
			$oldUnits = $backupConnect->table('ork_unit')->get()->toArray();
			DB::table('units')->truncate();
			if (count($oldUnits) > 0) {
				$bar5 = $this->output->createProgressBar(count($oldUnits));
				$bar5->start();
				foreach ($oldUnits as $oldUnit) {
					if ($oldUnit->type != '' && $oldUnit->type != 'Event') {
						$unitId = DB::table('units')->insertGetId([
								'type' => $oldUnit->type,
								'name' => $oldUnit->name != '' ? trim($oldUnit->name) : 'Unknown ' . $oldUnit->type,
								'heraldry' => $oldUnit->has_heraldry === 1 ? sprintf('%05d.jpg', $oldUnit->unit_id) : null,
								'description' => $oldUnit->description,
								'history' => $oldUnit->history,
								'url' => $this->cleanURL($oldUnit->url),
								'created_at' => $oldUnit->modified,
								'updated_at' => $oldUnit->modified
						]);
						$transUnits[$oldUnit->unit_id] = $unitId;
					}else{
						$deadRecords['Units'][$oldUnit->unit_id] = $oldUnit;
					}
					$bar5->advance();
				}
				$bar5->finish();
				$this->info('');
			}
// 			DB::table('trans')->insert([
// 					'table' => 'units',
// 					'value' => serialize($transUnits)
// 			]);
			
			//awards
			$this->info('Importing Awards...');
			DB::table('awards')->truncate();
			
			//Common awards first
			$backupConnect->table('ork_award')
				->where('name', 'Order of the Walker in the Middle')
				->update(['is_ladder' => 1]);
			$oldAwards = $backupConnect->table('ork_award')->where('is_ladder', 1)->get()->toArray();
			if (count($oldAwards) > 0) {
				$bar6 = $this->output->createProgressBar(216);
				$bar6->start();
				foreach ($oldAwards as $oldAward) {
					$nameClean = trim($oldAward->name);
					//the awards that aren't expressly defined in the RoP are no longer 'common'.  Make one for each kingdom, as appropriate
					if(!in_array($oldAward->award_id, $ropLadders)){
						if($nameClean === 'Order of the Walker in the Middle'){
							foreach($knownAwards[$nameClean] as $kid => $info){
								if($info){
									$awardId = DB::table('awards')->insertGetId([
											'awarder_type' => 'Kingdom',
											'awarder_id' => $transKingdoms[$kid],
											'name' => $info['name'],
											'is_ladder' => 0,
											'deleted_by' => null,
											'deleted_at' => null
									]);
									$transGenericAwards[$oldAward->award_id][$kid] = $awardId;
								}
							}
						}else{
							foreach($knownAwards[$nameClean] as $kid => $info){
								if($info){
									$awardId = DB::table('awards')->insertGetId([
											'awarder_type' => 'Kingdom',
											'awarder_id' => $transKingdoms[$kid],
											'name' => $info['name'],
											'is_ladder' => $info['is_ladder'],
											'deleted_by' => null,
											'deleted_at' => null
									]);
									$transGenericAwards[$oldAward->award_id][$kid] = $awardId;
								}
							}
						}
						$bar6->advance();
						continue;
					}
					$awardId = DB::table('awards')->insertGetId([
							'awarder_type' => 'Kingdom',
							'awarder_id' => null,
							'name' => $nameClean,
							'is_ladder' => 1,
							'deleted_by' => $oldAward->deprecate === 1 ? 1 : null,
							'deleted_at' => $oldAward->deprecate === 1 ? $now : null
					]);
					$transGenericAwards[$oldAward->award_id] = $awardId;
					$bar6->advance();
				}
				$bar6->finish();
				$this->info('');
			}
// 			DB::table('trans')->insert([
// 					'table' => 'genericawards',
// 					'value' => serialize($transGenericAwards)
// 			]);

			//record the loss of 'Custom Award' award
			$oldCustom = $backupConnect->table('ork_award')->where('name', 'LIKE', '%Award%')->get()->toArray();
			$deadRecords['Awards'][94] = $oldCustom[0];
			
			//custom awards next
			$this->info('Importing Custom Awards...');
			$oldCustomAwards = $backupConnect->table('ork_kingdomaward')
				->where(function($q) {
					$q->where('award_id', 94)->orWhere('award_id', 0);
				})
				->where(function($q) {
					$q->where('name', '')->orWhere('name', 'LIKE', '%Antigriffin%')->orWhere('name', 'LIKE', '%typhoon%')->orWhere('name', 'LIKE', '%tsunami%')->orWhere('name', 'LIKE', '%Hellrider%')->orWhere('name', 'LIKE', '%Dreamkeeper%')->orWhere('name', 'LIKE', '%Cyclone%')->orWhere('name', 'LIKE', '%Emerald%')->orWhere('name', 'LIKE', 'Order %');
				})->get()->toArray();
			if (count($oldCustomAwards) > 0) {
				$bar7 = $this->output->createProgressBar(count($oldCustomAwards));
				$bar7->start();
				foreach ($oldCustomAwards as $oldCustomAward) {
					$foundAward = DB::table('awards')->where('name', $oldCustomAward->name)->first();
					if(!$foundAward){
						$cleanName = trim($oldCustomAward->name);
						$customAwardId = DB::table('awards')->insertGetId([
								'awarder_type' => 'Kingdom',
								'awarder_id' => $transKingdoms[$oldCustomAward->kingdom_id],
								'name' => $cleanName != '' ? $cleanName : 'Unknown Award',
								'is_ladder' => strpos($oldCustomAward->name, 'dreamkeeper') > -1 || strpos($oldCustomAward->name, 'hell') > -1 ? 0 : 1
						]);
						$kingdomawardsProcessed[$oldCustomAward->kingdomaward_id] = $customAwardId;
						$transKingdomawards[$oldCustomAward->kingdomaward_id] = $customAwardId;
					}else{
						$kingdomawardsProcessed[$oldCustomAward->kingdomaward_id] = $foundAward->id;
						$transKingdomawards[$oldCustomAward->kingdomaward_id] = $foundAward->id;
					}
					$bar7->advance();
				}
				$bar7->finish();
				$this->info('');
			}
// 			DB::table('trans')->insert([
// 					'table' => 'customawards',
// 					'value' => serialize($transKingdomawards)
// 			]);
// 			DB::table('trans')->where('table', 'kingdomawardsprocessed')->update([
// 					'value' => serialize($kingdomawardsProcessed)
// 			]);
			
			//titles
			$this->info('Importing Titles...');
			$backupConnect->table('ork_award')
				->where('name', 'Apprentice')
				->orWhere('name', 'Master')
				->orWhere('name', 'Esquire')
				->orWhere('name', 'Cultural Olympian')
				->orWhere('name', 'Grand Olympian')
				->orWhere('name', 'War Event Winner')
				->orWhere('name', 'War Olympian')
				->orWhere('name', 'Warmaster')
				->orWhere('name', 'LIKE', '%Defender%')
				->orWhere('name', 'Order of the Walker in the Middle')
				->update(['is_title' => 1, 'is_ladder' => 0]);
			$oldTitles = $backupConnect->table('ork_award')->where('is_title', 1)->get()->toArray();
			DB::table('titles')->truncate();
			if (count($oldTitles) > 0) {
				$bar8 = $this->output->createProgressBar(392);
				$bar8->start();
				$titleId = 0;
				
				//first the RoP titles
				foreach ($oldTitles as $otID => $oldTitle) {
					if(in_array($oldTitle->award_id, $ropTitles)){
						$rank = $oldTitle->title_class;
						$cleanName = trim($oldTitle->name);
						$titleCheck = null;
						
						//if it exists, let's not remake it
						$titleCheck = Title::where('name', $cleanName)->orWhere('name', 'LIKE', $cleanName . '|%')->orWhere('name', 'LIKE', '%|' . $cleanName)->whereNull('titleable_id')->first();
						if($titleCheck){
							foreach(array_keys($knownTitles['Master Jovius']) as $kid){
								$transTitles[$oldTitle->award_id][$kid] = $titleCheck->id;
							}
							unset($oldTitles[$otID]);
							$bar8->advance();
							continue;
						}
						if($cleanName === 'Paragon Reeve'){
							$rank = 10;
							$peerage = 'Paragon';
						}
						if($cleanName === 'Lord\'s Page'){
							$cleanName = 'Page';
							$peerage = 'Retainer';
						}
						if($cleanName === 'Man-at-Arms'){
							$cleanName = 'At-Arms|Man-at-Arms|Woman-at-Arms|Comrade-at-Arms|Sword-at-Arms|Shieldmaiden|Shield Brother';
							$peerage = 'Retainer';
						}
						
						switch($oldTitle->peerage){
							case 'None':
								if(strpos($cleanName, 'Master ') > -1){
									$peerage = 'Master';
								}else if($cleanName === 'Apprentice'){
									$peerage = 'Retainer';
								}else{
									$peerage = 'None';
								}
								break;
							case 'Lords-Page':
								$peerage = 'Retainer';
								break;
							case 'Man-At-Arms':
								$peerage = 'Retainer';
								break;
							case 'Page':
								$peerage = 'Retainer';
								break;
							default:
								$peerage = $oldTitle->peerage;
						}
						$titleId = DB::table('titles')->insertGetId([
								'name' => $cleanName,
								'rank' => $rank,
								'peerage' => $peerage,
								'is_roaming' => 0,
								'is_active' => $cleanName === 'Paragon Raider' ? 0 : 1
						]);
						foreach(array_keys($knownTitles['Master Jovius']) as $kid){
							$transTitles[$oldTitle->award_id][$kid] = $titleId;
						}
						unset($oldTitles[$otID]);
						$bar8->advance();
					}
				}
				
				//now the known titles
				foreach($knownTitles as $title => $kingdomInfo){
					//find the $oldTitle with name === $title
					$foundTitle = null;
					$foundOtID = null;
					foreach($oldTitles as $otID => $ot){
						if($ot->name === $title){
							$foundTitle = $ot;
							$foundOtID = $otID;
							break;
						}
					}
					
					foreach($kingdomInfo as $kid => $info){
						if($info){
							$titleId = DB::table('titles')->insertGetId([
									'titleable_type' => 'Kingdom',
									'titleable_id' => $transKingdoms[$kid],
									'name' => $info['name'],
									'rank' => $info['rank'],
									'peerage' => $info['peerage'],
									'is_roaming' => $info['reign_limit'] ? 1 : 0,
									'is_active' => $info['is_active']
							]);
							if($foundTitle){
								$transTitles[$foundTitle->award_id][$kid] = $titleId;
								unset($oldTitles[$foundOtID]);
							}
							
							//translate the fem into this one
							if($title === 'Lord'){
								foreach($oldTitles as $otID => $ot){
									if($ot->name === 'Lady'){
										$transTitles[$ot->award_id][$kid] = $titleId;
										unset($oldTitles[$otID]);
										break;
									}
								}
							}else if($title === 'Baron'){
								foreach($oldTitles as $otID => $ot){
									if($ot->name === 'Baroness'){
										$transTitles[$ot->award_id][$kid] = $titleId;
										unset($oldTitles[$otID]);
										break;
									}
								}
							}else if($title === 'Baronet'){
								foreach($oldTitles as $otID => $ot){
									if($ot->name === 'Baronetess'){
										$transTitles[$ot->award_id][$kid] = $titleId;
										unset($oldTitles[$otID]);
										break;
									}
								}
							}else if($title === 'Count'){
								foreach($oldTitles as $otID => $ot){
									if($ot->name === 'Countess'){
										$transTitles[$ot->award_id][$kid] = $titleId;
										unset($oldTitles[$otID]);
										break;
									}
								}
							}else if($title === 'Duke'){
								foreach($oldTitles as $otID => $ot){
									if($ot->name === 'Duchess'){
										$transTitles[$ot->award_id][$kid] = $titleId;
										unset($oldTitles[$otID]);
										break;
									}
								}
							}else if($title === 'Archduke'){
								foreach($oldTitles as $otID => $ot){
									if($ot->name === 'Archduchess'){
										$transTitles[$ot->award_id][$kid] = $titleId;
										unset($oldTitles[$otID]);
										break;
									}
								}
							}else if($title === 'Grand Duke'){
								foreach($oldTitles as $otID => $ot){
									if($ot->name === 'Grand Duchess'){
										$transTitles[$ot->award_id][$kid] = $titleId;
										unset($oldTitles[$otID]);
										break;
									}
								}
							}else if($title === 'Marquis'){
								foreach($oldTitles as $otID => $ot){
									if($ot->name === 'Marquess'){
										$transTitles[$ot->award_id][$kid] = $titleId;
										unset($oldTitles[$otID]);
										break;
									}
								}
							}else if($title === 'Viscount'){
								foreach($oldTitles as $otID => $ot){
									if($ot->name === 'Viscountess'){
										$transTitles[$ot->award_id][$kid] = $titleId;
										unset($oldTitles[$otID]);
										break;
									}
								}
							}else if($title === 'Grand Marquis'){
								foreach($oldTitles as $otID => $ot){
									if($ot->name === 'Grand Marquess'){
										$transTitles[$ot->award_id][$kid] = $titleId;
										unset($oldTitles[$otID]);
										break;
									}
								}
							}
							$bar8->advance();
						}
					}
				}
				
				//whatever is left
				foreach ($oldTitles as $oldTitle) {
					$cleanName = trim($oldTitle->name);
					//the titles that aren't expressly defined in the RoP need to be put into the trans array
					if(!in_array($oldTitle->award_id, $ropTitles)){
						foreach($knownTitles[$cleanName] as $kid => $info){
							if($info){
								$titleId = DB::table('titles')->insertGetId([
										'titleable_type' => 'Kingdom',
										'titleable_id' => $transKingdoms[$kid],
										'name' => $info['name'],
										'rank' => $info['rank'],
										'peerage' => $info['peerage'],
										'is_roaming' => $info['reign_limit'] ? 1 : 0,
										'is_active' => $info['is_active']
								]);
								$transTitles[$oldTitle->award_id][$kid] = $titleId;
							}
						}
						$bar8->advance();
						continue;
					}
				}
				$bar8->finish();
				$this->info('');
			}
// 			DB::table('trans')->insert([
// 					'table' => 'titles',
// 					'value' => serialize($transTitles)
// 			]);
			
			//custom titles next
			$this->info('Importing Custom Titles...');
			$oldCustomTitles = $backupConnect->table('ork_kingdomaward')
				->where(function($q) {
					$q->where('award_id', 94)->orWhere('award_id', 0);
				})
				->where('name', '!=', '')
				->where('name', '!=', 'Antigriffin')
				->where('name', '!=', 'typhoon')
				->where('name', '!=', 'tsunami')
				->where('name', '!=', 'Hydra')
				->where('name', '!=', 'Hellrider')
				->where('name', '!=', 'Dreamkeeper')
				->where('name', '!=', 'Cyclone')
				->where('name', '!=', 'Emerald')
				->where('name', '!=', 'Hellrider')
				->where('name', 'NOT LIKE', 'Order %')
				->where('name', '!=', 'Custom Award')
				->where('name', 'NOT LIKE', '%GMR')
				->where('name', 'NOT LIKE', '%Board%')
				->where('name', 'NOT LIKE', '%qualified')
				->where('name', 'NOT LIKE', '%Guild%')
				->where('name', 'NOT LIKE', '%for life%')
				->where('name', 'NOT LIKE', '%monarch%')
				->where('name', 'NOT LIKE', '%champion%')
				->where('name', 'NOT LIKE', '%prime minister%')
				->where('name', 'NOT LIKE', '%regent%')
				->where('name', 'NOT LIKE', '%spotlight%')
				->where('name', 'NOT LIKE', '%PM%')
				->where('name', '!=', 'scribe')
				->where('name', 'NOT LIKE', 'speaker%')
				->where('name', 'NOT LIKE', 'knight%')
				->where('name', '!=', 'Nonnoble Title')
				->get()->toArray();
			if (count($oldCustomTitles) > 0) {
				$bar9 = $this->output->createProgressBar(count($oldCustomTitles));
				$bar9->start();
				foreach ($oldCustomTitles as $oldCustomTitle) {
					$customTitleId = null;
					$nameClean = trim($oldCustomTitle->name);
					if($nameClean === 'Master Monster'){
						$nameClean = 'Paragon Monster';
					}
					if($nameClean === 'Grand Marquess'){
						$nameClean = 'Grand Marquise';
					}
					if($nameClean === 'Man Behind the Curtains'){
						$nameClean = 'The Man Behind the Curtain';
					}
					
					//check to see if this one exists yet
					$titleExists = Title::where('name', $nameClean)->orWhere('name', 'LIKE', $nameClean . '|%')->orWhere('name', 'LIKE', '%|' . $nameClean)->where(function($query) use($oldCustomTitle, $transKingdoms){
						$query->whereNull('titleable_id');
						$query->orWhere('titleable_id', $transKingdoms[$oldCustomTitle->kingdom_id]);
					})->first();
					
					if(!$titleExists){
						//work out the peerage & rank
						$peerage = null;
						$rank = null;
						if($nameClean === 'Arcuarius'){
							$peerage = 'Master';
							$rank = 10;
						}else if($nameClean === 'Master' || $nameClean === 'Mistress'){
							$nameClean = 'Master|Mistress';
							$peerage = 'Gentry';
							$rank = 0;
						}else if($nameClean === 'Esquire'){
							$peerage = 'Gentry';
							$rank = 0;
						}else{
							$peerage = 'None';
							$rank = 0;
						}
						$customTitleId = DB::table('titles')->insertGetId([
								'titleable_type' => $nameClean === 'Valkyrie\'s Chosen' ? 'Chapter' : 'Kingdom',
								'titleable_id' => $nameClean === 'Valkyrie\'s Chosen' ? $transChapters[907] : $transKingdoms[$oldCustomTitle->kingdom_id],
								'name' => $nameClean,
								'rank' => $rank,
								'peerage' => $peerage,
								'is_roaming' => 0,
								'is_active' => $nameClean === 'Master' || $nameClean === 'Esquire' ? 0 : 1
						]);
						$transCustomTitles[$oldCustomTitle->kingdomaward_id] = $customTitleId;
					}else{
						$transCustomTitles[$oldCustomTitle->kingdomaward_id] = $titleExists->id;
					}
					$kingdomawardsProcessed[$oldCustomTitle->kingdomaward_id] = $customTitleId ? $customTitleId : $titleExists->id;
					$bar9->advance();
				}
				$bar9->finish();
				$this->info('');
			}
// 			DB::table('trans')->insert([
// 					'table' => 'customtitles',
// 					'value' => serialize($transCustomTitles)
// 			]);
// 			DB::table('trans')->where('table', 'kingdomawardsprocessed')->update([
// 					'value' => serialize($kingdomawardsProcessed)
// 			]);
			
			//offices
			$this->info('Creating Offices...');
			$count = 0;
			foreach($knownKingdomChaptertypesOffices as $d){
				$count = $count + array_sum(array_map("count", $d));
			}
			$bar10 = $this->output->createProgressBar($count);
			$bar10->start();
			DB::table('offices')->truncate();
			//create from known offices (that was a lot of corpora reading I just did)
			foreach($knownKingdomChaptertypesOffices as $kid => $knownKingdomChaptertypesOffice){
				foreach($knownKingdomChaptertypesOffice as $chaptertype => $offices){
					$officeableType = $chaptertype != 'Kingdom' ? 'Chaptertype' : 'Kingdom';
					$officeableID = $officeableType === 'Kingdom' ? $transKingdoms[$kid] : null;
					if(!$officeableID){
						$chaptertypeArray = Chaptertype::where('kingdom_id', $transKingdoms[$kid])->where('name', $chaptertype)->first();
						if(!$chaptertypeArray){
							//this shouldn't happen.  Tell me if it does.
							dd(array(
									$kid,
									$transKingdoms[$kid],
									$chaptertype
							));
						}
						$officeableID = $chaptertypeArray->id;
					}
					foreach($offices as $office => $officeData){
						$officeId = DB::table('offices')->insertGetId(
								[
										'officeable_type' => $officeableType,
										'officeable_id' => $officeableID,
										'name' => $office,
										'duration' => $officeData['duration'],
										'order' => array_key_exists('order', $officeData) ? $officeData['order'] : null
							]);
						$bar10->advance();
					}
				}
			}
			$bar10->finish();
			$this->info('');

			//pronouns
			$this->info('Importing Pronouns...');
			$oldPronouns = $backupConnect->table('ork_pronoun')->get()->toArray();
			DB::table('pronouns')->truncate();
			if (count($oldPronouns) > 0) {
				$bar12 = $this->output->createProgressBar(count($oldPronouns));
				$bar12->start();
				foreach ($oldPronouns as $oldPronoun) {
					$pronounId = DB::table('pronouns')->insertGetId([
							'subject' => $oldPronoun->subject,
							'object' => $oldPronoun->object,
							'possessive' => $oldPronoun->possessive,
							'possessivepronoun' => $oldPronoun->possessivepronoun,
							'reflexive' => $oldPronoun->reflexive
					]);
					$transPronouns[$oldPronoun->pronoun_id] = $pronounId;
					$bar12->advance();
				}
				$bar12->finish();
				$this->info('');
			}
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
			$this->info('Importing Users/Personas/Memberships/Suspensions/Waivers...');
			$backupConnect->table('ork_mundane')
				->where('mundane_id', 1)
				->update(['email' => 'admin@nowhere.net']);
			$oldUsers = $backupConnect->table('ork_mundane')->get()->toArray();
			$usedEmails = [];
			DB::table('users')->truncate();
			DB::table('personas')->truncate();
			DB::table('members')->truncate();
			DB::table('suspensions')->truncate();
			DB::table('waivers')->truncate();
			if (count($oldUsers) > 0) {
				$bar13 = $this->output->createProgressBar(count($oldUsers));
				$bar13->start();
				foreach ($oldUsers as $i => $oldUser) {
					$pronounId = null;
					$userId = null;
					//user data
					if(filter_var($oldUser->email, FILTER_VALIDATE_EMAIL)){
						if(!in_array(strtolower($oldUser->email), $usedEmails)){
							$userId = DB::table('users')->insertGetId(
								[
									'email' => $i === 0 ? 'nobody@nowhere.net' : strtolower($oldUser->email),
									'email_verified_at' => null,
									'password' => bin2hex(openssl_random_pseudo_bytes(4)),
									'remember_token' => null,
									'is_restricted' => $oldUser->restricted === 1 ? 1 : 0,
									'created_at' => $oldUser->modified,
									'updated_at' => $oldUser->modified
								]
							);
							//assign role
							$user = User::find($userId);
							//park_id == 0 && kingdom_id == $oldUser->kingdom_id && mundane_id == $oldUser->mundane_id
							//park_id == $oldUser->park_id && mundane_id == $oldUser->mundane_id
							$offices = $backupConnect->table('ork_officer')->where(function($query) use($oldUser) {
								$query->where('park_id', 0)
									->where('kingdom_id', $oldUser->kingdom_id)
									->where('mundane_id', $oldUser->mundane_id);
							})->orWhere(function($query2) use($oldUser) {
								$query2->where('park_id', $oldUser->park_id)
									->where('mundane_id', $oldUser->mundane_id);
							})->get()->toArray();
							if($userId === 1){
								$user->assignRole('admin');
							}else if(count($offices) > 0){
								$user->assignRole('officer');
							}else{
								$user->assignRole('player');
							}
							$usedEmails[] = strtolower($oldUser->email);
							$transUsers[$oldUser->mundane_id] = $userId;
						}else{
							$deadRecords['Users'][$oldUser->mundane_id] = 'Duplicate Email';
						}
					}
					
					if($oldUser->pronoun_id < 1){
						$detector = new \GenderDetector\GenderDetector();
						$gender = $detector->getGender(trim($oldUser->given_name), 'US');
						
						if($gender){
							if($gender->name === 'Male' || $gender->name === 'MostlyMale'){
								$pronounId = 2;
							}else if($gender->name === 'Female' || $gender->name === 'MostlyFemale'){
								$pronounId = 4;
							}else if($gender->name === 'Unisex'){
								$pronounId = null;
							}else{
								//this shouldn't happen.  Let me know if it does.
								dd(array($oldUser->given_name, $gender));
							}
						}else{
							$pronounId = null;
						}
					}else{
						$pronounId = $oldUser->pronoun_id;
					}
					
					//clean up the persona name
					if($this->cleanPersona($oldUser->persona, trim($oldUser->given_name) . ' ' . trim($oldUser->surname)) && $this->cleanPersona($oldUser->persona, trim($oldUser->given_name) . ' ' . trim($oldUser->surname)) != ''){
						$personaName = $this->cleanPersona($oldUser->persona, trim($oldUser->given_name) . ' ' . trim($oldUser->surname));
						$personaName = $this->stripTitles($personaName);
					}else{
						$personaName = null;
					}

					//persona data
					$personaId = DB::table('personas')->insertGetId([
							'chapter_id' => $oldUser->park_id == 0 ? 317 : $transChapters[$oldUser->park_id],
							'user_id' => $userId,
							'pronoun_id' => $pronounId,
							'mundane' => trim($oldUser->given_name) != '' || trim($oldUser->surname) != '' ? str_ireplace('zzz', '', trim($oldUser->given_name)) . ' ' . str_ireplace('zzz', '', trim($oldUser->surname)) : null,
							'name' => $personaName,
							'heraldry' => $oldUser->has_heraldry === 1 ? sprintf('%06d.jpg', $oldUser->mundane_id) : null,
							'image' => $oldUser->has_image === 1 ? sprintf('%06d.jpg', $oldUser->mundane_id) : null,
							'is_active' => $oldUser->active === 1 ? 1 : 0,
							'reeve_qualified_expires_at' => $oldUser->reeve_qualified != 1 ? null : ($oldUser->reeve_qualified_until === '0000-00-00' ? date('Y-m-d', strtotime('+20 years')) : $oldUser->reeve_qualified_until),
							'corpora_qualified_expires_at' => $oldUser->corpora_qualified != 1 ? null : ($oldUser->corpora_qualified_until === '0000-00-00' ? date('Y-m-d', strtotime('+20 years')) : $oldUser->corpora_qualified_until),
							'joined_chapter_at' => $oldUser->park_member_since === '0000-00-00' ? null : $oldUser->park_member_since,
							'created_at' => $oldUser->modified,
							'updated_at' => $oldUser->modified
					]);
					$transPersonas[$oldUser->mundane_id] = $personaId;

					//unit membership data
					if ($oldUser->company_id > 0) {
						if (array_key_exists($oldUser->company_id, $transUnits)) {
							$memberId = DB::table('members')->insertGetId(
								[
									'unit_id' => $transUnits[$oldUser->company_id],
									'persona_id' => $personaId,
									'joined_at' => null,
									'left_at' => null,
									'is_head' => 0,
									'is_voting' => 1
								]
							);
							$transMembers[$oldUser->mundane_id] = $memberId;
						}else{
							$deadRecords['Units'][$oldUser->company_id] = 'Deleted';
						}
					}

					//suspensions data
					if($oldUser->suspended > 0){
						if (!$oldUser->suspended_by_id || $oldUser->suspended_by_id < $oldUser->mundane_id) {
							DB::table('suspensions')->insertGetId(
								[
									'persona_id' => $personaId,
									'kingdom_id' => $transKingdoms[$oldUser->kingdom_id],
									'suspended_by' => $oldUser->suspended_by_id ? $transPersonas[$oldUser->suspended_by_id] : 1,
									'suspended_at' => !$oldUser->suspended_at || $oldUser->suspended_at === '0000-00-00' ? $oldUser->modified : $oldUser->suspended_at,
									'expires_at' => $oldUser->suspended_until && $oldUser->suspended_until > date('Y-m-d', strtotime('+5 years')) ? null : $oldUser->suspended_until,
									'is_propogating' => stripos($oldUser->suspension, 'COC') > -1 || stripos($oldUser->suspension, 'Code of Conduct') > -1 || stripos($oldUser->suspension, 'Registe') > -1 || (stripos($oldUser->suspension, 'Prop') > -1 && stripos($oldUser->suspension, ' not ') < 1 ) || stripos($oldUser->suspension, 'inter') > -1 || stripos($oldUser->suspension, 'triggers') > -1 || stripos($oldUser->suspension, 'applies') > -1 || stripos($oldUser->suspension, 'spans') > -1 ? 1 : 0,
									'cause' => $oldUser->suspension && $oldUser->suspension != '' ? $oldUser->suspension : 'Unknown',
									'created_at' => !$oldUser->suspended_at || $oldUser->suspended_at === '0000-00-00' ? $oldUser->modified : $oldUser->suspended_at,
									'updated_at' => !$oldUser->suspended_at || $oldUser->suspended_at === '0000-00-00' ? $oldUser->modified : $oldUser->suspended_at
								]
							);
						}else{
							$suspensionsWaitList[] = $oldUser;
						}
					}else{
						if($oldUser->penalty_box === 1){
							$deadRecords['PenaltyBox'][$oldUser->mundane_id] = $oldUser;
						}
					}
	  
					//waiver data
					if($oldUser->waivered > 0 && (trim($oldUser->given_name) != '' || trim($oldUser->surname) != '')){
						DB::table('waivers')->insertGetId([
								'pronoun_id' => null,
								'persona_id' => $personaId,
								'waiverable_type' => 'Chapter',
								'waiverable_id' => $oldUser->park_id == 0 ? 317 : $transChapters[$oldUser->park_id],
								'file' => $oldUser->waiver_ext != '' ? sprintf('%06d.' . $oldUser->waiver_ext, $oldUser->mundane_id) : null,
								'player' => trim($oldUser->given_name . ' ' . $oldUser->surname),
								'email' => null,
								'phone' => null,
								'location_id' => null,
								'dob' => null,
								'age_verified_at' => null,
								'age_verified_by' => null,
								'guardian' => null,
								'emergency_contact_name' => null,
								'emergency_contact_phone' => null,
								'signed_at' => $oldUser->park_member_since != '' && $oldUser->park_member_since != '0000-00-00' ? $oldUser->park_member_since : $oldUser->modified,
								'created_at' => $oldUser->park_member_since != '' && $oldUser->park_member_since != '0000-00-00' ? $oldUser->park_member_since : $oldUser->modified,
								'updated_at' => $oldUser->park_member_since != '' && $oldUser->park_member_since != '0000-00-00' ? $oldUser->park_member_since : $oldUser->modified
						]);	
					}
					$bar13->advance();
				}
				$bar13->finish();
				$this->info('');
			}
			if(count($suspensionsWaitList) > 0){
				$this->info('Finishing Up Suspensions...');
				$bar14 = $this->output->createProgressBar(count($suspensionsWaitList));
				$bar14->start();
				foreach($suspensionsWaitList as $oldUser){
					DB::table('suspensions')->insertGetId([
							'persona_id' => $personaId,
							'kingdom_id' => $transKingdoms[$oldUser->kingdom_id],
							'suspended_by' => $oldUser->suspended_by_id ? $transPersonas[$oldUser->suspended_by_id] : 1,
							'suspended_at' => !$oldUser->suspended_at || $oldUser->suspended_at === '0000-00-00' ? $oldUser->modified : $oldUser->suspended_at,
							'expires_at' => $oldUser->suspended_until && $oldUser->suspended_until > date('Y-m-d', strtotime('+5 years')) ? null : $oldUser->suspended_until,
							'is_propogating' => stripos($oldUser->suspension, 'COC') > -1 || stripos($oldUser->suspension, 'Code of Conduct') > -1 || stripos($oldUser->suspension, 'Registe') > -1 || (stripos($oldUser->suspension, 'Prop') > -1 && stripos($oldUser->suspension, ' not ') < 1 ) || stripos($oldUser->suspension, 'inter') > -1 || stripos($oldUser->suspension, 'triggers') > -1 || stripos($oldUser->suspension, 'applies') > -1 || stripos($oldUser->suspension, 'spans') > -1 ? 1 : 0,
							'cause' => $oldUser->suspension && $oldUser->suspension != '' ? $oldUser->suspension : 'Unknown',
							'created_at' => !$oldUser->suspended_at || $oldUser->suspended_at === '0000-00-00' ? $oldUser->modified : $oldUser->suspended_at,
							'updated_at' => !$oldUser->suspended_at || $oldUser->suspended_at === '0000-00-00' ? $oldUser->modified : $oldUser->suspended_at
					]);
					$bar14->advance();
				}
				$bar14->finish();
				$this->info('');
			}
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

			//events
			$this->info('Importing Events/Crats...');
			$oldEvents = $backupConnect->table('ork_event_calendardetail')
				->join('ork_event', 'ork_event_calendardetail.event_id', '=', 'ork_event.event_id')
				->select('ork_event_calendardetail.*', 'ork_event.*', 'ork_event.modified as modified_1', 'ork_event_calendardetail.modified as modified_2')
				->get()->toArray();
			DB::table('events')->truncate();
			if (count($oldEvents) > 0) {
				$bar15 = $this->output->createProgressBar(count($oldEvents));
				$bar15->start();
				$burningLands = Chapter::where('name', 'Burning Lands')->first();
				foreach ($oldEvents as $oldEvent) {
					$locationID = null;
					$eventable_type = $oldEvent->unit_id > 0 ? 'Unit' : ($oldEvent->mundane_id > 0 && ($oldEvent->kingdom_id == 0 && $oldEvent->park_id == 0) ? 'Persona' : ($oldEvent->park_id > 0 && $oldEvent->kingdom_id == 0 ? 'Chapter' : 'Kingdom'));
					if($oldEvent->kingdom_id && $oldEvent->kingdom_id != 0 && !array_key_exists($oldEvent->kingdom_id, $transKingdoms)){
						$kingdomId = DB::table('kingdoms')->insertGetId(
							[
								'parent_id' => null,
								'name' => 'Deleted Kingdom ' . $oldEvent->kingdom_id,
								'abbreviation' => 'DK' . $oldEvent->kingdom_id,
								'heraldry' => null,
								'is_active' => 0
							]
						);
						$transKingdoms[$oldEvent->kingdom_id] = $kingdomId;
// 						DB::table('trans')->where('table', 'kingdoms')->update([
// 								'value' => serialize($transKingdoms)
// 						]);
					}
					if($oldEvent->mundane_id && $oldEvent->mundane_id != 0 && !array_key_exists($oldEvent->mundane_id, $transPersonas)){
						$personaId = DB::table('personas')->insertGetId(
							[
								'chapter_id' => $oldEvent->park_id == 0 ? $burningLands->id : $transChapters[$oldEvent->park_id],
								'user_id' => null,
								'pronoun_id' => null,
								'mundane' => null,
								'name' => 'Deleted Persona ' . $oldEvent->mundane_id,
								'heraldry' => null,
								'image' => null,
								'is_active' => 0
							]
						);
						$transPersonas[$oldEvent->mundane_id] = $personaId;
// 						DB::table('trans')->where('table', 'personas')->update([
// 								'value' => serialize($transPersonas)
// 						]);
					}
					switch($eventable_type){
						case 'Unit':
							$eventable_id = $transUnits[$oldEvent->unit_id];
							break;
						case 'Persona':
							$eventable_id = $transPersonas[$oldEvent->mundane_id];
							break;
						case 'Chapter':
							$eventable_id = $transChapters[$oldEvent->park_id];
							break;
						case 'Kingdom':
							$eventable_id = $transKingdoms[$oldEvent->kingdom_id];
							break;
						default:
							$eventable_id = null;
							break;
					}
					if(($oldEvent->address != '' && $oldEvent->address != '1') || ($oldEvent->province != '' && $oldEvent->province != '1') || ($oldEvent->postal_code != '' && $oldEvent->postal_code != '1') || ($oldEvent->city != '' && $oldEvent->city != '1') || ($oldEvent->country != '' && $oldEvent->country != '1') || ($oldEvent->map_url != '' && $oldEvent->map_url != '1')){
						$location = Location::where('address', $oldEvent->address)
							->where('province', $oldEvent->province)
							->where('postal_code', $oldEvent->postal_code)
							->where('city', $oldEvent->city)
							->first();
						$locationID = $location ? $location->id : null;
						if(!$locationID){
							$locationID = DB::table('locations')->insertGetId([
								'address' => $this->locationClean($oldEvent->address),
								'city' => $this->locationClean($oldEvent->city),
								'province' => $this->locationClean($oldEvent->province),
								'postal_code' => $this->locationClean($oldEvent->postal_code),
								'google_geocode' => $this->geocodeClean($oldEvent->google_geocode),
								'latitude' => $this->locationClean($oldEvent->latitude),
								'longitude' => $this->locationClean($oldEvent->longitude),
								'location' => $this->locationClean($oldEvent->location),
								'map_url' => $this->locationClean($oldEvent->map_url),
								'description' => $this->locationClean($oldEvent->map_url_name),
								'directions' => null,
								'created_at' => min($oldEvent->modified_1, $oldEvent->modified_2),
								'updated_at' => max($oldEvent->modified_1, $oldEvent->modified_2)
							]);
						}
					}
					$eventId = DB::table('events')->insertGetId([
							'eventable_type' => $eventable_type,
							'eventable_id' => $eventable_id,
							'location_id' => $locationID ? $locationID : null,
							'name' => trim($oldEvent->name),
							'description' => trim($oldEvent->description),
							'is_active' => $oldEvent->current,
							'image' => $oldEvent->has_heraldry === 1 ? sprintf('%05d.jpg', $oldEvent->event_id) : null,
							'event_start' => $oldEvent->event_start > '0001-01-01 00:00:01' ? $oldEvent->event_start : min($oldEvent->modified_1, $oldEvent->modified_2),
							'event_end' => $oldEvent->event_end > '0001-01-01 00:00:01' ? $oldEvent->event_end : max($oldEvent->modified_1, $oldEvent->modified_2),
							'price' => $oldEvent->price,
							'url' => $this->cleanURL($oldEvent->url),
							'created_at' => min($oldEvent->modified_1, $oldEvent->modified_2),
							'updated_at' => max($oldEvent->modified_1, $oldEvent->modified_2)
					]);
					if($oldEvent->mundane_id != 0){
						//make the crat
						DB::table('crats')->insertGetId([
								'event_id' => $eventId,
								'persona_id' => $transPersonas[$oldEvent->mundane_id],
								'role' => 'Autocrat',
								'is_autocrat' => 1
						]);
					}
					if($oldEvent->url_name != ''){
						$deadRecords['EventUrlNames'][$oldEvent->event_calendardetail_id] = $oldEvent;
					}
					$transEvents[$oldEvent->event_id] = $eventId;
					$transEventDetails[$oldEvent->event_calendardetail_id] = $eventId;
					$bar15->advance();
				}
				$bar15->finish();
				$this->info('');
			}
// 			DB::table('trans')->insert([
// 					'table' => 'events',
// 					'value' => serialize($transEvents)
// 			]);
// 			DB::table('trans')->insert([
// 					'table' => 'eventDetails',
// 					'value' => serialize($transEventDetails)
// 			]);
			
			//accounts
			$this->info('Importing Accounts...');
			$oldAccounts = $backupConnect->table('ork_account')->get()->toArray();
			DB::table('accounts')->truncate();
			if (count($oldAccounts) > 0) {
				$bar16 = $this->output->createProgressBar(count($oldAccounts));
				$bar16->start();
				foreach ($oldAccounts as $oldAccount) {
					$accountable_type = $oldAccount->unit_id > 0 ? 'Unit' : ($oldAccount->event_id > 0 ? 'Event' : ($oldAccount->park_id > 0 ? 'Chapter' : 'Kingdom'));
					switch($accountable_type){
						case 'Unit':
							$accountable_id = $transUnits[$oldAccount->unit_id];
							break;
						case 'Event':
							$accountable_id = $transEvents[$oldAccount->event_id];
							break;
						case 'Chapter':
							$accountable_id = $transChapters[$oldAccount->park_id];
							break;
						case 'Kingdom':
							$accountable_id = $transKingdoms[$oldAccount->kingdom_id];
							break;
						default:
							$accountable_id = null;
							break;
					}
					$accountId = DB::table('accounts')->insertGetId([
							'parent_id' => $oldAccount->parent_id > 0 ? $transAccounts[$oldAccount->parent_id] : null,
							'accountable_type' => $accountable_type,
							'accountable_id' => $accountable_id,
							'name' => trim($oldAccount->name),
							'type' => $oldAccount->type
					]);
					$transAccounts[$oldAccount->account_id] = $accountId;
					$bar16->advance();
				}
				$bar16->finish();
				$this->info('');
			}
// 			DB::table('trans')->insert([
// 					'table' => 'accounts',
// 					'value' => serialize($transAccounts)
// 			]);

			//meetups
			$this->info('Importing Meetups...');
			$oldMeetups = $backupConnect->table('ork_parkday')->get()->toArray();
			DB::table('meetups')->truncate();
			if (count($oldMeetups) > 0) {
				$bar17 = $this->output->createProgressBar(count($oldMeetups));
				$bar17->start();
				$meetupMap = [
					'weekly' => 'Weekly',
					'monthly' => 'Monthly',
					'week-of-month' => 'Week-of-Month',
					'park-day' => 'Park Day',
					'fighter-practice' => 'Fighter Practice',
					'arts-day' => 'A&S Gathering',
					'other' => 'Other'
				];
				foreach ($oldMeetups as $oldMeetup) {
					$location = Location::where('address', $oldMeetup->address)->first();
					$locationID = $location ? $location->id : null;
					if(!$locationID){
						$locationID = DB::table('locations')->insertGetId([
								'address' => $this->locationClean($oldMeetup->address),
								'city' => $this->locationClean($oldMeetup->city),
								'province' => $this->locationClean($oldMeetup->province),
								'postal_code' => $this->locationClean($oldMeetup->postal_code),
								'google_geocode' => $this->geocodeClean($oldMeetup->google_geocode),
								'latitude' => $this->locationClean($oldMeetup->latitude),
								'longitude' => $this->locationClean($oldMeetup->longitude),
								'location' => $this->locationClean($oldMeetup->location),
								'map_url' => $this->locationClean($oldMeetup->map_url),
								'description' => $this->locationClean($oldMeetup->description),
								'directions' => null
						]);
						$location = Location::where('address', $oldMeetup->address)->first();
					}
					$altChecks = Meetup::where('chapter_id', $transChapters[$oldMeetup->park_id])
						->where('recurrence', $oldMeetup->recurrence)
						->where('week_of_month', $oldMeetup->week_of_month)
						->where('week_day', $oldMeetup->week_day)
						->where('month_day', $oldMeetup->month_day)
						->where('occurs_at', $oldMeetup->time)
						->where('purpose', $oldMeetup->purpose)
						->whereHas('location', function ($query) use($oldMeetup) {
							$query->where('address', '!=', $oldMeetup->address);
						})
						->get()
						->toArray();
					if(count($altChecks) > 0){
						$meetup = array_shift($altChecks);
						$meetup->alt_location_id = $locationID;
						$meetup->save();
						if(count($altChecks) > 0){
							for($i=0; $i<count($altChecks); $i++){
								$deadRecords['ParkdayAlternates'][$oldMeetup->parkday_id] = $oldMeetup;
							}
						}
					}else{
						$meetupId = DB::table('meetups')->insertGetId([
								'chapter_id' => $oldMeetup->park_id,
								'location_id' => $locationID,
								'alt_location_id' => null,
								'url' => $this->cleanURL($oldMeetup->location_url),
								'recurrence' => $meetupMap[$oldMeetup->recurrence],
								'week_of_month' => $oldMeetup->week_of_month > 0 ? $oldMeetup->week_of_month : null,
								'week_day' => $oldMeetup->week_day,
								'month_day' => $oldMeetup->month_day > 0 ? $oldMeetup->month_day : null,
								'occurs_at' => $oldMeetup->time,
								'purpose' => $meetupMap[$oldMeetup->purpose],
								'description' => trim($oldMeetup->description) != '' ? trim($oldMeetup->description) : null
						]);
						if($oldMeetup->location_url != '' && !filter_var($oldMeetup->location_url, FILTER_VALIDATE_URL)){
							$deadRecords['ParkdayUrl'][$oldMeetup->parkday_id] = $oldMeetup->location_url;
						}
						$transMeetups[$oldMeetup->parkday_id] = $meetupId;
					}
					$bar17->advance();
				}
				$bar17->finish();
				$this->info('');
			}
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
			$chapters = Chapter::all()->toArray();
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
					if($oldAttendance->mundane_id == 0){
						$pairing = null;
						$fromChapter = null;
						//those that just won't happen
						if($oldAttendance->persona === '' || $oldAttendance->flavor === '' && ($oldAttendance->note === '' || $oldAttendance->note === 'unknown' || $oldAttendance->note === '**' || $oldAttendance->note === '-' || $oldAttendance->note === '--' || $oldAttendance->note === '---' || $oldAttendance->note === '----' || $oldAttendance->note === '?' || $oldAttendance->note === '??' || $oldAttendance->note === '?? ??' || $oldAttendance->note === '??-??' || $oldAttendance->note === '??-???' || $oldAttendance->note === '???' || $oldAttendance->note === '????' || $oldAttendance->note === '-?' || $oldAttendance->note === 'Undeclaired' || $oldAttendance->note === 'Unk' || $oldAttendance->note === 'unknown' || $oldAttendance->note === 'unkwn' || $oldAttendance->note === 'visitor')){
							$deadRecords['HeadlessAttendances'][$oldAttendance->attendance_id] = $oldAttendance;
							$bar18->advance();
							continue;
						}else{
							//figure out if it's somebody
							if(strpos($oldAttendance->note, '--') > -1){
								$pairing = explode('--', $oldAttendance->note);
								$fromKingdom = array_search($pairing[0], array_column($kingdoms, 'abbreviation')) ? $kingdoms[array_search($pairing[0], array_column($kingdoms, 'abbreviation'))] : null;
								$fromChapters = array_keys(array_column($chapters, 'abbreviation'), $pairing[1]);
								$fromChapter = $fromKingdom && array_search($fromKingdom, array_column($fromChapters, 'kingdom_id')) ? $chapters[array_search($fromKingdom, array_column($fromChapters, 'kingdom_id'))] : null;
							}else if(strpos($oldAttendance->note, '-') > -1){
								$pairing = explode('-', $oldAttendance->note);
								$fromKingdom = array_search($pairing[0], array_column($kingdoms, 'abbreviation')) ? $kingdoms[array_search($pairing[0], array_column($kingdoms, 'abbreviation'))] : null;
								$fromChapters = array_keys(array_column($chapters, 'abbreviation'), $pairing[1]);
								$fromChapter = $fromKingdom && array_search($fromKingdom, array_column($fromChapters, 'kingdom_id')) ? $chapters[array_search($fromKingdom, array_column($fromChapters, 'kingdom_id'))] : null;
							}else if(strpos($oldAttendance->note, '/') > -1){
								$pairing = explode('/', $oldAttendance->note);
								$fromKingdom = array_search($pairing[0], array_column($kingdoms, 'abbreviation')) ? $kingdoms[array_search($pairing[0], array_column($kingdoms, 'abbreviation'))] : null;
								$fromChapters = array_keys(array_column($chapters, 'abbreviation'), $pairing[1]);
								$fromChapter = $fromKingdom && array_search($fromKingdom, array_column($fromChapters, 'kingdom_id')) ? $chapters[array_search($fromKingdom, array_column($fromChapters, 'kingdom_id'))] : null;
							}else if(strpos($oldAttendance->note, ':') > -1){
								$pairing = explode(':', $oldAttendance->note);
								$fromKingdom = array_search($pairing[0], array_column($kingdoms, 'abbreviation')) ? $kingdoms[array_search($pairing[0], array_column($kingdoms, 'abbreviation'))] : null;
								$fromChapters = array_keys(array_column($chapters, 'abbreviation'), $pairing[1]);
								$fromChapter = $fromKingdom && array_search($fromKingdom, array_column($fromChapters, 'kingdom_id')) ? $chapters[array_search($fromKingdom, array_column($fromChapters, 'kingdom_id'))] : null;
							}else{
								$fromChapter = array_search($oldAttendance->note, array_column($chapters, 'name')) ? $chapters[array_search($oldAttendance->note, array_column($chapters, 'name'))] : 
								(
									array_search(str_replace('.', '', $oldAttendance->note), array_column($chapters, 'abbreviation')) ? $chapters[array_search(str_replace('.', '', $oldAttendance->note), array_column($chapters, 'abbreviation'))] : 
									null
								);
							}
							if($fromChapter && trim($oldAttendance->persona)){
								$persona = Persona::where('name', 'LIKE', '%' . $oldAttendance->persona . '%')->where('chapter_id', $fromChapter)->first();
								$personaID = $persona ? $persona->id : null;
							}else{
								$deadRecords['HeadlessAttendances'][$oldAttendance->attendance_id] = $oldAttendance;
								$bar18->advance();
								continue;
							}
							if(!$personaID){
								$personaID = DB::table('personas')->insertGetId([
										'chapter_id' => $fromChapter['id'],
										'user_id' => null,
										'pronoun_id' => null,
										'mundane' => null,
										'name' => $this->cleanPersona($oldAttendance->persona, null),
										'heraldry' => null,
										'image' => null,
										'is_active' => 0,
										'reeve_qualified_expires_at' => null,
										'corpora_qualified_expires_at' => null,
										'joined_chapter_at' => null
								]);
								$transPersonas[$oldAttendance->mundane_id] = $personaID;
// 								DB::table('trans')->where('table', 'personas')->update([
// 										'value' => serialize($transPersonas)
// 								]);
							}
						}
					//get it
					}else{
						if(array_key_exists($oldAttendance->mundane_id, $transPersonas)){
						  $persona = Persona::where('id', $transPersonas[$oldAttendance->mundane_id])->first();
						}
						if(!$persona){
							$chapterID = null;
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
									if(array_key_exists($mostAttended->park_id, $transChapters)){
										$chapterID = $transChapters[$mostAttended->park_id];
										break;
									}
								}
							}else{
								$deadRecords['HeadlessAttendances'][$oldAttendance->attendance_id] = $oldAttendance;
								$bar18->advance();
								continue;
							}
							$personaID = DB::table('personas')->insertGetId(
								[
									'chapter_id' => $chapterID,
									'user_id' => null,
									'pronoun_id' => null,
									'mundane' => null,
									'name' => $this->cleanPersona($oldAttendance->persona, null) ? $this->cleanPersona($oldAttendance->persona, null) : 'Deleted Persona ' . $oldAttendance->mundane_id,
									'heraldry' => null,
									'image' => null,
									'is_active' => 0,
									'reeve_qualified_expires_at' => null,
									'corpora_qualified_expires_at' => null,
									'joined_chapter_at' => null
								]
							);
							$transPersonas[$oldAttendance->mundane_id] = $personaID;
// 							DB::table('trans')->where('table', 'personas')->update([
// 									'value' => serialize($transPersonas)
// 							]);
						}else{
							$personaID = $persona->id;
						}
					}
					
					//no park, kingdom, or event (ie, reconciliation)
					if($oldAttendance->park_id == 0 && $oldAttendance->kingdom_id == 0 && $oldAttendance->event_id == 0 && $oldAttendance->event_calendardetail_id == 0){
						DB::table('reconciliations')->insertGetId(
							[
								'archetype_id' => $archetypeId,
								'persona_id' => $oldAttendance->mundane_id > 0 ? $transPersonas[$oldAttendance->mundane_id] : $personaID,
								'credits' => $oldAttendance->credits
							]
						);
						$deadRecords['AttendancesReconciled'][$oldAttendance->attendance_id] = $oldAttendance;
					//no event and no date (ie, reconciliation)
					}else if($oldAttendance->event_id == 0 && $oldAttendance->event_calendardetail_id == 0 && $oldAttendance->entered_at === '0000-00-00 00:00:00' && $oldAttendance->date === '0000-00-00'){
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
					}else if($oldAttendance->credits > 2.9 && $oldAttendance->event_id == 0 && $oldAttendance->event_calendardetail_id == 0){
						DB::table('reconciliations')->insertGetId(
							[
								'archetype_id' => $archetypeId,
								'persona_id' => $oldAttendance->mundane_id > 0 ? $transPersonas[$oldAttendance->mundane_id] : $personaID,
								'credits' => $oldAttendance->credits
							]
							);
						$deadRecords['AttendancesReconciled'][$oldAttendance->attendance_id] = $oldAttendance;
					}else{
						if($oldAttendance->event_id == 0 && $oldAttendance->event_calendardetail_id == 0){
							//is there a meetup?
							$meetups = Meetup::where('chapter_id', $transChapters[$oldAttendance->park_id])->get()->toArray();
							if(count($meetups) > 0){
								//if the day of week for the meetup and the attendance match, this is it
								$meetupSelected = array_search(date('l', strtotime($oldAttendance->date)), array_column($meetups, 'week_day')) ? array_search(date('l', strtotime($oldAttendance->date)), array_column($meetups, 'week_day')) : 
								(
									//else if it's < 1 credit and class != 6, go with the fighter-practice one
									$oldAttendance->credits < 1 && $oldAttendance->class_id != 6 && array_search('Fighter Practice', array_column($meetups, 'purpose')) ? array_search('Fighter Practice', array_column($meetups, 'purpose')) : 
									(
										//else if it's < 1 credit and class === 6, go with the arts-day one
										$oldAttendance->credits < 1 && $oldAttendance->class_id == 6 && array_search('A&S Gathering', array_column($meetups, 'purpose')) ? array_search('A&S Gathering', array_column($meetups, 'purpose')) :
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
										'chapter_id' => $transChapters[$oldAttendance->park_id],
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
									$eventable_type = $parentEvent->unit_id > 0 ? 'Unit' : ($parentEvent->kingdom_id == 0 && $parentEvent->park_id == 0 ? 'Persona' : ($parentEvent->park_id > 0 && $parentEvent->kingdom_id == 0 ? 'Chapter' : 'Kingdom'));
									switch($eventable_type){
										case 'Unit':
											$eventable_id = $transUnits[$parentEvent->unit_id];
											break;
										case 'Persona':
											$eventable_id = $transPersonas[$parentEvent->mundane_id];
											break;
										case 'Chapter':
											$eventable_id = $transChapters[$parentEvent->park_id];
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
// 									DB::table('trans')->where('table', 'events')->update([
// 											'value' => serialize($transEvents)
// 									]);
									$transEventDetails[$oldAttendance->event_calendardetail_id] = $eventId;
// 									DB::table('trans')->where('table', 'eventDetails')->update([
// 											'value' => serialize($transEventDetails)
// 									]);
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
// 							DB::table('trans')->where('table', 'users')->update([
// 									'value' => serialize($transUsers)
// 							]);
							if(array_key_exists($oldAttendance->by_whom_id, $transPersonas)){
								DB::table('personas')->where('id', $transPersonas[$oldAttendance->by_whom_id])->update([
										'user_id' => $userId
								]);
							}else{
								$personaId = DB::table('personas')->insertGetId([
										'chapter_id' => $transChapters[$oldAttendance->park_id],
										'user_id' => $userId,
										'pronoun_id' => null,
										'mundane' => 'Deleted Persona',
										'name' => 'Deleted Persona',
										'is_active' => 0
								]);
								$transPersonas[$oldAttendance->by_whom_id] = $personaId;
// 								DB::table('trans')->where('table', 'personas')->update([
// 										'value' => serialize($transPersonas)
// 								]);
							}
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
// 			DB::table('trans')->insert([
// 					'table' => 'genericAttendances',
// 					'value' => serialize($transGenericAttendances)
// 			]);
// 			dd('check attendances');

			//tournaments
			$this->info('Importing Tournaments...');
			$oldTournaments = $backupConnect->table('ork_tournament')->get()->toArray();
			DB::table('tournaments')->truncate();
			if (count($oldTournaments) > 0) {
				$bar19 = $this->output->createProgressBar(count($oldTournaments));
				$bar19->start();
				foreach ($oldTournaments as $oldTournament) {
					if($oldTournament->kingdom_id == 0 && $oldTournament->park_id == 0 && $oldTournament->event_calendardetail_id == 0 && $oldTournament->event_id == 0){
						$deadRecords['Tournaments'][$oldTournament->tournament_id] = $oldTournament;
						$bar19->advance();
						continue;
					}
					$abletype = $oldTournament->kingdom_id > 0 ? 'Kingdom' : ($oldTournament->park_id > 0 ? 'Chapter' : 'Event');
					if($abletype === 'Kingdom'){
						$ableid = $transKingdoms[$oldTournament->kingdom_id];
					}elseif($abletype === 'Chapter'){
						$ableid = $transChapters[$oldTournament->park_id];
					}else{
						if($oldTournament->event_calendardetail_id > 0){
							if(!array_key_exists($oldTournament->event_calendardetail_id, $transEventDetails)){
								$deadRecords['Tournaments'][$oldTournament->tournament_id] = $oldTournament;
								$bar19->advance();
								continue;
							}else{
								$ableid = $transEventDetails[$oldTournament->event_calendardetail_id];
							}
						}else{
							//these are all garbage, so goodby
							$deadRecords['Tournaments'][$oldTournament->tournament_id] = $oldTournament;
							$bar19->advance();
							continue;
						}
					}
					$tournamentId = DB::table('tournaments')->insertGetId([
							'tournamentable_type' => $abletype,
							'tournamentable_id' => $ableid,
							'name' => $oldTournament->name,
							'description' => $oldTournament->description,
							'url' => $this->cleanURL($oldTournament->url),
							'occured_at' => $oldTournament->date_time
					]);
					$transTournaments[$oldTournament->tournament_id] = $tournamentId;
					$bar19->advance();
				}
				$bar19->finish();
				$this->info('');
			}
// 			DB::table('trans')->insert([
// 					'table' => 'tournaments',
// 					'value' => serialize($transTournaments)
// 			]);

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
								$kingdom->daily_minimum = $cleanNoQuotes === 'null' ? null : $cleanNoQuotes;
								break;
							case 'AttendanceWeeklyMinimum':
								$kingdom->weekly_minimum = $cleanNoQuotes === 'null' ? null : $cleanNoQuotes;
								break;
							case 'AveragePeriod':
								$data = json_decode($cleanValue);
								$kingdom->average_period_type = $data->Type != '' && $data->Type != '-' ? ucfirst($data->Type) : null;
								$kingdom->average_period = $data->Period != 'null' && $data->Period != '' ? ucfirst($data->Period) : null;
								break;
							case 'DuesAmount':
								$kingdom->dues_amount = $cleanNoQuotes;
								break;
							case 'DuesPeriod':
								$data = json_decode($cleanValue);
								$kingdom->dues_intervals_type = $data->Type != '' ? ucfirst($data->Type) : null;
								$kingdom->dues_intervals = $data->Period != 'null' && $data->Period != '' ? ucfirst($data->Period) : null;
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
			
			//transactions
			$this->info('Importing Transactions...');
			$oldTransactions = $backupConnect->table('ork_transaction')->get()->toArray();
			DB::table('transactions')->truncate();
			if (count($oldTransactions) > 0) {
				$bar21 = $this->output->createProgressBar(count($oldTransactions));
				$bar21->start();
				foreach ($oldTransactions as $oldTransaction) {
					if($oldTransaction->recorded_by != 0 && !array_key_exists($oldTransaction->recorded_by, $transUsers) && array_key_exists($oldTransaction->recorded_by, $transPersonas)){
						//somebody lost their user...we'll have to make one up
						$userId = DB::table('users')->insertGetId([
							'email' => 'deletedUser' . $oldTransaction->recorded_by . '@nowhere.net',
							'email_verified_at' => null,
							'password' => 'generated',
							'remember_token' => null,
							'is_restricted' => 1
						]);
						$transUsers[$oldTransaction->recorded_by] = $userId;
// 						DB::table('trans')->where('table', 'users')->update([
// 								'value' => serialize($transUsers)
// 						]);
						DB::table('personas')->where('id', $transPersonas[$oldTransaction->recorded_by])->update([
								'user_id' => $userId
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
// 			DB::table('trans')->insert([
// 					'table' => 'transactions',
// 					'value' => serialize($transTransactions)
// 			]);
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
						$bar27->advance();
						continue;
					}
					//transaction was deleted
					if(!array_key_exists($oldSplit->transaction_id, $transTransactions)){
						$deadRecords['Splits'][$oldSplit->split_id] = $oldSplit;
						$bar27->advance();
						continue;
					}
					//persona was deleted
					if(!array_key_exists($oldSplit->src_mundane_id, $transPersonas)){
						$deadRecords['Splits'][$oldSplit->split_id] = $oldSplit;
						$bar27->advance();
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
// 			DB::table('trans')->insert([
// 					'table' => 'splits',
// 					'value' => serialize($transSplits)
// 			]);
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
					if($oldDue->kingdom_id == 0 || !array_key_exists($oldDue->mundane_id, $transPersonas)){
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
						if($oldDue->import_transaction_id == 0 || !array_key_exists($oldDue->import_transaction_id, $transTransactions)){
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
// 							DB::table('trans')->where('table', 'transactions')->update([
// 									'value' => serialize($transTransactions)
// 							]);
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
// 							DB::table('trans')->where('table', 'users')->update([
// 									'value' => serialize($transUsers)
// 							]);
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
// 							DB::table('trans')->where('table', 'users')->update([
// 									'value' => serialize($transUsers)
// 							]);
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
// 			DB::table('trans')->insert([
// 					'table' => 'dues',
// 					'value' => serialize($transDues)
// 			]);
			dd('check dues');

			//members 
			$this->info('Importing Members...');
			$oldMembers = $backupConnect->table('ork_unit_mundane')->get()->toArray();
			DB::table('members')->truncate();
			if (count($oldMembers) > 0) {
				$bar23 = $this->output->createProgressBar(count($oldMembers));
				$bar23->start();
				foreach ($oldMembers as $oldMember) {
					//if they have a title, make/find it and give it to the persona
					if(trim($oldMember->title) != ''){
						$cleanTitle = trim($oldMember->title);
						$foundTitle = Title::where('titleable_type', 'Unit')->where('titleable_id', $transUnits[$oldMember->unit_id])->where('name', $cleanTitle)->first();
						if(!$foundTitle){
							$titleId = DB::table('titles')->insertGetId([
									'titleable_type' => 'Unit',
									'titleable_id' => $transUnits[$oldMember->unit_id],
									'name' => $cleanTitle,
									'rank' => null,
									'peerage' => null,
									'is_roaming' => 0,
									'is_active' => 1
							]);
						}else{
							$titleId = $foundTitle->id;
						}
						
						DB::table('issuances')->insert(
								[
										'issuable_type' => 'Title',
										'issuable_id' => $titleId,
										'authority_type' => 'Unit',
										'authority_id' => $transUnits[$oldMember->unit_id],
										'issuer_id' => null,
										'recipient_type' => 'Persona',
										'recipient_id' => $transPersonas[$oldMember->mundane_id],
										'issued_at' => date('Y-m-d'),
								]
						);
					}
					//check to see if entry exists already, and if so, update
					$memberCheck = Member::where('unit_id', $transUnits[$oldMember->unit_id])->where('persona_id', $transPersonas[$oldMember->mundane_id])->first();
					if($memberCheck){
						$memberCheck->role = ucfirst($oldMember->role);
						$memberCheck->is_active = $oldMember->active === 'Active' ? 1 : 0;
						$memberCheck->save();
					}else{
						$memberId = DB::table('members')->insertGetId([
								'unit_id' => $transUnits[$oldMember->unit_id],
								'persona_id' => $transPersonas[$oldMember->mundane_id],
								'joined_at' => null,
								'left_at' => null,
								'is_head' => $oldMember->role === 'captain' || $oldMember->role === 'lord' ? 1 : 0,
								'is_voting' => 1
						]);
					}
					$transMembers[$oldMember->mundane_id] = $memberId;
					$bar23->advance();
				}
				$bar23->finish();
				$this->info('');
			}
// 			DB::table('trans')->insert([
// 					'table' => 'members',
// 					'value' => serialize($transMembers)
// 			]);
			dd('check titles & members, particularly trans for duplicate & proper totals started with 543');
			
			//officers/reigns
			//TODO: move this up with the rest of the vars
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
							$chapter = Chapter::where('id', $transChapters[$oldOfficer->park_id])->first();
							$office = Office::where('officeable_type', 'Chaptertype')->where('officeable_id', $chapter->chaptertype_id)->where('order', 1)->first();
							$officeID = $office->id;
							if(strpos($chapter->name, '|') > -1){
								//assign custom term by gender (if known) Also, I'm sorry I'm defaulting to male.  I don't feel like I have a choice.  Please forgive me.
								$officeNames = explode('|', $office->name);
								if($chapter->chaptertype->rank < 30){
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
					$getReign = DB::table('reigns')->where('reignable_type', $oldOfficer->park_id != 0 ? 'Chapter' : 'Kingdom')->where('reignable_id', $oldOfficer->park_id != 0 ? $transChapters[$oldOfficer->park_id] : $transKingdoms[$oldOfficer->kingdom_id])->orderBy('ends_on', 'DESC')->first();
					if($getReign){
						$reignID = $getReign->id;
					}else{
						if(!array_key_exists($oldOfficer->kingdom_id, $knownCurrentReigns)){
							//this shouldn't happen.  let me know if it does
							dd($oldOfficer);
						}
						$reignID = DB::table('reigns')->insertGetId([
								'reignable_type' => $oldOfficer->park_id != 0 ? 'Chapter' : 'Kingdom',
								'reignable_id' => $oldOfficer->park_id != 0 ? $transChapters[$oldOfficer->park_id] : $transKingdoms[$oldOfficer->kingdom_id],
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
// 			DB::table('trans')->insert([
// 					'table' => 'officers',
// 					'value' => serialize($transOfficers)
// 			]);
			dd('check officers and reigns');
			
			//recommendations
			$this->info('Importing Recommendations...');
			$oldRecommendations = $backupConnect->table('ork_recommendations')->get()->toArray();
			DB::table('recommendations')->truncate();
			if (count($oldRecommendations) > 0) {
				$bar25 = $this->output->createProgressBar(count($oldRecommendations));
				$bar25->start();
				foreach ($oldRecommendations as $oldRecommendation) {
					//work out the kingdomaward_id (get persona, search kingdomawards by persona kingdom && award)
					$persona = $backupConnect->table('ork_mundane')->where('id', $oldRecommendation->mundane_id)->first();
					$kingdomaward = $backupConnect->table('ork_kingdomaward')->where('kingdom_id', $persona->kingdom_id)->where('award_id', $oldRecommendation->award_id)->first();
					$isTitle = array_key_exists($oldRecommendation->award_id, $transTitles) ? true : false;
					$RecommendationId = DB::table('recommendations')->insertGetId([
							'persona_id' => $transPersonas[$oldRecommendation->mundane_id],
							'recommendable_type' => $isTitle ? 'Title' : 'Award',
							'recommendable_id' => $isTitle ? $transTitles[$oldRecommendation->award_id][$persona->kingdom_id] : $transKingdomawards[$kingdomaward->id],
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
// 			DB::table('trans')->insert([
// 					'table' => 'recommendations',
// 					'value' => serialize($transRecommendations)
// 			]);
			dd('check recomendations');
			
			//reconciliations
			//TODO: check negatives...doesn't seem to be doing that right
			$this->info('Importing Reconciliations...');
			$oldReconciliations = $backupConnect->table('ork_class_reconciliation')->get()->toArray();
			DB::table('reconciliations')->truncate();
			if (count($oldReconciliations) > 0) {
				$bar26 = $this->output->createProgressBar(count($oldReconciliations));
				$bar26->start();
				foreach ($oldReconciliations as $oldReconciliation) {
					if($oldReconciliation->reconciled === 0){
						$deadRecords['Reconciliations'][$oldReconciliation->reconciliation_id] = $oldReconciliation;
						$bar26->advance();
						continue;
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
// 			DB::table('trans')->insert([
// 					'table' => 'reconciliations',
// 					'value' => serialize($transReconciliations)
// 			]);
			dd('check recomendations');
			
			//this will create too much garbage.  Make humans do it.
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
			//TODO: remove Events from auth_ty
			$this->info('Importing Issuances...');
			$oldIssuances = $backupConnect->table('ork_awards')->get()->toArray();
			DB::table('issuances')->truncate();
			if (count($oldIssuances) > 0) {
				$bar22 = $this->output->createProgressBar(count($oldIssuances));
				$bar22->start();
				foreach ($oldIssuances as $oldIssuance) {
					$issuable_type = null;
					$issuable_id = null;
					$rank = null;
					
					//we don't know what the issuance is...coincedently, we don't know the authorizing kingdom or park either
					if($oldIssuance->kingdomaward_id == 0){
						//leave them and let humans do the work.  There's only about 300 of them.
						$deadRecords['IssuancesNoAward'][$oldIssuances->awards_id] = $oldIssuance;
						$bar22->advance();
						continue;
					}
					
					//get kingdomaward (and thus, the kingdom)
					$kingdomaward = $backupConnect->table('ork_kingdomawards')->where('id', $oldIssuance->kingdomaward_id)->first();
					
					//get eventcalendardetail?
					$eventcaldet = null;
					if($oldIssuance->event_id != 0){
						$eventcaldet = $backupConnect->table('ork_event_calendardetail')->where('event_id', $oldIssuance->event_id)->where('event_start', '<=', $oldIssuance->date)->where('event_end', '>=', $oldIssuance->date)->first();
					}
					
					//awards
					if (array_key_exists($oldIssuance->kingdomaward_id, $transKingdomawards)) {
						//TODO: check for a custom award?
						if($oldIssuance->award_id == 94){
							//tile, office, or award?
// 					        if(){

// 					        }else if(){

// 					        }else if(){

// 					        }else{
// 					            //

// 					        }
						}
						$issuable_type = 'Award';
						$issuable_id = $transKingdomawards[$oldIssuance->kingdomaward_id];
						$rank = $oldIssuance->rank != '' ? $oldIssuance->rank : null;
					//TODO: this isn't gonna work, since some of them are 0
					}else if(array_key_exists($oldIssuance->award_id, $transTitles)){
						$issuable_type = 'Title';
						$issuable_id = $transTitles[$oldIssuance->award_id][$kingdomaward->kingdom_id];
						$rank = null;
					}
// 					else if(array_key_exists($oldIssuance->kingdomaward_id, $transOffices)){
						
// 					}
					else{
						$deadRecords['kingdomAwards'][$oldIssuance->awards_id] = $oldIssuance;
					}
					
					//make it
					$issuanceId = DB::table('issuances')->insertGetId(
							[
									'issuable_type' => $issuable_type,
									'issuable_id' => $issuable_id,
									'whereable_type' => $eventcaldet ? $transEventDetails[$eventcaldet->id] : $defaultLocationId,
									'whereable_id' => $eventcaldet ? 'Event' : 'Location',
									'authority_type' => $oldIssuance->park_id != 0 ? 'Chapter' : 'Kingdom',
									'authority_id' => $oldIssuance->park_id != 0 ? $transChapters[$oldIssuance->park_id] : $transKingdoms[$kingdomaward->kingdom_id],
									'recipient_type' => $oldIssuance->unit_id != 0 ? 'Unit' : 'Persona',
									'recipient_id' => $oldIssuance->unit_id != 0 ? $transUnits[$oldIssuance->unit_id] : ($oldIssuance->persona_id != 0 ? $transPersonas[$oldIssuance->persona_id] : $transPersonas[$oldIssuance->stripped_from]),
									'issuer_id' => $oldIssuance->given_by_id != 0 ? $transPersonas[$oldIssuance->given_by_id] : null,
									'custom_name' => $oldIssuance->custom_name != '' ? $oldIssuance->custom_name : null,
									'rank' => $rank,
									'issued_at' => $oldIssuance->date != '0000-00-00' ? $oldIssuance->date : ($oldIssuance->entered_at != '0000-00-00' ? $oldIssuance->entered_at : date('Y-m-d')),
									'note' => trim($oldIssuance->note) != '' ? trim($oldIssuance->note) : null,
									'image' => null,
									'revocation' => trim($oldIssuance->revocation) != '' ? trim($oldIssuance->revocation) : null,
									'revoked_by' => $transPersonas[$oldIssuance->revoked_by_id],
									'revoked_at' => $oldIssuance->revoked_at
							]
					);
					$transIssuances[$oldIssuance->issuance_id] = $issuanceId;
					$bar22->advance();
				}
				$bar22->finish();
				$this->info('');
			}
			dd('check issuances');
				
			
			
			//see what you can do about Squires, Pages, Apprentices, At-Arms in notes
			//see what you can do about units in notes
			//see what you can do about offices in notes
			
			//demos/guests
			
			//persona name titles  //go thru the personas
			//duplicate personas (move this up towards the top)
			//custom titles hidden in ork_awards...specifically, those for kingdomaward_id 6036.  Make the custom titles.
			//custom officers (award data)

			
			//TODO: wiki fields
			//TODO: website fields
			//TODO: kingdom waiver config options
			//TODO: add 'notes' style fields (like description) to titles, offices, and whatever else they're using 'notes' for
			//TODO: compare awardsprocessed with list of awards.  Dump results and check for stuff we can get


			$this->info(count($deadRecords['Chaptertypes']) . ' Chaptertypes lost due to a missing Kingdom');
			$this->info(count($deadRecords['Units']) . ' Units lost due to being an Event Type, having a missing Type, or having been deleted');
			$this->info(count($oldCustomAwards) . ' Awards created from \'Custom Award\'');
			$this->info(count($oldCustomTitles) . ' Titles created from \'Custom Award\'');
			$this->info(count($oldCustomOffices) . ' Offices created from \'Custom Award\'');
			$this->info(count($deadRecords['Users']) . ' Users (login only, not Persona data) not created due to duplicate emails');
			$this->info(count($deadRecords['PenaltyBox']) . ' Users in the Penalty Box but NOT suspended are now free');
			$this->info(count($deadRecords['EventUrlNames']) . ' Event URL names were tossed due to being unnecessary');
			$this->info(count($deadRecords['ParkdayAlternates']) . ' Parkday alternate locations dropped.');
			$this->info(count($deadRecords['ParkdayUrl']) . ' Parkday urls tossed for not being a url');
			$this->info(count($deadRecords['HeadlessAttendances']) . ' Attendances without a viable persona were lost');
			$this->info(count($deadRecords['AttendancesReconciled']) . ' Attendances made into Reconciliations due to missing critical data (date, chapter/event, etc)');
			$this->info(count($deadRecords['Dues']) . ' Dues lost due to no chapter/kingdom or terms');
			$this->info(count($deadRecords['IssuancesNoAward']) . ' Award/Title Issuances lost due to no award id');
			$this->info(count($deadRecords['Tournaments']) . ' Tournaments lost due to no kingdom/chapter/event data');
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
	
	private function cleanURL($url){
		if($url === ''){
			return null;
		}
		$url = str_ireplace('http://', '', $url);
		$url = str_ireplace('https://', '', $url);
		$url = 'https://' . $url;
		return filter_var($url, FILTER_VALIDATE_URL) ? $url : null;
	}
}