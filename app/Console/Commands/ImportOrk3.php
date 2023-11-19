<?php

namespace app\Console\Commands;

use Illuminate\Support\Facades\Log;
use Throwable;
use App\Helpers\AppHelper as AppHelper;
//use STS\Tunneler\Jobs\CreateTunnel;
use App\Models\Archetype;
use App\Models\Kingdom;
use App\Models\Location;
use App\Models\Meetup;
use App\Models\Member;
use App\Models\Office;
use App\Models\Chapter;
use App\Models\Chaptertype;
use App\Models\Persona;
use App\Models\Title;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tuqqu\GenderDetector\GenderDetector;

class ImportOrk3 extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'ImportOrk3 {step}';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'A series of async commands meant to translate the data in ORK3 to the improved format.';

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
			
			//setup
			$backupConnect = DB::connection('mysqlBak');
			$now = DB::raw('CURRENT_TIMESTAMP');
			$this->info('Beginning Import...');
			$deadRecords = [];
			$kingdomawardsProcessed = [];
			
			//what we know
			$step = $this->argument('step');
			$ropLadders = null;
			$ropTitles = null;
			//TODO: convert any of their GD's into 'kingdoms'
			$knownCollectiveGDs = null;
			$knownAwards = null;
			$knownTitles = null;
			$knownKingdomChaptertypesOffices = null;
			$knownCurrentReigns = null;
			$countries = null;
			include 'known.php';
			
			if(!Schema::hasTable('trans')){
				DB::statement("CREATE TABLE IF NOT EXISTS `trans` (
					`array` VARCHAR(50) NOT NULL,
					`oldID` bigint(20) unsigned NOT NULL,
					`oldMID` bigint(20) unsigned NULL,
					`newID` bigint(20) unsigned NOT NULL
				) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
			}
			
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
				
			$backupConnect->table('ork_parktitle')
				->where('kingdom_id', 16)
				->orWhere('title', 'Shire')
				->update(['class' => 20]);
				
			$backupConnect->table('ork_parktitle')
				->where('kingdom_id', 16)
				->orWhere('title', 'Barony')
				->update(['class' => 30]);
				
			$backupConnect->table('ork_award')
				->where('name', 'Order of the Walker in the Middle')
				->update(['is_ladder' => 1]);
				
			$backupConnect->table('ork_mundane')
				->where('mundane_id', 1)
				->update(['email' => 'admin@nowhere.net']);
			
			Schema::disableForeignKeyConstraints();
			
			switch($step){
				case 'Permissions':
					$this->info('Setting Roles & Permissions...');
					$bar = $this->output->createProgressBar(687);
					$bar->start();
					// Reset cached roles and permissions
					app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
					
					// create permissions
					Permission::create(['name' => 'list accounts', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'store accounts', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'display accounts', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'displayOwn accounts', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'displayRelated accounts', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'update accounts', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'updateOwn accounts', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'updateRelated accounts', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'remove accounts', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'removeOwn accounts', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'removeRelated accounts', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'list archetypes', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'store archetypes', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'display archetypes', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'displayOwn archetypes', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'displayRelated archetypes', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'update archetypes', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'updateOwn archetypes', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'updateRelated archetypes', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'remove archetypes', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'removeOwn archetypes', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'removeRelated archetypes', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'list attendances', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'store attendances', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'display attendances', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'displayOwn attendances', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'displayRelated attendances', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'update attendances', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'updateOwn attendances', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'updateRelated attendances', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'remove attendances', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'removeOwn attendances', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'removeRelated attendances', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'list awards', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'store awards', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'display awards', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'displayOwn awards', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'displayRelated awards', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'update awards', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'updateOwn awards', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'updateRelated awards', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'remove awards', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'removeOwn awards', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'removeRelated awards', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'list chapters', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'store chapters', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'display chapters', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'displayOwn chapters', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'displayRelated chapters', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'update chapters', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'updateOwn chapters', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'updateRelated chapters', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'remove chapters', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'removeOwn chapters', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'removeRelated chapters', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'list chaptertypes', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'store chaptertypes', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'display chaptertypes', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'displayOwn chaptertypes', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'displayRelated chaptertypes', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'update chaptertypes', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'remove chaptertypes', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'list crats', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'store crats', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'display crats', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'displayOwn crats', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'displayRelated crats', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'update crats', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'updateOwn crats', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'updateRelated crats', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'remove crats', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'removeOwn crats', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'removeRelated crats', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'list dues', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'store dues', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'display dues', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'displayOwn dues', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'displayRelated dues', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'update dues', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'updateOwn dues', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'updateRelated dues', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'remove dues', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'removeOwn dues', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'removeRelated dues', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'list events', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'store events', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'display events', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'displayOwn events', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'displayRelated events', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'update events', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'updateOwn events', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'updateRelated events', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'remove events', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'removeOwn events', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'removeRelated events', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'list issuances', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'store issuances', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'display issuances', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'displayOwn issuances', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'displayRelated issuances', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'update issuances', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'updateOwn issuances', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'updateRelated issuances', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'remove issuances', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'removeOwn issuances', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'removeRelated issuances', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'list kingdoms', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'store kingdoms', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'display kingdoms', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'displayOwn kingdoms', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'displayRelated kingdoms', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'update kingdoms', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'updateOwn kingdoms', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'updateRelated kingdoms', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'remove kingdoms', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'removeOwn kingdoms', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'removeRelated kingdoms', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'list locations', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'store locations', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'display locations', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'displayOwn locations', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'displayRelated locations', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'update locations', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'updateOwn locations', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'updateRelated locations', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'remove locations', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'removeOwn locations', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'removeRelated locations', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'list meetups', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'store meetups', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'display meetups', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'displayOwn meetups', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'displayRelated meetups', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'update meetups', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'updateOwn meetups', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'updateRelated meetups', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'remove meetups', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'removeOwn meetups', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'removeRelated meetups', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'list members', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'store members', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'display members', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'displayOwn members', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'displayRelated members', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'update members', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'updateOwn members', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'updateRelated members', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'remove members', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'removeOwn members', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'removeRelated members', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'list officers', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'store officers', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'display officers', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'displayOwn officers', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'displayRelated officers', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'update officers', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'updateOwn officers', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'updateRelated officers', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'remove officers', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'removeOwn officers', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'removeRelated officers', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'list offices', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'store offices', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'display offices', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'displayOwn offices', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'displayRelated offices', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'update offices', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'updateOwn offices', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'updateRelated offices', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'remove offices', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'removeOwn offices', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'removeRelated offices', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'list personas', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'store personas', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'display personas', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'displayOwn personas', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'displayRelated personas', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'update personas', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'updateOwn personas', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'updateRelated personas', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'remove personas', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'removeOwn personas', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'removeRelated personas', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'list pronouns', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'store pronouns', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'display pronouns', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'displayOwn pronouns', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'displayRelated pronouns', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'update pronouns', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'updateOwn pronouns', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'updateRelated pronouns', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'remove pronouns', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'removeOwn pronouns', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'removeRelated pronouns', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'list recommendations', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'store recommendations', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'display recommendations', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'displayOwn recommendations', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'displayRelated recommendations', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'update recommendations', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'updateOwn recommendations', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'updateRelated recommendations', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'remove recommendations', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'removeOwn recommendations', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'removeRelated recommendations', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'list reconciliations', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'store reconciliations', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'display reconciliations', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'displayOwn reconciliations', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'displayRelated reconciliations', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'update reconciliations', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'updateOwn reconciliations', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'updateRelated reconciliations', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'remove reconciliations', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'removeOwn reconciliations', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'removeRelated reconciliations', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'list reigns', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'store reigns', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'display reigns', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'displayOwn reigns', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'displayRelated reigns', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'update reigns', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'updateOwn reigns', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'updateRelated reigns', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'remove reigns', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'removeOwn reigns', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'removeRelated reigns', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'list splits', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'store splits', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'display splits', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'displayOwn splits', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'displayRelated splits', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'update splits', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'updateOwn splits', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'updateRelated splits', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'remove splits', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'removeOwn splits', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'removeRelated splits', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'list suspensions', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'store suspensions', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'display suspensions', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'displayOwn suspensions', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'displayRelated suspensions', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'update suspensions', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'updateOwn suspensions', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'updateRelated suspensions', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'remove suspensions', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'removeOwn suspensions', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'removeRelated suspensions', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'list titles', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'store titles', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'display titles', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'displayOwn titles', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'displayRelated titles', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'update titles', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'updateOwn titles', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'updateRelated titles', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'remove titles', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'removeOwn titles', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'removeRelated titles', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'list tournaments', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'store tournaments', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'display tournaments', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'displayOwn tournaments', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'displayRelated tournaments', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'update tournaments', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'updateOwn tournaments', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'updateRelated tournaments', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'remove tournaments', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'removeOwn tournaments', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'removeRelated tournaments', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'list transactions', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'store transactions', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'display transactions', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'displayOwn transactions', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'displayRelated transactions', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'update transactions', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'updateOwn transactions', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'updateRelated transactions', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'remove transactions', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'removeOwn transactions', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'removeRelated transactions', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'list units', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'store units', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'display units', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'displayOwn units', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'displayRelated units', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'update units', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'updateOwn units', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'updateRelated units', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'remove units', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'removeOwn units', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'removeRelated units', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'list users', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'store users', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'display users', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'displayOwn users', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'displayRelated users', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'update users', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'updateOwn users', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'updateRelated users', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'remove users', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'removeOwn users', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'removeRelated users', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'list waivers', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'store waivers', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'display waivers', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'displayOwn waivers', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'displayRelated waivers', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'update waivers', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'updateOwn waivers', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'updateRelated waivers', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'remove waivers', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'removeOwn waivers', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'removeRelated waivers', 'guard_name' => 'api']);$bar->advance();
					
					// create roles and assign created permissions
					$role = Role::create(['name' => 'admin', 'guard_name' => 'api']);$bar->advance();
					// gets all permissions via Gate::before rule; see AuthServiceProvider
					
					$role = Role::create(['name' => 'officer', 'guard_name' => 'api']);$bar->advance();
					$role->givePermissionTo('list accounts');$bar->advance();
					$role->givePermissionTo('store accounts');$bar->advance();
					$role->givePermissionTo('displayOwn accounts');$bar->advance();
					$role->givePermissionTo('displayRelated accounts');$bar->advance();
					$role->givePermissionTo('updateOwn accounts');$bar->advance();
					$role->givePermissionTo('updateRelated accounts');$bar->advance();
					$role->givePermissionTo('removeOwn accounts');$bar->advance();
					$role->givePermissionTo('removeRelated accounts');$bar->advance();
					$role->givePermissionTo('list archetypes');$bar->advance();
					$role->givePermissionTo('display archetypes');$bar->advance();
					$role->givePermissionTo('displayOwn archetypes');$bar->advance();
					$role->givePermissionTo('displayRelated archetypes');$bar->advance();
					$role->givePermissionTo('list attendances');$bar->advance();
					$role->givePermissionTo('store attendances');$bar->advance();
					$role->givePermissionTo('display attendances');$bar->advance();
					$role->givePermissionTo('displayOwn attendances');$bar->advance();
					$role->givePermissionTo('displayRelated attendances');$bar->advance();
					$role->givePermissionTo('updateOwn attendances');$bar->advance();
					$role->givePermissionTo('updateRelated attendances');$bar->advance();
					$role->givePermissionTo('removeOwn attendances');$bar->advance();
					$role->givePermissionTo('removeRelated attendances');$bar->advance();
					$role->givePermissionTo('list awards');$bar->advance();
					$role->givePermissionTo('store awards');$bar->advance();
					$role->givePermissionTo('display awards');$bar->advance();
					$role->givePermissionTo('displayOwn awards');$bar->advance();
					$role->givePermissionTo('displayRelated awards');$bar->advance();
					$role->givePermissionTo('updateOwn awards');$bar->advance();
					$role->givePermissionTo('updateRelated awards');$bar->advance();
					$role->givePermissionTo('removeOwn awards');$bar->advance();
					$role->givePermissionTo('removeRelated awards');$bar->advance();
					$role->givePermissionTo('list chapters');$bar->advance();
					$role->givePermissionTo('store chapters');$bar->advance();
					$role->givePermissionTo('display chapters');$bar->advance();
					$role->givePermissionTo('displayOwn chapters');$bar->advance();
					$role->givePermissionTo('displayRelated chapters');$bar->advance();
					$role->givePermissionTo('updateOwn chapters');$bar->advance();
					$role->givePermissionTo('updateRelated chapters');$bar->advance();
					$role->givePermissionTo('removeOwn chapters');$bar->advance();
					$role->givePermissionTo('removeRelated chapters');$bar->advance();
					$role->givePermissionTo('list chaptertypes');$bar->advance();
					$role->givePermissionTo('store chaptertypes');$bar->advance();
					$role->givePermissionTo('display chaptertypes');$bar->advance();
					$role->givePermissionTo('displayOwn chaptertypes');$bar->advance();
					$role->givePermissionTo('displayRelated chaptertypes');$bar->advance();
					$role->givePermissionTo('list crats');$bar->advance();
					$role->givePermissionTo('store crats');$bar->advance();
					$role->givePermissionTo('display crats');$bar->advance();
					$role->givePermissionTo('displayOwn crats');$bar->advance();
					$role->givePermissionTo('displayRelated crats');$bar->advance();
					$role->givePermissionTo('updateOwn crats');$bar->advance();
					$role->givePermissionTo('updateRelated crats');$bar->advance();
					$role->givePermissionTo('removeOwn crats');$bar->advance();
					$role->givePermissionTo('removeRelated crats');$bar->advance();
					$role->givePermissionTo('list dues');$bar->advance();
					$role->givePermissionTo('store dues');$bar->advance();
					$role->givePermissionTo('display dues');$bar->advance();
					$role->givePermissionTo('displayOwn dues');$bar->advance();
					$role->givePermissionTo('displayRelated dues');$bar->advance();
					$role->givePermissionTo('updateOwn dues');$bar->advance();
					$role->givePermissionTo('updateRelated dues');$bar->advance();
					$role->givePermissionTo('removeOwn dues');$bar->advance();
					$role->givePermissionTo('removeRelated dues');$bar->advance();
					$role->givePermissionTo('list events');$bar->advance();
					$role->givePermissionTo('store events');$bar->advance();
					$role->givePermissionTo('display events');$bar->advance();
					$role->givePermissionTo('displayOwn events');$bar->advance();
					$role->givePermissionTo('displayRelated events');$bar->advance();
					$role->givePermissionTo('updateOwn events');$bar->advance();
					$role->givePermissionTo('updateRelated events');$bar->advance();
					$role->givePermissionTo('removeOwn events');$bar->advance();
					$role->givePermissionTo('removeRelated events');$bar->advance();
					$role->givePermissionTo('list issuances');$bar->advance();
					$role->givePermissionTo('store issuances');$bar->advance();
					$role->givePermissionTo('display issuances');$bar->advance();
					$role->givePermissionTo('displayOwn issuances');$bar->advance();
					$role->givePermissionTo('displayRelated issuances');$bar->advance();
					$role->givePermissionTo('updateOwn issuances');$bar->advance();
					$role->givePermissionTo('updateRelated issuances');$bar->advance();
					$role->givePermissionTo('removeOwn issuances');$bar->advance();
					$role->givePermissionTo('removeRelated issuances');$bar->advance();
					$role->givePermissionTo('list kingdoms');$bar->advance();
					$role->givePermissionTo('display kingdoms');$bar->advance();
					$role->givePermissionTo('displayOwn kingdoms');$bar->advance();
					$role->givePermissionTo('displayRelated kingdoms');$bar->advance();
					$role->givePermissionTo('updateOwn kingdoms');$bar->advance();
					$role->givePermissionTo('updateRelated kingdoms');$bar->advance();
					$role->givePermissionTo('list locations');$bar->advance();
					$role->givePermissionTo('store locations');$bar->advance();
					$role->givePermissionTo('display locations');$bar->advance();
					$role->givePermissionTo('displayOwn locations');$bar->advance();
					$role->givePermissionTo('displayRelated locations');$bar->advance();
					$role->givePermissionTo('updateOwn locations');$bar->advance();
					$role->givePermissionTo('updateRelated locations');$bar->advance();
					$role->givePermissionTo('removeOwn locations');$bar->advance();
					$role->givePermissionTo('removeRelated locations');$bar->advance();
					$role->givePermissionTo('list meetups');$bar->advance();
					$role->givePermissionTo('store meetups');$bar->advance();
					$role->givePermissionTo('display meetups');$bar->advance();
					$role->givePermissionTo('displayOwn meetups');$bar->advance();
					$role->givePermissionTo('displayRelated meetups');$bar->advance();
					$role->givePermissionTo('updateOwn meetups');$bar->advance();
					$role->givePermissionTo('updateRelated meetups');$bar->advance();
					$role->givePermissionTo('removeOwn meetups');$bar->advance();
					$role->givePermissionTo('removeRelated meetups');$bar->advance();
					$role->givePermissionTo('list members');$bar->advance();
					$role->givePermissionTo('store members');$bar->advance();
					$role->givePermissionTo('display members');$bar->advance();
					$role->givePermissionTo('displayOwn members');$bar->advance();
					$role->givePermissionTo('displayRelated members');$bar->advance();
					$role->givePermissionTo('updateOwn members');$bar->advance();
					$role->givePermissionTo('updateRelated members');$bar->advance();
					$role->givePermissionTo('removeOwn members');$bar->advance();
					$role->givePermissionTo('removeRelated members');$bar->advance();
					$role->givePermissionTo('list officers');$bar->advance();
					$role->givePermissionTo('store officers');$bar->advance();
					$role->givePermissionTo('display officers');$bar->advance();
					$role->givePermissionTo('displayOwn officers');$bar->advance();
					$role->givePermissionTo('displayRelated officers');$bar->advance();
					$role->givePermissionTo('updateOwn officers');$bar->advance();
					$role->givePermissionTo('updateRelated officers');$bar->advance();
					$role->givePermissionTo('removeOwn officers');$bar->advance();
					$role->givePermissionTo('removeRelated officers');$bar->advance();
					$role->givePermissionTo('list offices');$bar->advance();
					$role->givePermissionTo('store offices');$bar->advance();
					$role->givePermissionTo('display offices');$bar->advance();
					$role->givePermissionTo('displayOwn offices');$bar->advance();
					$role->givePermissionTo('displayRelated offices');$bar->advance();
					$role->givePermissionTo('updateOwn offices');$bar->advance();
					$role->givePermissionTo('updateRelated offices');$bar->advance();
					$role->givePermissionTo('removeOwn offices');$bar->advance();
					$role->givePermissionTo('removeRelated offices');$bar->advance();
					$role->givePermissionTo('list personas');$bar->advance();
					$role->givePermissionTo('store personas');$bar->advance();
					$role->givePermissionTo('display personas');$bar->advance();
					$role->givePermissionTo('displayOwn personas');$bar->advance();
					$role->givePermissionTo('displayRelated personas');$bar->advance();
					$role->givePermissionTo('updateOwn personas');$bar->advance();
					$role->givePermissionTo('updateRelated personas');$bar->advance();
					$role->givePermissionTo('removeOwn personas');$bar->advance();
					$role->givePermissionTo('removeRelated personas');$bar->advance();
					$role->givePermissionTo('list pronouns');$bar->advance();
					$role->givePermissionTo('display pronouns');$bar->advance();
					$role->givePermissionTo('displayOwn pronouns');$bar->advance();
					$role->givePermissionTo('displayRelated pronouns');$bar->advance();
					$role->givePermissionTo('list recommendations');$bar->advance();
					$role->givePermissionTo('store recommendations');$bar->advance();
					$role->givePermissionTo('display recommendations');$bar->advance();
					$role->givePermissionTo('displayOwn recommendations');$bar->advance();
					$role->givePermissionTo('displayRelated recommendations');$bar->advance();
					$role->givePermissionTo('updateOwn recommendations');$bar->advance();
					$role->givePermissionTo('updateRelated recommendations');$bar->advance();
					$role->givePermissionTo('removeOwn recommendations');$bar->advance();
					$role->givePermissionTo('removeRelated recommendations');$bar->advance();
					$role->givePermissionTo('list reconciliations');$bar->advance();
					$role->givePermissionTo('store reconciliations');$bar->advance();
					$role->givePermissionTo('display reconciliations');$bar->advance();
					$role->givePermissionTo('displayOwn reconciliations');$bar->advance();
					$role->givePermissionTo('displayRelated reconciliations');$bar->advance();
					$role->givePermissionTo('updateOwn reconciliations');$bar->advance();
					$role->givePermissionTo('updateRelated reconciliations');$bar->advance();
					$role->givePermissionTo('removeOwn reconciliations');$bar->advance();
					$role->givePermissionTo('removeRelated reconciliations');$bar->advance();
					$role->givePermissionTo('list reigns');$bar->advance();
					$role->givePermissionTo('store reigns');$bar->advance();
					$role->givePermissionTo('display reigns');$bar->advance();
					$role->givePermissionTo('displayOwn reigns');$bar->advance();
					$role->givePermissionTo('displayRelated reigns');$bar->advance();
					$role->givePermissionTo('updateOwn reigns');$bar->advance();
					$role->givePermissionTo('updateRelated reigns');$bar->advance();
					$role->givePermissionTo('removeOwn reigns');$bar->advance();
					$role->givePermissionTo('removeRelated reigns');$bar->advance();
					$role->givePermissionTo('list splits');$bar->advance();
					$role->givePermissionTo('store splits');$bar->advance();
					$role->givePermissionTo('display splits');$bar->advance();
					$role->givePermissionTo('displayOwn splits');$bar->advance();
					$role->givePermissionTo('displayRelated splits');$bar->advance();
					$role->givePermissionTo('updateOwn splits');$bar->advance();
					$role->givePermissionTo('updateRelated splits');$bar->advance();
					$role->givePermissionTo('removeOwn splits');$bar->advance();
					$role->givePermissionTo('removeRelated splits');$bar->advance();
					$role->givePermissionTo('list suspensions');$bar->advance();
					$role->givePermissionTo('store suspensions');$bar->advance();
					$role->givePermissionTo('display suspensions');$bar->advance();
					$role->givePermissionTo('displayOwn suspensions');$bar->advance();
					$role->givePermissionTo('displayRelated suspensions');$bar->advance();
					$role->givePermissionTo('updateOwn suspensions');$bar->advance();
					$role->givePermissionTo('updateRelated suspensions');$bar->advance();
					$role->givePermissionTo('removeOwn suspensions');$bar->advance();
					$role->givePermissionTo('removeRelated suspensions');$bar->advance();
					$role->givePermissionTo('list titles');$bar->advance();
					$role->givePermissionTo('store titles');$bar->advance();
					$role->givePermissionTo('display titles');$bar->advance();
					$role->givePermissionTo('displayOwn titles');$bar->advance();
					$role->givePermissionTo('displayRelated titles');$bar->advance();
					$role->givePermissionTo('updateOwn titles');$bar->advance();
					$role->givePermissionTo('updateRelated titles');$bar->advance();
					$role->givePermissionTo('removeOwn titles');$bar->advance();
					$role->givePermissionTo('removeRelated titles');$bar->advance();
					$role->givePermissionTo('list tournaments');$bar->advance();
					$role->givePermissionTo('store tournaments');$bar->advance();
					$role->givePermissionTo('display tournaments');$bar->advance();
					$role->givePermissionTo('displayOwn tournaments');$bar->advance();
					$role->givePermissionTo('displayRelated tournaments');$bar->advance();
					$role->givePermissionTo('updateOwn tournaments');$bar->advance();
					$role->givePermissionTo('updateRelated tournaments');$bar->advance();
					$role->givePermissionTo('removeOwn tournaments');$bar->advance();
					$role->givePermissionTo('removeRelated tournaments');$bar->advance();
					$role->givePermissionTo('list transactions');$bar->advance();
					$role->givePermissionTo('store transactions');$bar->advance();
					$role->givePermissionTo('displayOwn transactions');$bar->advance();
					$role->givePermissionTo('displayRelated transactions');$bar->advance();
					$role->givePermissionTo('updateOwn transactions');$bar->advance();
					$role->givePermissionTo('updateRelated transactions');$bar->advance();
					$role->givePermissionTo('removeOwn transactions');$bar->advance();
					$role->givePermissionTo('removeRelated transactions');$bar->advance();
					$role->givePermissionTo('list units');$bar->advance();
					$role->givePermissionTo('store units');$bar->advance();
					$role->givePermissionTo('display units');$bar->advance();
					$role->givePermissionTo('displayOwn units');$bar->advance();
					$role->givePermissionTo('displayRelated units');$bar->advance();
					$role->givePermissionTo('updateOwn units');$bar->advance();
					$role->givePermissionTo('updateRelated units');$bar->advance();
					$role->givePermissionTo('removeOwn units');$bar->advance();
					$role->givePermissionTo('removeRelated units');$bar->advance();
					$role->givePermissionTo('list users');$bar->advance();
					$role->givePermissionTo('store users');$bar->advance();
					$role->givePermissionTo('display users');$bar->advance();
					$role->givePermissionTo('displayOwn users');$bar->advance();
					$role->givePermissionTo('displayRelated users');$bar->advance();
					$role->givePermissionTo('updateOwn users');$bar->advance();
					$role->givePermissionTo('updateRelated users');$bar->advance();
					$role->givePermissionTo('removeOwn users');$bar->advance();
					$role->givePermissionTo('removeRelated users');$bar->advance();
					$role->givePermissionTo('list waivers');$bar->advance();
					$role->givePermissionTo('store waivers');$bar->advance();
					$role->givePermissionTo('display waivers');$bar->advance();
					$role->givePermissionTo('displayOwn waivers');$bar->advance();
					$role->givePermissionTo('displayRelated waivers');$bar->advance();
					$role->givePermissionTo('updateOwn waivers');$bar->advance();
					$role->givePermissionTo('updateRelated waivers');$bar->advance();
					$role->givePermissionTo('removeOwn waivers');$bar->advance();
					$role->givePermissionTo('removeRelated waivers');
					
					$role = Role::create(['name' => 'player', 'guard_name' => 'api']);$bar->advance();
					$role->givePermissionTo('list archetypes');$bar->advance();
					$role->givePermissionTo('display archetypes');$bar->advance();
					$role->givePermissionTo('list attendances');$bar->advance();
					$role->givePermissionTo('store attendances');$bar->advance();
					$role->givePermissionTo('display attendances');$bar->advance();
					$role->givePermissionTo('displayOwn attendances');$bar->advance();
					$role->givePermissionTo('displayRelated attendances');$bar->advance();
					$role->givePermissionTo('list awards');$bar->advance();
					$role->givePermissionTo('display awards');$bar->advance();
					$role->givePermissionTo('displayOwn awards');$bar->advance();
					$role->givePermissionTo('displayRelated awards');$bar->advance();
					$role->givePermissionTo('list chaptertypes');$bar->advance();
					$role->givePermissionTo('list chapters');$bar->advance();
					$role->givePermissionTo('display chapters');$bar->advance();
					$role->givePermissionTo('displayOwn chapters');$bar->advance();
					$role->givePermissionTo('displayRelated chapters');$bar->advance();
					$role->givePermissionTo('display chaptertypes');$bar->advance();
					$role->givePermissionTo('displayOwn chaptertypes');$bar->advance();
					$role->givePermissionTo('displayRelated chaptertypes');$bar->advance();
					$role->givePermissionTo('list crats');$bar->advance();
					$role->givePermissionTo('store crats');$bar->advance();
					$role->givePermissionTo('display crats');$bar->advance();
					$role->givePermissionTo('displayOwn crats');$bar->advance();
					$role->givePermissionTo('displayRelated crats');$bar->advance();
					$role->givePermissionTo('updateOwn crats');$bar->advance();
					$role->givePermissionTo('removeOwn crats');$bar->advance();
					$role->givePermissionTo('list dues');$bar->advance();
					$role->givePermissionTo('display dues');$bar->advance();
					$role->givePermissionTo('displayOwn dues');$bar->advance();
					$role->givePermissionTo('displayRelated dues');$bar->advance();
					$role->givePermissionTo('list events');$bar->advance();
					$role->givePermissionTo('display events');$bar->advance();
					$role->givePermissionTo('displayOwn events');$bar->advance();
					$role->givePermissionTo('displayRelated events');$bar->advance();
					$role->givePermissionTo('updateOwn events');$bar->advance();
					$role->givePermissionTo('list issuances');$bar->advance();
					$role->givePermissionTo('display issuances');$bar->advance();
					$role->givePermissionTo('displayOwn issuances');$bar->advance();
					$role->givePermissionTo('displayRelated issuances');$bar->advance();
					$role->givePermissionTo('list kingdoms');$bar->advance();
					$role->givePermissionTo('display kingdoms');$bar->advance();
					$role->givePermissionTo('list locations');$bar->advance();
					$role->givePermissionTo('store locations');$bar->advance();
					$role->givePermissionTo('display locations');$bar->advance();
					$role->givePermissionTo('displayOwn locations');$bar->advance();
					$role->givePermissionTo('displayRelated locations');$bar->advance();
					$role->givePermissionTo('updateOwn locations');$bar->advance();
					$role->givePermissionTo('removeOwn locations');$bar->advance();
					$role->givePermissionTo('list meetups');$bar->advance();
					$role->givePermissionTo('display meetups');$bar->advance();
					$role->givePermissionTo('displayOwn meetups');$bar->advance();
					$role->givePermissionTo('displayRelated meetups');$bar->advance();
					$role->givePermissionTo('list members');$bar->advance();
					$role->givePermissionTo('store members');$bar->advance();
					$role->givePermissionTo('display members');$bar->advance();
					$role->givePermissionTo('displayOwn members');$bar->advance();
					$role->givePermissionTo('displayRelated members');$bar->advance();
					$role->givePermissionTo('updateOwn members');$bar->advance();
					$role->givePermissionTo('removeOwn members');$bar->advance();
					$role->givePermissionTo('list officers');$bar->advance();
					$role->givePermissionTo('display officers');$bar->advance();
					$role->givePermissionTo('displayOwn officers');$bar->advance();
					$role->givePermissionTo('displayRelated officers');$bar->advance();
					$role->givePermissionTo('list offices');$bar->advance();
					$role->givePermissionTo('display offices');$bar->advance();
					$role->givePermissionTo('displayOwn offices');$bar->advance();
					$role->givePermissionTo('displayRelated offices');$bar->advance();
					$role->givePermissionTo('list personas');$bar->advance();
					$role->givePermissionTo('display personas');$bar->advance();
					$role->givePermissionTo('displayOwn personas');$bar->advance();
					$role->givePermissionTo('displayRelated personas');$bar->advance();
					$role->givePermissionTo('updateOwn personas');$bar->advance();
					$role->givePermissionTo('list pronouns');$bar->advance();
					$role->givePermissionTo('display pronouns');$bar->advance();
					$role->givePermissionTo('displayOwn pronouns');$bar->advance();
					$role->givePermissionTo('displayRelated pronouns');$bar->advance();
					$role->givePermissionTo('updateOwn pronouns');$bar->advance();
					$role->givePermissionTo('removeOwn pronouns');$bar->advance();
					$role->givePermissionTo('list recommendations');$bar->advance();
					$role->givePermissionTo('store recommendations');$bar->advance();
					$role->givePermissionTo('display recommendations');$bar->advance();
					$role->givePermissionTo('displayOwn recommendations');$bar->advance();
					$role->givePermissionTo('displayRelated recommendations');$bar->advance();
					$role->givePermissionTo('updateOwn recommendations');$bar->advance();
					$role->givePermissionTo('removeOwn recommendations');$bar->advance();
					$role->givePermissionTo('list reconciliations');$bar->advance();
					$role->givePermissionTo('display reconciliations');$bar->advance();
					$role->givePermissionTo('displayOwn reconciliations');$bar->advance();
					$role->givePermissionTo('displayRelated reconciliations');$bar->advance();
					$role->givePermissionTo('list reigns');$bar->advance();
					$role->givePermissionTo('display reigns');$bar->advance();
					$role->givePermissionTo('displayOwn reigns');$bar->advance();
					$role->givePermissionTo('displayRelated reigns');$bar->advance();
					$role->givePermissionTo('list suspensions');$bar->advance();
					$role->givePermissionTo('display suspensions');$bar->advance();
					$role->givePermissionTo('displayOwn suspensions');$bar->advance();
					$role->givePermissionTo('displayRelated suspensions');$bar->advance();
					$role->givePermissionTo('list titles');$bar->advance();
					$role->givePermissionTo('display titles');$bar->advance();
					$role->givePermissionTo('displayOwn titles');$bar->advance();
					$role->givePermissionTo('displayRelated titles');$bar->advance();
					$role->givePermissionTo('list tournaments');$bar->advance();
					$role->givePermissionTo('store tournaments');$bar->advance();
					$role->givePermissionTo('display tournaments');$bar->advance();
					$role->givePermissionTo('displayOwn tournaments');$bar->advance();
					$role->givePermissionTo('displayRelated tournaments');$bar->advance();
					$role->givePermissionTo('updateOwn tournaments');$bar->advance();
					$role->givePermissionTo('removeOwn tournaments');$bar->advance();
					$role->givePermissionTo('list units');$bar->advance();
					$role->givePermissionTo('store units');$bar->advance();
					$role->givePermissionTo('display units');$bar->advance();
					$role->givePermissionTo('displayOwn units');$bar->advance();
					$role->givePermissionTo('displayRelated units');$bar->advance();
					$role->givePermissionTo('update units');$bar->advance();
					$role->givePermissionTo('updateOwn units');$bar->advance();
					$role->givePermissionTo('remove units');$bar->advance();
					$role->givePermissionTo('removeOwn units');$bar->advance();
					$role->givePermissionTo('list users');$bar->advance();
					$role->givePermissionTo('store users');$bar->advance();
					$role->givePermissionTo('display users');$bar->advance();
					$role->givePermissionTo('displayOwn users');$bar->advance();
					$role->givePermissionTo('displayRelated users');$bar->advance();
					$role->givePermissionTo('updateOwn users');$bar->advance();
					$role->givePermissionTo('removeOwn users');$bar->advance();
					$role->givePermissionTo('list waivers');$bar->advance();
					$role->givePermissionTo('display waivers');$bar->advance();
					$role->givePermissionTo('displayOwn waivers');$bar->advance();
					$role->givePermissionTo('displayRelated waivers');$bar->advance();
					
					app('cache')
						->store(config('permission.cache.store') != 'default' ? config('permission.cache.store') : null)
						->forget(config('permission.cache.key'));
					break;
				case 'Archetypes':
					$this->info('Importing Archetypes...');
					$transArchetypes = [];
					$oldArchetypes = $backupConnect->table('ork_class')->get()->toArray();
					$bar = $this->output->createProgressBar(count($oldArchetypes));
					$bar->start();
					foreach ($oldArchetypes as $oldArchetype) {
						$archetypeId = DB::table('archetypes')->insertGetId([
								'name' => $oldArchetype->name,
								'is_active' => $oldArchetype->active
						]);
						DB::table('trans')->insert([
								'array' => 'archetypes',
								'oldID' => $oldArchetype->class_id,
								'newID' => $archetypeId
						]);
						$bar->advance();
					}
					break;
				case 'Kingdoms':
					$this->info('Importing Kingdoms...');
					$transKingdoms = [];
					$freehold = $backupConnect->table('ork_kingdom')->where('name', 'The Freeholds of Amtgard')->first();
					$oldKingdoms = $backupConnect->table('ork_kingdom')->orderBy('kingdom_id', 'ASC')->get()->toArray();
					$bar = $this->output->createProgressBar(count($oldKingdoms) - 1);
					$bar->start();
					foreach ($oldKingdoms as $oldKingdom) {
						//nope this guy
						//TODO: check me!
						if($oldKingdom->name === '&THORN;e Olde Records Empire'){
							//we're moving them to freeholds
							$deadRecords['Kingdoms'][$oldKingdom->kingdom_id] = $oldKingdom;
							DB::table('trans')->insert([
									'array' => 'kingdoms',
									'oldID' => $oldKingdom->kingdom_id,
									'newID' => $freehold->kingdom_id
							]);
							$transKingdoms[$oldKingdom->kingdom_id] = $freehold->kingdom_id;
							continue;
						}
						$kingdomId = DB::table('kingdoms')->insertGetId([
							'parent_id' => $oldKingdom->parent_kingdom_id == 0 ? null : $transKingdoms[$oldKingdom->parent_kingdom_id],
							'name' => $oldKingdom->name,
							'abbreviation' => $oldKingdom->abbreviation,
							'heraldry' => $oldKingdom->has_heraldry === '1' ? sprintf('%04d.jpg', $oldKingdom->kingdom_id) : null,
							'is_active' => $oldKingdom->active === 'Active' ? 1 : 0,
							'created_at' => $oldKingdom->modified,
							'updated_at' => $oldKingdom->modified
						]);
						DB::table('trans')->insert([
								'array' => 'kingdoms',
								'oldID' => $oldKingdom->kingdom_id,
								'newID' => $kingdomId
						]);
						$transKingdoms[$oldKingdom->kingdom_id] = $kingdomId;
						$bar->advance();
					}
					break;
				case 'Chaptertypes':
					$this->info('Importing Chaptertypes...');
					$transChaptertypes = [];
					$chaptertypeId = 0;
					$oldKingdoms = $backupConnect->table('ork_kingdom')->pluck('kingdom_id')->toArray();
					$transKingdoms = $this->getTrans('kingdoms');
					$oldChaptertypes = $backupConnect->table('ork_parktitle')->get()->toArray();
					$bar = $this->output->createProgressBar(count($oldChaptertypes) + 43);
					$bar->start();
					foreach ($oldChaptertypes as $oldChaptertype) {
						//deleted kingdoms
						if (!array_key_exists($oldChaptertype->kingdom_id, $oldKingdoms) && !array_key_exists($oldChaptertype->kingdom_id, $transKingdoms)) {
							$kingdomId = DB::table('kingdoms')->insertGetId([
									'parent_id' => null,
									'name' => 'Deleted Kingdom ' . $oldChaptertype->kingdom_id,
									'abbreviation' => 'DK' . $oldChaptertype->kingdom_id,
									'heraldry' => null,
									'is_active' => 0
							]);
							DB::table('trans')->insert([
									'array' => 'kingdoms',
									'oldID' => $oldChaptertype->kingdom_id,
									'newID' => $kingdomId
							]);
							$transKingdoms[$oldChaptertype->kingdom_id] = $kingdomId;
						}
						
						//wait for the kingdom to exist
						while(!array_key_exists($oldChaptertype->kingdom_id, $transKingdoms)){
							$this->info('waiting for kingdom ' . $oldChaptertype->kingdom_id);
							sleep(5);
							$transKingdoms = $this->getTrans('kingdoms');
						}
						
						//If it's one of our known kingdoms,
						if(array_key_exists($oldChaptertype->kingdom_id, $knownKingdomChaptertypesOffices)){
							//and it's not in the known array (or 'Kingdom', thanks for that DS),
							if(!array_key_exists($oldChaptertype->title, $knownKingdomChaptertypesOffices[$oldChaptertype->kingdom_id]) || $oldChaptertype->title == "Kingdom"){
								//don't add this one.
								//TODO: check me
								switch($oldChaptertype->parktitle_id){
									case '56':
										$transChaptertypes[$oldChaptertype->parktitle_id] = (int)$chaptertypeId + 1;
										break;
									case '31':
										$transChaptertypes[$oldChaptertype->parktitle_id] = (int)$chaptertypeId + 1;
										break;
									case '35':
										$transChaptertypes[$oldChaptertype->parktitle_id] = (int)$chaptertypeId;
										break;
									default:
								}
								$deadRecords['Chaptertypes'][$oldChaptertype->parktitle_id] = $oldChaptertype;
								$bar->advance();
								continue;
							}else{
								unset($knownKingdomChaptertypesOffices[$oldChaptertype->kingdom_id][$oldChaptertype->title]);
							}
						}
						$chaptertypeId = DB::table('chaptertypes')->insertGetId([
								'kingdom_id' => $transKingdoms[$oldChaptertype->kingdom_id],
								'name' => $oldChaptertype->title,
								'rank' => $oldChaptertype->class,
								'minimumattendance' => $oldChaptertype->minimumattendance,
								'minimumcutoff' => $oldChaptertype->minimumcutoff
						]);
						DB::table('trans')->insert([
								'array' => 'chaptertypes',
								'oldID' => $oldChaptertype->parktitle_id,
								'newID' => $chaptertypeId
						]);
						$transChaptertypes[$oldChaptertype->parktitle_id] = $chaptertypeId;
						$bar->advance();
					}
					
					//now add what's missing
					foreach($knownKingdomChaptertypesOffices as $kid => $kingdomChaptertypes){
						//wait for the kingdom to exist
						while(!array_key_exists($kid, $transKingdoms)){
							$this->info('waiting for kingdom ' . $kid);
							sleep(5);
							$transKingdoms = $this->getTrans('kingdoms');
						}
						foreach($kingdomChaptertypes as $knownChaptertype => $offices){
							if($knownChaptertype != 'Kingdom'){
								$chaptertypeId = DB::table('chaptertypes')->insertGetId([
									'kingdom_id' => $transKingdoms[$kid],
									'name' => $knownChaptertype,
									'rank' => $knownChaptertype === 'Principality' ? 50 : 35,
									'minimumattendance' => $knownChaptertype === 'Principality' ? 60 : 21,
									'minimumcutoff' => $knownChaptertype === 'Principality' ? 56 : 19
								]);
								$bar->advance();
							}
						}
					}
					break;
				case 'Chapters':
					$this->info('Importing Chapters...');
					$transChapters = [];
					$transKingdoms = $this->getTrans('kingdoms');
					$transChaptertypes = $this->getTrans('chaptertypes');
					$oldKingdoms = $backupConnect->table('ork_kingdom')->pluck('kingdom_id')->toArray();
					$oldChapters = $backupConnect->table('ork_park')->get()->toArray();
					$bar = $this->output->createProgressBar(count($oldChapters));
					$bar->start();
					foreach ($oldChapters as $oldChapter) {
						//deleted kingdoms
						if (!array_key_exists($oldChapter->kingdom_id, $oldKingdoms) && !array_key_exists($oldChapter->kingdom_id, $transKingdoms)) {
							$kingdomId = DB::table('kingdoms')->insertGetId([
									'parent_id' => null,
									'name' => 'Deleted Kingdom ' . $oldChapter->kingdom_id,
									'abbreviation' => 'DK' . $oldChapter->kingdom_id,
									'heraldry' => null,
									'is_active' => 0
							]);
							DB::table('trans')->insert([
									'array' => 'kingdoms',
									'oldID' => $oldKingdom->kingdom_id,
									'newID' => $kingdomId
							]);
							$transKingdoms[$oldChapter->kingdom_id] = $kingdomId;
						}
						$locationID = DB::table('locations')->insertGetId([
								'address' => $this->locationClean($oldChapter->address),
								'city' => $this->locationClean($oldChapter->city),
								'province' => $this->locationClean($oldChapter->province),
								'postal_code' => $this->locationClean($oldChapter->postal_code),
								'country' => $this->getCountryCode((string) substr($oldChapter->address, strrpos("/$oldChapter->address", ', ') + 1), $countries),
								'google_geocode' => $this->geocodeClean($oldChapter->google_geocode),
								'latitude' => $this->locationClean($oldChapter->latitude),
								'longitude' => $this->locationClean($oldChapter->longitude),
								'location' => $this->locationClean($oldChapter->location),
								'map_url' => $this->cleanUrl($this->locationClean($oldChapter->map_url)),
								'description' => $this->locationClean($oldChapter->description),
								'directions' => $this->locationClean($oldChapter->directions)
						]);
						while(!array_key_exists($oldChapter->kingdom_id, $transKingdoms)){
							$this->info('waiting for kingdom ' . $oldChapter->kingdom_id);
							sleep(5);
							$transKingdoms = $this->getTrans('kingdoms');
						}
						while(!array_key_exists($oldChapter->parktitle_id, $transChaptertypes)){
							$this->info('waiting for chaptertypes ' . $oldChapter->parktitle_id);
							sleep(5);
							$transChaptertypes = $this->getTrans('chaptertypes');
						}
						if($oldChapter->parktitle_id == 186){//inactive is being removed
							$lowestChaptertype = Chaptertype::where('kingdom_id', $transKingdoms[$oldChapter->kingdom_id])->orderBy('rank', 'ASC')->first();
						}
						$chapterID = DB::table('chapters')->insertGetId([
								'kingdom_id' => $transKingdoms[$oldChapter->kingdom_id],
								'chaptertype_id' => $oldChapter->parktitle_id == 186 ? $lowestChaptertype->id : $transChaptertypes[$oldChapter->parktitle_id],
								'location_id' => $locationID,
								'name' => trim($oldChapter->name),
								'abbreviation' => $oldChapter->abbreviation === '' ? $this->getAbbreviation(trim($oldChapter->name)) : $oldChapter->abbreviation,
								'heraldry' => $oldChapter->has_heraldry === '1' ? sprintf('%05d.jpg', $oldChapter->park_id) : null,
								'is_active' => $oldChapter->active != 'Active' || $oldChapter->parktitle_id == 186 ? 0 : 1,
								'created_at' => $oldChapter->modified,
								'updated_at' => $oldChapter->modified
						]);
						DB::table('trans')->insert([
								'array' => 'chapters',
								'oldID' => $oldChapter->park_id,
								'newID' => $chapterID
						]);
						$transChapters[$oldChapter->park_id] = $chapterID;
						$url = $this->cleanURL($oldChapter->url);
						if($url){
							DB::table('socials')->insert([
									'sociable_type' => 'Chapter',
									'sociable_id' => $chapterID,
									'media' => 'Web',
									'value' => $url
							]);
						}
						$bar->advance();
					}
					break;
				case 'Units':
					$this->info('Importing Units...');
					$transUnits = [];
					$oldUnits = $backupConnect->table('ork_unit')->get()->toArray();
					$bar = $this->output->createProgressBar(count($oldUnits));
					$bar->start();
					foreach ($oldUnits as $oldUnit) {
						if ($oldUnit->type != '') {
							$unitId = DB::table('units')->insertGetId([
									'type' => $oldUnit->type,
									'name' => $oldUnit->name != '' ? trim($oldUnit->name) : 'Unknown ' . $oldUnit->type,
									'heraldry' => $oldUnit->has_heraldry === '1' ? sprintf('%05d.jpg', $oldUnit->unit_id) : null,
									'description' => trim($oldUnit->description) != '' ? trim($oldUnit->description) : null,
									'history' => trim($oldUnit->history) != '' ? trim($oldUnit->history) : null,
									'created_at' => $oldUnit->modified,
									'updated_at' => $oldUnit->modified
							]);
							$url = $this->cleanURL($oldUnit->url);
							if($url){
								DB::table('socials')->insert([
										'sociable_type' => 'Unit',
										'sociable_id' => $unitId,
										'media' => 'Web',
										'value' => $url
								]);
							}
							DB::table('trans')->insert([
									'array' => 'units',
									'oldID' => $oldUnit->unit_id,
									'newID' => $unitId
							]);
							$transUnits[$oldUnit->unit_id] = $unitId;
						}else{
							$deadRecords['Units'][$oldUnit->unit_id] = $oldUnit;
						}
						$bar->advance();
					}
					break;
				case 'Awards':
					$this->info('Importing Awards...');
					$transGenericAwards = [];
					$transKingdoms = $this->getTrans('kingdoms');
					//Common awards first
					$oldAwards = $backupConnect->table('ork_award')->where('is_ladder', 1)->get()->toArray();
					$bar = $this->output->createProgressBar(216);
					$bar->start();
					foreach ($oldAwards as $oldAward) {
						$nameClean = trim($oldAward->name);
						//the awards that aren't expressly defined in the RoP are no longer 'common'.  Make one for each kingdom, as appropriate
						if(!in_array($oldAward->award_id, $ropLadders)){
							if($nameClean === 'Order of the Walker in the Middle'){
								foreach($knownAwards[$nameClean] as $kid => $info){
									while(!array_key_exists($kid, $transKingdoms)){
										$this->info('waiting for kingdom ' . $kid);
										sleep(5);
										$transKingdoms = $this->getTrans('kingdoms');
									}
									if($info){
										$awardId = DB::table('awards')->insertGetId([
												'awarder_type' => 'Kingdom',
												'awarder_id' => $transKingdoms[$kid],
												'name' => $info['name'],
												'is_ladder' => 0,
												'deleted_by' => null,
												'deleted_at' => null
										]);
										DB::table('trans')->insert([
												'array' => 'genericawards',
												'oldID' => $oldAward->award_id,
												'newID' => $awardId
										]);
										$transGenericAwards[$oldAward->award_id][$kid] = $awardId;
									}
								}
							}else{
								foreach($knownAwards[$nameClean] as $kid => $info){
									if($info){
										while(!array_key_exists($kid, $transKingdoms)){
											$this->info('waiting for kingdom ' . $kid);
											sleep(5);
											$transKingdoms = $this->getTrans('kingdoms');
										}
										$awardId = DB::table('awards')->insertGetId([
												'awarder_type' => 'Kingdom',
												'awarder_id' => $transKingdoms[$kid],
												'name' => $info['name'],
												'is_ladder' => $info['is_ladder'],
												'deleted_by' => null,
												'deleted_at' => null
										]);
										DB::table('trans')->insert([
												'array' => 'genericawards',
												'oldID' => $oldAward->award_id,
												'newID' => $awardId
										]);
										$transGenericAwards[$oldAward->award_id][$kid] = $awardId;
									}
								}
							}
							$bar->advance();
							continue;
						}
						$awardId = DB::table('awards')->insertGetId([
								'awarder_type' => 'Kingdom',
								'awarder_id' => null,
								'name' => $nameClean,
								'is_ladder' => 1,
								'deleted_by' => $oldAward->deprecate === '1' ? 1 : null,
								'deleted_at' => $oldAward->deprecate === '1' ? $now : null
						]);
						DB::table('trans')->insert([
								'array' => 'genericawards',
								'oldID' => $oldAward->award_id,
								'newID' => $awardId
						]);
						$transGenericAwards[$oldAward->award_id] = $awardId;
						$bar->advance();
					}
					break;
				case 'CustomAwards':
					$this->info('Importing Custom Awards...');
					$transKingdomawards = [];
					$transKingdoms = $this->getTrans('kingdoms');
					$oldCustom = $backupConnect->table('ork_award')->where('name', 'LIKE', '%Award%')->get()->toArray();
					$deadRecords['Awards'][94] = $oldCustom[0];
					$oldCustomAwards = $backupConnect->table('ork_kingdomaward')
						->where(function($q) {
							$q->where('award_id', 94)->orWhere('award_id', 0);
						})
						->where(function($q) {
							$q->where('name', '')->orWhere('name', 'LIKE', '%Antigriffin%')->orWhere('name', 'LIKE', '%typhoon%')->orWhere('name', 'LIKE', '%tsunami%')->orWhere('name', 'LIKE', '%Hellrider%')->orWhere('name', 'LIKE', '%Dreamkeeper%')->orWhere('name', 'LIKE', '%Cyclone%')->orWhere('name', 'LIKE', '%Emerald%')->orWhere('name', 'LIKE', 'Order %');
						})->get()->toArray();
					$bar = $this->output->createProgressBar(count($oldCustomAwards));
					$bar->start();
					foreach ($oldCustomAwards as $oldCustomAward) {
						$foundAward = DB::table('awards')->where('name', $oldCustomAward->name)->first();
						if(!$foundAward){
							while(!array_key_exists($oldCustomAward->kingdom_id, $transKingdoms)){
								$this->info('waiting for kingdom ' . $oldCustomAward->kingdom_id);
								sleep(5);
								$transKingdoms = $this->getTrans('kingdoms');
							}
							$cleanName = trim($oldCustomAward->name);
							$customAwardId = DB::table('awards')->insertGetId([
									'awarder_type' => 'Kingdom',
									'awarder_id' => $transKingdoms[$oldCustomAward->kingdom_id],
									'name' => $cleanName != '' ? $cleanName : 'Unknown Award',
									'is_ladder' => strpos($oldCustomAward->name, 'dreamkeeper') > -1 || strpos($oldCustomAward->name, 'hell') > -1 ? 0 : 1
							]);
							DB::table('trans')->insert([
									'array' => 'kingdomawardsprocessed',
									'oldID' => $oldCustomAward->kingdomaward_id,
									'newID' => $customAwardId
							]);
							$kingdomawardsProcessed[(int)$oldCustomAward->kingdomaward_id] = $customAwardId;
							DB::table('trans')->insert([
									'array' => 'kingdomawards',
									'oldID' => $oldCustomAward->kingdomaward_id,
									'newID' => $customAwardId
							]);
							$transKingdomawards[$oldCustomAward->kingdomaward_id] = $customAwardId;
						}else{
							DB::table('trans')->insert([
									'array' => 'kingdomawardsprocessed',
									'oldID' => $oldCustomAward->kingdomaward_id,
									'newID' => $foundAward->id
							]);
							$kingdomawardsProcessed[(int)$oldCustomAward->kingdomaward_id] = $foundAward->id;
							DB::table('trans')->insert([
									'array' => 'kingdomawards',
									'oldID' => $oldCustomAward->kingdomaward_id,
									'newID' => $foundAward->id
							]);
							$transKingdomawards[$oldCustomAward->kingdomaward_id] = $foundAward->id;
						}
						$bar->advance();
					}
					break;
				case 'Titles':
					$this->info('Importing Titles...');
					$transTitles = [];
					$transKingdoms = $this->getTrans('kingdoms');
					$oldTitles = $backupConnect->table('ork_award')->where('is_title', 1)->get()->toArray();
					$bar = $this->output->createProgressBar(392);
					$bar->start();
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
									DB::table('trans')->insert([
											'array' => 'titles',
											'oldID' => $oldTitle->award_id,
											'oldMID' => $kid,
											'newID' => $titleCheck->id
									]);
									$transTitles[$oldTitle->award_id][$kid] = $titleCheck->id;
								}
								unset($oldTitles[$otID]);
								$bar->advance();
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
								DB::table('trans')->insert([
										'array' => 'titles',
										'oldID' => $oldTitle->award_id,
										'oldMID' => $kid,
										'newID' => $titleId
								]);
								$transTitles[$oldTitle->award_id][$kid] = $titleId;
							}
							unset($oldTitles[$otID]);
							$bar->advance();
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
								while(!array_key_exists($kid, $transKingdoms)){
									$this->info('waiting for kingdom ' . $kid);
									sleep(5);
									$transKingdoms = $this->getTrans('kingdoms');
								}
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
									DB::table('trans')->insert([
											'array' => 'titles',
											'oldID' => $foundTitle->award_id,
											'oldMID' => $kid,
											'newID' => $titleId
									]);
									$transTitles[$foundTitle->award_id][$kid] = $titleId;
									unset($oldTitles[$foundOtID]);
								}
								
								//translate the fem into this one
								if($title === 'Lord'){
									foreach($oldTitles as $otID => $ot){
										if($ot->name === 'Lady'){
											DB::table('trans')->insert([
													'array' => 'titles',
													'oldID' => $ot->award_id,
													'oldMID' => $kid,
													'newID' => $titleId
											]);
											$transTitles[$ot->award_id][$kid] = $titleId;
											unset($oldTitles[$otID]);
											break;
										}
									}
								}else if($title === 'Baron'){
									foreach($oldTitles as $otID => $ot){
										if($ot->name === 'Baroness'){
											DB::table('trans')->insert([
													'array' => 'titles',
													'oldID' => $ot->award_id,
													'oldMID' => $kid,
													'newID' => $titleId
											]);
											$transTitles[$ot->award_id][$kid] = $titleId;
											unset($oldTitles[$otID]);
											break;
										}
									}
								}else if($title === 'Baronet'){
									foreach($oldTitles as $otID => $ot){
										if($ot->name === 'Baronetess'){
											DB::table('trans')->insert([
													'array' => 'titles',
													'oldID' => $ot->award_id,
													'oldMID' => $kid,
													'newID' => $titleId
											]);
											$transTitles[$ot->award_id][$kid] = $titleId;
											unset($oldTitles[$otID]);
											break;
										}
									}
								}else if($title === 'Count'){
									foreach($oldTitles as $otID => $ot){
										if($ot->name === 'Countess'){
											DB::table('trans')->insert([
													'array' => 'titles',
													'oldID' => $ot->award_id,
													'oldMID' => $kid,
													'newID' => $titleId
											]);
											$transTitles[$ot->award_id][$kid] = $titleId;
											unset($oldTitles[$otID]);
											break;
										}
									}
								}else if($title === 'Duke'){
									foreach($oldTitles as $otID => $ot){
										if($ot->name === 'Duchess'){
											DB::table('trans')->insert([
													'array' => 'titles',
													'oldID' => $ot->award_id,
													'oldMID' => $kid,
													'newID' => $titleId
											]);
											$transTitles[$ot->award_id][$kid] = $titleId;
											unset($oldTitles[$otID]);
											break;
										}
									}
								}else if($title === 'Archduke'){
									foreach($oldTitles as $otID => $ot){
										if($ot->name === 'Archduchess'){
											DB::table('trans')->insert([
													'array' => 'titles',
													'oldID' => $ot->award_id,
													'oldMID' => $kid,
													'newID' => $titleId
											]);
											$transTitles[$ot->award_id][$kid] = $titleId;
											unset($oldTitles[$otID]);
											break;
										}
									}
								}else if($title === 'Grand Duke'){
									foreach($oldTitles as $otID => $ot){
										if($ot->name === 'Grand Duchess'){
											DB::table('trans')->insert([
													'array' => 'titles',
													'oldID' => $ot->award_id,
													'oldMID' => $kid,
													'newID' => $titleId
											]);
											$transTitles[$ot->award_id][$kid] = $titleId;
											unset($oldTitles[$otID]);
											break;
										}
									}
								}else if($title === 'Marquis'){
									foreach($oldTitles as $otID => $ot){
										if($ot->name === 'Marquess'){
											DB::table('trans')->insert([
													'array' => 'titles',
													'oldID' => $ot->award_id,
													'oldMID' => $kid,
													'newID' => $titleId
											]);
											$transTitles[$ot->award_id][$kid] = $titleId;
											unset($oldTitles[$otID]);
											break;
										}
									}
								}else if($title === 'Viscount'){
									foreach($oldTitles as $otID => $ot){
										if($ot->name === 'Viscountess'){
											DB::table('trans')->insert([
													'array' => 'titles',
													'oldID' => $ot->award_id,
													'oldMID' => $kid,
													'newID' => $titleId
											]);
											$transTitles[$ot->award_id][$kid] = $titleId;
											unset($oldTitles[$otID]);
											break;
										}
									}
								}else if($title === 'Grand Marquis'){
									foreach($oldTitles as $otID => $ot){
										if($ot->name === 'Grand Marquess'){
											DB::table('trans')->insert([
													'array' => 'titles',
													'oldID' => $ot->award_id,
													'oldMID' => $kid,
													'newID' => $titleId
											]);
											$transTitles[$ot->award_id][$kid] = $titleId;
											unset($oldTitles[$otID]);
											break;
										}
									}
								}
								$bar->advance();
							}
						}
					}
					
					//whatever is left
					foreach ($oldTitles as $oldTitle) {
						$cleanName = trim($oldTitle->name);
						//the titles that aren't expressly defined in the RoP need to be put into the trans array
						if(!in_array($oldTitle->award_id, $ropTitles)){
							foreach($knownTitles[$cleanName] as $kid => $info){
								while(!array_key_exists($kid, $transKingdoms)){
									$this->info('waiting for kingdom ' . $kid);
									sleep(5);
									$transKingdoms = $this->getTrans('kingdoms');
								}
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
									DB::table('trans')->insert([
											'array' => 'titles',
											'oldID' => $oldTitle->award_id,
											'oldMID' => $kid,
											'newID' => $titleId
									]);
									$transTitles[$oldTitle->award_id][$kid] = $titleId;
								}
							}
							$bar->advance();
							continue;
						}
					}
					break;
				case 'CustomTitles':
					$this->info('Importing Custom Titles...');
					$transKingdoms = $this->getTrans('kingdoms');
					$transChapters = $this->getTrans('chapters');
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
					$bar = $this->output->createProgressBar(count($oldCustomTitles));
					$bar->start();
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
						
						while(!array_key_exists($oldCustomTitle->kingdom_id, $transKingdoms)){
							$this->info('waiting for kingdom ' . $oldCustomTitle->kingdom_id);
							sleep(5);
							$transKingdoms = $this->getTrans('kingdoms');
						}
						
						while(!array_key_exists(907, $transChapters)){
							$this->info('waiting for chapter 907');
							sleep(5);
							$transChapters = $this->getTrans('chapters');
						}
						
						//check to see if this one exists yet
						$titleExists = Title::where('name', $nameClean)->orWhere('name', 'LIKE', $nameClean . '|%')->orWhere('name', 'LIKE', '%|' . $nameClean)->where(function($query) use(&$oldCustomTitle, &$transKingdoms){
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
							}else if($nameClean === 'Esquire'){
								$peerage = 'Gentry';
							}else{
								$peerage = 'None';
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
						}
						DB::table('trans')->insert([
								'array' => 'kingdomawardsprocessed',
								'oldID' => $oldCustomTitle->kingdomaward_id,
								'newID' => $customTitleId ? $customTitleId : $titleExists->id
						]);
						$kingdomawardsProcessed[(int)$oldCustomTitle->kingdomaward_id] = $customTitleId ? $customTitleId : $titleExists->id;
						$bar->advance();
					}
					break;
				case 'Offices':
					$this->info('Creating Offices...');
					$count = 0;
					$transKingdoms = $this->getTrans('kingdoms');
					foreach($knownKingdomChaptertypesOffices as $d){
						$count = $count + array_sum(array_map("count", $d));
					}
					$bar = $this->output->createProgressBar($count);
					$bar->start();
					//create from known offices (that was a lot of corpora reading I just did)
					foreach($knownKingdomChaptertypesOffices as $kid => $knownKingdomChaptertypesOffice){
						foreach($knownKingdomChaptertypesOffice as $chaptertype => $offices){
							while(!array_key_exists($kid, $transKingdoms)){
								$this->info('waiting for kingdom ' . $kid);
								sleep(5);
								$transKingdoms = $this->getTrans('kingdoms');
							}
							$officeableType = $chaptertype != 'Kingdom' ? 'Chaptertype' : 'Kingdom';
							$officeableID = $officeableType === 'Kingdom' ? $transKingdoms[$kid] : null;
							if(!$officeableID){
								$chaptertypeArray = Chaptertype::where('kingdom_id', $transKingdoms[$kid])->where('name', $chaptertype)->first();
								while(!$chaptertypeArray){
									$this->info('waiting for chaptertype ' . $chaptertype);
									sleep(5);
									$chaptertypeArray = Chaptertype::where('kingdom_id', $transKingdoms[$kid])->where('name', $chaptertype)->first();
								}
								$officeableID = $chaptertypeArray->id;
							}
							foreach($offices as $office => $officeData){
								DB::table('offices')->insert([
										'officeable_type' => $officeableType,
										'officeable_id' => $officeableID,
										'name' => $office,
										'duration' => $officeData['duration'],
										'order' => array_key_exists('order', $officeData) ? $officeData['order'] : null
								]);
								$bar->advance();
							}
						}
					}
					break;
				case 'Pronouns':
					$this->info('Importing Pronouns...');
					$oldPronouns = $backupConnect->table('ork_pronoun')->get()->toArray();
					$bar = $this->output->createProgressBar(count($oldPronouns));
					$bar->start();
					foreach ($oldPronouns as $oldPronoun) {
						DB::table('pronouns')->insert([
								'subject' => $oldPronoun->subject,
								'object' => $oldPronoun->object,
								'possessive' => $oldPronoun->possessive,
								'possessivepronoun' => $oldPronoun->possessivepronoun,
								'reflexive' => $oldPronoun->reflexive
						]);
						$bar->advance();
					}
					break;
				case 'Personas':
					$this->info('Importing Users/Personas/Memberships/Suspensions/Waivers...');
					$usedEmails = [];
					$suspensionsWaitList = [];
					$transUsers = [];
					$transPersonas = [];
					$deadRecords = [];
					$transUnits = $this->getTrans('units');
					$transChapters = $this->getTrans('chapters');
					$transKingdoms = $this->getTrans('kingdoms');
					$bar = $this->output->createProgressBar($backupConnect->table('ork_mundane')->count());
					$bar->start();
					$backupConnect->table('ork_mundane')->orderBy('mundane_id')->chunk(100, function ($oldUsers) use (&$usedEmails, $backupConnect, &$suspensionsWaitList, &$transUsers, &$transPersonas, &$deadRecords, &$bar, &$transUnits, &$transChapters, &$transKingdoms, &$oldUnits){
						foreach($oldUsers as $oldUser) {
							$pronounId = null;
							$userId = null;
							//user data
							if(filter_var($oldUser->email, FILTER_VALIDATE_EMAIL)){
								if(!in_array(strtolower($oldUser->email), $usedEmails)){
									$userId = DB::table('users')->insertGetId([
											'email' => strtolower($oldUser->email),
											'email_verified_at' => null,
											'password' => bin2hex(openssl_random_pseudo_bytes(4)),
											'remember_token' => null,
											'is_restricted' => $oldUser->restricted === '1' ? 1 : 0,
											'created_at' => $oldUser->modified,
											'updated_at' => $oldUser->modified
									]);
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
										$roleExists = Role::findByName('admin')->get();
										while(!$roleExists){
											$this->info('waiting for role admin');
											sleep(5);
											$roleExists = Role::findByName('admin')->get();
										}
										$user->assignRole('admin');
									}else if(count($offices) > 0){
										$roleExists = Role::findByName('officer')->get();
										while(!$roleExists){
											$this->info('waiting for role officer');
											sleep(5);
											$roleExists = Role::findByName('officer')->get();
										}
										$user->assignRole('officer');
									}else{
										$roleExists = Role::findByName('player')->get();
										while(!$roleExists){
											$this->info('waiting for role player');
											sleep(5);
											$roleExists = Role::findByName('player')->get();
										}
										$user->assignRole('player');
									}
									$usedEmails[] = strtolower($oldUser->email);
									DB::table('trans')->insert([
											'array' => 'users',
											'oldID' => $oldUser->mundane_id,
											'newID' => $userId
									]);
									$transUsers[$oldUser->mundane_id] = $userId;
								}else{
									$deadRecords['Users'][$oldUser->mundane_id] = 'Duplicate Email';
								}
							}
							
							if($oldUser->pronoun_id < 1){
								$detector = new \GenderDetector\GenderDetector();
								$gender = $detector->getGender(trim($oldUser->given_name), 'US');
								//TODO: check me
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
							$personaName = $this->cleanPersona($oldUser->persona, trim($oldUser->given_name) . ' ' . trim($oldUser->surname));
							$personaName = $this->stripTitles($personaName);
							
							//wait for the chapter to exist
							while(!array_key_exists($oldUser->park_id, $transChapters)){
								$this->info('waiting for chapter ' . $oldUser->park_id);
								sleep(5);
								$transChapters = $this->getTrans('chapters');
							}
							
							//persona data
							$personaId = DB::table('personas')->insertGetId([
									'chapter_id' => $oldUser->park_id == 0 ? 317 : $transChapters[$oldUser->park_id],
									'user_id' => $userId,
									'pronoun_id' => $pronounId,
									'mundane' => trim($oldUser->given_name) != '' || trim($oldUser->surname) != '' ? str_ireplace('zzz', '', trim($oldUser->given_name)) . ' ' . str_ireplace('zzz', '', trim($oldUser->surname)) : null,
									'name' => $personaName,
									'heraldry' => $oldUser->has_heraldry === '1' ? sprintf('%06d.jpg', $oldUser->mundane_id) : null,
									'image' => $oldUser->has_image === '1' ? sprintf('%06d.jpg', $oldUser->mundane_id) : null,
									'is_active' => $oldUser->active === '1' ? 1 : 0,
									'reeve_qualified_expires_at' => $oldUser->reeve_qualified != 1 ? null : ($oldUser->reeve_qualified_until === '0000-00-00' ? date('Y-m-d', strtotime('+20 years')) : $oldUser->reeve_qualified_until),
									'corpora_qualified_expires_at' => $oldUser->corpora_qualified != 1 ? null : ($oldUser->corpora_qualified_until === '0000-00-00' ? date('Y-m-d', strtotime('+20 years')) : $oldUser->corpora_qualified_until),
									'joined_chapter_at' => $oldUser->park_member_since === '0000-00-00' ? null : $oldUser->park_member_since,
									'created_at' => $oldUser->modified,
									'updated_at' => $oldUser->modified
							]);
							DB::table('trans')->insert([
									'array' => 'personas',
									'oldID' => $oldUser->mundane_id,
									'newID' => $personaId
							]);
							$transPersonas[$oldUser->mundane_id] = $personaId;
							
							//unit membership data
							if ($oldUser->company_id > 0) {
								if (array_key_exists($oldUser->company_id, $oldUnits)) {
									//wait for the unit to exist
									while(!array_key_exists($oldUser->park_id, $transUnits)){
										$this->info('waiting for park ' . $oldUser->park_id);
										sleep(5);
										$transUnits = $this->getTrans('units');
									}
									DB::table('members')->insert([
											'unit_id' => $transUnits[$oldUser->company_id],
											'persona_id' => $personaId,
											'joined_at' => null,
											'left_at' => null,
											'is_head' => 0,
											'is_voting' => 1
									]);
								}else{
									$deadRecords['Units'][$oldUser->company_id] = 'Deleted';
								}
							}
							
							while(!array_key_exists($oldUser->kingdom_id, $transKingdoms)){
								$this->info('waiting for kingdom ' . $oldUser->kingdom_id);
								sleep(5);
								$transKingdoms = $this->getTrans('kingdoms');
							}
							
							//suspensions data
							if($oldUser->suspended > 0){
								if (!$oldUser->suspended_by_id || array_key_exists($oldUser->suspended_by_id, $transPersonas)) {
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
								}else{
									$suspensionsWaitList[] = $oldUser;
								}
							}else{
								if($oldUser->penalty_box === '1'){
									$deadRecords['PenaltyBox'][$oldUser->mundane_id] = $oldUser;
								}
							}
							
							//waiver data
							if($oldUser->waivered > 0 && trim($oldUser->given_name) != '' && trim($oldUser->surname) != ''){
								DB::table('waivers')->insertGetId([
										'pronoun_id' => $pronounId,
										'persona_id' => $personaId,
										'waiverable_type' => 'Kingdom',
										'waiverable_id' => $transKingdoms[$oldUser->kingdom_id],
										'file' => $oldUser->waiver_ext != '' ? sprintf('%06d.' . $oldUser->waiver_ext, $oldUser->mundane_id) : null,
										'player' => $this->cleanMundane($oldUser->given_name . ' ' . $oldUser->surname),
										'email' => filter_var($oldUser->email, FILTER_VALIDATE_EMAIL) ? strtolower($oldUser->email) : null,
										'phone' => null,
										'location_id' => null,
										'dob' => null,
										'age_verified_at' => null,
										'age_verified_by' => null,
										'guardian' => null,
										'emergency_name' => null,
										'emergency_relationship' => null,
										'emergency_phone' => null,
										'signed_at' => $oldUser->park_member_since != '' && $oldUser->park_member_since != '0000-00-00' ? $oldUser->park_member_since : $oldUser->modified,
										'created_at' => $oldUser->park_member_since != '' && $oldUser->park_member_since != '0000-00-00' ? $oldUser->park_member_since : $oldUser->modified,
										'updated_at' => $oldUser->park_member_since != '' && $oldUser->park_member_since != '0000-00-00' ? $oldUser->park_member_since : $oldUser->modified
								]);
							}
							$bar->advance();
						}
					});
					
					if(count($suspensionsWaitList) > 0){
						$this->info('Finishing Up Suspensions...');
						$bar = $this->output->createProgressBar(count($suspensionsWaitList));
						$bar->start();
						foreach($suspensionsWaitList as $oldUser){
							while(!array_key_exists($oldUser->kingdom_id, $transKingdoms)){
								$this->info('waiting for kingdom ' . $oldUser->kingdom_id);
								sleep(5);
								$transKingdoms = $this->getTrans('kingdoms');
							}
							DB::table('suspensions')->insertGetId([
									'persona_id' => $transPersonas[$oldUser->mundane_id],
									'kingdom_id' => $transKingdoms[$oldUser->kingdom_id],
									'suspended_by' => $oldUser->suspended_by_id ? (array_key_exists($oldUser->suspended_by_id, $transPersonas) ? $transPersonas[$oldUser->suspended_by_id] : 1) : 1,
									'suspended_at' => !$oldUser->suspended_at || $oldUser->suspended_at === '0000-00-00' ? $oldUser->modified : $oldUser->suspended_at,
									'expires_at' => $oldUser->suspended_until && $oldUser->suspended_until > date('Y-m-d', strtotime('+5 years')) ? null : $oldUser->suspended_until,
									'is_propogating' => stripos($oldUser->suspension, 'COC') > -1 || stripos($oldUser->suspension, 'Code of Conduct') > -1 || stripos($oldUser->suspension, 'Registe') > -1 || (stripos($oldUser->suspension, 'Prop') > -1 && stripos($oldUser->suspension, ' not ') < 1 ) || stripos($oldUser->suspension, 'inter') > -1 || stripos($oldUser->suspension, 'triggers') > -1 || stripos($oldUser->suspension, 'applies') > -1 || stripos($oldUser->suspension, 'spans') > -1 ? 1 : 0,
									'cause' => $oldUser->suspension && $oldUser->suspension != '' ? $oldUser->suspension : 'Unknown',
									'created_at' => !$oldUser->suspended_at || $oldUser->suspended_at === '0000-00-00' ? $oldUser->modified : $oldUser->suspended_at,
									'updated_at' => !$oldUser->suspended_at || $oldUser->suspended_at === '0000-00-00' ? $oldUser->modified : $oldUser->suspended_at
							]);
							$bar->advance();
						}
					}
					break;
				case 'Events':
					$this->info('Importing Events/Crats...');
					$transEvents = [];
					$transEventDetails = [];
					$transKingdoms = $this->getTrans('kingdoms');
					$transChapters = $this->getTrans('chapters');
					$transPersonas = $this->getTrans('personas');
					$transUnits = $this->getTrans('units');
					$oldEvents = $backupConnect->table('ork_event_calendardetail')
						->join('ork_event', 'ork_event_calendardetail.event_id', '=', 'ork_event.event_id')
						->select('ork_event_calendardetail.*', 'ork_event.*', 'ork_event.modified as modified_1', 'ork_event_calendardetail.modified as modified_2')
						->get()->toArray();
					$bar = $this->output->createProgressBar(count($oldEvents));
					$bar->start();
					$burningLands = Chapter::where('name', 'Burning Lands')->first();
					foreach ($oldEvents as $oldEvent) {
						$locationID = null;
						$eventable_type = $oldEvent->unit_id > 0 ? 'Unit' : ($oldEvent->mundane_id > 0 && ($oldEvent->kingdom_id == 0 && $oldEvent->park_id == 0) ? 'Persona' : ($oldEvent->park_id > 0 && $oldEvent->kingdom_id == 0 ? 'Chapter' : 'Kingdom'));
						if($oldEvent->kingdom_id && $oldEvent->kingdom_id != 0 && array_key_exists($oldEvent->kingdom_id, $knownKingdomChaptertypesOffices)){
							while(!array_key_exists($oldEvent->kingdom_id, $transKingdoms)){
								$this->info('waiting for kingdom ' . $oldEvent->kingdom_id);
								sleep(5);
								$transKingdoms = $this->getTrans('kingdoms');
							}
						}
						if($oldEvent->kingdom_id && $oldEvent->kingdom_id != 0 && !array_key_exists($oldEvent->kingdom_id, $transKingdoms)){
							$kingdomId = DB::table('kingdoms')->insertGetId([
									'parent_id' => null,
									'name' => 'Deleted Kingdom ' . $oldEvent->kingdom_id,
									'abbreviation' => 'DK' . $oldEvent->kingdom_id,
									'heraldry' => null,
									'is_active' => 0
							]);
							DB::table('trans')->insert([
									'array' => 'kingdoms',
									'oldID' => $oldEvent->kingdom_id,
									'newID' => $kingdomId
							]);
							$transKingdoms[$oldEvent->kingdom_id] = $kingdomId;
						}
						if($oldEvent->mundane_id && $oldEvent->mundane_id != 0){
							while(!array_key_exists($oldEvent->park_id, $transChapters)){
								$this->info('waiting for chapter ' . $oldEvent->park_id);
								sleep(5);
								$transChapters = $this->getTrans('chapters');
							}
							//check old mundanes for existence
							$mundaneCheck = $backupConnect->table('ork_mundane')->where('mundane_id', $oldEvent->mundane_id)->first();
							if($mundaneCheck){
								if(!array_key_exists($oldEvent->mundane_id, $transPersonas)){
									while(!array_key_exists($oldEvent->mundane_id, $transPersonas)){
										$this->info('waiting for persona ' . $oldEvent->mundane_id);
										sleep(5);
										$transPersonas = $this->getTrans('personas');
									}
								}
							}else{
								$personaId = DB::table('personas')->insertGetId([
									'chapter_id' => $oldEvent->park_id == 0 ? $burningLands->id : $transChapters[$oldEvent->park_id],
									'user_id' => null,
									'pronoun_id' => null,
									'mundane' => null,
									'name' => 'Deleted Persona ' . $oldEvent->mundane_id,
									'heraldry' => null,
									'image' => null,
									'is_active' => 0
								]);
								DB::table('trans')->insert([
									'array' => 'personas',
									'oldID' => $oldEvent->mundane_id,
									'newID' => $personaId
								]);
								$transPersonas[$oldEvent->mundane_id] = $personaId;
							}
						}
						switch($eventable_type){
							case 'Unit':
								while(!array_key_exists($oldEvent->unit_id, $transUnits)){
									$this->info('waiting for unit ' . $oldEvent->unit_id);
									sleep(5);
									$transUnits = $this->getTrans('units');
								}
								$eventable_id = $transUnits[$oldEvent->unit_id];
								break;
							case 'Persona':
								while(!array_key_exists($oldEvent->mundane_id, $transPersonas)){
									$this->info('waiting for persona ' . $oldEvent->mundane_id);
									sleep(5);
									$transPersonas = $this->getTrans('personas');
								}
								$eventable_id = $transPersonas[$oldEvent->mundane_id];
								break;
							case 'Chapter':
								while(!array_key_exists($oldEvent->park_id, $transChapters)){
									$this->info('waiting for chapter ' . $oldEvent->park_id);
									sleep(5);
									$transChapters = $this->getTrans('chapters');
								}
								$eventable_id = $transChapters[$oldEvent->park_id];
								break;
							case 'Kingdom':
								while(!array_key_exists($oldEvent->kingdom_id, $transKingdoms)){
									$this->info('waiting for kingdom ' . $oldEvent->kingdom_id);
									sleep(5);
									$transKingdoms = $this->getTrans('kingdoms');
								}
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
										'country' => $this->getCountryCode((string) substr($oldEvent->address, strrpos("/$oldEvent->address", ', ') + 1), $countries),
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
								'description' => trim($oldEvent->description) != '' ? trim($oldEvent->description) : null,
								'is_active' => $oldEvent->current,
								'image' => $oldEvent->has_heraldry === '1' ? sprintf('%05d.jpg', $oldEvent->event_id) : null,
								'event_start' => $oldEvent->event_start > '0001-01-01 00:00:01' ? $oldEvent->event_start : min($oldEvent->modified_1, $oldEvent->modified_2),
								'event_end' => $oldEvent->event_end > '0001-01-01 00:00:01' ? $oldEvent->event_end : max($oldEvent->modified_1, $oldEvent->modified_2),
								'price' => $oldEvent->price,
								'created_at' => min($oldEvent->modified_1, $oldEvent->modified_2),
								'updated_at' => max($oldEvent->modified_1, $oldEvent->modified_2)
						]);
						$url = $this->cleanURL($oldEvent->url);
						if($url){
							DB::table('socials')->insert([
									'sociable_type' => 'Event',
									'sociable_id' => $eventId,
									'media' => 'Web',
									'value' => $url
							]);
						}
						if($oldEvent->mundane_id != 0){
							//make the crat
							while(!array_key_exists($oldEvent->mundane_id, $transPersonas)){
								$this->info('waiting for persona ' . $oldEvent->mundane_id);
								sleep(5);
								$transPersonas = $this->getTrans('personas');
							}
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
						DB::table('trans')->insert([
								'array' => 'events',
								'oldID' => $oldEvent->event_id,
								'newID' => $eventId
						]);
						$transEvents[$oldEvent->event_id] = $eventId;
						DB::table('trans')->insert([
								'array' => 'eventdetails',
								'oldID' => $oldEvent->event_calendardetail_id,
								'newID' => $eventId
						]);
						$transEventDetails[$oldEvent->event_calendardetail_id] = $eventId;
						$bar->advance();
					}
					break;
				case 'Accounts':
					$this->info('Importing Accounts...');
					$transAccounts = [];
					$transKingdoms = $this->getTrans('kingdoms');
					$transChapters = $this->getTrans('chapters');
					$transEvents = $this->getTrans('events');
					$transUnits = $this->getTrans('units');
					$oldAccounts = $backupConnect->table('ork_account')->orderBy('account_id')->get()->toArray();
					$bar = $this->output->createProgressBar(count($oldAccounts));
					$bar->start();
					foreach ($oldAccounts as $oldAccount) {
						$accountable_type = $oldAccount->unit_id > 0 ? 'Unit' : ($oldAccount->event_id > 0 ? 'Event' : ($oldAccount->park_id > 0 ? 'Chapter' : 'Kingdom'));
						switch($accountable_type){
							case 'Unit':
								while(!array_key_exists($oldAccount->unit_id, $transUnits)){
									$this->info('waiting for unit ' . $oldAccount->unit_id);
									sleep(5);
									$transUnits = $this->getTrans('units');
								}
								$accountable_id = $transUnits[$oldAccount->unit_id];
								break;
							case 'Event':
								while(!array_key_exists($oldAccount->event_id, $transEvents)){
									$this->info('waiting for event ' . $oldAccount->event_id);
									sleep(5);
									$transEvents = $this->getTrans('events');
								}
								$accountable_id = $transEvents[$oldAccount->event_id];
								break;
							case 'Chapter':
								while(!array_key_exists($oldAccount->park_id, $transChapters)){
									$this->info('waiting for chapter ' . $oldAccount->park_id);
									sleep(5);
									$transChapters = $this->getTrans('chapters');
								}
								$accountable_id = $transChapters[$oldAccount->park_id];
								break;
							case 'Kingdom':
								while(!array_key_exists($oldAccount->kingdom_id, $transKingdoms)){
									$this->info('waiting for kingdom ' . $oldAccount->kingdom_id);
									sleep(5);
									$transKingdoms = $this->getTrans('kingdoms');
								}
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
						DB::table('trans')->insert([
								'array' => 'accounts',
								'oldID' => $oldAccount->account_id,
								'newID' => $accountId
						]);
						$transAccounts[$oldAccount->account_id] = $accountId;
						$bar->advance();
					}
					break;
				case 'Meetups':
					$this->info('Importing Meetups...');
					$transChapters = $this->getTrans('chapters');
					$oldMeetups = $backupConnect->table('ork_parkday')->get()->toArray();
					$bar = $this->output->createProgressBar(count($oldMeetups));
					$bar->start();
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
									'country' => $this->getCountryCode((string) substr($oldMeetup->address, strrpos("/$oldMeetup->address", ', ') + 1), $countries),
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
						while(!array_key_exists($oldMeetup->park_id, $transChapters)){
							$this->info('waiting for chapter ' . $oldMeetup->park_id);
							sleep(5);
							$transChapters = $this->getTrans('chapters');
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
							DB::table('meetups')->insert([
									'chapter_id' => $transChapters[$oldMeetup->park_id],
									'location_id' => $locationID,
									'alt_location_id' => null,
									'recurrence' => $meetupMap[$oldMeetup->recurrence],
									'week_of_month' => $oldMeetup->week_of_month > 0 ? $oldMeetup->week_of_month : null,
									'week_day' => $oldMeetup->week_day,
									'month_day' => $oldMeetup->month_day > 0 ? $oldMeetup->month_day : null,
									'occurs_at' => $oldMeetup->time,
									'purpose' => $meetupMap[$oldMeetup->purpose],
									'description' => trim($oldMeetup->description) != '' ? trim($oldMeetup->description) : null
							]);
						}
						$bar->advance();
					}
					break;
				case 'Attendances':
					$this->info('Importing Attendances...');
					$oldKingdoms = $backupConnect->table('ork_kingdom')->get()->toArray();
					$oldChapters = $backupConnect->table('ork_park')->get()->toArray();
					$oldPersonas = $backupConnect->table('ork_mundane')->get()->toArray();
					$transKingdoms = $this->getTrans('kingdoms');
					$transChapters = $this->getTrans('chapters');
					$transPersonas = $this->getTrans('personas');
					$transUnits = $this->getTrans('units');
					$transEvents = $this->getTrans('events');
					$transEventDetails = $this->getTrans('eventsdetails');
					$transUsers = $this->getTrans('users');
					$backupConnect->table('ork_attendance')->orderBy('mundane_id')->chunk(100, function ($oldAttendances) use (&$transPersonas, &$transEvents, &$transUnits, &$transKingdoms, &$transEventDetails, &$transChapters, &$transUsers, &$deadRecords, &$oldKingdoms, &$oldChapters, &$oldPersonas, $backupConnect, &$transArchetypes){
						$meetups = null;
						$meetupId = null;
						$bar = $this->output->createProgressBar(count($oldAttendances));
						$bar->start();
						foreach ($oldAttendances as $oldAttendance) {
							$locationID = null;
							//work out archetype stuff
							$archetypeId = null;
							if($oldAttendance->flavor != ''){
								$flavorClean = $oldAttendance->flavor === 'Newbie' ? 'Undeclared' : trim($oldAttendance->flavor);
								$archetype = Archetype::where('name', $flavorClean)->first();
								if(!$archetype){
									$archetypeId = DB::table('archetypes')->insertGetId([
											'name' => $flavorClean,
											'is_active' => $flavorClean === 'Undeclared' ? 1 : 0
									]);
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
									$bar->advance();
									continue;
								}else{
									//figure out if it's somebody
									if(strpos($oldAttendance->note, '--') > -1){
										$pairing = explode('--', $oldAttendance->note);
										$fromKingdomOldID = array_search($pairing[0], array_column($oldKingdoms, 'abbreviation'));
										$fromChapters = array_keys(array_column($oldChapters, 'abbreviation'), $pairing[1]);
										$fromChapterOldID = array_search($fromKingdomOldID, array_column($fromChapters, 'kingdom_id'));
										$fromChapter = null;
										if($fromChapterOldID){
											while(!array_key_exists($fromChapterOldID, $transChapters)){
												$this->info('waiting for chapter ' . $fromChapterOldID);
												sleep(5);
												$transChapters = $this->getTrans('chapters');
											}
											$fromChapter = $transChapters[$fromChapterOldID];
										}
									}else if(strpos($oldAttendance->note, '-') > -1){
										$pairing = explode('-', $oldAttendance->note);
										$fromKingdomOldID = array_search($pairing[0], array_column($oldKingdoms, 'abbreviation'));
										$fromChapters = array_keys(array_column($oldChapters, 'abbreviation'), $pairing[1]);
										$fromChapterOldID = array_search($fromKingdomOldID, array_column($fromChapters, 'kingdom_id'));
										$fromChapter = null;
										if($fromChapterOldID){
											while(!array_key_exists($fromChapterOldID, $transChapters)){
												$this->info('waiting for chapter ' . $fromChapterOldID);
												sleep(5);
												$transChapters = $this->getTrans('chapters');
											}
											$fromChapter = $transChapters[$fromChapterOldID];
										}
									}else if(strpos($oldAttendance->note, '/') > -1){
										$pairing = explode('/', $oldAttendance->note);
										$fromKingdomOldID = array_search($pairing[0], array_column($oldKingdoms, 'abbreviation'));
										$fromChapters = array_keys(array_column($oldChapters, 'abbreviation'), $pairing[1]);
										$fromChapterOldID = array_search($fromKingdomOldID, array_column($fromChapters, 'kingdom_id'));
										$fromChapter = null;
										if($fromChapterOldID){
											while(!array_key_exists($fromChapterOldID, $transChapters)){
												$this->info('waiting for chapter ' . $fromChapterOldID);
												sleep(5);
												$transChapters = $this->getTrans('chapters');
											}
											$fromChapter = $transChapters[$fromChapterOldID];
										}
									}else if(strpos($oldAttendance->note, ':') > -1){
										$pairing = explode(':', $oldAttendance->note);
										$fromKingdomOldID = array_search($pairing[0], array_column($oldKingdoms, 'abbreviation'));
										$fromChapters = array_keys(array_column($oldChapters, 'abbreviation'), $pairing[1]);
										$fromChapterOldID = array_search($fromKingdomOldID, array_column($fromChapters, 'kingdom_id'));
										$fromChapter = null;
										if($fromChapterOldID){
											while(!array_key_exists($fromChapterOldID, $transChapters)){
												$this->info('waiting for chapter ' . $fromChapterOldID);
												sleep(5);
												$transChapters = $this->getTrans('chapters');
											}
											$fromChapter = $transChapters[$fromChapterOldID];
										}
									}else{
										$fromChapterOldID = array_search($oldAttendance->note, array_column($oldChapters, 'name')) ? array_search($oldAttendance->note, array_column($oldChapters, 'name')) : 
										(
												array_search(str_replace('.', '', $oldAttendance->note), array_column($oldChapters, 'abbreviation')) ? array_search(str_replace('.', '', $oldAttendance->note), array_column($oldChapters, 'abbreviation')) :
												null
										);
										$fromChapter = null;
										if($fromChapterOldID){
											while(!array_key_exists($fromChapterOldID, $transChapters)){
												$this->info('waiting for chapter ' . $fromChapterOldID);
												sleep(5);
												$transChapters = $this->getTrans('chapters');
											}
											$fromChapter = $transChapters[$fromChapterOldID];
										}
									}
									if($fromChapter && trim($oldAttendance->persona)){
										$persona = $backupConnect->table('ork_mundane')->where('name', 'LIKE', '%' . $oldAttendance->persona . '%')->where('chapter_id', $fromChapterOldID)->first();
										while(!array_key_exists($persona->id, $transPersonas)){
											$this->info('waiting for persona ' . $persona->id);
											sleep(5);
											$transPersonas = $this->getTrans('personas');
										}
										$personaID = $persona ? $transPersonas[$persona->id] : null;
									}else{
										$deadRecords['HeadlessAttendances'][$oldAttendance->attendance_id] = $oldAttendance;
										$bar->advance();
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
										DB::table('trans')->insert([
												'array' => 'personas',
												'oldID' => $oldAttendance->mundane_id,
												'newID' => $personaID
										]);
										$transPersonas[$oldAttendance->mundane_id] = $personaID;
									}
								}
							//get it
							}else{
								if(array_key_exists($oldAttendance->mundane_id, $oldPersonas)){
									while(!array_key_exists($oldAttendance->mundane_id, $transPersonas)){
										$this->info('waiting for persona ' . $oldAttendance->mundane_id);
										sleep(5);
										$transPersonas = $this->getTrans('personas');
									}
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
										$bar->advance();
										continue;
									}
									$personaID = DB::table('personas')->insertGetId([
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
									]);
									DB::table('trans')->insert([
											'array' => 'personas',
											'oldID' => $oldAttendance->mundane_id,
											'newID' => $personaID
									]);
									$transPersonas[$oldAttendance->mundane_id] = $personaID;
								}else{
									$personaID = $persona->id;
								}
							}
							
							//no park, kingdom, or event (ie, reconciliation)
							if($oldAttendance->park_id == 0 && $oldAttendance->kingdom_id == 0 && $oldAttendance->event_id == 0 && $oldAttendance->event_calendardetail_id == 0){
								DB::table('reconciliations')->insertGetId([
										'archetype_id' => $archetypeId,
										'persona_id' => $oldAttendance->mundane_id > 0 ? $transPersonas[$oldAttendance->mundane_id] : $personaID,
										'credits' => $oldAttendance->credits
								]);
								$deadRecords['AttendancesReconciled'][$oldAttendance->attendance_id] = $oldAttendance;
								//no event and no date (ie, reconciliation)
							}else if($oldAttendance->event_id == 0 && $oldAttendance->event_calendardetail_id == 0 && $oldAttendance->entered_at === '0000-00-00 00:00:00' && $oldAttendance->date === '0000-00-00'){
								DB::table('reconciliations')->insertGetId([
										'archetype_id' => $archetypeId,
										'persona_id' => $oldAttendance->mundane_id > 0 ? $transPersonas[$oldAttendance->mundane_id] : $personaID,
										'credits' => $oldAttendance->credits
								]);
								$deadRecords['AttendancesReconciled'][$oldAttendance->attendance_id] = $oldAttendance;
								//if the date is before Feb 01 1983, it's a reconciliation
							}else if($oldAttendance->date < '1983-02-01'){
								DB::table('reconciliations')->insertGetId([
										'archetype_id' => $archetypeId,
										'persona_id' => $oldAttendance->mundane_id > 0 ? $transPersonas[$oldAttendance->mundane_id] : $personaID,
										'credits' => $oldAttendance->credits
								]);
								$deadRecords['AttendancesReconciled'][$oldAttendance->attendance_id] = $oldAttendance;
								//if the date is missing the month or day, reconcile it
							}else if(strpos($oldAttendance->date, '-00') > -1){
								DB::table('reconciliations')->insertGetId([
										'archetype_id' => $archetypeId,
										'persona_id' => $oldAttendance->mundane_id > 0 ? $transPersonas[$oldAttendance->mundane_id] : $personaID,
										'credits' => $oldAttendance->credits
								]);
								$deadRecords['AttendancesReconciled'][$oldAttendance->attendance_id] = $oldAttendance;
								//if it's more than 2 credits and no event, it's a reconcilliation
							}else if($oldAttendance->credits > 2.9 && $oldAttendance->event_id == 0 && $oldAttendance->event_calendardetail_id == 0){
								DB::table('reconciliations')->insertGetId([
										'archetype_id' => $archetypeId,
										'persona_id' => $oldAttendance->mundane_id > 0 ? $transPersonas[$oldAttendance->mundane_id] : $personaID,
										'credits' => $oldAttendance->credits
								]);
								$deadRecords['AttendancesReconciled'][$oldAttendance->attendance_id] = $oldAttendance;
							}else{
								if($oldAttendance->event_id == 0 && $oldAttendance->event_calendardetail_id == 0){
									//is there a meetup?
									$meetups = $backupConnect->table('parkdays')->where('park_id', $oldAttendance->park_id)->get()->toArray();
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
										$meetupId = DB::table('meetups')->insertGetId([
												'chapter_id' => $transChapters[$oldAttendance->park_id],
												'location_id' => $locationID ? $locationID : null,
												'alt_location_id' => null,
												'recurrence' => 'Weekly',
												'week_of_month' => null,
												'week_day' => date('l', strtotime($oldAttendance->date)),
												'month_day' => null,
												'occurs_at' => '13:00:00',
												'purpose' => 'Park Day',
												'description' => 'This Meetup has been generated.  Please review it and correct as appropriate.'
										]);
									}
								//check to make sure the event exists
								}else if($oldAttendance->event_calendardetail_id != 0){
									while(!array_key_exists($oldAttendance->event_calendardetail_id, $transEventDetails)){
										$this->info('waiting for event ' . $oldAttendance->event_calendardetail_id);
										sleep(5);
										$transEventDetails = $this->getTrans('eventdetails');
									}
									if(!array_key_exists($oldAttendance->event_calendardetail_id, $transEventDetails)){
										//make it
										if($oldAttendance->event_id > 0){
											$parentEvent = $backupConnect->table('ork_event')->where('event_id', $oldAttendance->event_id)->first();
											$eventable_type = $parentEvent->unit_id > 0 ? 'Unit' : ($parentEvent->kingdom_id == 0 && $parentEvent->park_id == 0 ? 'Persona' : ($parentEvent->park_id > 0 && $parentEvent->kingdom_id == 0 ? 'Chapter' : 'Kingdom'));
											switch($eventable_type){
												case 'Unit':
													while(!array_key_exists($parentEvent->unit_id, $transUnits)){
														$this->info('waiting for unit ' . $parentEvent->unit_id);
														sleep(5);
														$transUnits = $this->getTrans('units');
													}
													$eventable_id = $transUnits[$parentEvent->unit_id];
													break;
												case 'Persona':
													while(!array_key_exists($parentEvent->mundane_id, $transPersonas)){
														$this->info('waiting for persona ' . $parentEvent->mundane_id);
														sleep(5);
														$transPersonas = $this->getTrans('personas');
													}
													$eventable_id = $transPersonas[$parentEvent->mundane_id];
													break;
												case 'Chapter':
													while(!array_key_exists($parentEvent->park_id, $transChapters)){
														$this->info('waiting for chapter ' . $parentEvent->park_id);
														sleep(5);
														$transChapters = $this->getTrans('chapters');
													}
													$eventable_id = $transChapters[$parentEvent->park_id];
													break;
												case 'Kingdom':
													while(!array_key_exists($parentEvent->kingdom_id, $transKingdoms)){
														$this->info('waiting for kingdom ' . $parentEvent->kingdom_id);
														sleep(5);
														$transKingdoms = $this->getTrans('kingdoms');
													}
													$eventable_id = $transKingdoms[$parentEvent->kingdom_id];
													break;
												default:
													$eventable_id = null;
													break;
											}
											$eventId = DB::table('events')->insertGetId([
													'eventable_type' => $eventable_type,
													'eventable_id' => $eventable_id,
													'location_id' => $locationID ? $locationID : null,
													'name' => trim($parentEvent->name),
													'description' => 'This event was generated from related records.  Please correct it.',
													'is_active' => 0,
													'image' => null,
													'event_start' => $oldAttendance->date,
													'event_end' => $oldAttendance->date,
													'price' => null
											]);
											DB::table('trans')->insert([
													'array' => 'events',
													'oldID' => $oldAttendance->event_id,
													'newID' => $eventId
											]);
											$transEvents[$oldAttendance->event_id] = $eventId;
											DB::table('trans')->insert([
													'array' => 'eventdetails',
													'oldID' => $oldAttendance->event_calendardetail_id,
													'newID' => $eventId
											]);
											$transEventDetails[$oldAttendance->event_calendardetail_id] = $eventId;
										}else{
											//deadrecords it since there's no event data
											$deadRecords['HeadlessAttendances'][$oldAttendance->attendance_id] = $oldAttendance;
										}
									}
								}
								//check by_whom
								if($oldAttendance->by_whom_id != 0){
									if(array_key_exists($oldAttendance->by_whom_id, $oldPersonas)){
										while(!array_key_exists($oldAttendance->by_whom_id, $transPersonas)){
											$this->info('waiting for persona ' . $oldAttendance->by_whom_id);
											sleep(5);
											$transPersonas = $this->getTrans('personas');
										}
										//if they need a user, we'll have to make one up
										if(!array_key_exists($oldAttendance->by_whom_id, $transUsers)){
											$userId = DB::table('users')->insertGetId([
													'email' => 'deletedUser' . $oldAttendance->by_whom_id . '@nowhere.net',
													'email_verified_at' => null,
													'password' => 'generated',
													'remember_token' => null,
													'is_restricted' => 1
											]);
											DB::table('trans')->insert([
													'array' => 'users',
													'oldID' => $oldAttendance->by_whom_id,
													'newID' => $userId
											]);
											$transUsers[$oldAttendance->by_whom_id] = $userId;
										}
										DB::table('personas')->where('id', $transPersonas[$oldAttendance->by_whom_id])->update([
												'user_id' => $userId
										]);
									}else{
										$userId = DB::table('users')->insertGetId([
												'email' => 'deletedUser' . $oldAttendance->by_whom_id . '@nowhere.net',
												'email_verified_at' => null,
												'password' => 'generated',
												'remember_token' => null,
												'is_restricted' => 1
										]);
										DB::table('trans')->insert([
												'array' => 'users',
												'oldID' => $oldAttendance->by_whom_id,
												'newID' => $userId
										]);
										$transUsers[$oldAttendance->by_whom_id] = $userId;
										$personaId = DB::table('personas')->insertGetId([
												'chapter_id' => $transChapters[$oldAttendance->park_id],
												'user_id' => $userId,
												'pronoun_id' => null,
												'mundane' => 'Deleted Persona' . $oldAttendance->by_whom_id,
												'name' => 'Deleted Persona' . $oldAttendance->by_whom_id,
												'is_active' => 0
										]);
										DB::table('trans')->insert([
												'array' => 'personas',
												'oldID' => $oldAttendance->by_whom_id,
												'newID' => $personaId
										]);
										$transPersonas[$oldAttendance->by_whom_id] = $personaId;
									}
								}
								DB::table('attendances')->insert([
										'persona_id' => $oldAttendance->mundane_id > 0 ? $transPersonas[$oldAttendance->mundane_id] : $personaID,
										'archetype_id' => $archetypeId,
										'attendable_type' => $oldAttendance->event_calendardetail_id > 0 ? 'Event' : 'Meetup',  //Meetup, Event
										'attendable_id' => $oldAttendance->event_calendardetail_id > 0 ? $transEventDetails[$oldAttendance->event_calendardetail_id] : $meetupId,
										'attended_at' => $oldAttendance->date,
										'credits' => $oldAttendance->credits,
										'created_by' => $oldAttendance->by_whom_id != 0 ? $transUsers[$oldAttendance->by_whom_id] : 1,
										'created_at' => $oldAttendance->entered_at != '0000-00-00 00:00:00' ? $oldAttendance->entered_at : $oldAttendance->date
								]);
							}
							$bar->advance();
						}
					});
						break;
				case 'Tournaments':
					$this->info('Importing Tournaments...');
					$oldEventDetails = $backupConnect->table('ork_event_calendardetail')->get()->toArray();
					$transEventDetails = $this->getTrans('eventdetails');
					$transKingdoms = $this->getTrans('kingdoms');
					$transChapters = $this->getTrans('chapters');
					$oldTournaments = $backupConnect->table('ork_tournament')->get()->toArray();
					$bar = $this->output->createProgressBar(count($oldTournaments));
					$bar->start();
					foreach ($oldTournaments as $oldTournament) {
						if($oldTournament->kingdom_id == 0 && $oldTournament->park_id == 0 && $oldTournament->event_calendardetail_id == 0 && $oldTournament->event_id == 0){
							$deadRecords['Tournaments'][$oldTournament->tournament_id] = $oldTournament;
							$bar->advance();
							continue;
						}
						$abletype = $oldTournament->kingdom_id > 0 ? 'Kingdom' : ($oldTournament->park_id > 0 ? 'Chapter' : 'Event');
						if($abletype === 'Kingdom'){
							while(!array_key_exists($oldTournament->kingdom_id, $transKingdoms)){
								$this->info('waiting for kingdom ' . $oldTournament->kingdom_id);
								sleep(5);
								$transKingdoms = $this->getTrans('kingdoms');
							}
							$ableid = $transKingdoms[$oldTournament->kingdom_id];
						}elseif($abletype === 'Chapter'){
							while(!array_key_exists($oldTournament->park_id, $transChapters)){
								$this->info('waiting for chapter ' . $oldTournament->park_id);
								sleep(5);
								$transChapters = $this->getTrans('chapters');
							}
							$ableid = $transChapters[$oldTournament->park_id];
						}else{
							if($oldTournament->event_calendardetail_id > 0){
								if(!array_key_exists($oldTournament->event_calendardetail_id, $oldEventDetails)){
									$deadRecords['Tournaments'][$oldTournament->tournament_id] = $oldTournament;
									$bar->advance();
									continue;
								}else{
									while(!array_key_exists($oldTournament->event_calendardetail_id, $transEventDetails)){
										$this->info('waiting for event ' . $oldTournament->event_calendardetail_id);
										sleep(5);
										$transEventDetails = $this->getTrans('eventdetails');
									}
									$ableid = $transEventDetails[$oldTournament->event_calendardetail_id];
								}
							}else{
								//these are all garbage, so goodby
								$deadRecords['Tournaments'][$oldTournament->tournament_id] = $oldTournament;
								$bar->advance();
								continue;
							}
						}
						DB::table('tournaments')->insert([
								'tournamentable_type' => $abletype,
								'tournamentable_id' => $ableid,
								'name' => $oldTournament->name,
								'description' => $oldTournament->description,
								'occured_at' => $oldTournament->date_time
						]);
						$bar->advance();
					}
					break;
				case 'Configurations':
					$this->info('Importing Configurations...');
					$transKingdoms = $this->getTrans('kingdoms');
					$oldConfigurations = $backupConnect->table('ork_configuration')->where('type', 'Kingdom')->get()->toArray();
					$bar = $this->output->createProgressBar(count($oldConfigurations));
					$bar->start();
					foreach ($oldConfigurations as $oldConfiguration) {
						if($oldConfiguration->key === 'AccountPointers'){
							$deadRecords['Configurations'][$oldConfiguration->configuration_id] = $oldConfiguration;
						}else{
							if(array_key_exists($oldConfiguration->id, $knownKingdomChaptertypesOffices)){
								//update the kingdom
								while(!array_key_exists($oldConfiguration->id, $transKingdoms)){
									$this->info('waiting for kingdom ' . $oldConfiguration->id);
									sleep(5);
									$transKingdoms = $this->getTrans('kingdoms');
								}
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
						}
						$bar->advance();
					}
					break;
				case 'Transactions':
					$this->info('Importing Transactions...');
					$transTransactions = [];
					$transUsers = $this->getTrans('users');
					$oldPersonas = $backupConnect->table('ork_mundane')->get()->toArray();
					$oldTransactions = $backupConnect->table('ork_transaction')->get()->toArray();
					$bar = $this->output->createProgressBar(count($oldTransactions));
					$bar->start();
					foreach ($oldTransactions as $oldTransaction) {
						if($oldTransaction->recorded_by != 0){
							if(array_key_exists($oldTransaction->recorded_by, $oldPersonas)){
								while(!array_key_exists($oldTransaction->recorded_by, $transPersonas)){
									$this->info('waiting for persona ' . $oldTransaction->recorded_by);
									sleep(5);
									$transPersonas = $this->getTrans('personas');
								}
								//if they need a user, we'll have to make one up
								if(!array_key_exists($oldTransaction->recorded_by, $transUsers)){
									$userId = DB::table('users')->insertGetId([
											'email' => 'deletedUser' . $oldTransaction->recorded_by . '@nowhere.net',
											'email_verified_at' => null,
											'password' => 'generated',
											'remember_token' => null,
											'is_restricted' => 1
									]);
									DB::table('trans')->insert([
											'array' => 'users',
											'oldID' => $oldTransaction->recorded_by,
											'newID' => $userId
									]);
									$transUsers[$oldTransaction->recorded_by] = $userId;
									DB::table('personas')->where('id', $transPersonas[$oldTransaction->recorded_by])->update([
											'user_id' => $userId
									]);
								}
							}else{
								$userId = DB::table('users')->insertGetId([
										'email' => 'deletedUser' . $oldTransaction->recorded_by . '@nowhere.net',
										'email_verified_at' => null,
										'password' => 'generated',
										'remember_token' => null,
										'is_restricted' => 1
								]);
								DB::table('trans')->insert([
										'array' => 'users',
										'oldID' => $oldTransaction->recorded_by,
										'newID' => $userId
								]);
								$transUsers[$oldTransaction->recorded_by] = $userId;
								//to get teh chapter id, dig into the splits that reference this transaction to get the mundane id, and from that, the park_id
								$oldTransactionSplit = $backupConnect->table('ork_split')->where('transaction_id', $oldTransaction->transaction_id)->first();
								$oldMundane = $oldTransactionSplit ? $backupConnect->table('ork_mundane')->where('mundane_id', $oldTransactionSplit->src_mundane_id)->first() : null;
								if($oldMundane){
									$personaId = DB::table('personas')->insertGetId([
											'chapter_id' => $oldMundane->park_id,
											'user_id' => $userId,
											'pronoun_id' => null,
											'mundane' => 'Deleted Persona' . $oldTransaction->recorded_by,
											'name' => 'Deleted Persona' . $oldTransaction->recorded_by,
											'is_active' => 0
									]);
									DB::table('trans')->insert([
											'array' => 'personas',
											'oldID' => $oldTransaction->recorded_by,
											'newID' => $personaId
									]);
									$transPersonas[$oldTransaction->recorded_by] = $personaId;
								}else{
									//nothing to be done
									$deadRecords['Transactions'][$oldTransaction->transaction_id] = $oldTransaction;
									$bar->advance();
									continue;
								}
							}
						}
						$transactionId = DB::table('transactions')->insertGetId([
								'description' => $oldTransaction->description,
								'memo' => $oldTransaction->memo,
								'transaction_at' => $oldTransaction->transaction_date <= '1969-12-31' ? $oldTransaction->date_created : $oldTransaction->transaction_date,
								'created_by' => $oldTransaction->recorded_by != 0 ? $transUsers[$oldTransaction->recorded_by] : 1,
								'created_at' => $oldTransaction->date_created
						]);
						DB::table('trans')->insert([
								'array' => 'transactions',
								'oldID' => $oldTransaction->transaction_id,
								'newID' => $transactionId
						]);
						$transTransactions[$oldTransaction->transaction_id] = $transactionId;
						$bar->advance();
					}
					break;
				case 'Splits':
					$this->info('Importing Splits...');
					$transAccounts = $this->getTrans('accounts');
					$transTransactions = $this->getTrans('transactions');
					$transPersonas = $this->getTrans('personas');
					$oldAccounts = $backupConnect->table('ork_account')->get()->toArray();
					$oldTransactions = $backupConnect->table('ork_transaction')->get()->toArray();
					$oldPersonas = $backupConnect->table('ork_mundane')->get()->toArray();
					$oldSplits = $backupConnect->table('ork_split')->get()->toArray();
					$bar = $this->output->createProgressBar(count($oldSplits));
					$bar->start();
					foreach ($oldSplits as $oldSplit) {
						//account was deleted...sigh.  Not sure there's enough of these to justify the time it'd take me to make the script rebuild it, and I'm not sure I even could.  So, without further adeau...
						if(!array_key_exists($oldSplit->account_id, $oldAccounts)){
							$deadRecords['Splits'][$oldSplit->split_id] = $oldSplit;
							$bar->advance();
							continue;
						}
						//transaction was deleted
						if(!array_key_exists($oldSplit->transaction_id, $oldTransactions)){
							$deadRecords['Splits'][$oldSplit->split_id] = $oldSplit;
							$bar->advance();
							continue;
						}
						//persona was deleted
						if(!array_key_exists($oldSplit->src_mundane_id, $oldPersonas)){
							$deadRecords['Splits'][$oldSplit->split_id] = $oldSplit;
							$bar->advance();
							continue;
						}
						while(!array_key_exists($oldSplit->account_id, $transAccounts)){
							$this->info('waiting for account ' . $oldSplit->account_id);
							sleep(5);
							$transAccounts = $this->getTrans('accounts');
						}
						while(!array_key_exists($oldSplit->transaction_id, $transTransactions)){
							$this->info('waiting for transaction ' . $oldSplit->transaction_id);
							sleep(5);
							$transTransactions = $this->getTrans('transactions');
						}
						while(!array_key_exists($oldSplit->src_mundane_id, $transPersonas)){
							$this->info('waiting for persona ' . $oldSplit->src_mundane_id);
							sleep(5);
							$transPersonas = $this->getTrans('personas');
						}
						DB::table('splits')->insert([
								'account_id' => $oldSplit->account_id > 0 ? $transAccounts[$oldSplit->account_id] : null,
								'transaction_id' => $transTransactions[$oldSplit->transaction_id],
								'persona_id' => $transPersonas[$oldSplit->src_mundane_id],
								'amount' => $oldSplit->amount
						]);
						$bar->advance();
					}
					break;
				case 'Dues':
					//https://github.com/scottlaurent/accounting - we'll be updating to that.  For now, just pass the data over.
					$this->info('Importing Dues');
					$transPersonas = $this->getTrans('personas');
					$transTransactions = $this->getTrans('transactions');
					$transUsers = $this->getTrans('transactions');
					$transKingdoms = $this->getTrans('kingdoms');
					$oldPersonas = $backupConnect->table('ork_mundane')->get()->toArray();
					$oldTransactions = $backupConnect->table('ork_transactions')->get()->toArray();
					$oldDues = $backupConnect->table('ork_dues')->get()->toArray();
					$oldTransaction = null;
					$bar = $this->output->createProgressBar(count($oldDues));
					$bar->start();
					foreach ($oldDues as $oldDue) {
						$thisSplit = null;
						$thisTransaction = null;
						$earned = null;
						$duesFrom = null;
						$kingdom = null;
						if($oldDue->kingdom_id == 0 || !array_key_exists($oldDue->mundane_id, $oldPersonas)){
							//looks like these are the victims of related deletions.  So sad.
							$deadRecords['Dues'][$oldDue->dues_id] = $oldDue;
							$bar->advance();
							continue;
						}
						if($oldDue->created_on > date('Y-m-d hh:mm:ss', strtotime('tomorrow'))){
							//it's just bad data, not much I can do
							$deadRecords['Dues'][$oldDue->dues_id] = $oldDue;
							$bar->advance();
							continue;
						}else{
							if($oldDue->import_transaction_id == 0 || !array_key_exists($oldDue->import_transaction_id, $oldTransactions)){
								//make the transaction
								while(!array_key_exists($oldDue->mundane_id, $transPersonas)){
									$this->info('waiting for persona ' . $oldDue->mundane_id);
									sleep(5);
									$transPersonas = $this->getTrans('personas');
								}
								$persona = Persona::where('id', $transPersonas[$oldDue->mundane_id])->first();
								$transactionId = DB::table('transactions')->insertGetId([
										'description' => 'Dues Paid for ' . $persona->mundane,
										'memo' => 'Dues Paid for ' . $persona->mundane,
										'transaction_at' => $oldDue->created_on,
										'created_by' => $transUsers[$oldDue->created_by],
										'created_at' => $oldDue->created_on
								]);
								DB::table('trans')->insert([
										'array' => 'transactions',
										'oldID' => $oldDue->import_transaction_id,
										'newID' => $transactionId
								]);
							}else{
								while(!array_key_exists($oldDue->import_transaction_id, $transTransactions)){
									$this->info('waiting for transaction ' . $oldDue->import_transaction_id);
									sleep(5);
									$transTransactions = $this->getTrans('transactions');
								}
								$transactionId = $transTransactions[$oldDue->import_transaction_id];
							}
						}
						//if the dues_from is before 1998-07-01, we need to figure out what it REALLY is, with the floor set at Feb 01, 1983 (Our birth month)
						if(strtotime($oldDue->dues_from) < strtotime('1998-07-01')){
							$thisSplit = $backupConnect->table('ork_split')->where('transaction_id', $oldDue->import_transaction_id)->where('is_dues', 1)->first();
							if(!$thisSplit){
								//damn.  Guess this one is toast.
								$deadRecords['Dues'][$oldDue->dues_id] = $oldDue;
								$bar->advance();
								continue;
							}
							$thisTransaction = $backupConnect->table('ork_transaction')->where('transaction_id', $thisSplit->transaction_id)->first();
							if($thisTransaction){
								$duesFrom = $thisTransaction->date_created;
							}else{
								$kingdom = $backupConnect->table('kingdoms')->where('id', $oldDue->kingdom_id)->first();
								$earned = $thisSplit->amount / $kingdom->dues_amount;
								$duesFrom = date('Y-m-d H:i:s', strtotime('-' . round($earned) . ' months', strtotime($thisSplit->dues_through)));
							}
							if($duesFrom < date('Y-m-d H:i:s', strtotime('Feb 01, 1983'))){
								$duesFrom = date('Y-m-d H:i:s', strtotime('Feb 01, 1983'));
							}
						}else{
							$duesFrom = date('Y-m-d H:i:s', strtotime($oldDue->dues_from));
						}
						//check users
						if(!array_key_exists($oldDue->created_by, $oldPersonas)){
							$userId = DB::table('users')->insertGetId([
									'email' => 'deletedUser' . $oldDue->created_by . '@nowhere.net',
									'email_verified_at' => null,
									'password' => 'generated',
									'remember_token' => null,
									'is_restricted' => 1
							]);
							DB::table('trans')->insert([
									'array' => 'users',
									'oldID' => $oldDue->created_by,
									'newID' => $userId
							]);
							$transUsers[$oldDue->created_by] = $userId;
							$personaId = DB::table('personas')->insertGetId([
									'chapter_id' => $transChapters[$oldDue->park_id],
									'user_id' => $userId,
									'pronoun_id' => null,
									'mundane' => 'Deleted Persona' . $oldDue->created_by,
									'name' => 'Deleted Persona' . $oldDue->created_by,
									'is_active' => 0
							]);
							DB::table('trans')->insert([
									'array' => 'personas',
									'oldID' => $oldDue->created_by,
									'newID' => $personaId
							]);
							$transPersonas[$oldDue->created_by] = $personaId;
						}else{
							while(!array_key_exists($oldDue->created_by, $transUsers)){
								$this->info('waiting for user ' . $oldDue->created_by);
								sleep(5);
								$transUsers = $this->getTrans('users');
							}
						}
						if($oldDue->revoked_by && !array_key_exists($oldDue->revoked_by, $oldPersonas)){
							$userId = DB::table('users')->insertGetId([
									'email' => 'deletedUser' . $oldDue->revoked_by . '@nowhere.net',
									'email_verified_at' => null,
									'password' => 'generated',
									'remember_token' => null,
									'is_restricted' => 1
							]);
							DB::table('trans')->insert([
									'array' => 'users',
									'oldID' => $oldDue->revoked_by,
									'newID' => $userId
							]);
							$transUsers[$oldDue->revoked_by] = $userId;
							$personaId = DB::table('personas')->insertGetId([
									'chapter_id' => $transChapters[$oldDue->park_id],
									'user_id' => $userId,
									'pronoun_id' => null,
									'mundane' => 'Deleted Persona' . $oldDue->revoked_by,
									'name' => 'Deleted Persona' . $oldDue->revoked_by,
									'is_active' => 0
							]);
							DB::table('trans')->insert([
									'array' => 'personas',
									'oldID' => $oldDue->revoked_by,
									'newID' => $personaId
							]);
							$transPersonas[$oldDue->revoked_by] = $personaId;
						}elseif($oldDue->revoked_by){
							while(!array_key_exists($oldDue->revoked_by, $transUsers)){
								$this->info('waiting for user ' . $oldDue->revoked_by);
								sleep(5);
								$transUsers = $this->getTrans('users');
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
						while(!array_key_exists($oldDue->mundane_id, $transPersonas)){
							$this->info('waiting for persona ' . $oldDue->mundane_id);
							sleep(5);
							$transPersonas = $this->getTrans('personas');
						}
						DB::table('dues')->insert([
							'persona_id' => $transPersonas[$oldDue->mundane_id],
							'transaction_id' => $transactionId,
							'dues_on' => date('Y-m-d', strtotime($duesFrom)),
							'intervals' => $intervals,
							'created_at' => $duesFrom,
							'created_by' => $transUsers[$oldDue->created_by],
							'deleted_at' => $oldDue->revoked === '1' ? date('Y-m-d H:i:s', strtotime($oldDue->revoked_on)) : null,
							'deleted_by' => $oldDue->revoked === '1' ? $transUsers[$oldDue->revoked_by] : null
						]);
						$bar->advance();
					}
					break;
				case 'Members':
					$this->info('Importing Members...');
					$transUnits = $this->getTrans('units');
					$transPersonas = $this->getTrans('personas');
					$oldMembers = $backupConnect->table('ork_unit_mundane')->get()->toArray();
					$bar = $this->output->createProgressBar(count($oldMembers));
					$bar->start();
					foreach ($oldMembers as $oldMember) {
						while(!array_key_exists($oldMember->unit_id, $transUnits)){
							$this->info('waiting for unit ' . $oldMember->unit_id);
							sleep(5);
							$transUnits = $this->getTrans('units');
						}
						while(!array_key_exists($oldMember->mundane_id, $transPersonas)){
							$this->info('waiting for persona ' . $oldMember->mundane_id);
							sleep(5);
							$transPersonas = $this->getTrans('personas');
						}
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
									'peerage' => 'None',
									'is_roaming' => 0,
									'is_active' => 1
								]);
							}else{
								$titleId = $foundTitle->id;
							}
							DB::table('issuances')->insert([
								'issuable_type' => 'Title',
								'issuable_id' => $titleId,
								'authority_type' => 'Unit',
								'authority_id' => $transUnits[$oldMember->unit_id],
								'issuer_id' => null,
								'recipient_type' => 'Persona',
								'recipient_id' => $transPersonas[$oldMember->mundane_id],
								'issued_at' => date('Y-m-d'),
							]);
						}
						//check to see if entry exists already, and if so, update
						$memberCheck = Member::where('unit_id', $transUnits[$oldMember->unit_id])->where('persona_id', $transPersonas[$oldMember->mundane_id])->first();
						if($memberCheck){
							$memberCheck->role = ucfirst($oldMember->role);
							$memberCheck->is_active = $oldMember->active === 'Active' ? 1 : 0;
							$memberCheck->save();
						}else{
							DB::table('members')->insert([
								'unit_id' => $transUnits[$oldMember->unit_id],
								'persona_id' => $transPersonas[$oldMember->mundane_id],
								'joined_at' => null,
								'left_at' => null,
								'is_head' => $oldMember->role === 'captain' || $oldMember->role === 'lord' ? 1 : 0,
								'is_voting' => 1
							]);
						}
						$bar->advance();
					}
					break;
				case 'Officers':
					//TODO: check Plagueservant of Peasants
					$this->info('Importing Officers...');
					$transChapters = $this->getTrans('chapters');
					$transPersonas = $this->getTrans('personas');
					$transKingdoms = $this->getTrans('kingdoms');
					$oldOfficers = $backupConnect->table('ork_officer')->get()->toArray();
					$bar = $this->output->createProgressBar(count($oldOfficers));
					$bar->start();
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
							while(!array_key_exists($oldOfficer->mundane_id, $transPersonas)){
								$this->info('waiting for persona ' . $oldOfficer->mundane_id);
								sleep(5);
								$transPersonas = $this->getTrans('personas');
							}
							if($oldOfficer->park_id != 0){
								while(!array_key_exists($oldOfficer->park_id, $transChapters)){
									$this->info('waiting for chapter ' . $oldOfficer->park_id);
									sleep(5);
									$transChapters = $this->getTrans('chapters');
								}
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
								while(!array_key_exists($oldOfficer->kingdom_id, $transKingdoms)){
									$this->info('waiting for kingdom ' . $oldOfficer->kingdom_id);
									sleep(5);
									$transKingdoms = $this->getTrans('kingdoms');
								}
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
						DB::table('officers')->insert([
							'officerable_type' => 'Reign',
							'officerable_id' => $reignID,
							'office_id' => $officeID,
							'persona_id' => $transPersonas[$oldOfficer->mundane_id],
							'label' => $label ? $label : null,
							'starts_on' => null,
							'ends_on' => null
						]);
						$bar->advance();
					}
					break;
				case 'Recommendations':
					$this->info('Importing Recommendations...');
					$transTitles = $this->getTrans('titles');
					$transKingdomawards = $this->getTrans('kingdomawards');
					$transPersonas = $this->getTrans('personas');
					$oldTitles = $backupConnect->table('ork_award')->where('is_title', 1)->get()->toArray();
					$oldRecommendations = $backupConnect->table('ork_recommendations')->get()->toArray();
					$bar = $this->output->createProgressBar(count($oldRecommendations));
					$bar->start();
					foreach ($oldRecommendations as $oldRecommendation) {
						//work out the kingdomaward_id (get persona, search kingdomawards by persona kingdom && award)
						$persona = $backupConnect->table('ork_mundane')->where('mundane_id', $oldRecommendation->mundane_id)->first();
						$kingdomaward = $backupConnect->table('ork_kingdomaward')->where('kingdom_id', $persona->kingdom_id)->where('award_id', $oldRecommendation->award_id)->first();
						$isTitle = array_key_exists($oldRecommendation->award_id, $oldTitles) ? true : false;
						while(!array_key_exists($oldRecommendation->recommended_by_id, $transPersonas)){
							$this->info('waiting for persona ' . $oldRecommendation->recommended_by_id);
							sleep(5);
							$transPersonas = $this->getTrans('personas');
						}
						if($isTitle){
							while(!array_key_exists($oldRecommendation->award_id, $transTitles)){
								$this->info('waiting for title ' . $oldRecommendation->award_id);
								sleep(5);
								$transTitles = $this->getTrans('titles');
							}
						}else{
							while(!array_key_exists($kingdomaward->id, $transKingdomawards)){
								$this->info('waiting for award ' . $kingdomaward->id);
								sleep(5);
								$transKingdomawards = $this->getTrans('awards');
							}
						}
						DB::table('recommendations')->insert([
								'persona_id' => $transPersonas[$oldRecommendation->mundane_id],
								'recommendable_type' => $isTitle ? 'Title' : 'Award',
								'recommendable_id' => $isTitle ? $transTitles[$oldRecommendation->award_id][$persona->kingdom_id] : $transKingdomawards[$kingdomaward->id],
								'rank' => $oldRecommendation->rank > 0 ? $oldRecommendation->rank : null,
								'is_anonymous' => $oldRecommendation->mask_giver,
								'reason' => $oldRecommendation->reason,
								'created_by' => $transPersonas[$oldRecommendation->recommended_by_id],
								'created_at' => $oldRecommendation->date_recommended
						]);
						$bar->advance();
					}
					break;
				case 'Reconciliations':
					//TODO: check negatives...doesn't seem to be doing that right
					$this->info('Importing Reconciliations...');
					$transArchetypes = $this->getTrans('archetypes');
					$oldReconciliations = $backupConnect->table('ork_class_reconciliation')->get()->toArray();
					$bar = $this->output->createProgressBar(count($oldReconciliations));
					$bar->start();
					foreach ($oldReconciliations as $oldReconciliation) {
						if($oldReconciliation->reconciled === 0){
							$deadRecords['Reconciliations'][$oldReconciliation->reconciliation_id] = $oldReconciliation;
							$bar->advance();
							continue;
						}
						while(!array_key_exists($oldReconciliation->class_id, $transArchetypes)){
							$this->info('waiting for archetype ' . $oldReconciliation->class_id);
							sleep(5);
							$transArchetypes = $this->getTrans('archetypes');
						}
						DB::table('reconciliations')->insert([
								'archetype_id' => $transArchetypes[$oldReconciliation->class_id],
								'persona_id' => $oldReconciliation->mundane_id,
								'credits' => (int) $oldReconciliation->reconciled > 2000 ? 2000 : (int) $oldReconciliation->reconciled
						]);
						$bar->advance();
					}
					break;
				case 'Issuances':
					//walker in the middle is a title someplaces, and an award others.  work out where, and what they call it
					//124 Walker in the Middle
					// 			138 Master Monster
					// 			161 Grand Duke
					// 			187 Dragonmaster (and more, is 'custom award')
					//autocrat & subcrat not issuances, but instead 'crats'
					//			218 Autocrat
					//			219 Subcrat
					$this->info('Importing Issuances...');
					$transKingdomawards = $this->getTrans('kingdomawards');
					$transTitles = $this->getTrans('titles');
					$transEventDetails = $this->getTrans('eventdetails');
					$transChapters = $this->getTrans('chapters');
					$oldKingdomawards = $backupConnect->table('ork_kingdomaward')
						->where(function($q) {
							$q->where('award_id', 94)->orWhere('award_id', 0);
						})
						->where(function($q) {
							$q->where('name', '')->orWhere('name', 'LIKE', '%Antigriffin%')->orWhere('name', 'LIKE', '%typhoon%')->orWhere('name', 'LIKE', '%tsunami%')->orWhere('name', 'LIKE', '%Hellrider%')->orWhere('name', 'LIKE', '%Dreamkeeper%')->orWhere('name', 'LIKE', '%Cyclone%')->orWhere('name', 'LIKE', '%Emerald%')->orWhere('name', 'LIKE', 'Order %');
						})->get()->toArray();
					$oldTitles = $backupConnect->table('ork_award')->where('is_title', 1)->get()->toArray();
					$oldIssuances = $backupConnect->table('ork_awards')->get()->toArray();
					//Make a default 'unknown' location
					$defaultLocationId = DB::table('locations')->insertGetId([
							'address' => 'Lost to the Ages',
							'country' => null
					]);
					$bar = $this->output->createProgressBar(count($oldIssuances));
					$bar->start();
					foreach ($oldIssuances as $oldIssuance) {
						$issuable_type = null;
						$issuable_id = null;
						$rank = null;
						
						//we don't know what the issuance is...coincedently, we don't know the authorizing kingdom or park either
						if($oldIssuance->kingdomaward_id == 0){
							//leave them and let humans do the work.  There's only about 300 of them.
							$deadRecords['IssuancesNoAward'][$oldIssuances->awards_id] = $oldIssuance;
							$bar->advance();
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
						if (array_key_exists($oldIssuance->kingdomaward_id, $oldKingdomawards)) {
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
							while(!array_key_exists($oldIssuance->kingdomaward_id, $transKingdomawards)){
								$this->info('waiting for kingdomaward ' . $oldIssuance->kingdomaward_id);
								sleep(5);
								$transKingdomawards = $this->getTrans('kingdomawards');
							}
							$issuable_id = $transKingdomawards[$oldIssuance->kingdomaward_id];
							$rank = $oldIssuance->rank != '' ? $oldIssuance->rank : null;
							//TODO: this isn't gonna work, since some of them are 0
						}else if(array_key_exists($oldIssuance->award_id, $oldTitles)){
							$issuable_type = 'Title';
							while(!array_key_exists($oldIssuance->award_id, $transTitles[$kingdomaward->kingdom_id])){
								$this->info('waiting for title ' . $oldIssuance->award_id);
								sleep(5);
								$transTitles = $this->getTrans('titles');
							}
							$issuable_id = $transTitles[$oldIssuance->award_id][$kingdomaward->kingdom_id];
							$rank = null;
						}
	// 					else if(array_key_exists($oldIssuance->kingdomaward_id, $transOffices)){
	
	// 					}
						else{
							$deadRecords['kingdomAwards'][$oldIssuance->awards_id] = $oldIssuance;
						}
						
						while(!array_key_exists($eventcaldet->id, $transEventDetails)){
							$this->info('waiting for eventdetails ' . $eventcaldet->id);
							sleep(5);
							$transEventDetails = $this->getTrans('eventdetails');
						}
						if($oldIssuance->park_id != '0'){
							while(!array_key_exists($oldIssuance->park_id, $transChapters)){
								$this->info('waiting for chapter ' . $oldIssuance->park_id);
								sleep(5);
								$transChapters = $this->getTrans('chapters');
							}
						}else{
							while(!array_key_exists($kingdomaward->kingdom_id, $transKingdoms)){
								$this->info('waiting for kingdom ' . $kingdomaward->kingdom_id);
								sleep(5);
								$transKingdoms = $this->getTrans('kingdoms');
							}
						}
						if($oldIssuance->unit_id != '0'){
							while(!array_key_exists($oldIssuance->unit_id, $transUnits)){
								$this->info('waiting for unit ' . $oldIssuance->unit_id);
								sleep(5);
								$transUnits = $this->getTrans('units');
							}
						}else{
							$target = $oldIssuance->persona_id != '0' ? $oldIssuance->persona_id : $oldIssuance->stripped_from;
							while(!array_key_exists($target, $transPersonas)){
								$this->info('waiting for persona ' . $target);
								sleep(5);
								$transPersonas = $this->getTrans('personas');
							}
						}
						if($oldIssuance->given_by_id != '0'){
							while(!array_key_exists($oldIssuance->given_by_id, $transPersonas)){
								$this->info('waiting for persona ' . $oldIssuance->given_by_id);
								sleep(5);
								$transPersonas = $this->getTrans('personas');
							}
						}
						if($oldIssuance->revoked_by_id != '0'){
							while(!array_key_exists($oldIssuance->revoked_by_id, $transPersonas)){
								$this->info('waiting for persona ' . $oldIssuance->revoked_by_id);
								sleep(5);
								$transPersonas = $this->getTrans('personas');
							}
						}
						
						//make it
						DB::table('issuances')->insert([
							'issuable_type' => $issuable_type,
							'issuable_id' => $issuable_id,
							'whereable_type' => $eventcaldet ? $transEventDetails[$eventcaldet->id] : $defaultLocationId,
							'whereable_id' => $eventcaldet ? 'Event' : 'Location',
							'authority_type' => $oldIssuance->park_id != '0' ? 'Chapter' : 'Kingdom',
							'authority_id' => $oldIssuance->park_id != '0' ? $transChapters[$oldIssuance->park_id] : $transKingdoms[$kingdomaward->kingdom_id],
							'recipient_type' => $oldIssuance->unit_id != '0' ? 'Unit' : 'Persona',
							'recipient_id' => $oldIssuance->unit_id != '0' ? $transUnits[$oldIssuance->unit_id] : ($oldIssuance->persona_id != '0' ? $transPersonas[$oldIssuance->persona_id] : $transPersonas[$oldIssuance->stripped_from]),
							'issuer_id' => $oldIssuance->given_by_id != '0' ? $transPersonas[$oldIssuance->given_by_id] : null,
							'custom_name' => $oldIssuance->custom_name != '' ? $oldIssuance->custom_name : null,
							'rank' => $rank,
							'issued_at' => $oldIssuance->date != '0000-00-00' ? $oldIssuance->date : ($oldIssuance->entered_at != '0000-00-00' ? $oldIssuance->entered_at : date('Y-m-d')),
							'note' => trim($oldIssuance->note) != '' ? trim($oldIssuance->note) : null,
							'image' => null,
							'revocation' => trim($oldIssuance->revocation) != '' ? trim($oldIssuance->revocation) : null,
							'revoked_by' => $oldIssuance->revoked_by_id != '0' ? $transPersonas[$oldIssuance->revoked_by_id] : null,
							'revoked_at' => $oldIssuance->revoked_at != '0000-00-00' ? $oldIssuance->revoked_at : null
						]);
						$bar->advance();
					}
					break;
				case 'Default':
					break;
			}
			
			//clean up
			$bar->finish();
			Schema::enableForeignKeyConstraints();

			
			//demos/guests: demos are just events.  Add 'is demo' flag to event.  add guests table.  in user import above, find obvious demo entries and move them.
			
			//custom titles hidden in ork_awards...specifically, those for kingdomaward_id 6036.  Make the custom titles.
			//custom officers (award data)
			//iterate locations: update 'address' to 'street', add 'label', use google geocoder to clean up data & add geocode field
			
			//TODO: compare awardsprocessed with list of awards.  Dump results and check for stuff we can get
			//TODO: dump notes into a persona-transed table for processing

			
// 			$this->info(count($deadRecords['Chaptertypes']) . ' Chaptertypes lost due to a missing Kingdom');
// 			$this->info(count($deadRecords['Units']) . ' Units lost due to being an Event Type, having a missing Type, or having been deleted');
// 			$this->info(count($oldCustomAwards) . ' Awards created from \'Custom Award\'');
// 			$this->info(count($oldCustomTitles) . ' Titles created from \'Custom Award\'');
// 			$this->info(count($deadRecords['Users']) . ' Users (login only, not Persona data) not created due to duplicate emails');
// 			$this->info(count($deadRecords['PenaltyBox']) . ' Users in the Penalty Box but NOT suspended are now free');
// 			$this->info(count($deadRecords['EventUrlNames']) . ' Event URL names were tossed due to being unnecessary');
// 			$this->info(count($deadRecords['ParkdayAlternates']) . ' Parkday alternate locations dropped.');
// 			$this->info(count($deadRecords['HeadlessAttendances']) . ' Attendances without a viable persona were lost');
// 			$this->info(count($deadRecords['AttendancesReconciled']) . ' Attendances made into Reconciliations due to missing critical data (date, chapter/event, etc)');
// 			$this->info(count($deadRecords['Dues']) . ' Dues lost due to no chapter/kingdom or terms');
// 			$this->info(count($deadRecords['IssuancesNoAward']) . ' Award/Title Issuances lost due to no award id');
// 			$this->info(count($deadRecords['Tournaments']) . ' Tournaments lost due to no kingdom/chapter/event data');
// 			$this->info(count($deadRecords['Reconciliations']) . ' Reconciliations lost due to 0 value reconciled');
// 			$this->info(count($deadRecords['Configurations']) . ' Configurations moved to kingdom table');
// 			$this->info(count($deadRecords['Splits']) . ' Splits lost due to deleted Account, Persona, or Transactiom');

			//TODO: log all the dead records somewhere
			dd(array(
				$deadRecords,
				$kingdomawardsProcessed
			));

			$this->info('All done!');
		} catch (Throwable $e) {
			$trace = $e->getTrace()[AppHelper::instance()->search_multi_array(__FILE__, 'file', $e->getTrace())];
			Log::error($e->getMessage() . ' (' . $trace['file'] . ':' . $trace['line'] . ')\r\n' . '[stacktrace]' . '\r\n' . $e->getTraceAsString());
			$this->error(sprintf('%s:%d - ' . $e->getMessage(), $e->getFile(), $e->getLine()));
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
	
	private function cleanPersona($personaName, $mundaneName = null){
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
		if($mundaneName){
			$mundaneName = $this->cleanMundane($mundaneName);
		}
		if($personaName === $mundaneName){
			$personaName = 'Undeclared(' . $personaName . ')';
		}
		return !$personaName || $personaName === '' ? 'Undeclared (' . $mundaneName . ')' : $personaName;
	}
	
	private function cleanMundane($mundaneName){
		preg_replace("/\([^)]+\)/", "", $mundaneName);
		$mundaneName = str_replace('  ', ' ', $mundaneName);
		$mundaneName = str_replace('.', '', $mundaneName);
		$mundaneName = trim($mundaneName);
		$mundaneName = str_ireplace('zzz', '', $mundaneName);
		return $mundaneName;
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
	
	private function getCountryCode($country, $countries){
		if(!$country || $country === ''){
			return null;
		}
		if($country === 'USA' || $country === 'US'){
			$country = 'United States';
		}
		return array_search($country, $countries) ? array_search($country, $countries) : null;
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
	
	private function getAbbreviation($name){
		$abbreviatedName = [];
		if(strpos($name, '-') > -1){
			$namesploded = explode('-', $name);
			$name = $namesploded[0];
		}
		$name = str_replace(' Defunct', '', $name);
		preg_replace("/\([^)]+\)/", "", $name);
		$name = trim($name);
		preg_match_all('/\b\w/u', $name, $abbreviatedName);
		return implode("", substr($abbreviatedName[0][0], 0, 3));
	}
	
	private function getTrans($array){
		$array = [];
		$transJSONs = DB::table('trans')->where('array', $array)->get()->toArray();
		foreach($transJSONs as $transJSON){
			$array[$transJSON->oldID] = $transJSON->newID;
		}
		return $array;
	}
}