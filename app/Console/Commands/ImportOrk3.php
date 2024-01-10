<?php

namespace app\Console\Commands;

use App\Models\Account;
use App\Models\Archetype;
use App\Models\Chapter;
use App\Models\Chaptertype;
use App\Models\Location;
use App\Models\Meetup;
use App\Models\Member;
use App\Models\Office;
use App\Models\Persona;
use App\Models\Realm;
use App\Models\Title;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use app\Helpers\AppHelper;
use Throwable;

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
			$realmawardsProcessed = [];
			ini_set('memory_limit', '512M');
			
			//what we know
			$step = $this->argument('step');
			$ropLadders = null;
			$ropTitles = null;
			$knownAwards = null;
			$knownTitles = null;
			$knownRealmChaptertypesOffices = null;
			$knownCurrentReigns = null;
			$countries = null;
			include 'known.php';
			
			if(!Schema::hasTable('trans')){
				DB::statement("CREATE TABLE IF NOT EXISTS `trans` (
					`id` BIGINT(20) NOT NULL AUTO_INCREMENT,
					`array` VARCHAR(50) NOT NULL,
					`oldID` bigint(20) unsigned NOT NULL,
					`oldMID` bigint(20) unsigned NULL,
					`newID` bigint(20) unsigned NOT NULL,
					PRIMARY KEY (`id`)
				) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
			}
			
			if(!Schema::hasTable('crypt')){
				DB::statement("CREATE TABLE IF NOT EXISTS `crypt` (
					`id` BIGINT(20) NOT NULL AUTO_INCREMENT,
					`model` VARCHAR(50) NOT NULL,
					`cause` VARCHAR(50) NOT NULL,
					`model_id` bigint(20) unsigned NOT NULL,
					`model_value` JSON NOT NULL,
					PRIMARY KEY (`id`)
				) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
			}
			
			//clean up some edge cases
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
			
			$backupConnect->table('ork_kingdomaward')
			->where('kingdomaward_id', 6043)
			->update(['award_id' => 209]);
			
			$backupConnect->table('ork_kingdomaward')
			->where('kingdomaward_id', 6580)
			->delete();
			
			$backupConnect->table('ork_kingdomaward')
			->where('kingdomaward_id', 6287)
			->orWhere('kingdomaward_id', 6166)
			->orWhere('kingdomaward_id', 6042)
			->update(['award_id' => 226]);
			
			$backupConnect->table('ork_kingdomaward')
			->where('kingdomaward_id', 6338)
			->update(['award_id' => 31]);
			
			$backupConnect->table('ork_kingdomaward')
			->where('kingdomaward_id', 2839)
			->update(['name' => 'Order of the Walker of the Middle']);
			
			$backupConnect->table('ork_kingdomaward')
			->where('kingdomaward_id', 3119)
			->update(['name' => 'Walker in the Middle']);
			
			$backupConnect->table('ork_officer')
			->where('kingdom_id', 0)
			->update(['kingdom_id' => 8]);
			
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
			
			$backupConnect->table('ork_recommendations')
			->where('kingdomaward_id', 7051)
			->update(['kingdomaward_id' => 6960]);
			
			$backupConnect->table('ork_mundane')
			->where('mundane_id', 1)
			->update(['email' => 'admin@ork.amtgard.com']);
			
			$backupConnect->table('ork_mundane')
			->where('mundane_id', 42079)
			->update(['email' => '']);
			
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
					Permission::create(['name' => 'list realms', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'store realms', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'display realms', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'displayOwn realms', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'displayRelated realms', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'update realms', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'updateOwn realms', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'updateRelated realms', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'remove realms', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'removeOwn realms', 'guard_name' => 'api']);$bar->advance();
					Permission::create(['name' => 'removeRelated realms', 'guard_name' => 'api']);$bar->advance();
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
					$role->givePermissionTo('list realms');$bar->advance();
					$role->givePermissionTo('display realms');$bar->advance();
					$role->givePermissionTo('displayOwn realms');$bar->advance();
					$role->givePermissionTo('displayRelated realms');$bar->advance();
					$role->givePermissionTo('updateOwn realms');$bar->advance();
					$role->givePermissionTo('updateRelated realms');$bar->advance();
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
					$role->givePermissionTo('list realms');$bar->advance();
					$role->givePermissionTo('display realms');$bar->advance();
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
				case 'Realms':
					$this->info('Importing Realms...');
					$transRealms = [];
					$freeholdId = null;
					$oldRealms = $backupConnect->table('ork_kingdom')->orderBy('kingdom_id', 'ASC')->get()->toArray();
					$bar = $this->output->createProgressBar(count($oldRealms) - 1);
					$bar->start();
					foreach ($oldRealms as $oldRealm) {
						//nope this guy
						if($oldRealm->name === '&THORN;e Olde Records Empire'){
							//we're moving them to freeholds
							DB::table('trans')->insert([
									'array' => 'realms',
									'oldID' => $oldRealm->kingdom_id,
									'newID' => $freeholdId
							]);
							$transRealms[$oldRealm->kingdom_id] = $freeholdId;
							continue;
						}
						$realmId = DB::table('realms')->insertGetId([
								'parent_id' => $oldRealm->parent_kingdom_id == 0 ? null : $transRealms[$oldRealm->parent_kingdom_id],
								'name' => $oldRealm->name,
								'abbreviation' => $oldRealm->abbreviation,
								'heraldry' => $oldRealm->has_heraldry === '1' ? sprintf('%04d.jpg', $oldRealm->kingdom_id) : null,
								'is_active' => $oldRealm->active === 'Active' ? 1 : 0,
								'created_at' => $oldRealm->modified,
								'updated_at' => $oldRealm->modified
						]);
						DB::table('trans')->insert([
								'array' => 'realms',
								'oldID' => $oldRealm->kingdom_id,
								'newID' => $realmId
						]);
						$transRealms[$oldRealm->kingdom_id] = $realmId;
						if($oldRealm->name === 'The Freeholds of Amtgard'){
							$freeholdId = $realmId;
						}
						$bar->advance();
					}
					break;
				case 'Chaptertypes':
					$this->info('Importing Chaptertypes...');
					$transChaptertypes = [];
					$chaptertypeId = 0;
					$doneKnown = [];
					$oldRealms = $backupConnect->table('ork_kingdom')->pluck('kingdom_id')->toArray();
					$transRealms = $this->getTrans('realms');
					$oldChaptertypes = $backupConnect->table('ork_parktitle')->orderBy('parktitle_id')->get()->toArray();
					$bar = $this->output->createProgressBar(count($oldChaptertypes) + 43);
					$bar->start();
					foreach ($oldChaptertypes as $oldChaptertype) {
						//deleted realms
						if (!in_array($oldChaptertype->kingdom_id, $oldRealms)) {
							$transRealms = $this->getTrans('realms');
							if(!array_key_exists($oldChaptertype->kingdom_id, $transRealms)){
								$realmId = DB::table('realms')->insertGetId([
										'parent_id' => null,
										'name' => 'Deleted Realm ' . $oldChaptertype->kingdom_id,
										'abbreviation' => 'DK' . $oldChaptertype->kingdom_id,
										'heraldry' => null,
										'is_active' => 0
								]);
								DB::table('trans')->insert([
										'array' => 'realms',
										'oldID' => $oldChaptertype->kingdom_id,
										'newID' => $realmId
								]);
								$transRealms = $this->getTrans('realms');
							}
						}else{
							//wait for the realm to exist
							while(!array_key_exists($oldChaptertype->kingdom_id, $transRealms)){
								$this->info('waiting for realm ' . $oldChaptertype->kingdom_id);
								sleep(5);
								$transRealms = $this->getTrans('realms');
							}
							DB::reconnect("mysqlBak");
						}
						
						//If it's one of our known realms,
						if(array_key_exists($oldChaptertype->kingdom_id, $knownRealmChaptertypesOffices)){
							//it's not in the known array,
							if($oldChaptertype->title === 'Kingdom' || !array_key_exists($oldChaptertype->title, $knownRealmChaptertypesOffices[$oldChaptertype->kingdom_id])){
								//don't add this one.
								switch($oldChaptertype->parktitle_id){
									case '56':
										DB::table('trans')->insert([
										'array' => 'chaptertypes',
										'oldID' => $oldChaptertype->parktitle_id,
										'newID' => (int)$chaptertypeId + 1
										]);
										$transChaptertypes[$oldChaptertype->parktitle_id] = (int)$chaptertypeId + 1;
										break;
									case '31':
										DB::table('trans')->insert([
										'array' => 'chaptertypes',
										'oldID' => $oldChaptertype->parktitle_id,
										'newID' => (int)$chaptertypeId + 1
										]);
										$transChaptertypes[$oldChaptertype->parktitle_id] = (int)$chaptertypeId + 1;
										break;
									case '35':
										DB::table('trans')->insert([
										'array' => 'chaptertypes',
										'oldID' => $oldChaptertype->parktitle_id,
										'newID' => (int)$chaptertypeId
										]);
										$transChaptertypes[$oldChaptertype->parktitle_id] = (int)$chaptertypeId;
										break;
									default:
								}
								DB::table('crypt')->insert([
										'model' 		=> 'Chaptertype',
										'cause' 		=> 'NotInCorpora',
										'model_id'		=> $oldChaptertype->parktitle_id,
										'model_value'	=> json_encode($oldChaptertype)
								]);
								$bar->advance();
								continue;
							}else{
								$doneKnown[$oldChaptertype->kingdom_id][$oldChaptertype->title] = $knownRealmChaptertypesOffices[$oldChaptertype->kingdom_id][$oldChaptertype->title];
							}
						}
						$chaptertypeId = DB::table('chaptertypes')->insertGetId([
								'realm_id' => $transRealms[$oldChaptertype->kingdom_id],
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
					foreach($knownRealmChaptertypesOffices as $rid => $realmChaptertypes){
						//wait for the realm to exist
						while(!array_key_exists($rid, $transRealms)){
							$this->info('waiting for realm ' . $rid);
							sleep(5);
							$transRealms = $this->getTrans('realms');
						}
						DB::reconnect("mysqlBak");
						foreach($realmChaptertypes as $knownChaptertype => $offices){
							//skip it if it's kingdom or done already
							if($knownChaptertype === 'Kingdom' || (array_key_exists($rid, $doneKnown) && array_key_exists($knownChaptertype, $doneKnown[$rid]))){
								continue;
							}
							$chaptertypeId = DB::table('chaptertypes')->insertGetId([
									'realm_id' => $transRealms[$rid],
									'name' => $knownChaptertype,
									'rank' => $knownChaptertype === 'Principality' ? 50 : 35,
									'minimumattendance' => $knownChaptertype === 'Principality' ? 60 : 21,
									'minimumcutoff' => $knownChaptertype === 'Principality' ? 56 : 19
							]);
							$bar->advance();
						}
					}
					break;
				case 'Chapters':
					$this->info('Importing Chapters...');
					$transChapters = [];
					$transRealms = $this->getTrans('realms');
					$transChaptertypes = $this->getTrans('chaptertypes');
					$oldRealms = $backupConnect->table('ork_kingdom')->pluck('kingdom_id')->toArray();
					$oldChapters = $backupConnect->table('ork_park')->get()->toArray();
					$bar = $this->output->createProgressBar(count($oldChapters));
					$bar->start();
					foreach ($oldChapters as $oldChapter) {
						$lowestChaptertype = null;
						//deleted realms
						if (!in_array($oldChapter->kingdom_id, $oldRealms)) {
							$transRealms = $this->getTrans('realms');
							if(!array_key_exists($oldChapter->kingdom_id, $transRealms)){
								$realmId = DB::table('realms')->insertGetId([
										'parent_id' => null,
										'name' => 'Deleted Realm ' . $oldChapter->kingdom_id,
										'abbreviation' => 'DK' . $oldChapter->kingdom_id,
										'heraldry' => null,
										'is_active' => 0
								]);
								DB::table('trans')->insert([
										'array' => 'realms',
										'oldID' => $oldChapter->kingdom_id,
										'newID' => $realmId
								]);
								$transRealms = $this->getTrans('realms');
							}
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
						while(!array_key_exists($oldChapter->kingdom_id, $transRealms)){
							$this->info('waiting for realm ' . $oldChapter->kingdom_id);
							sleep(5);
							$transRealms = $this->getTrans('realms');
						}
						DB::reconnect("mysqlBak");
						if($oldChapter->parktitle_id != 186){
							while(!array_key_exists($oldChapter->parktitle_id, $transChaptertypes)){
								$this->info('waiting for chaptertype ' . $oldChapter->parktitle_id);
								sleep(5);
								$transChaptertypes = $this->getTrans('chaptertypes');
							}
							DB::reconnect("mysqlBak");
						}
						if($oldChapter->parktitle_id == 186){//inactive is being removed
							$lowestChaptertype = Chaptertype::where('realm_id', $transRealms[$oldChapter->kingdom_id])->orderBy('rank', 'ASC')->first();
						}
						$chapterID = DB::table('chapters')->insertGetId([
								'realm_id' => $transRealms[$oldChapter->kingdom_id],
								'chaptertype_id' => $lowestChaptertype ? $lowestChaptertype->id : $transChaptertypes[$oldChapter->parktitle_id],
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
							DB::table('crypt')->insert([
									'model' 		=> 'Unit',
									'cause' 		=> 'NoType',
									'model_id'		=> $oldUnit->unit_id,
									'model_value'	=> json_encode($oldUnit)
							]);
						}
						$bar->advance();
					}
					break;
				case 'Awards':
					//TODO: work out those wacky other things
					$this->info('Importing Awards...');
					$transGenericAwards = [];
					$transRealms = $this->getTrans('realms');
					//Common awards first
					$oldAwards = $backupConnect->table('ork_award')->where('is_ladder', 1)->get()->toArray();
					$bar = $this->output->createProgressBar(216);
					$bar->start();
					foreach ($oldAwards as $oldAward) {
						$nameClean = trim($oldAward->name);
						$this->info('Working ' . $nameClean);
						//the awards that aren't expressly defined in the RoP are no longer 'common'.  Make one for each realm, as appropriate
						if(!in_array($oldAward->award_id, $ropLadders)){
							foreach($knownAwards[$nameClean] as $rid => $info){
								$this->info('');
								$this->info('Checking ' . $rid . '/' . $nameClean);
								if($info){
									$this->info('');
									$this->info('Adding ' . $rid . '/' . $nameClean);
									while(!array_key_exists($rid, $transRealms)){
										$this->info('waiting for realm ' . $rid);
										sleep(5);
										$transRealms = $this->getTrans('realms');
									}
									DB::reconnect("mysqlBak");
									$awardId = DB::table('awards')->insertGetId([
											'awarder_type' => 'Realm',
											'awarder_id' => $transRealms[$rid],
											'name' => $info['name'],
											'is_ladder' => $info['is_ladder'],
											'deleted_by' => null,
											'deleted_at' => null
									]);
									DB::table('trans')->insert([
											'array' => 'genericawards',
											'oldID' => $oldAward->award_id,
											'oldMID' => $rid,
											'newID' => $awardId
									]);
									$transGenericAwards[$oldAward->award_id][$rid] = $awardId;
									$realmawards = $backupConnect->table('ork_kingdomaward')->where('award_id', $oldAward->award_id)->where('kingdom_id', $rid)->get()->toArray();
									if($realmawards){
										foreach($realmawards as $realmaward){
											DB::table('trans')->insert([
													'array' => 'realmawards',
													'oldID' => $realmaward->kingdomaward_id,
													'newID' => $awardId
											]);
											$transRealmawards[(int)$realmaward->kingdomaward_id] = $awardId;
											DB::table('trans')->insert([
													'array' => 'realmawardsprocessed',
													'oldID' => $realmaward->kingdomaward_id,
													'newID' => $awardId
											]);
											$realmawardsProcessed[(int)$realmaward->kingdomaward_id] = $awardId;
										}
									}
								}
							}
							$bar->advance();
							continue;
						}
						$awardId = DB::table('awards')->insertGetId([
								'awarder_type' => 'Realm',
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
						//go thru the realmawards that use this award, and add them to the trans and processed arrays
						//TODO: some of those (name = 'Order of the x') have different, deleted award_id's.  Check those guys.
						$realmawards = $backupConnect->table('ork_kingdomaward')->where('name', $nameClean)->get()->toArray();
						$this->info('');
						$this->info('Adding ' . $nameClean);
						foreach($realmawards as $realmaward){
							DB::table('trans')->insert([
									'array' => 'realmawards',
									'oldID' => $realmaward->kingdomaward_id,
									'newID' => $awardId
							]);
							$transRealmawards[(int)$realmaward->kingdomaward_id] = $awardId;
							DB::table('trans')->insert([
									'array' => 'realmawardsprocessed',
									'oldID' => $realmaward->kingdomaward_id,
									'newID' => $awardId
							]);
							$realmawardsProcessed[(int)$realmaward->kingdomaward_id] = $awardId;
							//6960 is also in the system as 7051 (no name).  conflate them.
							if($realmaward->kingdomaward_id == '6960'){
								DB::table('trans')->insert([
										'array' => 'realmawards',
										'oldID' => 7051,
										'newID' => $awardId
								]);
								$transRealmawards[7051] = $awardId;
								DB::table('trans')->insert([
										'array' => 'realmawardsprocessed',
										'oldID' => 7051,
										'newID' => $awardId
								]);
								$realmawardsProcessed[7051] = $awardId;
							}
						}
						$bar->advance();
					}
					break;
				case 'CustomAwards':
					$this->info('Importing Custom Awards...');
					$transRealmawards = [];
					$transRealms = $this->getTrans('realms');
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
						$cleanName = trim($oldCustomAward->name);
						$this->info('');
						$this->info('Checking ' . $cleanName);
						while(!array_key_exists($oldCustomAward->kingdom_id, $transRealms)){
							$this->info('waiting for realm ' . $oldCustomAward->kingdom_id);
							sleep(5);
							$transRealms = $this->getTrans('realms');
						}
						DB::reconnect("mysqlBak");
						$foundAward = DB::table('awards')->where('awarder_type', 'Realm')->where('awarder_id', $transRealms[$oldCustomAward->kingdom_id])->where('name', $oldCustomAward->name)->first();
						if(!$foundAward){
							$this->info('');
							$this->info('Adding ' . $cleanName);
							$customAwardId = DB::table('awards')->insertGetId([
									'awarder_type' => 'Realm',
									'awarder_id' => $transRealms[$oldCustomAward->kingdom_id],
									'name' => $cleanName != '' ? $cleanName : 'Unknown Award ' . $oldCustomAward->kingdomaward_id,
									'is_ladder' => strpos($oldCustomAward->name, 'dreamkeeper') > -1 || strpos($oldCustomAward->name, 'hell') > -1 ? 0 : 1
							]);
							DB::table('trans')->insert([
									'array' => 'realmawardsprocessed',
									'oldID' => $oldCustomAward->kingdomaward_id,
									'newID' => $customAwardId
							]);
							$realmawardsProcessed[(int)$oldCustomAward->kingdomaward_id] = $customAwardId;
							DB::table('trans')->insert([
									'array' => 'realmawards',
									'oldID' => $oldCustomAward->kingdomaward_id,
									'newID' => $customAwardId
							]);
							$transRealmawards[(int)$oldCustomAward->kingdomaward_id] = $customAwardId;
						}else{
							$this->info('');
							$this->info('Recording ' . $cleanName);
							DB::table('trans')->insert([
									'array' => 'realmawardsprocessed',
									'oldID' => $oldCustomAward->kingdomaward_id,
									'newID' => $foundAward->id
							]);
							$realmawardsProcessed[(int)$oldCustomAward->kingdomaward_id] = $foundAward->id;
							DB::table('trans')->insert([
									'array' => 'realmawards',
									'oldID' => $oldCustomAward->kingdomaward_id,
									'newID' => $foundAward->id
							]);
							$transRealmawards[(int)$oldCustomAward->kingdomaward_id] = $foundAward->id;
						}
						$bar->advance();
					}
					break;
				case 'Titles':
					$this->info('Importing Titles...');
					$transTitles = [];
					$transRealms = $this->getTrans('realms');
					$transRealmTitles = $this->getTrans('realmtitles');
					$oldTitles = $backupConnect->table('ork_award')->where('is_title', 1)->get()->toArray();
					$bar = $this->output->createProgressBar(392);
					$bar->start();
					$titleId = 0;
					//first the RoP titles
					foreach ($oldTitles as $oldTitle) {
						if(in_array($oldTitle->award_id, $ropTitles)){
							$rank = $oldTitle->title_class;
							$cleanName = trim($oldTitle->name);
							$titleCheck = null;
							$titleableType = 'Realm';
							
							//if it exists, let's not remake it
							$titleCheck = Title::where('name', $cleanName)->orWhere('name', 'LIKE', $cleanName . '|%')->orWhere('name', 'LIKE', '%|' . $cleanName)->whereNull('titleable_id')->first();
							if($titleCheck){
								DB::table('trans')->insert([
										'array' => 'titles',
										'oldID' => $oldTitle->award_id,
										'oldMID' => null,
										'newID' => $titleCheck->id
								]);
								$transTitles[0][$oldTitle->award_id] = $titleCheck->id;
								$realmawards = $backupConnect->table('ork_kingdomaward')->where('award_id', $oldTitle->award_id)->get()->toArray();
								foreach($realmawards as $realmaward){
									DB::table('trans')->insert([
											'array' => 'realmawards',
											'oldID' => $realmaward->kingdomaward_id,
											'newID' => $titleCheck->id
									]);
									$transRealmawards[(int)$realmaward->kingdomaward_id] = $titleId;
									DB::table('trans')->insert([
											'array' => 'realmawardsprocessed',
											'oldID' => $realmaward->kingdomaward_id,
											'newID' => $titleCheck->id
									]);
									$realmawardsProcessed[(int)$realmaward->kingdomaward_id] = $titleCheck->id;
								}
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
									$titleableType = 'Persona';
									$peerage = 'Retainer';
									break;
								case 'Man-At-Arms':
									$titleableType = 'Persona';
									$peerage = 'Retainer';
									break;
								case 'Page':
									$titleableType = 'Persona';
									$peerage = 'Retainer';
									break;
								case 'Squire':
									$titleableType = 'Persona';
									break;
								default:
									$peerage = $oldTitle->peerage;
							}
							$titleId = DB::table('titles')->insertGetId([
									'titleable_type' => $titleableType,
									'titleable_id' => null,
									'name' => $cleanName,
									'rank' => $rank,
									'peerage' => $peerage,
									'is_roaming' => 0,
									'is_active' => $cleanName === 'Paragon Raider' ? 0 : 1
							]);
							DB::table('trans')->insert([
									'array' => 'titles',
									'oldID' => $oldTitle->award_id,
									'oldMID' => null,
									'newID' => $titleId
							]);
							$transTitles[0][$oldTitle->award_id] = $titleId;
							$realmawards = $backupConnect->table('ork_kingdomaward')->where('award_id', $oldTitle->award_id)->get()->toArray();
							foreach($realmawards as $realmaward){
								DB::table('trans')->insert([
										'array' => 'realmawards',
										'oldID' => $realmaward->kingdomaward_id,
										'newID' => $titleId
								]);
								$transRealmawards[(int)$realmaward->kingdomaward_id] = $titleId;
								DB::table('trans')->insert([
										'array' => 'realmawardsprocessed',
										'oldID' => $realmaward->kingdomaward_id,
										'newID' => $titleId
								]);
								$realmawardsProcessed[(int)$realmaward->kingdomaward_id] = $titleId;
							}
							$bar->advance();
						}
					}
					
					//now the known titles
					foreach($knownTitles as $title => $realmInfo){
						//find the $oldTitle with name === $title
						$foundTitle = null;
						foreach($oldTitles as $ot){
							if($ot->name === $title){
								$foundTitle = $ot;
								break;
							}
						}
						foreach($realmInfo as $rid => $info){
							if($info){
								while(!array_key_exists($rid, $transRealms)){
									$this->info('waiting for realm ' . $rid);
									sleep(5);
									$transRealms = $this->getTrans('realms');
								}
								DB::reconnect("mysqlBak");
								$titleId = DB::table('titles')->insertGetId([
										'titleable_type' => 'Realm',
										'titleable_id' => $transRealms[$rid],
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
											'oldMID' => $rid,
											'newID' => $titleId
									]);
									$transTitles[$rid][$foundTitle->award_id] = $titleId;
									$realmawards = $backupConnect->table('ork_kingdomaward')->where('award_id', $foundTitle->award_id)->where('kingdom_id', $rid)->get()->toArray();
									foreach($realmawards as $realmaward){
										DB::table('trans')->insert([
												'array' => 'realmawards',
												'oldID' => $realmaward->kingdomaward_id,
												'newID' => $titleId
										]);
										$transRealmawards[(int)$realmaward->kingdomaward_id] = $titleId;
										DB::table('trans')->insert([
												'array' => 'realmawardsprocessed',
												'oldID' => $realmaward->kingdomaward_id,
												'newID' => $titleId
										]);
										$realmawardsProcessed[(int)$realmaward->kingdomaward_id] = $titleId;
									}
								}else{
									$oldRealmaward = $backupConnect->table('ork_kingdomaward')->where('kingdom_id', $rid)->where('name', $info['name'])->first();
									if($oldRealmaward){
										DB::table('trans')->insert([
												'array' => 'realmtitles',
												'oldID' => $oldRealmaward->kingdomaward_id,
												'oldMID' => $rid,
												'newID' => $titleId
										]);
										$transRealmTitles[(int)$rid][(int)$oldRealmaward->kingdomaward_id] = $titleId;
									}
								}
								
								//translate the fem into this one
								if($title === 'Lord'){
									foreach($oldTitles as $ot){
										if($ot->name === 'Lady'){
											DB::table('trans')->insert([
													'array' => 'titles',
													'oldID' => $ot->award_id,
													'oldMID' => $rid,
													'newID' => $titleId
											]);
											$transTitles[$rid][$ot->award_id] = $titleId;
											$realmawards = $backupConnect->table('ork_kingdomaward')->where('award_id', $ot->award_id)->where('kingdom_id', $rid)->get()->toArray();
											foreach($realmawards as $realmaward){
												DB::table('trans')->insert([
														'array' => 'realmawards',
														'oldID' => $realmaward->kingdomaward_id,
														'newID' => $titleId
												]);
												$transRealmawards[(int)$realmaward->kingdomaward_id] = $titleId;
												DB::table('trans')->insert([
														'array' => 'realmawardsprocessed',
														'oldID' => $realmaward->kingdomaward_id,
														'newID' => $titleId
												]);
												$realmawardsProcessed[(int)$realmaward->kingdomaward_id] = $titleId;
											}
											break;
										}
									}
								}else if($title === 'Baron'){
									foreach($oldTitles as $ot){
										if($ot->name === 'Baroness'){
											DB::table('trans')->insert([
													'array' => 'titles',
													'oldID' => $ot->award_id,
													'oldMID' => $rid,
													'newID' => $titleId
											]);
											$transTitles[$rid][$ot->award_id] = $titleId;
											$realmawards = $backupConnect->table('ork_kingdomaward')->where('award_id', $ot->award_id)->where('kingdom_id', $rid)->get()->toArray();
											foreach($realmawards as $realmaward){
												DB::table('trans')->insert([
														'array' => 'realmawards',
														'oldID' => $realmaward->kingdomaward_id,
														'newID' => $titleId
												]);
												$transRealmawards[(int)$realmaward->kingdomaward_id] = $titleId;
												DB::table('trans')->insert([
														'array' => 'realmawardsprocessed',
														'oldID' => $realmaward->kingdomaward_id,
														'newID' => $titleId
												]);
												$realmawardsProcessed[(int)$realmaward->kingdomaward_id] = $titleId;
											}
											break;
										}
									}
								}else if($title === 'Baronet'){
									foreach($oldTitles as $ot){
										if($ot->name === 'Baronetess'){
											DB::table('trans')->insert([
													'array' => 'titles',
													'oldID' => $ot->award_id,
													'oldMID' => $rid,
													'newID' => $titleId
											]);
											$transTitles[$rid][$ot->award_id] = $titleId;
											$realmawards = $backupConnect->table('ork_kingdomaward')->where('award_id', $ot->award_id)->where('kingdom_id', $rid)->get()->toArray();
											foreach($realmawards as $realmaward){
												DB::table('trans')->insert([
														'array' => 'realmawards',
														'oldID' => $realmaward->kingdomaward_id,
														'newID' => $titleId
												]);
												$transRealmawards[(int)$realmaward->kingdomaward_id] = $titleId;
												DB::table('trans')->insert([
														'array' => 'realmawardsprocessed',
														'oldID' => $realmaward->kingdomaward_id,
														'newID' => $titleId
												]);
												$realmawardsProcessed[(int)$realmaward->kingdomaward_id] = $titleId;
											}
											break;
										}
									}
								}else if($title === 'Count'){
									foreach($oldTitles as $ot){
										if($ot->name === 'Countess'){
											DB::table('trans')->insert([
													'array' => 'titles',
													'oldID' => $ot->award_id,
													'oldMID' => $rid,
													'newID' => $titleId
											]);
											$transTitles[$rid][$ot->award_id] = $titleId;
											$realmawards = $backupConnect->table('ork_kingdomaward')->where('award_id', $ot->award_id)->where('kingdom_id', $rid)->get()->toArray();
											foreach($realmawards as $realmaward){
												DB::table('trans')->insert([
														'array' => 'realmawards',
														'oldID' => $realmaward->kingdomaward_id,
														'newID' => $titleId
												]);
												$transRealmawards[(int)$realmaward->kingdomaward_id] = $titleId;
												DB::table('trans')->insert([
														'array' => 'realmawardsprocessed',
														'oldID' => $realmaward->kingdomaward_id,
														'newID' => $titleId
												]);
												$realmawardsProcessed[(int)$realmaward->kingdomaward_id] = $titleId;
											}
											break;
										}
									}
								}else if($title === 'Duke'){
									foreach($oldTitles as $ot){
										if($ot->name === 'Duchess'){
											DB::table('trans')->insert([
													'array' => 'titles',
													'oldID' => $ot->award_id,
													'oldMID' => $rid,
													'newID' => $titleId
											]);
											$transTitles[$rid][$ot->award_id] = $titleId;
											$realmawards = $backupConnect->table('ork_kingdomaward')->where('award_id', $ot->award_id)->where('kingdom_id', $rid)->get()->toArray();
											foreach($realmawards as $realmaward){
												DB::table('trans')->insert([
														'array' => 'realmawards',
														'oldID' => $realmaward->kingdomaward_id,
														'newID' => $titleId
												]);
												$transRealmawards[(int)$realmaward->kingdomaward_id] = $titleId;
												DB::table('trans')->insert([
														'array' => 'realmawardsprocessed',
														'oldID' => $realmaward->kingdomaward_id,
														'newID' => $titleId
												]);
												$realmawardsProcessed[(int)$realmaward->kingdomaward_id] = $titleId;
											}
											break;
										}
									}
								}else if($title === 'Archduke'){
									foreach($oldTitles as $ot){
										if($ot->name === 'Archduchess'){
											DB::table('trans')->insert([
													'array' => 'titles',
													'oldID' => $ot->award_id,
													'oldMID' => $rid,
													'newID' => $titleId
											]);
											$transTitles[$rid][$ot->award_id] = $titleId;
											$realmawards = $backupConnect->table('ork_kingdomaward')->where('award_id', $ot->award_id)->where('kingdom_id', $rid)->get()->toArray();
											foreach($realmawards as $realmaward){
												DB::table('trans')->insert([
														'array' => 'realmawards',
														'oldID' => $realmaward->kingdomaward_id,
														'newID' => $titleId
												]);
												$transRealmawards[(int)$realmaward->kingdomaward_id] = $titleId;
												DB::table('trans')->insert([
														'array' => 'realmawardsprocessed',
														'oldID' => $realmaward->kingdomaward_id,
														'newID' => $titleId
												]);
												$realmawardsProcessed[(int)$realmaward->kingdomaward_id] = $titleId;
											}
											break;
										}
									}
								}else if($title === 'Grand Duke'){
									foreach($oldTitles as $ot){
										if($ot->name === 'Grand Duchess'){
											DB::table('trans')->insert([
													'array' => 'titles',
													'oldID' => $ot->award_id,
													'oldMID' => $rid,
													'newID' => $titleId
											]);
											$transTitles[$rid][$ot->award_id] = $titleId;
											$realmawards = $backupConnect->table('ork_kingdomaward')->where('award_id', $ot->award_id)->where('kingdom_id', $rid)->get()->toArray();
											foreach($realmawards as $realmaward){
												DB::table('trans')->insert([
														'array' => 'realmawards',
														'oldID' => $realmaward->kingdomaward_id,
														'newID' => $titleId
												]);
												$transRealmawards[(int)$realmaward->kingdomaward_id] = $titleId;
												DB::table('trans')->insert([
														'array' => 'realmawardsprocessed',
														'oldID' => $realmaward->kingdomaward_id,
														'newID' => $titleId
												]);
												$realmawardsProcessed[(int)$realmaward->kingdomaward_id] = $titleId;
											}
											break;
										}
									}
								}else if($title === 'Marquis'){
									foreach($oldTitles as $ot){
										if($ot->name === 'Marquess'){
											DB::table('trans')->insert([
													'array' => 'titles',
													'oldID' => $ot->award_id,
													'oldMID' => $rid,
													'newID' => $titleId
											]);
											$transTitles[$rid][$ot->award_id] = $titleId;
											$realmawards = $backupConnect->table('ork_kingdomaward')->where('award_id', $ot->award_id)->where('kingdom_id', $rid)->get()->toArray();
											foreach($realmawards as $realmaward){
												DB::table('trans')->insert([
														'array' => 'realmawards',
														'oldID' => $realmaward->kingdomaward_id,
														'newID' => $titleId
												]);
												$transRealmawards[(int)$realmaward->kingdomaward_id] = $titleId;
												DB::table('trans')->insert([
														'array' => 'realmawardsprocessed',
														'oldID' => $realmaward->kingdomaward_id,
														'newID' => $titleId
												]);
												$realmawardsProcessed[(int)$realmaward->kingdomaward_id] = $titleId;
											}
											break;
										}
									}
								}else if($title === 'Viscount'){
									foreach($oldTitles as $ot){
										if($ot->name === 'Viscountess'){
											DB::table('trans')->insert([
													'array' => 'titles',
													'oldID' => $ot->award_id,
													'oldMID' => $rid,
													'newID' => $titleId
											]);
											$transTitles[$rid][$ot->award_id] = $titleId;
											$realmawards = $backupConnect->table('ork_kingdomaward')->where('award_id', $ot->award_id)->where('kingdom_id', $rid)->get()->toArray();
											foreach($realmawards as $realmaward){
												DB::table('trans')->insert([
														'array' => 'realmawards',
														'oldID' => $realmaward->kingdomaward_id,
														'newID' => $titleId
												]);
												$transRealmawards[(int)$realmaward->kingdomaward_id] = $titleId;
												DB::table('trans')->insert([
														'array' => 'realmawardsprocessed',
														'oldID' => $realmaward->kingdomaward_id,
														'newID' => $titleId
												]);
												$realmawardsProcessed[(int)$realmaward->kingdomaward_id] = $titleId;
											}
											break;
										}
									}
								}else if($title === 'Grand Marquis'){
									foreach($oldTitles as $ot){
										if($ot->name === 'Grand Marquess'){
											DB::table('trans')->insert([
													'array' => 'titles',
													'oldID' => $ot->award_id,
													'oldMID' => $rid,
													'newID' => $titleId
											]);
											$transTitles[$rid][$ot->award_id] = $titleId;
											$realmawards = $backupConnect->table('ork_kingdomaward')->where('award_id', $ot->award_id)->where('kingdom_id', $rid)->get()->toArray();
											foreach($realmawards as $realmaward){
												DB::table('trans')->insert([
														'array' => 'realmawards',
														'oldID' => $realmaward->kingdomaward_id,
														'newID' => $titleId
												]);
												$transRealmawards[(int)$realmaward->kingdomaward_id] = $titleId;
												DB::table('trans')->insert([
														'array' => 'realmawardsprocessed',
														'oldID' => $realmaward->kingdomaward_id,
														'newID' => $titleId
												]);
												$realmawardsProcessed[(int)$realmaward->kingdomaward_id] = $titleId;
											}
											break;
										}
									}
								}
								$bar->advance();
							}else{
								$bar->advance();
							}
						}
					}
					
					//whatever is left
					foreach ($oldTitles as $oldTitle) {
						//not if they're in ropTitles
						if(in_array($oldTitle->award_id, $ropTitles)){
							continue;
						}
						//not if they're in knownTitles
						foreach($knownTitles as $title => $realmInfo){
							if($oldTitle->name === $title){
								continue 2;
							}
						}
						DB::table('crypt')->insert([
								'model' 		=> 'Title',
								'cause' 		=> 'Femms',
								'model_id'		=> $oldTitle->award_id,
								'model_value'	=> json_encode($oldTitle)
						]);
					}
					break;
				case 'CustomTitles':
					$this->info('Importing Custom Titles...');
					$transRealms = $this->getTrans('realms');
					$transChapters = $this->getTrans('chapters');
					$transNonNobles = $this->getTrans('nonnobletitles');
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
					$oldCustomNonnobles = $backupConnect->table('ork_awards')->where('kingdomaward_id', 6036)->get()->toArray();
					$bar = $this->output->createProgressBar(count($oldCustomTitles) + count($oldCustomNonnobles));
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
						
						while(!array_key_exists($oldCustomTitle->kingdom_id, $transRealms)){
							$this->info('waiting for realm ' . $oldCustomTitle->kingdom_id);
							sleep(5);
							$transRealms = $this->getTrans('realms');
						}
						DB::reconnect("mysqlBak");
						
						while(!array_key_exists(907, $transChapters)){
							$this->info('waiting for chapter 907');
							sleep(5);
							$transChapters = $this->getTrans('chapters');
						}
						DB::reconnect("mysqlBak");
						
						//check to see if this one exists yet
						$titleExists = Title::where('name', $nameClean)->orWhere('name', 'LIKE', $nameClean . '|%')->orWhere('name', 'LIKE', '%|' . $nameClean)->where(function($query) use(&$oldCustomTitle, &$transRealms){
							$query->whereNull('titleable_id');
							$query->orWhere('titleable_id', $transRealms[$oldCustomTitle->kingdom_id]);
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
									'titleable_type' => $nameClean === 'Valkyrie\'s Chosen' ? 'Chapter' : 'Realm',
									'titleable_id' => $nameClean === 'Valkyrie\'s Chosen' ? $transChapters[907] : $transRealms[$oldCustomTitle->kingdom_id],
									'name' => $nameClean,
									'rank' => $rank,
									'peerage' => $peerage,
									'is_roaming' => 0,
									'is_active' => $nameClean === 'Master' || $nameClean === 'Esquire' ? 0 : 1
							]);
							DB::table('trans')->insert([
									'array' => 'realmtitles',
									'oldID' => $oldCustomTitle->kingdomaward_id,
									'oldMID' => $oldCustomTitle->kingdom_id,
									'newID' => $customTitleId
							]);
							$transRealmTitles[(int)$oldCustomTitle->kingdom_id][(int)$oldCustomTitle->kingdomaward_id] = $customTitleId;
						}else{
							DB::table('trans')->insert([
									'array' => 'realmtitles',
									'oldID' => $oldCustomTitle->kingdomaward_id,
									'oldMID' => $oldCustomTitle->kingdom_id,
									'newID' => $titleExists->id
							]);
							$transRealmTitles[(int)$oldCustomTitle->kingdom_id][(int)$oldCustomTitle->kingdomaward_id] = $titleExists->id;
						}
						DB::table('trans')->insert([
								'array' => 'realmawards',
								'oldID' => $oldCustomTitle->kingdomaward_id,
								'newID' => $customTitleId ? $customTitleId : $titleExists->id
						]);
						$transRealmawards[(int)$oldCustomTitle->kingdomaward_id] = $customTitleId ? $customTitleId : $titleExists->id;
						DB::table('trans')->insert([
								'array' => 'realmawardsprocessed',
								'oldID' => $oldCustomTitle->kingdomaward_id,
								'newID' => $customTitleId ? $customTitleId : $titleExists->id
						]);
						$realmawardsProcessed[(int)$oldCustomTitle->kingdomaward_id] = $customTitleId ? $customTitleId : $titleExists->id;
						$bar->advance();
					}
					
					foreach ($oldCustomNonnobles as $oldCustomNonnoble) {
						$customTitleId = null;
						$nameFor = $this->cleanCustomNonNobles($oldCustomNonnoble->note);
						$nameClean = $nameFor['name'];
						
						//we're adding these as park titles, so we need a park.
						if($oldCustomNonnoble->park_id == '0' && $oldCustomNonnoble->at_park_id == '0'){
							//don't need to record these in the crypt, it'll get handled in Issuances
							$bar->advance();
							continue;
						}else{
							$parkID = ($oldCustomNonnoble->park_id != '0' ? $oldCustomNonnoble->park_id : $oldCustomNonnoble->at_park_id);
						}
						
						//no note, no title
						if($oldCustomNonnoble->note == ''){
							//don't need to record these in the crypt, it'll get handled in Issuances
							$bar->advance();
							continue;
						}
						
						while(!array_key_exists($parkID, $transChapters)){
							$this->info('waiting for chapter ' . $parkID);
							sleep(5);
							$transRealms = $this->getTrans('chapters');
						}
						DB::reconnect("mysqlBak");
						
						//check to see if this one exists yet
						$titleExists = Title::where('name', $nameClean)->where('titleable_type', 'Chapter')->where('titleable_id', $parkID)->first();
						
						if(!$titleExists){
							$peerage = 'None';
							$rank = null;
							$customTitleId = DB::table('titles')->insertGetId([
									'titleable_type' => 'Chapter',
									'titleable_id' => $parkID,
									'name' => $nameClean,
									'rank' => $rank,
									'peerage' => $peerage,
									'is_roaming' => 0,
									'is_active' => 1
							]);
							DB::table('trans')->insert([
									'array' => 'nonnobletitles',
									'oldID' => $oldCustomNonnoble->awards_id,
									'newID' => $customTitleId
							]);
							$transNonNobles[(int)$oldCustomNonnoble->awards_id] = $customTitleId;
						}else{
							DB::table('trans')->insert([
									'array' => 'nonnobletitles',
									'oldID' => $oldCustomNonnoble->awards_id,
									'newID' => $titleExists->id
							]);
							$transNonNobles[(int)$oldCustomNonnoble->awards_id] = $titleExists->id;
						}
						$bar->advance();
					}
					break;
				case 'Offices':
					$this->info('Creating Offices...');
					$count = 0;
					$transRealms = $this->getTrans('realms');
					foreach($knownRealmChaptertypesOffices as $d){
						$count = $count + array_sum(array_map("count", $d));
					}
					$bar = $this->output->createProgressBar($count);
					$bar->start();
					//create from known offices (that was a lot of corpora reading I just did)
					foreach($knownRealmChaptertypesOffices as $rid => $knownRealmChaptertypesOffice){
						foreach($knownRealmChaptertypesOffice as $chaptertype => $offices){
							while(!array_key_exists($rid, $transRealms)){
								$this->info('waiting for realm ' . $rid);
								sleep(5);
								$transRealms = $this->getTrans('realms');
							}
							DB::reconnect("mysqlBak");
							$officeableType = $chaptertype != 'Kingdom' ? 'Chaptertype' : 'Realm';
							$officeableID = $officeableType === 'Realm' ? $transRealms[$rid] : null;
							if(!$officeableID){
								$chaptertypeArray = Chaptertype::where('realm_id', $transRealms[$rid])->where('name', $chaptertype)->first();
								while(!$chaptertypeArray){
									$this->info('waiting for realm/chaptertype (' . $rid . ') ' . $transRealms[$rid] . '/' . $chaptertype);
									sleep(5);
									$chaptertypeArray = null;
									$chaptertypeArray = Chaptertype::where('realm_id', $transRealms[$rid])->where('name', $chaptertype)->first();
								}
								DB::reconnect("mysqlBak");
								$officeableID = $chaptertypeArray->id;
							}
							foreach($offices as $office => $officeData){
								$officeID = DB::table('offices')->insertGetId([
										'officeable_type' => $officeableType,
										'officeable_id' => $officeableID,
										'name' => $office,
										'duration' => $officeData['duration'],
										'order' => array_key_exists('order', $officeData) ? $officeData['order'] : null
								]);
								//find it in kingdomawards, then add it to transOffices
								//TODO: check me!
								if(is_array($officeData['award_ids'])){
									foreach($officeData['award_ids'] as $award_id){
										$realmawards = $backupConnect->table('ork_kingdomaward')->where('kingdom_id', $rid)->where('award_id', $award_id)->get()->toArray();
										if($realmawards){
											foreach($realmawards as $realmaward){
												DB::table('trans')->insert([
														'array' => 'offices',
														'oldID' => $realmaward->kingdomaward_id,
														'newID' => $officeID
												]);
												$transOffices[(int)$realmaward->kingdomaward_id] = $officeID;
											}
										}
									}
								}
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
					$this->info('Importing Users/Personas/Guests/Memberships/Suspensions/Waivers...');
					$usedEmails = [];
					$suspensionsWaitList = [];
					$transUsers = [];
					$transPersonas = [];
					$oldUnits = $backupConnect->table('ork_unit')->where('type', '!=', '')->pluck('unit_id')->toArray();
					$transUnits = $this->getTrans('units');
					$transChapters = $this->getTrans('chapters');
					$transRealms = $this->getTrans('realms');
					$bar = $this->output->createProgressBar($backupConnect->table('ork_mundane')->count());
					$bar->start();
					$backupConnect->table('ork_mundane')->orderBy('mundane_id')->chunk(1000, function ($oldUsers) use (&$usedEmails, $backupConnect, &$suspensionsWaitList, &$transUsers, &$transPersonas, &$bar, &$transUnits, &$transChapters, &$transRealms, &$oldUnits){
						foreach($oldUsers as $oldUser) {
							$pronounId = null;
							$userId = null;
							$isDemo = false;
							$personaId = null;
							//don't redo this one
							if($oldUser->username === 'orkadmin'){
								DB::table('trans')->insert([
										'array' => 'personas',
										'oldID' => $oldUser->mundane_id,
										'newID' => 1
								]);
								$transPersonas[$oldUser->mundane_id] = 1;
								continue;
							}
							while(!array_key_exists($oldUser->kingdom_id, $transRealms)){
								$this->info('waiting for realm ' . $oldUser->kingdom_id);
								sleep(5);
								$transRealms = $this->getTrans('realms');
							}
							DB::reconnect("mysqlBak");
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
										throw new \Exception($oldUser->given_name . ' for gender ' . $gender->name);
									}
								}else{
									$pronounId = null;
								}
							}else{
								$pronounId = $oldUser->pronoun_id;
							}
							//obvious demo people only get a waiver.  There's no event to tie 'em to.
							if(
									str_contains($oldUser->persona, 'zzc2e2_') ||
									str_contains($oldUser->persona, 'zzsc')
									){
										$isDemo = true;
							}
							
							if(!$isDemo){
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
											$roleExists = Role::where('name', 'admin')->exists();
											while(!$roleExists){
												$this->info('waiting for role admin');
												sleep(5);
												$roleExists = Role::where('name', 'admin')->exists();
											}
											DB::reconnect("mysqlBak");
											$user->assignRole('admin');
										}else if(count($offices) > 0){
											$roleExists = Role::where('name', 'officer')->exists();
											while(!$roleExists){
												$this->info('waiting for role officer');
												sleep(5);
												$roleExists = Role::where('name', 'officer')->exists();
											}
											DB::reconnect("mysqlBak");
											$user->assignRole('officer');
										}else{
											$roleExists = Role::where('name', 'player')->exists();
											while(!$roleExists){
												$this->info('waiting for role player');
												sleep(5);
												$roleExists = Role::where('name', 'player')->exists();
											}
											DB::reconnect("mysqlBak");
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
										DB::table('crypt')->insert([
												'model' 		=> 'User',
												'cause' 		=> 'DuplicateEmail',
												'model_id'		=> $oldUser->mundane_id,
												'model_value'	=> json_encode($oldUser)
										]);
									}
								}
								
								//clean up the persona name
								$personaName = $this->cleanPersona($oldUser->persona, trim($oldUser->given_name) . ' ' . trim($oldUser->surname));
								$personaName = $this->stripTitles($personaName);
								
								if($oldUser->park_id == 0){
									$burningLands = $backupConnect->table('ork_park')->where('name', 'Burning Lands')->first();
								}
								
								//wait for the chapter to exist
								while(!array_key_exists(($oldUser->park_id == 0 ? $burningLands->park_id : $oldUser->park_id), $transChapters)){
									$this->info('waiting for chapter ' . ($oldUser->park_id == 0 ? $burningLands->park_id : $oldUser->park_id));
									sleep(5);
									$transChapters = $this->getTrans('chapters');
								}
								DB::reconnect("mysqlBak");
								
								//persona data
								$personaId = DB::table('personas')->insertGetId([
										'chapter_id' => $oldUser->park_id == 0 ? $transChapters[$burningLands->park_id] : $transChapters[$oldUser->park_id],
										'user_id' => $userId,
										'pronoun_id' => $pronounId,
										'mundane' => trim($oldUser->given_name) != '' || trim($oldUser->surname) != '' ? str_ireplace('zzz', '', trim($oldUser->given_name)) . ' ' . str_ireplace('zzz', '', trim($oldUser->surname)) : null,
										'name' => $personaName,
										'heraldry' => $oldUser->has_heraldry === '1' ? sprintf('%06d.jpg', $oldUser->mundane_id) : null,
										'image' => $oldUser->has_image === '1' ? sprintf('%06d.jpg', $oldUser->mundane_id) : null,
										'is_active' => $oldUser->active === '1' ? 1 : 0,
										'reeve_qualified_expires_at' => $oldUser->reeve_qualified != 1 ? null : ($oldUser->reeve_qualified_until === '0000-00-00' ? date('Y-m-d', strtotime('+20 years')) : $oldUser->reeve_qualified_until),
										'corpora_qualified_expires_at' => $oldUser->corpora_qualified != 1 ? null : ($oldUser->corpora_qualified_until === '0000-00-00' ? date('Y-m-d', strtotime('+20 years')) : $oldUser->corpora_qualified_until),
										'joined_chapter_at' => $oldUser->park_member_since === '0000-00-00' || $userId === 1 ? null : $oldUser->park_member_since,
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
								if ($oldUser->company_id > 0 && $oldUser->park_id != 0) {
									if (in_array($oldUser->company_id, $oldUnits)) {
										//wait for the unit to exist
										while(!array_key_exists($oldUser->company_id, $transUnits)){
											$this->info('waiting for unit ' . $oldUser->company_id);
											sleep(5);
											$transUnits = $this->getTrans('units');
										}
										DB::reconnect("mysqlBak");
										DB::table('members')->insert([
												'unit_id' => $transUnits[$oldUser->company_id],
												'persona_id' => $personaId,
												'joined_at' => null,
												'left_at' => null,
												'is_head' => 0,
												'is_voting' => 1
										]);
									}else{
										DB::table('crypt')->insert([
												'model' 		=> 'Unit',
												'cause' 		=> 'Deleted',
												'model_id'		=> $oldUser->company_id,
												'model_value'	=> json_encode($oldUser)
										]);
									}
								}
								
								//suspensions data
								if($oldUser->suspended > 0){
									if (!$oldUser->suspended_by_id || array_key_exists($oldUser->suspended_by_id, $transPersonas)) {
										DB::table('suspensions')->insertGetId([
												'persona_id' => $personaId,
												'realm_id' => $transRealms[$oldUser->kingdom_id],
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
								}
							}else{
								DB::table('crypt')->insert([
										'model' 		=> 'Personas',
										'cause' 		=> 'Demo',
										'model_id'		=> $oldUser->mundane_id,
										'model_value'	=> json_encode($oldUser)
								]);
							}
							
							//waiver data
							if($oldUser->waivered > 0 && trim($oldUser->given_name) != '' && trim($oldUser->surname) != '' && $oldUser->park_id != 0){
								DB::table('waivers')->insertGetId([
										'pronoun_id' => $pronounId,
										'persona_id' => $personaId,
										'waiverable_type' => 'Realm',
										'waiverable_id' => $transRealms[$oldUser->kingdom_id],
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
								while(!array_key_exists($oldUser->kingdom_id, $transRealms)){
									$this->info('waiting for realm ' . $oldUser->kingdom_id);
									sleep(5);
									$transRealms = $this->getTrans('realms');
								}
								DB::reconnect("mysqlBak");
								DB::table('suspensions')->insertGetId([
										'persona_id' => $transPersonas[$oldUser->mundane_id],
										'realm_id' => $transRealms[$oldUser->kingdom_id],
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
					$transEventDetails = [];
					$transRealms = $this->getTrans('realms');
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
						$eventable_type = $oldEvent->unit_id > 0 ? 'Unit' : ($oldEvent->mundane_id > 0 && ($oldEvent->kingdom_id == 0 && $oldEvent->park_id == 0) ? 'Persona' : ($oldEvent->park_id > 0 && $oldEvent->kingdom_id == 0 ? 'Chapter' : 'Realm'));
						if($oldEvent->kingdom_id && $oldEvent->kingdom_id != 0 && array_key_exists($oldEvent->kingdom_id, $knownRealmChaptertypesOffices)){
							while(!array_key_exists($oldEvent->kingdom_id, $transRealms)){
								$this->info('waiting for realm ' . $oldEvent->kingdom_id);
								sleep(5);
								$transRealms = $this->getTrans('realms');
							}
							DB::reconnect("mysqlBak");
						}
						if($oldEvent->kingdom_id && $oldEvent->kingdom_id != 0 && !array_key_exists($oldEvent->kingdom_id, $transRealms)){
							$transRealms = $this->getTrans('realms');
							if(!array_key_exists($oldEvent->kingdom_id, $transRealms)){
								$realmId = DB::table('realms')->insertGetId([
										'parent_id' => null,
										'name' => 'Deleted Realm ' . $oldEvent->kingdom_id,
										'abbreviation' => 'DK' . $oldEvent->kingdom_id,
										'heraldry' => null,
										'is_active' => 0
								]);
								DB::table('trans')->insert([
										'array' => 'realms',
										'oldID' => $oldEvent->kingdom_id,
										'newID' => $realmId
								]);
								$transRealms = $this->getTrans('realms');
							}
						}
						if($oldEvent->mundane_id && $oldEvent->mundane_id != 0){
							//check old mundanes for existence
							$mundaneCheck = $backupConnect->table('ork_mundane')->where('mundane_id', $oldEvent->mundane_id)->first();
							if($mundaneCheck){
								if(!array_key_exists($oldEvent->mundane_id, $transPersonas)){
									while(!array_key_exists($oldEvent->mundane_id, $transPersonas)){
										$this->info('waiting for persona1 ' . $oldEvent->mundane_id);
										sleep(5);
										$transPersonas = $this->getTrans('personas');
									}
									DB::reconnect("mysqlBak");
								}
							}else{
								if($oldEvent->park_id != '0'){
									while(!array_key_exists($oldEvent->park_id, $transChapters)){
										$this->info('waiting for chapter ' . $oldEvent->park_id);
										sleep(5);
										$transChapters = $this->getTrans('chapters');
									}
									DB::reconnect("mysqlBak");
								}
								$personaId = DB::table('personas')->insertGetId([
										'chapter_id' => $oldEvent->park_id == '0' ? $burningLands->id : $transChapters[$oldEvent->park_id],
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
								DB::reconnect("mysqlBak");
								$eventable_id = $transUnits[$oldEvent->unit_id];
								break;
							case 'Persona':
								while(!array_key_exists($oldEvent->mundane_id, $transPersonas)){
									$this->info('waiting for persona2 ' . $oldEvent->mundane_id);
									sleep(5);
									$transPersonas = $this->getTrans('personas');
								}
								DB::reconnect("mysqlBak");
								$eventable_id = $transPersonas[$oldEvent->mundane_id];
								break;
							case 'Chapter':
								while(!array_key_exists($oldEvent->park_id, $transChapters)){
									$this->info('waiting for chapter ' . $oldEvent->park_id);
									sleep(5);
									$transChapters = $this->getTrans('chapters');
								}
								DB::reconnect("mysqlBak");
								$eventable_id = $transChapters[$oldEvent->park_id];
								break;
							case 'Realm':
								while(!array_key_exists($oldEvent->kingdom_id, $transRealms)){
									$this->info('waiting for realm ' . $oldEvent->kingdom_id);
									sleep(5);
									$transRealms = $this->getTrans('realms');
								}
								DB::reconnect("mysqlBak");
								$eventable_id = $transRealms[$oldEvent->kingdom_id];
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
								'is_demo' => str_contains(strtolower(trim($oldEvent->name)), 'demo') ? 1 : 0,
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
								$this->info('waiting for persona3 ' . $oldEvent->mundane_id);
								sleep(5);
								$transPersonas = $this->getTrans('personas');
							}
							DB::reconnect("mysqlBak");
							DB::table('crats')->insertGetId([
									'event_id' => $eventId,
									'persona_id' => $transPersonas[$oldEvent->mundane_id],
									'role' => 'Autocrat',
									'is_autocrat' => 1
							]);
						}
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
					$transRealms = $this->getTrans('realms');
					$transChapters = $this->getTrans('chapters');
					$transUnits = $this->getTrans('units');
					$oldAccounts = $backupConnect->table('ork_account')->orderBy('account_id')->get()->toArray();
					$oldRealms = $backupConnect->table('ork_kingdom')->pluck('kingdom_id')->toArray();
					$realmsDone = [];
					$bar = $this->output->createProgressBar(count($oldAccounts));
					$bar->start();
					foreach ($oldAccounts as $oldAccount) {
						$accountable_type = $oldAccount->unit_id > 0 ? 'Unit' : ($oldAccount->event_id > 0 ? 'Event' : ($oldAccount->park_id > 0 ? 'Chapter' : 'Realm'));
						switch($accountable_type){
							case 'Unit':
								while(!array_key_exists($oldAccount->unit_id, $transUnits)){
									$this->info('waiting for unit ' . $oldAccount->unit_id);
									sleep(5);
									$transUnits = $this->getTrans('units');
								}
								DB::reconnect("mysqlBak");
								$accountable_id = $transUnits[$oldAccount->unit_id];
								break;
							case 'Event':
								DB::table('crypt')->insert([
								'model' 		=> 'Accounts',
								'cause' 		=> 'Events',
								'model_id'		=> $oldAccount->account_id,
								'model_value'	=> json_encode($oldAccount)
								]);
								$bar->advance();
								continue 2;
							case 'Chapter':
								while(!array_key_exists($oldAccount->park_id, $transChapters)){
									$this->info('waiting for chapter ' . $oldAccount->park_id);
									sleep(5);
									$transChapters = $this->getTrans('chapters');
								}
								DB::reconnect("mysqlBak");
								$accountable_id = $transChapters[$oldAccount->park_id];
								break;
							case 'Realm':
								while(!array_key_exists($oldAccount->kingdom_id, $transRealms)){
									$this->info('waiting for realm ' . $oldAccount->kingdom_id);
									sleep(5);
									$transRealms = $this->getTrans('realms');
								}
								DB::reconnect("mysqlBak");
								$accountable_id = $transRealms[$oldAccount->kingdom_id];
								break;
							default:
								$accountable_id = null;
								break;
						}
						//since realm has possible dupes in the trans (combined realms), check for existence
						if($accountable_type === 'Realm'){
							$foundAccount = Account::where('accountable_type', $accountable_type)
								->where('accountable_id', $accountable_id)
								->where('name', trim($oldAccount->name))
								->where('type', $oldAccount->type)
								->first();
								if($foundAccount){
									DB::table('trans')->insert([
											'array' => 'accounts',
											'oldID' => $oldAccount->account_id,
											'newID' => $foundAccount->id
									]);
									$transAccounts[$oldAccount->account_id] = $foundAccount->id;
									$bar->advance();
									continue;
								}
						}
						$accountId = DB::table('accounts')->insertGetId([
								'parent_id' => $oldAccount->parent_id > 0 ? $transAccounts[$oldAccount->parent_id] : null,
								'accountable_type' => $accountable_type,
								'accountable_id' => $accountable_id,
								'name' => trim($oldAccount->name) === 'Kingdom Take' ? 'Realm Take' : trim($oldAccount->name),
								'type' => $oldAccount->type
						]);
						DB::table('trans')->insert([
								'array' => 'accounts',
								'oldID' => $oldAccount->account_id,
								'newID' => $accountId
						]);
						$transAccounts[$oldAccount->account_id] = $accountId;
						if($accountable_type === 'Realm'){
							$realmsDone[] = $oldAccount->kingdom_id;
						}
						$bar->advance();
					}
					//fill in missing realm data
					$this->info('Adding missing Realms...');
					//TODO: check me
					foreach($oldRealms as $oldRealm){
						if(!in_array($oldRealm->kingdom_id, $realmsDone)){
							$assetId = DB::table('accounts')->insertGetId([
									'parent_id' => null,
									'accountable_type' => $oldRealm->kingdom_id,
									'accountable_id' => $accountable_id,
									'name' => 'Assets',
									'type' => 'Asset'
							]);
							$liabilityId = DB::table('accounts')->insertGetId([
									'parent_id' => null,
									'accountable_type' => $oldRealm->kingdom_id,
									'accountable_id' => $accountable_id,
									'name' => 'Liability',
									'type' => 'Liability'
							]);
							DB::table('accounts')->insert([
									'parent_id' => null,
									'accountable_type' => $oldRealm->kingdom_id,
									'accountable_id' => $accountable_id,
									'name' => 'Equity',
									'type' => 'Equity'
							]);
							$incomeId = DB::table('accounts')->insertGetId([
									'parent_id' => null,
									'accountable_type' => $oldRealm->kingdom_id,
									'accountable_id' => $accountable_id,
									'name' => 'Income',
									'type' => 'Income'
							]);
							DB::table('accounts')->insert([
									'parent_id' => null,
									'accountable_type' => $oldRealm->kingdom_id,
									'accountable_id' => $accountable_id,
									'name' => 'Imbalance',
									'type' => 'Imbalance'
							]);
							$expensesId = DB::table('accounts')->insertGetId([
									'parent_id' => null,
									'accountable_type' => $oldRealm->kingdom_id,
									'accountable_id' => $accountable_id,
									'name' => 'Expenses',
									'type' => 'Expenses'
							]);
							DB::table('accounts')->insert([
									'parent_id' => $assetId,
									'accountable_type' => $oldRealm->kingdom_id,
									'accountable_id' => $accountable_id,
									'name' => 'Checking',
									'type' => 'Asset'
							]);
							DB::table('accounts')->insert([
									'parent_id' => $assetId,
									'accountable_type' => $oldRealm->kingdom_id,
									'accountable_id' => $accountable_id,
									'name' => 'Park Dues',
									'type' => 'Asset'
							]);
							DB::table('accounts')->insert([
									'parent_id' => $assetId,
									'accountable_type' => $oldRealm->kingdom_id,
									'accountable_id' => $accountable_id,
									'name' => 'Cash',
									'type' => 'Asset'
							]);
							DB::table('accounts')->insert([
									'parent_id' => $incomeId,
									'accountable_type' => $oldRealm->kingdom_id,
									'accountable_id' => $accountable_id,
									'name' => 'Dues Paid',
									'type' => 'Income'
							]);
							DB::table('accounts')->insert([
									'parent_id' => $incomeId,
									'accountable_type' => $oldRealm->kingdom_id,
									'accountable_id' => $accountable_id,
									'name' => 'Donations',
									'type' => 'Income'
							]);
							DB::table('accounts')->insert([
									'parent_id' => $expensesId,
									'accountable_type' => $oldRealm->kingdom_id,
									'accountable_id' => $accountable_id,
									'name' => 'Realm Take',
									'type' => 'Expenses'
							]);
							DB::table('accounts')->insert([
									'parent_id' => $expensesId,
									'accountable_type' => $oldRealm->kingdom_id,
									'accountable_id' => $accountable_id,
									'name' => 'Supplies',
									'type' => 'Expenses'
							]);
							DB::table('accounts')->insert([
									'parent_id' => $expensesId,
									'accountable_type' => $oldRealm->kingdom_id,
									'accountable_id' => $accountable_id,
									'name' => 'Events',
									'type' => 'Expenses'
							]);
							DB::table('accounts')->insert([
									'parent_id' => $expensesId,
									'accountable_type' => $oldRealm->kingdom_id,
									'accountable_id' => $accountable_id,
									'name' => 'Miscellaneous',
									'type' => 'Expenses'
							]);
							DB::table('accounts')->insert([
									'parent_id' => $expensesId,
									'accountable_type' => $oldRealm->kingdom_id,
									'accountable_id' => $accountable_id,
									'name' => 'Food',
									'type' => 'Expenses'
							]);
							DB::table('accounts')->insert([
									'parent_id' => $expensesId,
									'accountable_type' => $oldRealm->kingdom_id,
									'accountable_id' => $accountable_id,
									'name' => 'Site',
									'type' => 'Expenses'
							]);
							DB::table('accounts')->insert([
									'parent_id' => $liabilityId,
									'accountable_type' => $oldRealm->kingdom_id,
									'accountable_id' => $accountable_id,
									'name' => 'Dues Owed',
									'type' => 'Liability'
							]);
						}
					}
					break;
				case 'Meetups':
					$this->info('Importing Meetups...');
					$transMeetups = [];
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
						DB::reconnect("mysqlBak");
						$alternateMeetupsChecks = Meetup::where('chapter_id', $transChapters[$oldMeetup->park_id])
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
						//we might have duplicate meetups.  If it already exists, update the alt_location
						if(count($alternateMeetupsChecks) > 0){
							$meetup = array_shift($alternateMeetupsChecks);
							$meetup->alt_location_id = $locationID;
							$meetup->save();
							DB::table('crypt')->insert([
									'model' 		=> 'Meetup',
									'cause' 		=> 'Unused',
									'model_id'		=> $oldMeetup->parkday_id,
									'model_value'	=> json_encode($oldMeetup)
							]);
						}else{
							$meetupId = DB::table('meetups')->insertGetId([
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
							DB::table('trans')->insert([
									'array' => 'meetups',
									'oldID' => $oldMeetup->parkday_id,
									'newID' => $meetupId
							]);
							$transMeetups[$oldMeetup->parkday_id] = $meetupId;
						}
						$bar->advance();
					}
					break;
				case 'Attendances':
					$this->info('Importing Attendances...');
					$oldRealms = $backupConnect->table('ork_kingdom')->get()->toArray();
					$oldChapters = $backupConnect->table('ork_park')->get()->toArray();
					$oldChaptersCheck = $backupConnect->table('ork_park')->pluck('park_id')->toArray();
					$oldPersonasCheck = $backupConnect->table('ork_mundane')->pluck('mundane_id')->toArray();
					$personaNamesCheck = $backupConnect->table('ork_mundane')->select(['mundane_id', 'persona'])->get()->toArray();
					$transArchetypes = $this->getTrans('archetypes');
					$transRealms = $this->getTrans('realms');
					$transChapters = $this->getTrans('chapters');
					$transPersonas = $this->getTrans('personas');
					$transUnits = $this->getTrans('units');
					$transEventDetails = $this->getTrans('eventsdetails');
					$transUsers = $this->getTrans('users');
					$transMeetups = $this->getTrans('meetups');
					$count = $backupConnect->table('ork_attendance')->count();
					$bar = $this->output->createProgressBar($count);
					$bar->start();
					$backupConnect->table('ork_attendance')->orderBy('attendance_id')->chunk(1000, function ($oldAttendances) use (&$personaNamesCheck, &$oldChapters, &$bar, &$transMeetups, &$transPersonas, &$transUnits, &$transRealms, &$transEventDetails, &$transChapters, &$transUsers, &$oldRealms, &$oldPersonasCheck, $backupConnect, &$transArchetypes, &$oldChaptersCheck){
						$meetups = null;
						$meetupId = null;
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
								while(!array_key_exists($oldAttendance->class_id, $transArchetypes)){
									$this->info('waiting for archetype ' . $oldAttendance->class_id);
									sleep(5);
									$transArchetypes = $this->getTrans('archetypes');
								}
								DB::reconnect("mysqlBak");
								$archetypeId = $transArchetypes[$oldAttendance->class_id];
							}
							
							//no persona
							$persona = null;
							if($oldAttendance->mundane_id == 0){
								$pairing = null;
								$fromChapter = null;
								//those that just won't happen
								if($oldAttendance->persona === '' || $oldAttendance->flavor === '' && ($oldAttendance->note === '' || $oldAttendance->note === 'unknown' || $oldAttendance->note === '**' || $oldAttendance->note === '-' || $oldAttendance->note === '--' || $oldAttendance->note === '---' || $oldAttendance->note === '----' || $oldAttendance->note === '?' || $oldAttendance->note === '??' || $oldAttendance->note === '?? ??' || $oldAttendance->note === '??-??' || $oldAttendance->note === '??-???' || $oldAttendance->note === '???' || $oldAttendance->note === '????' || $oldAttendance->note === '-?' || $oldAttendance->note === 'Undeclaired' || $oldAttendance->note === 'Unk' || $oldAttendance->note === 'unknown' || $oldAttendance->note === 'unkwn' || $oldAttendance->note === 'visitor')){
									DB::table('crypt')->insert([
											'model' 		=> 'Attendance',
											'cause' 		=> 'BadData',
											'model_id'		=> $oldAttendance->attendance_id,
											'model_value'	=> json_encode($oldAttendance)
									]);
									$bar->advance();
									continue;
								}else{
									//figure out if it's somebody
									if(strpos($oldAttendance->note, '--') > -1){
										$pairing = explode('--', $oldAttendance->note);
										$fromRealmOldID = array_search($pairing[0], array_column($oldRealms, 'abbreviation'));
										$fromChapters = array_keys(array_column($oldChapters, 'abbreviation'), $pairing[1]);
										$fromChapterOldID = array_search($fromRealmOldID, array_column($fromChapters, 'kingdom_id'));
										$fromChapter = null;
										if($fromChapterOldID){
											if(in_array($fromChapterOldID, $oldChaptersCheck)){
												while(!array_key_exists($fromChapterOldID, $transChapters)){
													$this->info('1 waiting for chapter ' . $fromChapterOldID);
													sleep(5);
													$transChapters = $this->getTrans('chapters');
												}
												DB::reconnect("mysqlBak");
												$fromChapter = $transChapters[$fromChapterOldID];
											}
										}
									}else if(strpos($oldAttendance->note, '-') > -1){
										$pairing = explode('-', $oldAttendance->note);
										$fromRealmOldID = array_search($pairing[0], array_column($oldRealms, 'abbreviation'));
										$fromChapters = array_keys(array_column($oldChapters, 'abbreviation'), $pairing[1]);
										$fromChapterOldID = array_search($fromRealmOldID, array_column($fromChapters, 'kingdom_id'));
										$fromChapter = null;
										if($fromChapterOldID){
											if(in_array($fromChapterOldID, $oldChaptersCheck)){
												while(!array_key_exists($fromChapterOldID, $transChapters)){
													$this->info('2 waiting for chapter ' . $fromChapterOldID);
													sleep(5);
													$transChapters = $this->getTrans('chapters');
												}
												DB::reconnect("mysqlBak");
												$fromChapter = $transChapters[$fromChapterOldID];
											}
										}
									}else if(strpos($oldAttendance->note, '/') > -1){
										$pairing = explode('/', $oldAttendance->note);
										$fromRealmOldID = array_search($pairing[0], array_column($oldRealms, 'abbreviation'));
										$fromChapters = array_keys(array_column($oldChapters, 'abbreviation'), $pairing[1]);
										$fromChapterOldID = array_search($fromRealmOldID, array_column($fromChapters, 'kingdom_id'));
										$fromChapter = null;
										if($fromChapterOldID){
											if(in_array($fromChapterOldID, $oldChaptersCheck)){
												while(!array_key_exists($fromChapterOldID, $transChapters)){
													$this->info('3 waiting for chapter ' . $fromChapterOldID);
													sleep(5);
													$transChapters = $this->getTrans('chapters');
												}
												DB::reconnect("mysqlBak");
												$fromChapter = $transChapters[$fromChapterOldID];
											}
										}
									}else if(strpos($oldAttendance->note, ':') > -1){
										$pairing = explode(':', $oldAttendance->note);
										$fromRealmOldID = array_search($pairing[0], array_column($oldRealms, 'abbreviation'));
										$fromChapters = array_keys(array_column($oldChapters, 'abbreviation'), $pairing[1]);
										$fromChapterOldID = array_search($fromRealmOldID, array_column($fromChapters, 'kingdom_id'));
										$fromChapter = null;
										if($fromChapterOldID){
											if(in_array($fromChapterOldID, $oldChaptersCheck)){
												while(!array_key_exists($fromChapterOldID, $transChapters)){
													$this->info('4 waiting for chapter ' . $fromChapterOldID);
													sleep(5);
													$transChapters = $this->getTrans('chapters');
												}
												DB::reconnect("mysqlBak");
												$fromChapter = $transChapters[$fromChapterOldID];
											}
										}
									}else{
										$fromChapterOldID = null;
										$fromChapter = null;
										// Search by 'name'
										$indexByName = array_search($oldAttendance->note, array_column($oldChapters, 'name'));
										if ($indexByName !== false) {
											$fromChapterOldID = $oldChapters[$indexByName]->park_id;
										} else {
											// Search by 'abbreviation'
											$indexByAbbreviation = array_search(str_replace('.', '', $oldAttendance->note), array_column($oldChapters, 'abbreviation'));
											if ($indexByAbbreviation !== false) {
												$fromChapterOldID = $oldChapters[$indexByAbbreviation]->park_id;
											}
										}
										if ($fromChapterOldID !== null && array_key_exists($fromChapterOldID, $oldChapters)) {
											while (!array_key_exists($fromChapterOldID, $transChapters)) {
												$this->info('5 waiting for chapter ' . $fromChapterOldID);
												sleep(5);
												$transChapters = $this->getTrans('chapters');
											}
											DB::reconnect("mysqlBak");
											$fromChapter = $transChapters[$fromChapterOldID];
										}
									}
									if($fromChapter && trim($oldAttendance->persona)){
										$persona = $backupConnect->table('ork_mundane')->where('persona', 'LIKE', '%' . $oldAttendance->persona . '%')->where('park_id', $fromChapterOldID)->first();
										if($persona){
											while(!array_key_exists($persona->mundane_id, $transPersonas)){
												$this->info('waiting for persona1 ' . $persona->mundane_id);
												sleep(5);
												$transPersonas = $this->getTrans('personas');
											}
											DB::reconnect("mysqlBak");
										}
										$personaID = $persona ? $transPersonas[$persona->mundane_id] : null;
									}else{
										DB::table('crypt')->insert([
												'model' 		=> 'Attendance',
												'cause' 		=> 'PersonaUnconstructable',
												'model_id'		=> $oldAttendance->attendance_id,
												'model_value'	=> json_encode($oldAttendance)
										]);
										$bar->advance();
										continue;
									}
									if(!$personaID){
										$personaID = DB::table('personas')->insertGetId([
												'chapter_id' => $fromChapter,
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
								if(in_array($oldAttendance->mundane_id, $oldPersonasCheck)){
									$key = array_key_first(
										array_filter(
											array_keys($personaNamesCheck),
											function ($key) use ($oldAttendance, $personaNamesCheck) {
												return $personaNamesCheck[$key]->mundane_id == $oldAttendance->mundane_id;
											}
										)
									);
									
									if(
											str_contains($personaNamesCheck[$key]->persona, 'zzc2e2_') ||
											str_contains($personaNamesCheck[$key]->persona, 'zzsc')
									){
										//this is a demo person...they don't get attendance credit
										DB::table('crypt')->insert([
												'model' 		=> 'Attendance',
												'cause' 		=> 'DemoPersona',
												'model_id'		=> $oldAttendance->attendance_id,
												'model_value'	=> json_encode($oldAttendance)
										]);
										$bar->advance();
										continue;
									};
									while(!array_key_exists($oldAttendance->mundane_id, $transPersonas)){
										$this->info('waiting for persona2 ' . $oldAttendance->mundane_id);
										sleep(5);
										$transPersonas = $this->getTrans('personas');
									}
									DB::reconnect("mysqlBak");
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
											if(in_array($mostAttended->park_id, array_column($oldChapters, 'park_id'))){
												$transChapters = $this->getTrans('chapters');
												while(!array_key_exists($mostAttended->park_id, $transChapters)){
													$this->info('6 waiting for chapter ' . $mostAttended->park_id);
													sleep(5);
													$transChapters = $this->getTrans('chapters');
												}
												DB::reconnect("mysqlBak");
												$chapterID = $transChapters[$mostAttended->park_id];
												break;
											}
										}
									}
									if(!$chapterID){
										DB::table('crypt')->insert([
												'model' 		=> 'Attendance',
												'cause' 		=> 'NoPersonaChapter',
												'model_id'		=> $oldAttendance->attendance_id,
												'model_value'	=> json_encode($oldAttendance)
										]);
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
							
							//no park, realm, or event (ie, reconciliation)
							if($oldAttendance->park_id == 0 && $oldAttendance->kingdom_id == 0 && $oldAttendance->event_id == 0 && $oldAttendance->event_calendardetail_id == 0){
								DB::table('reconciliations')->insertGetId([
										'archetype_id' => $archetypeId,
										'persona_id' => $oldAttendance->mundane_id > 0 ? $transPersonas[$oldAttendance->mundane_id] : $personaID,
										'credits' => $oldAttendance->credits
								]);
								DB::table('crypt')->insert([
										'model' 		=> 'Attendance',
										'cause' 		=> 'ReconciledNoPlace',
										'model_id'		=> $oldAttendance->attendance_id,
										'model_value'	=> json_encode($oldAttendance)
								]);
								$bar->advance();
								continue;
								//no event and no date (ie, reconciliation)
							}else if($oldAttendance->event_id == 0 && $oldAttendance->event_calendardetail_id == 0 && $oldAttendance->entered_at === '0000-00-00 00:00:00' && $oldAttendance->date === '0000-00-00'){
								DB::table('reconciliations')->insertGetId([
										'archetype_id' => $archetypeId,
										'persona_id' => $oldAttendance->mundane_id > 0 ? $transPersonas[$oldAttendance->mundane_id] : $personaID,
										'credits' => $oldAttendance->credits
								]);
								DB::table('crypt')->insert([
										'model' 		=> 'Attendance',
										'cause' 		=> 'ReconciledNoDate',
										'model_id'		=> $oldAttendance->attendance_id,
										'model_value'	=> json_encode($oldAttendance)
								]);
								$bar->advance();
								continue;
								//if the date is before Feb 01 1983, it's a reconciliation
							}else if($oldAttendance->date < '1983-02-01'){
								DB::table('reconciliations')->insertGetId([
										'archetype_id' => $archetypeId,
										'persona_id' => $oldAttendance->mundane_id > 0 ? $transPersonas[$oldAttendance->mundane_id] : $personaID,
										'credits' => $oldAttendance->credits
								]);
								DB::table('crypt')->insert([
										'model' 		=> 'Attendance',
										'cause' 		=> 'ReconciledPreDawnDate',
										'model_id'		=> $oldAttendance->attendance_id,
										'model_value'	=> json_encode($oldAttendance)
								]);
								$bar->advance();
								continue;
								//if the date is missing the month or day, reconcile it
							}else if(strpos($oldAttendance->date, '-00') > -1){
								DB::table('reconciliations')->insertGetId([
										'archetype_id' => $archetypeId,
										'persona_id' => $oldAttendance->mundane_id > 0 ? $transPersonas[$oldAttendance->mundane_id] : $personaID,
										'credits' => $oldAttendance->credits
								]);
								DB::table('crypt')->insert([
										'model' 		=> 'Attendance',
										'cause' 		=> 'ReconciledBadDate',
										'model_id'		=> $oldAttendance->attendance_id,
										'model_value'	=> json_encode($oldAttendance)
								]);
								$bar->advance();
								continue;
								//if it's more than 2 credits and no event, it's a reconcilliation
							}else if($oldAttendance->credits > 2.9 && $oldAttendance->event_id == 0 && $oldAttendance->event_calendardetail_id == 0){
								DB::table('reconciliations')->insertGetId([
										'archetype_id' => $archetypeId,
										'persona_id' => $oldAttendance->mundane_id > 0 ? $transPersonas[$oldAttendance->mundane_id] : $personaID,
										'credits' => $oldAttendance->credits
								]);
								DB::table('crypt')->insert([
										'model' 		=> 'Attendance',
										'cause' 		=> 'ReconciledTooManyCredits',
										'model_id'		=> $oldAttendance->attendance_id,
										'model_value'	=> json_encode($oldAttendance)
								]);
								$bar->advance();
								continue;
							}else{
								//it's a meetup
								if($oldAttendance->event_id == 0 && $oldAttendance->event_calendardetail_id == 0){
									//is there a meetup?
									$meetups = $backupConnect->table('ork_parkday')->where('park_id', $oldAttendance->park_id)->get()->toArray();
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
										$oldMeetupId = $meetups[$meetupSelected ? $meetupSelected : 0]->parkday_id;
										while(!array_key_exists($oldMeetupId, $transMeetups)){
											$this->info('waiting for meetup ' . $oldMeetupId);
											sleep(5);
											$transMeetups = $this->getTrans('meetups');
										}
										DB::reconnect("mysqlBak");
										$meetupId = $transMeetups[$oldMeetupId];
									}else{
										$transChapters = $this->getTrans('chapters');
										if(!in_array($oldAttendance->park_id, $oldChaptersCheck)){
											DB::table('crypt')->insert([
													'model' 		=> 'Attendance',
													'cause' 		=> 'NoMeetupChapter',
													'model_id'		=> $oldAttendance->attendance_id,
													'model_value'	=> json_encode($oldAttendance)
											]);
											$bar->advance();
											continue;
										}else{
											while(!array_key_exists($oldAttendance->park_id, $transChapters)){
												$this->info('7 waiting for chapter ' . $oldAttendance->park_id);
												sleep(5);
												$transChapters = $this->getTrans('chapters');
											}
											DB::reconnect("mysqlBak");
										}
										
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
									//it's an event
								}else if($oldAttendance->event_calendardetail_id != 0){
									$eventDetailsCheck = $backupConnect->table('ork_event_calendardetail')->where('event_calendardetail_id', $oldAttendance->event_calendardetail_id)->first();
									//and it's a thing
									if($eventDetailsCheck){
										//wait for it
										while(!array_key_exists($oldAttendance->event_calendardetail_id, $transEventDetails)){
											$this->info('waiting for event ' . $oldAttendance->event_calendardetail_id);
											sleep(5);
											$transEventDetails = $this->getTrans('eventdetails');
										}
										DB::reconnect("mysqlBak");
									//otherwise, make it
									}else{
										if($oldAttendance->event_id > 0){
											//TODO: DEMO CHECK
											$parentEvent = $backupConnect->table('ork_event')->where('event_id', $oldAttendance->event_id)->first();
											$eventable_type = $parentEvent->unit_id > 0 ? 'Unit' : ($parentEvent->kingdom_id == 0 && $parentEvent->park_id == 0 ? 'Persona' : ($parentEvent->park_id > 0 && $parentEvent->kingdom_id == 0 ? 'Chapter' : 'Realm'));
											switch($eventable_type){
												case 'Unit':
													while(!array_key_exists($parentEvent->unit_id, $transUnits)){
														$this->info('waiting for unit ' . $parentEvent->unit_id);
														sleep(5);
														$transUnits = $this->getTrans('units');
													}
													DB::reconnect("mysqlBak");
													$eventable_id = $transUnits[$parentEvent->unit_id];
													break;
												case 'Persona':
													while(!array_key_exists($parentEvent->mundane_id, $transPersonas)){
														$this->info('waiting for persona3 ' . $parentEvent->mundane_id);
														sleep(5);
														$transPersonas = $this->getTrans('personas');
													}
													DB::reconnect("mysqlBak");
													$eventable_id = $transPersonas[$parentEvent->mundane_id];
													break;
												case 'Chapter':
													while(!array_key_exists($parentEvent->park_id, $transChapters)){
														$this->info('8 waiting for chapter ' . $parentEvent->park_id);
														sleep(5);
														$transChapters = $this->getTrans('chapters');
													}
													DB::reconnect("mysqlBak");
													$eventable_id = $transChapters[$parentEvent->park_id];
													break;
												case 'Realm':
													while(!array_key_exists($parentEvent->kingdom_id, $transRealms)){
														$this->info('waiting for realm ' . $parentEvent->kingdom_id);
														sleep(5);
														$transRealms = $this->getTrans('realms');
													}
													DB::reconnect("mysqlBak");
													$eventable_id = $transRealms[$parentEvent->kingdom_id];
													break;
												default:
													$eventable_id = null;
													break;
											}
											$eventId = DB::table('events')->insertGetId([
													'eventable_type' => $eventable_type,
													'eventable_id' => $eventable_id,
													'location_id' => $locationID ? $locationID : 1,
													'name' => trim($parentEvent->name),
													'description' => 'This event was generated from related records.  Please correct it.',
													'is_active' => 0,
													'is_demo' => str_contains(strtolower(trim($parentEvent->name)), 'demo') ? 1 : 0,
													'image' => null,
													'event_start' => $oldAttendance->date,
													'event_end' => $oldAttendance->date,
													'price' => null
											]);
											DB::table('trans')->insert([
													'array' => 'eventdetails',
													'oldID' => $oldAttendance->event_calendardetail_id,
													'newID' => $eventId
											]);
											$transEventDetails[$oldAttendance->event_calendardetail_id] = $eventId;
										}else{
											//deadrecords it since there's no event data
											DB::table('crypt')->insert([
													'model' 		=> 'Attendance',
													'cause' 		=> 'NoEvent',
													'model_id'		=> $oldAttendance->attendance_id,
													'model_value'	=> json_encode($oldAttendance)
											]);
											$bar->advance();
											continue;
										}
									}
								}
								//check by_whom
								if($oldAttendance->by_whom_id != 0){
									$userId = null;
									if(in_array($oldAttendance->by_whom_id, $oldPersonasCheck)){
										while(!array_key_exists($oldAttendance->by_whom_id, $transPersonas)){
											$this->info('waiting for entering persona ' . $oldAttendance->by_whom_id);
											sleep(5);
											$transPersonas = $this->getTrans('personas');
										}
										DB::reconnect("mysqlBak");
										//if they need a user, we'll have to make one up
										$transUsers = $this->getTrans('users');
										if(!array_key_exists($oldAttendance->by_whom_id, $transUsers)){
											$userCheck = User::where('email', 'deletedUser' . $oldAttendance->by_whom_id . '@nowhere.net')->select('id')->first();
											if($userCheck){
												$userId = $userCheck->id;
											}
											if(!$userId){
												$userId = DB::table('users')->insertGetId([
														'email' => 'deletedUser' . $oldAttendance->by_whom_id . '@nowhere.net',
														'email_verified_at' => null,
														'password' => 'generated',
														'remember_token' => null,
														'is_restricted' => 1
												]);
											}
											DB::table('trans')->insert([
													'array' => 'users',
													'oldID' => $oldAttendance->by_whom_id,
													'newID' => $userId
											]);
											$transUsers[$oldAttendance->by_whom_id] = $userId;
											Persona::where('id', $transPersonas[$oldAttendance->by_whom_id])->update([
													'user_id' => $userId
											]);
										}
									}elseif($oldAttendance->park_id != '0'){
										$userCheck = User::where('email', 'deletedUser' . $oldAttendance->by_whom_id . '@nowhere.net')->select('id')->first();
										if($userCheck){
											$userId = $userCheck->id;
										}
										if(!$userId){
											$userId = DB::table('users')->insertGetId([
													'email' => 'deletedUser' . $oldAttendance->by_whom_id . '@nowhere.net',
													'email_verified_at' => null,
													'password' => 'generated',
													'remember_token' => null,
													'is_restricted' => 1
											]);
										}
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
										'created_by' => $oldAttendance->by_whom_id != 0 ? (in_array($oldAttendance->by_whom_id, $transUsers) ? $transUsers[$oldAttendance->by_whom_id] : 1) : 1,
										'created_at' => $oldAttendance->entered_at != '0000-00-00 00:00:00' ? $oldAttendance->entered_at : $oldAttendance->date
								]);
							}
							$bar->advance();
						}
					});
						break;
				case 'Tournaments':
					$this->info('Importing Tournaments...');
					$oldEventDetails = $backupConnect->table('ork_event_calendardetail')->pluck('event_calendardetail_id')->toArray();
					$transEventDetails = $this->getTrans('eventdetails');
					$transRealms = $this->getTrans('realms');
					$transChapters = $this->getTrans('chapters');
					$oldTournaments = $backupConnect->table('ork_tournament')->get()->toArray();
					$bar = $this->output->createProgressBar(count($oldTournaments));
					$bar->start();
					foreach ($oldTournaments as $oldTournament) {
						if($oldTournament->kingdom_id == 0 && $oldTournament->park_id == 0 && $oldTournament->event_calendardetail_id == 0 && $oldTournament->event_id == 0){
							DB::table('crypt')->insert([
									'model' 		=> 'Tournament',
									'cause' 		=> 'NoHost',
									'model_id'		=> $oldTournament->tournament_id,
									'model_value'	=> json_encode($oldTournament)
							]);
							$bar->advance();
							continue;
						}
						$abletype = $oldTournament->kingdom_id > 0 ? 'Realm' : ($oldTournament->park_id > 0 ? 'Chapter' : 'Event');
						if($abletype === 'Realm'){
							while(!array_key_exists($oldTournament->kingdom_id, $transRealms)){
								$this->info('waiting for realm ' . $oldTournament->kingdom_id);
								sleep(5);
								$transRealms = $this->getTrans('realms');
							}
							DB::reconnect("mysqlBak");
							$ableid = $transRealms[$oldTournament->kingdom_id];
						}elseif($abletype === 'Chapter'){
							while(!array_key_exists($oldTournament->park_id, $transChapters)){
								$this->info('waiting for chapter ' . $oldTournament->park_id);
								sleep(5);
								$transChapters = $this->getTrans('chapters');
							}
							DB::reconnect("mysqlBak");
							$ableid = $transChapters[$oldTournament->park_id];
						}else{
							if($oldTournament->event_calendardetail_id > 0){
								if(!in_array($oldTournament->event_calendardetail_id, $oldEventDetails)){
									DB::table('crypt')->insert([
											'model' 		=> 'Tournament',
											'cause' 		=> 'GoneEvent',
											'model_id'		=> $oldTournament->tournament_id,
											'model_value'	=> json_encode($oldTournament)
									]);
									$bar->advance();
									continue;
								}else{
									while(!array_key_exists($oldTournament->event_calendardetail_id, $transEventDetails)){
										$this->info('waiting for event ' . $oldTournament->event_calendardetail_id);
										sleep(5);
										$transEventDetails = $this->getTrans('eventdetails');
									}
									DB::reconnect("mysqlBak");
									$ableid = $transEventDetails[$oldTournament->event_calendardetail_id];
								}
							}else{
								//these are all garbage, so goodby
								DB::table('crypt')->insert([
										'model' 		=> 'Tournament',
										'cause' 		=> 'NoEvent',
										'model_id'		=> $oldTournament->tournament_id,
										'model_value'	=> json_encode($oldTournament)
								]);
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
					$transRealms = $this->getTrans('realms');
					$oldConfigurations = $backupConnect->table('ork_configuration')->where('type', 'Kingdom')->get()->toArray();
					$bar = $this->output->createProgressBar(count($oldConfigurations));
					$bar->start();
					foreach ($oldConfigurations as $oldConfiguration) {
						if($oldConfiguration->key === 'AccountPointers'){
							DB::table('crypt')->insert([
									'model' 		=> 'Configuration',
									'cause' 		=> 'AccountPointer',
									'model_id'		=> $oldConfiguration->configuration_id,
									'model_value'	=> json_encode($oldConfiguration)
							]);
						}else{
							if(array_key_exists($oldConfiguration->id, $knownRealmChaptertypesOffices)){
								//update the realm
								while(!array_key_exists($oldConfiguration->id, $transRealms)){
									$this->info('waiting for realm ' . $oldConfiguration->id);
									sleep(5);
									$transRealms = $this->getTrans('realms');
								}
								DB::reconnect("mysqlBak");
								$realm = Realm::where('id', $transRealms[$oldConfiguration->id])->first();
								//this shouldn't happen
								if(!$realm){
									throw new \Exception('oldConfiguration ' . $oldConfiguration->configuration_id . ' has no Realm');
								}
								$cleanValue = utf8_encode(stripslashes($oldConfiguration->value));
								$cleanNoQuotes = str_replace('"', '', $cleanValue);
								switch($oldConfiguration->key){
									case 'AtlasColor':
										$realm->color = $cleanNoQuotes;
										break;
									case 'AttendanceCreditMinimum':
										$realm->credit_minimum = $cleanNoQuotes;
										break;
									case 'AttendanceDailyMinimum':
										$realm->daily_minimum = $cleanNoQuotes === 'null' ? null : $cleanNoQuotes;
										break;
									case 'AttendanceWeeklyMinimum':
										$realm->weekly_minimum = $cleanNoQuotes === 'null' ? null : $cleanNoQuotes;
										break;
									case 'AveragePeriod':
										$data = json_decode($cleanValue);
										$realm->average_period_type = $data->Type != '' && $data->Type != '-' ? ucfirst($data->Type) : null;
										$realm->average_period = $data->Period != 'null' && $data->Period != '' ? ucfirst($data->Period) : null;
										break;
									case 'DuesAmount':
										$realm->dues_amount = $cleanNoQuotes;
										break;
									case 'DuesPeriod':
										$data = json_decode($cleanValue);
										$realm->dues_intervals_type = $data->Type != '' ? ucfirst($data->Type) : null;
										$realm->dues_intervals = $data->Period != 'null' && $data->Period != '' ? ucfirst($data->Period) : null;
										break;
									case 'realmDuesTake':
										$realm->dues_take = $cleanNoQuotes;
										break;
									case 'MonthlyCreditMaximum':
										$realm->credit_maximum = $cleanNoQuotes === 'null' || $cleanNoQuotes > 100 ? null : $cleanNoQuotes;
										break;
								}
								$realm->save();
							}
						}
						$bar->advance();
					}
					break;
				case 'Transactions':
					$this->info('Importing Transactions...');
					$transTransactions = [];
					$transUsers = $this->getTrans('users');
					$transPersonas = $this->getTrans('personas');
					$oldPersonas = $backupConnect->table('ork_mundane')->pluck('mundane_id')->toArray();
					$oldTransactions = $backupConnect->table('ork_transaction')->get()->toArray();
					$bar = $this->output->createProgressBar(count($oldTransactions));
					$bar->start();
					foreach ($oldTransactions as $oldTransaction) {
						if($oldTransaction->recorded_by != 0){
							if(in_array($oldTransaction->recorded_by, $oldPersonas)){
								while(!array_key_exists($oldTransaction->recorded_by, $transPersonas)){
									$this->info('waiting for persona ' . $oldTransaction->recorded_by);
									sleep(5);
									$transPersonas = $this->getTrans('personas');
								}
								DB::reconnect("mysqlBak");
								//if they need a user, we'll have to make one up
								$transUsers = $this->getTrans('users');
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
									DB::table('crypt')->insert([
											'model' 		=> 'Transaction',
											'cause' 		=> 'PersonaGone',
											'model_id'		=> $oldTransaction->transaction_id,
											'model_value'	=> json_encode($oldTransaction)
									]);
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
					$oldAccounts = $backupConnect->table('ork_account')->pluck('account_id')->toArray();
					$oldTransactions = $backupConnect->table('ork_transaction')->pluck('transaction_id')->toArray();
					$oldPersonas = $backupConnect->table('ork_mundane')->pluck('mundane_id')->toArray();
					$oldSplits = $backupConnect->table('ork_split')->get()->toArray();
					$bar = $this->output->createProgressBar(count($oldSplits));
					$bar->start();
					foreach ($oldSplits as $oldSplit) {
						if($oldSplit->account_id === '0'){
							DB::table('crypt')->insert([
									'model' 		=> 'Split',
									'cause' 		=> 'NoAccount',
									'model_id'		=> $oldSplit->split_id,
									'model_value'	=> json_encode($oldSplit)
							]);
							$bar->advance();
							continue;
						}
						//account was deleted...sigh.  Not sure there's enough of these to justify the time it'd take me to make the script rebuild it, and I'm not sure I even could.  So, without further adeau...
						if(!in_array($oldSplit->account_id, $oldAccounts)){
							DB::table('crypt')->insert([
									'model' 		=> 'Split',
									'cause' 		=> 'GoneAccount',
									'model_id'		=> $oldSplit->split_id,
									'model_value'	=> json_encode($oldSplit)
							]);
							$bar->advance();
							continue;
						}
						//transaction was deleted
						if(!in_array($oldSplit->transaction_id, $oldTransactions)){
							DB::table('crypt')->insert([
									'model' 		=> 'Split',
									'cause' 		=> 'GoneTransaction',
									'model_id'		=> $oldSplit->split_id,
									'model_value'	=> json_encode($oldSplit)
							]);
							$bar->advance();
							continue;
						}
						//persona was deleted
						if(!in_array($oldSplit->src_mundane_id, $oldPersonas)){
							DB::table('crypt')->insert([
									'model' 		=> 'Split',
									'cause' 		=> 'GonePersona',
									'model_id'		=> $oldSplit->split_id,
									'model_value'	=> json_encode($oldSplit)
							]);
							$bar->advance();
							continue;
						}
						while(!array_key_exists($oldSplit->account_id, $transAccounts)){
							$this->info('waiting for account ' . $oldSplit->account_id);
							sleep(5);
							$transAccounts = $this->getTrans('accounts');
						}
						DB::reconnect("mysqlBak");
						while(!array_key_exists($oldSplit->transaction_id, $transTransactions)){
							$this->info('waiting for transaction ' . $oldSplit->transaction_id);
							sleep(5);
							$transTransactions = $this->getTrans('transactions');
						}
						DB::reconnect("mysqlBak");
						while(!array_key_exists($oldSplit->src_mundane_id, $transPersonas)){
							$this->info('waiting for persona ' . $oldSplit->src_mundane_id);
							sleep(5);
							$transPersonas = $this->getTrans('personas');
						}
						DB::reconnect("mysqlBak");
						DB::table('splits')->insert([
								'account_id' => $oldSplit->account_id != '0' ? $transAccounts[$oldSplit->account_id] : null,
								'transaction_id' => $transTransactions[$oldSplit->transaction_id],
								'persona_id' => $transPersonas[$oldSplit->src_mundane_id],
								'amount' => $oldSplit->amount
						]);
						$bar->advance();
					}
					break;
				case 'Dues':
					$this->info('Importing Dues');
					$transPersonas = $this->getTrans('personas');
					$transTransactions = $this->getTrans('transactions');
					$transUsers = $this->getTrans('users');
					$transChapters = $this->getTrans('chapters');
					$oldPersonas = $backupConnect->table('ork_mundane')->pluck('mundane_id')->toArray();
					$oldTransactions = $backupConnect->table('ork_transaction')->get()->toArray();
					$oldDues = $backupConnect->table('ork_dues')->get()->toArray();
					$oldTransaction = null;
					$bar = $this->output->createProgressBar(count($oldDues));
					$bar->start();
					foreach ($oldDues as $oldDue) {
						$thisSplit = null;
						$thisTransaction = null;
						$duesFrom = null;
						if($oldDue->kingdom_id == 0){
							DB::table('crypt')->insert([
									'model' 		=> 'Due',
									'cause' 		=> 'KingdomGone',
									'model_id'		=> $oldDue->dues_id,
									'model_value'	=> json_encode($oldDue)
							]);
							$bar->advance();
							continue;
						}
						if(!in_array($oldDue->mundane_id, $oldPersonas)){
							//looks like these are the victims of related deletions.  So sad.
							DB::table('crypt')->insert([
									'model' 		=> 'Due',
									'cause' 		=> 'PersonaGone',
									'model_id'		=> $oldDue->dues_id,
									'model_value'	=> json_encode($oldDue)
							]);
							$bar->advance();
							continue;
						}
						if($oldDue->created_on > date('Y-m-d hh:mm:ss', strtotime('tomorrow'))){
							//it's just bad data, not much I can do
							DB::table('crypt')->insert([
									'model' 		=> 'Due',
									'cause' 		=> 'BadDate',
									'model_id'		=> $oldDue->dues_id,
									'model_value'	=> json_encode($oldDue)
							]);
							$bar->advance();
							continue;
						}
						if($oldDue->dues_for_life == '1'){
							$intervals = null;
						}else{
							//work out the intervals
							//dues_until - dues_from in months / 6
							$date1 = $duesFrom;
							$date2 = $oldDue->dues_until;
							$date_diff = abs(strtotime($date2) - strtotime($date1));
							$intervals = $date_diff / (182.5*60*60*24);
							//convert intervals > 160 to 'dues paid for life'
							if($intervals > 160){
								$intervals = null;
							}
						}
						//if the dues_from is before 1998-07-01, we need to figure out what it REALLY is, with the floor set at Feb 01, 1983 (Our birth month)
						if(strtotime($oldDue->dues_from) < strtotime('1998-07-01')){
							$thisSplit = $backupConnect->table('ork_split')->where('transaction_id', $oldDue->import_transaction_id)->where('is_dues', 1)->first();
							if(!$thisSplit){
								//damn.  Guess this one is toast.
								DB::table('crypt')->insert([
										'model' 		=> 'Due',
										'cause' 		=> 'SplitGone',
										'model_id'		=> $oldDue->dues_id,
										'model_value'	=> json_encode($oldDue)
								]);
								$bar->advance();
								continue;
							}
							$thisTransaction = $backupConnect->table('ork_transaction')->where('transaction_id', $thisSplit->transaction_id)->first();
							if($thisTransaction){
								$duesFrom = date('Y-m-d H:i:s', strtotime($thisTransaction->date_created));
							}else{
								if($intervals){
									$duesFrom = date('Y-m-d H:i:s', strtotime('-' . round($intervals*6) . ' months', strtotime($thisSplit->dues_through)));
								}else{
									$duesFrom = date('Y-m-d H:i:s', strtotime('Feb 01, 1983'));
								}
							}
							if($duesFrom < date('Y-m-d H:i:s', strtotime('Feb 01, 1983'))){
								$duesFrom = date('Y-m-d H:i:s', strtotime('Feb 01, 1983'));
							}
						}else{
							$duesFrom = date('Y-m-d H:i:s', strtotime($oldDue->dues_from));
						}
						//created_on fixes
						if($oldDue->created_on === '1969-12-31'){
							$dueCreatedOn = date('Y-m-d H:i:s', strtotime('Feb 01, 1983'));
						}else{
							$dueCreatedOn = date('Y-m-d H:i:s', strtotime($oldDue->created_on));
						}
						//fix those wonky dues_from
						if($duesFrom > strtotime('now')){
							$duesFrom = $dueCreatedOn;
						}
						if($oldDue->import_transaction_id == 0 || !in_array($oldDue->import_transaction_id, $oldTransactions)){
							while(!array_key_exists($oldDue->mundane_id, $transPersonas)){
								$this->info('waiting for persona1 ' . $oldDue->mundane_id);
								sleep(5);
								$transPersonas = $this->getTrans('personas');
							}
							DB::reconnect("mysqlBak");
							$persona = Persona::where('id', $transPersonas[$oldDue->mundane_id])->first();
							$mundane = $backupConnect->table('ork_mundane')->where('mundane_id', $oldDue->created_by)->first();
							if(!$mundane || $mundane->email === '' || !filter_var($mundane->email, FILTER_VALIDATE_EMAIL)){
								$createdBy = null;
							}else{
								while(!array_key_exists($mundane->mundane_id, $transUsers)){
									$this->info('1 waiting for user ' . $oldDue->created_by);
									sleep(5);
									$transUsers = $this->getTrans('users');
								}
								DB::reconnect("mysqlBak");
								$createdBy = $transUsers[$oldDue->created_by];
							}
							
							$transactionId = DB::table('transactions')->insertGetId([
									'description' => 'Dues Paid for ' . $persona->mundane,
									'memo' => 'Dues Paid for ' . $persona->mundane,
									'transaction_at' => $dueCreatedOn,
									'created_by' => $createdBy ? $createdBy : 1,
									'created_at' => $duesFrom
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
							DB::reconnect("mysqlBak");
							$transactionId = $transTransactions[$oldDue->import_transaction_id];
						}
						//check users
						while(!array_key_exists($oldDue->park_id, $transChapters)){
							$this->info('waiting for chapter ' . $oldDue->park_id);
							sleep(5);
							$transChapters = $this->getTrans('chapters');
						}
						DB::reconnect("mysqlBak");
						$transUsers = $this->getTrans('users');
						if(!in_array($oldDue->created_by, $oldPersonas) && !array_key_exists($oldDue->created_by, $transUsers)){
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
							$createdBy = $userId;
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
							$mundane = $backupConnect->table('ork_mundane')->where('mundane_id', $oldDue->created_by)->first();
							if(!$mundane || $mundane->email === '' || !filter_var($mundane->email, FILTER_VALIDATE_EMAIL)){
								$createdBy = null;
							}else{
								while(!array_key_exists($oldDue->created_by, $transUsers)){
									$this->info('2 waiting for user ' . $oldDue->created_by);
									sleep(5);
									$transUsers = $this->getTrans('users');
								}
								DB::reconnect("mysqlBak");
								$createdBy = $transUsers[$oldDue->created_by];
							}
						}
						$transUsers = $this->getTrans('users');
						if($oldDue->revoked_by && !in_array($oldDue->revoked_by, $oldPersonas) && !array_key_exists($oldDue->revoked_by, $transUsers)){
							while(!array_key_exists($oldDue->park_id, $transChapters)){
								$this->info('waiting for chapter ' . $oldDue->park_id);
								sleep(5);
								$transChapters = $this->getTrans('chapters');
							}
							DB::reconnect("mysqlBak");
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
							$revokedBy = $userId;
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
							$mundane = $backupConnect->table('ork_mundane')->where('mundane_id', $oldDue->revoked_by)->first();
							if(!$mundane || $mundane->email === '' || !filter_var($mundane->email, FILTER_VALIDATE_EMAIL)){
								$revokedBy = null;
							}else{
								while(!array_key_exists($oldDue->revoked_by, $transUsers)){
									$this->info('3 waiting for user ' . $oldDue->revoked_by);
									sleep(5);
									$transUsers = $this->getTrans('users');
								}
								DB::reconnect("mysqlBak");
								$revokedBy = $transUsers[$oldDue->revoked_by];
							}
						}else{
							$revokedBy = null;
						}
						while(!array_key_exists($oldDue->mundane_id, $transPersonas)){
							$this->info('waiting for persona2 ' . $oldDue->mundane_id);
							sleep(5);
							$transPersonas = $this->getTrans('personas');
						}
						DB::reconnect("mysqlBak");
						DB::table('dues')->insert([
								'persona_id' => $transPersonas[$oldDue->mundane_id],
								'transaction_id' => $transactionId,
								'dues_on' => date('Y-m-d', strtotime($duesFrom)),
								'intervals' => $intervals ? round($intervals, 3) : null,
								'created_at' => $duesFrom,
								'created_by' => $createdBy ? $createdBy : 1,
								'deleted_at' => $oldDue->revoked === '1' ? date('Y-m-d H:i:s', strtotime($oldDue->revoked_on)) : null,
								'deleted_by' => $oldDue->revoked === '1' ? $revokedBy : null
						]);
						$bar->advance();
					}
					break;
				case 'Members':
					$this->info('Importing Members...');
					$transUnits = $this->getTrans('units');
					$transPersonas = $this->getTrans('personas');
					$oldPersonas = $backupConnect->table('ork_mundane')->pluck('mundane_id')->toArray();
					$oldUnits = $backupConnect->table('ork_unit')->where('type', '!=', '')->pluck('unit_id')->toArray();
					$oldMembers = $backupConnect->table('ork_unit_mundane')->get()->toArray();
					$bar = $this->output->createProgressBar(count($oldMembers));
					$bar->start();
					foreach ($oldMembers as $oldMember) {
						if($oldMember->mundane_id == '0'){
							DB::table('crypt')->insert([
									'model' 		=> 'Member',
									'cause' 		=> 'NullPersona',
									'model_id'		=> $oldMember->unit_id,
									'model_value'	=> json_encode($oldMember)
							]);
							$bar->advance();
							continue;
						}
						if(in_array($oldMember->unit_id, $oldUnits)){
							while(!array_key_exists($oldMember->unit_id, $transUnits)){
								$this->info('waiting for unit ' . $oldMember->unit_id);
								sleep(5);
								$transUnits = $this->getTrans('units');
							}
							DB::reconnect("mysqlBak");
						}else{
							DB::table('crypt')->insert([
									'model' 		=> 'Member',
									'cause' 		=> 'NoUnit',
									'model_id'		=> $oldMember->unit_id,
									'model_value'	=> json_encode($oldMember)
							]);
							$bar->advance();
							continue;
						}
						if(in_array($oldMember->mundane_id, $oldPersonas)){
							while(!array_key_exists($oldMember->mundane_id, $transPersonas)){
								$this->info('waiting for persona ' . $oldMember->mundane_id);
								sleep(5);
								$transPersonas = $this->getTrans('personas');
							}
							DB::reconnect("mysqlBak");
						}else{
							DB::table('crypt')->insert([
									'model' 		=> 'Member',
									'cause' 		=> 'PersonaGone',
									'model_id'		=> $oldMember->unit_id,
									'model_value'	=> json_encode($oldMember)
							]);
							$bar->advance();
							continue;
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
							$memberCheck->is_head = $oldMember->role === 'captain' || $oldMember->role === 'lord' ? 1 : 0;
							$memberCheck->is_voting = 1;
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
					$transChaptertypes = $this->getTrans('chaptertypes');
					$transPersonas = $this->getTrans('personas');
					$transRealms = $this->getTrans('realms');
					$oldOfficers = $backupConnect->table('ork_officer')->get()->toArray();
					$oldRealmCheck = $backupConnect->table('ork_kingdom')->pluck('kingdom_id')->toArray();
					$personaCheck = $backupConnect->table('ork_mundane')->pluck('mundane_id')->toArray();
					$bar = $this->output->createProgressBar(count($oldOfficers));
					$bar->start();
					foreach ($oldOfficers as $oldOfficer) {
						if($oldOfficer->mundane_id == '0'){
							DB::table('crypt')->insert([
									'model' 		=> 'Officer',
									'cause' 		=> 'NullPersona',
									'model_id'		=> $oldOfficer->officer_id,
									'model_value'	=> json_encode($oldOfficer)
							]);
							$bar->advance();
							continue;
						}
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
							if(!in_array($oldOfficer->mundane_id, $personaCheck)){
								DB::table('crypt')->insert([
										'model' 		=> 'Officer',
										'cause' 		=> 'PersonaGone',
										'model_id'		=> $oldOfficer->officer_id,
										'model_value'	=> json_encode($oldOfficer)
								]);
								$bar->advance();
								continue;
							}
							while(!array_key_exists($oldOfficer->mundane_id, $transPersonas)){
								$this->info('waiting for persona ' . $oldOfficer->mundane_id);
								sleep(5);
								$transPersonas = $this->getTrans('personas');
							}
							DB::reconnect("mysqlBak");
							if($oldOfficer->authorization_id != '0'){
								if(!in_array($oldOfficer->authorization_id, $personaCheck)){
									DB::table('crypt')->insert([
											'model' 		=> 'Officer',
											'cause' 		=> 'NoAuthPersona',
											'model_id'		=> $oldOfficer->officer_id,
											'model_value'	=> json_encode($oldOfficer)
									]);
									$bar->advance();
									continue;
								}
								while(!array_key_exists($oldOfficer->authorization_id, $transPersonas)){
									$this->info('waiting for auth persona ' . $oldOfficer->authorization_id);
									sleep(5);
									$transPersonas = $this->getTrans('personas');
								}
								DB::reconnect("mysqlBak");
							}
							if($oldOfficer->park_id != 0){
								while(!array_key_exists($oldOfficer->park_id, $transChapters)){
									$this->info('waiting for chapter ' . $oldOfficer->park_id);
									sleep(5);
									$transChapters = $this->getTrans('chapters');
								}
								DB::reconnect("mysqlBak");
								$chapter = Chapter::where('id', $transChapters[$oldOfficer->park_id])->first();
								$oldChapter = $backupConnect->table('ork_park')->where('park_id', $oldOfficer->park_id)->first();
								if(!in_array($oldChapter->kingdom_id, $oldRealmCheck)){
									DB::table('crypt')->insert([
											'model' 		=> 'Officer',
											'cause' 		=> 'RealmGone',
											'model_id'		=> $oldOfficer->officer_id,
											'model_value'	=> json_encode($oldOfficer)
									]);
									$bar->advance();
									continue;
								}
								if(!array_key_exists($oldChapter->kingdom_id, $knownRealmChaptertypesOffices)){
									DB::table('crypt')->insert([
											'model' 		=> 'Officer',
											'cause' 		=> 'NoRealmCorpora',
											'model_id'		=> $oldOfficer->officer_id,
											'model_value'	=> json_encode($oldOfficer)
									]);
									$bar->advance();
									continue;
								}
								while(!array_key_exists($oldChapter->kingdom_id, $transRealms)){
									$this->info('waiting for realm ' . $oldChapter->kingdom_id);
									sleep(5);
									$transRealms = $this->getTrans('realms');
								}
								DB::reconnect("mysqlBak");
								$transChaptertypes = $this->getTrans('chaptertypes');
								while(!in_array($chapter->chaptertype_id, $transChaptertypes)){
									$this->info('waiting for chaptertype ' . $chapter->chaptertype_id);
									sleep(5);
									$transChaptertypes = $this->getTrans('chaptertypes');
								}
								DB::reconnect("mysqlBak");
								//oddly, we have officers for offices and chaptertypes that don't actually exist...like champion for WL shires, which don't have them.  Kill those.
								if(!array_key_exists($chapter->chaptertype->name, $knownRealmChaptertypesOffices[$oldChapter->kingdom_id])){
									DB::table('crypt')->insert([
											'model' 		=> 'Officer',
											'cause' 		=> 'NoCorporaChaptertype',
											'model_id'		=> $oldOfficer->officer_id,
											'model_value'	=> json_encode($oldOfficer)
									]);
									$bar->advance();
									continue;
								}
								if(array_search($order, array_column($knownRealmChaptertypesOffices[$oldChapter->kingdom_id][$chapter->chaptertype->name], 'order')) === FALSE){
									DB::table('crypt')->insert([
											'model' 		=> 'Officer',
											'cause' 		=> 'NoCorporaOffice',
											'model_id'		=> $oldOfficer->officer_id,
											'model_value'	=> json_encode($oldOfficer)
									]);
									$bar->advance();
									continue;
								}
								if(!array_key_exists($oldChapter->kingdom_id, $knownCurrentReigns)){
									DB::table('crypt')->insert([
											'model' 		=> 'Officer',
											'cause' 		=> 'NoRealmReign',
											'model_id'		=> $oldOfficer->officer_id,
											'model_value'	=> json_encode($oldOfficer)
									]);
									$bar->advance();
									continue;
								}
								$office = Office::where('officeable_type', 'Chaptertype')->where('officeable_id', $chapter->chaptertype_id)->where('order', $order)->first();
								while(!$office){
									$this->info('waiting for office for chaptertype/order(id) ' . $chapter->chaptertype_id . '/' . $order . ' (' . $oldOfficer->officer_id . ')');
									sleep(5);
									$office = Office::where('officeable_type', 'Chaptertype')->where('officeable_id', $chapter->chaptertype_id)->where('order', $order)->first();
								}
								DB::reconnect("mysqlBak");
								$officeID = $office->id;
								if(strpos($office->name, '|') > -1){
									//assign custom term by gender (if known) Also, I'm sorry I'm defaulting to male.  I don't feel like I have a choice.  Please forgive me.
									$officeNames = explode('|', $office->name);
									//Sheriff|Mayor is an exception...just go with the first one
									if($chapter->chaptertype->rank < 30){
										$label = $officeNames[0];
									}else{
										$persona = Persona::where('id', $transPersonas[$oldOfficer->mundane_id])->first();
										if($persona->pronoun && $persona->pronoun->subject === 'she'){
											$label = $officeNames[1];
										}else{
											$label = $officeNames[0];
										}
									}
								}else{
									$label = $office->name;
								}
								//no park
							}else{
								if(!in_array($oldOfficer->kingdom_id, $oldRealmCheck)){
									DB::table('crypt')->insert([
											'model' 		=> 'Officer',
											'cause' 		=> 'RealmGone',
											'model_id'		=> $oldOfficer->officer_id,
											'model_value'	=> json_encode($oldOfficer)
									]);
									$bar->advance();
									continue;
								}
								if(!array_key_exists($oldOfficer->kingdom_id, $knownRealmChaptertypesOffices)){
									DB::table('crypt')->insert([
											'model' 		=> 'Officer',
											'cause' 		=> 'NoRealmCorpora',
											'model_id'		=> $oldOfficer->officer_id,
											'model_value'	=> json_encode($oldOfficer)
									]);
									$bar->advance();
									continue;
								}
								while(!array_key_exists($oldOfficer->kingdom_id, $transRealms)){
									$this->info('waiting for realm ' . $oldOfficer->kingdom_id);
									sleep(5);
									$transRealms = $this->getTrans('realms');
								}
								DB::reconnect("mysqlBak");
								if(!array_key_exists($oldOfficer->kingdom_id, $knownCurrentReigns)){
									DB::table('crypt')->insert([
											'model' 		=> 'Officer',
											'cause' 		=> 'NoRealmReign',
											'model_id'		=> $oldOfficer->officer_id,
											'model_value'	=> json_encode($oldOfficer)
									]);
									$bar->advance();
									continue;
								}
								$office = Office::where('officeable_type', 'Realm')->where('officeable_id', $transRealms[$oldOfficer->kingdom_id])->where('order', $order)->first();
								while(!$office){
									$this->info('waiting for office realm/order ' . $oldOfficer->kingdom_id . '/' . $order);
									sleep(5);
									$office = Office::where('officeable_type', 'Realm')->where('officeable_id', $transRealms[$oldOfficer->kingdom_id])->where('order', $order)->first();
								}
								DB::reconnect("mysqlBak");
								$officeID = $office->id;
								if(strpos($office->name, '|') > -1){
									//assign custom term by gender (if known) Also, I'm sorry I'm defaulting to male.  I don't feel like I have a choice.  Please forgive me.
									$officeNames = explode('|', $office->name);
									$persona = Persona::where('id', $transPersonas[$oldOfficer->mundane_id])->first();
									if($persona->pronoun && $persona->pronoun->subject === 'she'){
										$label = $officeNames[1];
									}else{
										$label = $officeNames[0];
									}
								}else{
									$label = $office->name;
								}
							}
						}else{
							DB::table('crypt')->insert([
									'model' 		=> 'Officer',
									'cause' 		=> 'NoOrderFound',
									'model_id'		=> $oldOfficer->officer_id,
									'model_value'	=> json_encode($oldOfficer)
							]);
							$bar->advance();
							continue;
						}
						
						//reign?
						$getReign = DB::table('reigns')->where('reignable_type', $oldOfficer->park_id != 0 ? 'Chapter' : 'Realm')->where('reignable_id', $oldOfficer->park_id != 0 ? $transChapters[$oldOfficer->park_id] : $transRealms[$oldOfficer->kingdom_id])->orderBy('ends_on', 'DESC')->first();
						if($getReign){
							$reignID = $getReign->id;
						}else{
							if(!array_key_exists(($oldOfficer->park_id != 0 ? $oldChapter->kingdom_id : $oldOfficer->kingdom_id), $knownCurrentReigns)){
								//this shouldn't happen.  let me know if it does
								throw new \Exception('oldOfficer ' . $oldOfficer->officer_id . ' has no reign detected.' . $oldOfficer->park_id . '/' . $oldChapter->kingdom_id . '/' . $oldOfficer->kingdom_id . '/' . ($oldOfficer->park_id != 0 ? $oldChapter->kingdom_id : $oldOfficer->kingdom_id));
							}
							$reignID = DB::table('reigns')->insertGetId([
									'reignable_type' => $oldOfficer->park_id != 0 ? 'Chapter' : 'Realm',
									'reignable_id' => $oldOfficer->park_id != 0 ? $transChapters[$oldOfficer->park_id] : $transRealms[$oldOfficer->kingdom_id],
									'name' => $oldOfficer->park_id != 0 ? null : $knownCurrentReigns[$oldOfficer->kingdom_id]['label'],
									'starts_on' => $order === 2 || $order === 5 ? $knownCurrentReigns[$oldOfficer->park_id != 0 ? $oldChapter->kingdom_id : $oldOfficer->kingdom_id]['midreign'] : $knownCurrentReigns[$oldOfficer->park_id != 0 ? $oldChapter->kingdom_id : $oldOfficer->kingdom_id]['begins'],
									'ends_on' => $order === 2 || $order === 5 ? date('Y-m-d', strtotime($knownCurrentReigns[$oldOfficer->park_id != 0 ? $oldChapter->kingdom_id : $oldOfficer->kingdom_id]['midreign'] . '+6 months')) : $knownCurrentReigns[$oldOfficer->park_id != 0 ? $oldChapter->kingdom_id : $oldOfficer->kingdom_id]['begins']
							]);
						}
						DB::table('officers')->insert([
								'officerable_type' => 'Reign',
								'officerable_id' => $reignID,
								'office_id' => $officeID,
								'persona_id' => $transPersonas[$oldOfficer->mundane_id],
								'label' => $label ? $label : null,
								'starts_on' => null,
								'ends_on' => null,
								'created_by' => $oldOfficer->authorization_id != '0' ? $transPersonas[$oldOfficer->authorization_id] : 1
						]);
						$bar->advance();
					}
					break;
				case 'Recommendations':
					$this->info('Importing Recommendations...');
					$transTitles = $this->getTrans('titles');
					$transRealmawards = $this->getTrans('realmawards');
					$transPersonas = $this->getTrans('personas');
					$transRealmTitles = $this->getTrans('realmtitles');
					$oldTitles = $backupConnect->table('ork_award')->where('is_title', 1)->pluck('award_id')->toArray();
					$oldKingdomawards = $backupConnect->table('ork_kingdomaward')->pluck('kingdomaward_id')->toArray();
					$oldCustomAwards = $backupConnect->table('ork_kingdomaward')
					->where(function($q) {
						$q->where('award_id', 94)->orWhere('award_id', 0);
					})
					->where(function($q) {
						$q->where('name', '')->orWhere('name', 'LIKE', '%Antigriffin%')->orWhere('name', 'LIKE', '%typhoon%')->orWhere('name', 'LIKE', '%tsunami%')->orWhere('name', 'LIKE', '%Hellrider%')->orWhere('name', 'LIKE', '%Dreamkeeper%')->orWhere('name', 'LIKE', '%Cyclone%')->orWhere('name', 'LIKE', '%Emerald%')->orWhere('name', 'LIKE', 'Order %');
					})->pluck('kingdomaward_id')->toArray();
					$oldRecommendations = $backupConnect->table('ork_recommendations')->get()->toArray();
					$bar = $this->output->createProgressBar(count($oldRecommendations));
					$bar->start();
					foreach ($oldRecommendations as $oldRecommendation) {
						//work out the kingdomaward_id (get persona, search realmawards by persona realm && award)
						$persona = $backupConnect->table('ork_mundane')->where('mundane_id', $oldRecommendation->mundane_id)->first();
						if(!$persona){
							DB::table('crypt')->insert([
									'model' 		=> 'Recommendation',
									'cause' 		=> 'NoTargetPersona',
									'model_id'		=> $oldRecommendation->recommendations_id,
									'model_value'	=> json_encode($oldRecommendation)
							]);
							$bar->advance();
							continue;
						}
						$recommendingPersona = $backupConnect->table('ork_mundane')->where('mundane_id', $oldRecommendation->recommended_by_id)->first();
						if(!$recommendingPersona){
							DB::table('crypt')->insert([
									'model' 		=> 'Recommendation',
									'cause' 		=> 'NoByPersona',
									'model_id'		=> $oldRecommendation->recommendations_id,
									'model_value'	=> json_encode($oldRecommendation)
							]);
							$bar->advance();
							continue;
						}
						while(!array_key_exists($oldRecommendation->recommended_by_id, $transPersonas)){
							$this->info('waiting for persona1 ' . $oldRecommendation->recommended_by_id);
							sleep(5);
							$transPersonas = $this->getTrans('personas');
						}
						DB::reconnect("mysqlBak");
						while(!array_key_exists($oldRecommendation->mundane_id, $transPersonas)){
							$this->info('waiting for persona2 ' . $oldRecommendation->mundane_id);
							sleep(5);
							$transPersonas = $this->getTrans('personas');
						}
						DB::reconnect("mysqlBak");
						$isTitle = in_array($oldRecommendation->award_id, $oldTitles) ? true : false;
						$isCustomTitle = false;
						//let's fix this for WitM
						if($oldRecommendation->award_id == 31){
							if(is_array($knownAwards['Order of the Walker in the Middle'][$persona->kingdom_id]) && $knownAwards['Order of the Walker in the Middle'][$persona->kingdom_id]['type'] == 'award'){
								$isTitle = false;
							}
						}
						//custom award gets its own handling
						if($oldRecommendation->award_id == 94){
							$realmaward = $backupConnect->table('ork_kingdomaward')->where('kingdomaward_id', $oldRecommendation->kingdomaward_id)->first();
							//eliminate garbage
							if(!$realmaward){
								DB::table('crypt')->insert([
										'model' 		=> 'Recommendation',
										'cause' 		=> 'CustomRealmAwardGone',
										'model_id'		=> $oldRecommendation->recommendations_id,
										'model_value'	=> json_encode($oldRecommendation)
								]);
								$bar->advance();
								continue;
							}
							if($realmaward->name === 'Custom Award' || $realmaward->name === ''){
								DB::table('crypt')->insert([
										'model' 		=> 'Recommendation',
										'cause' 		=> 'CustomAwardBlank',
										'model_id'		=> $oldRecommendation->recommendations_id,
										'model_value'	=> json_encode($oldRecommendation)
								]);
								$bar->advance();
								continue;
							}
							//check $knownTitles
							if($realmaward->name === 'Master' || $realmaward->name === 'Mistress'){
								$titleName = 'Master';
							}else if($realmaward->name === 'Lord' || $realmaward->name === 'Lady' || $realmaward->name === 'Noble' || $realmaward->name === 'Liege'){
								$titleName = 'Lord';
							}else if($realmaward->name === 'Baronet' || $realmaward->name === 'Baronetess' || $realmaward->name === 'Constable' || $realmaward->name === 'Baronetex'){
								$titleName = 'Baronet';
							}else if($realmaward->name === 'Baron' || $realmaward->name === 'Baroness' || $realmaward->name === 'Viceroy' || $realmaward->name === 'Baronex'){
								$titleName = 'Baron';
							}else if($realmaward->name === 'Viscount' || $realmaward->name === 'Viscountess' || $realmaward->name === 'Vicarius' || $realmaward->name === 'Viscountex'){
								$titleName = 'Viscount';
							}else if($realmaward->name === 'Marquis' || $realmaward->name === 'Marquise' || $realmaward->name === 'Warden' || $realmaward->name === 'Marchioness' || $realmaward->name === 'Marquex'){
								$titleName = 'Marquis';
							}else if($realmaward->name === 'Count' || $realmaward->name === 'Countess' || $realmaward->name === 'Castellan' || $realmaward->name === 'Jarl' || $realmaward->name === 'Countex'){
								$titleName = 'Count';
							}else if($realmaward->name === 'Duke' || $realmaward->name === 'Duchess' || $realmaward->name === 'Dux'){
								$titleName = 'Duke';
							}else if($realmaward->name === 'Archduke' || $realmaward->name === 'Arch Duke' || $realmaward->name === 'Arch-Duke' || $realmaward->name === 'Archduchess' || $realmaward->name === 'Arch Duchess' || $realmaward->name === 'Arch-Duchess' || $realmaward->name === 'Arci Dux'){
								$titleName = 'Archduke';
							}else if($realmaward->name === 'Grand Duke' || $realmaward->name === 'Grand-Duke' || $realmaward->name === 'Grand Duchess' || $realmaward->name === 'Grand-Duchess' || $realmaward->name === 'Magnus Dux'){
								$titleName = 'Grand Duke';
							}else if($realmaward->name === 'Grand Marquis' || $realmaward->name === 'Grand Marquise'){
								$titleName = 'Grand Marquis';
							}else{
								$titleName = $realmaward->name;
							}
							if(
								array_key_exists($titleName, $knownTitles) &&
								array_key_exists($persona->kingdom_id, $knownTitles[$titleName]) &&
								is_array($knownTitles[$titleName][$persona->kingdom_id])
							){
								$isTitle = true;
								//wait for it in trans
								while(
										!array_key_exists($persona->kingdom_id, $transRealmTitles) ||
										!array_key_exists($realmaward->kingdomaward_id, $transRealmTitles[$persona->kingdom_id])
										){
											$this->info('waiting for realm custom title ' . $persona->kingdom_id . '|' . $realmaward->kingdomaward_id);
											sleep(5);
											$transRealmTitles = $this->getTrans('realmtitles');
								}
								DB::reconnect("mysqlBak");
								$isCustomTitle = true;
								$titleAwardId = $realmaward->kingdomaward_id;
							}
							//check awards
							if(!in_array($oldRecommendation->kingdomaward_id, $oldCustomAwards)) {
								DB::table('crypt')->insert([
										'model' 		=> 'Recommendation',
										'cause' 		=> 'CustomAwardGone',
										'model_id'		=> $oldRecommendation->recommendations_id,
										'model_value'	=> json_encode($oldRecommendation)
								]);
								$bar->advance();
								continue;
							}else{
								while(!array_key_exists($oldRecommendation->kingdomaward_id, $transRealmawards)){
									$this->info('waiting for custom realmaward ' . $oldRecommendation->kingdomaward_id);
									sleep(5);
									$transRealmawards = $this->getTrans('realmawards');
								}
								DB::reconnect("mysqlBak");
							}
						}else{
							$realmawards = $backupConnect->table('ork_kingdomaward')->where('kingdom_id', $persona->kingdom_id)->where('award_id', $oldRecommendation->award_id)->get()->toArray();
							//eliminate garbage
							if(!$realmawards){
								DB::table('crypt')->insert([
										'model' 		=> 'Recommendation',
										'cause' 		=> 'NoAwardTitle',
										'model_id'		=> $oldRecommendation->recommendations_id,
										'model_value'	=> json_encode($oldRecommendation)
								]);
								$bar->advance();
								continue;
							}
							foreach($realmawards as $realmaward){
								if($isTitle){
									if(in_array($oldRecommendation->award_id, $ropTitles)){
										while(
											!array_key_exists(0, $transTitles) ||
											!array_key_exists($oldRecommendation->award_id, $transTitles[0])
										){
											$this->info('waiting for general title ' . $oldRecommendation->award_id);
											sleep(5);
											$transTitles = $this->getTrans('titles');
										}
										DB::reconnect("mysqlBak");
									}else{
										if($realmaward->name === 'Master' || $realmaward->name === 'Mistress'){
											$titleName = 'Master';
										}else if($realmaward->name === 'Lord' || $realmaward->name === 'Lady' || $realmaward->name === 'Noble' || $realmaward->name === 'Liege'){
											$titleName = 'Lord';
										}else if($realmaward->name === 'Baronet' || $realmaward->name === 'Baronetess' || $realmaward->name === 'Constable' || $realmaward->name === 'Baronetex'){
											$titleName = 'Baronet';
										}else if($realmaward->name === 'Baron' || $realmaward->name === 'Baroness' || $realmaward->name === 'Viceroy' || $realmaward->name === 'Baronex'){
											$titleName = 'Baron';
										}else if($realmaward->name === 'Viscount' || $realmaward->name === 'Viscountess' || $realmaward->name === 'Vicarius' || $realmaward->name === 'Viscountex'){
											$titleName = 'Viscount';
										}else if($realmaward->name === 'Marquis' || $realmaward->name === 'Marquise' || $realmaward->name === 'Warden' || $realmaward->name === 'Marchioness' || $realmaward->name === 'Marquex'){
											$titleName = 'Marquis';
										}else if($realmaward->name === 'Count' || $realmaward->name === 'Countess' || $realmaward->name === 'Castellan' || $realmaward->name === 'Jarl' || $realmaward->name === 'Countex'){
											$titleName = 'Count';
										}else if($realmaward->name === 'Duke' || $realmaward->name === 'Duchess' || $realmaward->name === 'Dux'){
											$titleName = 'Duke';
										}else if($realmaward->name === 'Archduke' || $realmaward->name === 'Arch Duke' || $realmaward->name === 'Arch-Duke' || $realmaward->name === 'Archduchess' || $realmaward->name === 'Arch Duchess' || $realmaward->name === 'Arch-Duchess' || $realmaward->name === 'Arci Dux'){
											$titleName = 'Archduke';
										}else if($realmaward->name === 'Grand Duke' || $realmaward->name === 'Grand-Duke' || $realmaward->name === 'Grand Duchess' || $realmaward->name === 'Grand-Duchess' || $realmaward->name === 'Magnus Dux'){
											$titleName = 'Grand Duke';
										}else if($realmaward->name === 'Grand Marquis' || $realmaward->name === 'Grand Marquise'){
											$titleName = 'Grand Marquis';
										}else{
											$titleName = $realmaward->name;
										}
										if(
											array_key_exists($titleName, $knownTitles) &&
											array_key_exists($persona->kingdom_id, $knownTitles[$titleName]) &&
											is_array($knownTitles[$titleName][$persona->kingdom_id])
										){
											while(
												!array_key_exists($persona->kingdom_id, $transTitles) ||
												!array_key_exists($oldRecommendation->award_id, $transTitles[$persona->kingdom_id])
											){
												$this->info('waiting for realm/title ' . $persona->kingdom_id . '/' . $oldRecommendation->award_id);
												sleep(5);
												$transTitles = $this->getTrans('titles');
											}
											DB::reconnect("mysqlBak");
										}else{
											//This realm doesn't have this award
											DB::table('crypt')->insert([
													'model' 		=> 'Recommendation',
													'cause' 		=> 'NoRealmTitle',
													'model_id'		=> $oldRecommendation->recommendations_id,
													'model_value'	=> json_encode($oldRecommendation)
											]);
											$bar->advance();
											continue;
										}
									}
									$titleAwardId = $oldRecommendation->award_id;
								}else{
									if(!in_array($oldRecommendation->kingdomaward_id, $oldKingdomawards)) {
										DB::table('crypt')->insert([
												'model' 		=> 'Recommendation',
												'cause' 		=> 'NoRealmaward',
												'model_id'		=> $oldRecommendation->recommendations_id,
												'model_value'	=> json_encode($oldRecommendation)
										]);
										$bar->advance();
										continue;
									}else{
										//check for 'office'
										if($oldRecommendation->award_id == '0'){
											DB::table('crypt')->insert([
													'model' 		=> 'Recommendation',
													'cause' 		=> 'NullAward',
													'model_id'		=> $oldRecommendation->recommendations_id,
													'model_value'	=> json_encode($oldRecommendation)
											]);
											$bar->advance();
											continue;
										}else{
											$oldAward = $backupConnect->table('ork_award')->where('award_id', $oldRecommendation->award_id)->first();
											if(!$oldAward){
												DB::table('crypt')->insert([
														'model' 		=> 'Recommendation',
														'cause' 		=> 'AwardGone',
														'model_id'		=> $oldRecommendation->recommendations_id,
														'model_value'	=> json_encode($oldRecommendation)
												]);
												$bar->advance();
												continue;
											}elseif($oldAward->officer_role != 'none'){
												DB::table('crypt')->insert([
														'model' 		=> 'Recommendation',
														'cause' 		=> 'IsOfficer',
														'model_id'		=> $oldRecommendation->recommendations_id,
														'model_value'	=> json_encode($oldRecommendation)
												]);
												$bar->advance();
												continue;
											}
										}
										$awardName = $realmaward->name;
										if(
											(
												in_array($realmaward->award_id, $ropLadders)
											) ||
											(
												array_key_exists($awardName, $knownAwards) &&
												array_key_exists($realmaward->kingdom_id, $knownAwards[$awardName]) &&
												is_array($knownAwards[$awardName][$persona->kingdom_id])
											)
										){
											while(!array_key_exists($oldRecommendation->kingdomaward_id, $transRealmawards)){
												$this->info('waiting for realmaward ' . $oldRecommendation->kingdomaward_id);
												sleep(5);
												$transRealmawards = $this->getTrans('realmawards');
											}
											DB::reconnect("mysqlBak");
										}else{
											//This realm doesn't have this award
											DB::table('crypt')->insert([
													'model' 		=> 'Recommendation',
													'cause' 		=> 'NoAwardForRealm',
													'model_id'		=> $oldRecommendation->recommendations_id,
													'model_value'	=> json_encode($oldRecommendation)
											]);
											$bar->advance();
											continue;
										}
									}
								}
							}
						}
						//TODO: check
						DB::table('recommendations')->insert([
								'persona_id' => $transPersonas[$oldRecommendation->mundane_id],
								'recommendable_type' => $isTitle ? 'Title' : 'Award',
								'recommendable_id' => $isTitle ? (
										$isCustomTitle ? 
											$transRealmTitles[$persona->kingdom_id][$oldRecommendation->kingdomaward_id][$titleAwardId] :
											$transTitles[(
												in_array($oldRecommendation->award_id, $ropTitles) ?
													0 :
													$persona->kingdom_id
												)][$titleAwardId]
									) :
									$transRealmawards[(int)$oldRecommendation->kingdomaward_id],
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
					$oldArchetypes = $backupConnect->table('ork_class')->pluck('class_id')->toArray();
					$transPersonas = $this->getTrans('personas');
					$oldPersonas = $backupConnect->table('ork_mundane')->pluck('mundane_id')->toArray();
					$oldReconciliations = $backupConnect->table('ork_class_reconciliation')->get()->toArray();
					$bar = $this->output->createProgressBar(count($oldReconciliations));
					$bar->start();
					foreach ($oldReconciliations as $oldReconciliation) {
						if($oldReconciliation->reconciled === 0){
							DB::table('crypt')->insert([
									'model' 		=> 'Reconciliation',
									'cause' 		=> 'NullValue',
									'model_id'		=> $oldReconciliation->class_reconciliation_id,
									'model_value'	=> json_encode($oldReconciliation)
							]);
							$bar->advance();
							continue;
						}
						if(!in_array($oldReconciliation->class_id, $oldArchetypes)){
							DB::table('crypt')->insert([
									'model' 		=> 'Reconciliation',
									'cause' 		=> 'ArchetypeGone',
									'model_id'		=> $oldReconciliation->class_reconciliation_id,
									'model_value'	=> json_encode($oldReconciliation)
							]);
							$bar->advance();
							continue;
						}
						if(!in_array($oldReconciliation->mundane_id, $oldPersonas)){
							DB::table('crypt')->insert([
									'model' 		=> 'Reconciliation',
									'cause' 		=> 'PersonaGone',
									'model_id'		=> $oldReconciliation->class_reconciliation_id,
									'model_value'	=> json_encode($oldReconciliation)
							]);
							$bar->advance();
							continue;
						}
						while(!array_key_exists($oldReconciliation->mundane_id, $transPersonas)){
							$this->info('waiting for persona ' . $oldReconciliation->mundane_id);
							sleep(5);
							$transPersonas = $this->getTrans('personas');
						}
						DB::reconnect("mysqlBak");
						while(!array_key_exists($oldReconciliation->class_id, $transArchetypes)){
							$this->info('waiting for archetype ' . $oldReconciliation->class_id);
							sleep(5);
							$transArchetypes = $this->getTrans('archetypes');
						}
						DB::reconnect("mysqlBak");
						DB::table('reconciliations')->insert([
								'archetype_id' => $transArchetypes[$oldReconciliation->class_id],
								'persona_id' => $transPersonas[$oldReconciliation->mundane_id],
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
					//when you get to titles, remember you may have already added it from their persona name, so check, and if so, update instead
					$this->info('Importing Issuances...');
					$transRealmawards = $this->getTrans('realmawards');
					$transRealms = $this->getTrans('realms');
					$transUnits = $this->getTrans('units');
					$transTitles = $this->getTrans('titles');
					$transRealmTitles = $this->getTrans('realmtitles');
					$transPersonas = $this->getTrans('personas');
					$transEventDetails = $this->getTrans('eventdetails');
					$transChapters = $this->getTrans('chapters');
					$transOffices = $this->getTrans('offices');
					$transNonNobles = $this->getTrans('nonnobletitles');
					$oldAwards = $backupConnect->table('ork_award')->where('is_ladder', 1)->get()->toArray();
					$oldAwardsCheck = $backupConnect->table('ork_award')->where('is_ladder', 1)->pluck('award_id')->toArray();
					$oldPersonas = $backupConnect->table('ork_mundane')->pluck('mundane_id')->toArray();
					$oldCustomAwards = $backupConnect->table('ork_kingdomaward')
					->where(function($q) {
						$q->where('award_id', 94)->orWhere('award_id', 0);
					})
					->where(function($q) {
						$q->where('name', '')->orWhere('name', 'LIKE', '%Antigriffin%')->orWhere('name', 'LIKE', '%typhoon%')->orWhere('name', 'LIKE', '%tsunami%')->orWhere('name', 'LIKE', '%Hellrider%')->orWhere('name', 'LIKE', '%Dreamkeeper%')->orWhere('name', 'LIKE', '%Cyclone%')->orWhere('name', 'LIKE', '%Emerald%')->orWhere('name', 'LIKE', 'Order %');
					})->pluck('kingdomaward_id')->toArray();
					$oldTitles = $backupConnect->table('ork_award')->where('is_title', 1)->pluck('award_id')->toArray();
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
						->pluck('kingdomaward_id')->toArray();
					$oldOffices = $backupConnect->table('ork_award')->where('officer_role', '!=', 'none')->pluck('award_id')->toArray();
					// 					$oldTitles = $backupConnect->table('ork_award')->where('is_title', 1)->get()->toArray();
					//Make a default 'unknown' location
					$defaultLocationId = DB::table('locations')->insertGetId([
							'address' => 'Lost to the Ages',
							'country' => null
					]);
					
					$bar = $this->output->createProgressBar($backupConnect->table('ork_awards')->count());
					$bar->start();
					$backupConnect->table('ork_awards')->orderBy('awards_id')->chunk(1000, function ($oldIssuances) use (&$transRealmTitles, &$transNonNobles, &$oldCustomTitles, &$knownRealmChaptertypesOffices, &$ropLadders, &$oldAwards, &$knownAwards, &$knownCurrentReigns, &$oldOffices, &$transOffices, &$oldPersonas, &$oldCustomAwards, &$knownTitles, &$ropTitles, &$backupConnect, &$bar, &$defaultLocationId, &$transRealmawards, &$transTitles, &$transEventDetails, &$transChapters, &$oldAwardsCheck, &$oldTitles, &$transRealms, &$transUnits, &$transPersonas){
						foreach($oldIssuances as $oldIssuance) {
							$issuable_type = null;
							$issuable_id = null;
							$rank = null;
							$reason = null;
							$issueDate = $oldIssuance->date != '0000-00-00' ? str_replace('-00-', '-01-', str_replace('-00', '-01', $oldIssuance->date)) : '0000-00-00';
							
							//we don't know what the issuance is...coincedently, we don't know the authorizing realm or park either
							if($oldIssuance->kingdomaward_id == 0){
								//leave them and let humans do the work.  There's only about 300 of them.
								DB::table('crypt')->insert([
										'model' 		=> 'Issuance',
										'cause' 		=> 'NoAward',
										'model_id'		=> $oldIssuance->awards_id,
										'model_value'	=> json_encode($oldIssuance)
								]);
								$bar->advance();
								continue;
							}
							
							//get realmaward (and thus, the realm)
							$realmaward = $backupConnect->table('ork_kingdomaward')->where('kingdomaward_id', $oldIssuance->kingdomaward_id)->first();
							if(!$realmaward){
								DB::table('crypt')->insert([
										'model' 		=> 'Issuance',
										'cause' 		=> 'NoRealmaward',
										'model_id'		=> $oldIssuance->awards_id,
										'model_value'	=> json_encode($oldIssuance)
								]);
								$bar->advance();
								continue;
							}
							
							if($realmaward->kingdom_id == 15){
								$kingdomID = 7;
							}else{
								$kingdomID = $realmaward->kingdom_id;
							}
							
							//get eventcalendardetail?
							$eventcaldet = null;
							if($oldIssuance->at_event_id != 0){
								$eventcaldet = $backupConnect->table('ork_event_calendardetail')->where('event_id', $oldIssuance->at_event_id)->where('event_start', '<=', $issueDate)->where('event_end', '>=', $issueDate)->first();
								if($eventcaldet){
									while(!array_key_exists($eventcaldet->event_calendardetail_id, $transEventDetails)){
										$this->info('waiting for eventdetails ' . $eventcaldet->event_calendardetail_id);
										sleep(5);
										$transEventDetails = $this->getTrans('eventdetails');
									}
									DB::reconnect("mysqlBak");
								}
							}
							
							//custom awards/titles gets its own handling
							if($oldIssuance->award_id == 94){
								if($realmaward->name === 'Custom Award' || $realmaward->name === ''){
									DB::table('crypt')->insert([
											'model' 		=> 'Issuance',
											'cause' 		=> 'CustomAwardBlank',
											'model_id'		=> $oldIssuance->awards_id,
											'model_value'	=> json_encode($oldIssuance)
									]);
									$bar->advance();
									continue;
								}
								//check $knownTitles
								if($realmaward->name === 'Master' || $realmaward->name === 'Mistress'){
									$titleName = 'Master';
								}else if($realmaward->name === 'Lord' || $realmaward->name === 'Lady' || $realmaward->name === 'Noble' || $realmaward->name === 'Liege'){
									$titleName = 'Lord';
								}else if($realmaward->name === 'Baronet' || $realmaward->name === 'Baronetess' || $realmaward->name === 'Constable' || $realmaward->name === 'Baronetex'){
									$titleName = 'Baronet';
								}else if($realmaward->name === 'Baron' || $realmaward->name === 'Baroness' || $realmaward->name === 'Viceroy' || $realmaward->name === 'Baronex'){
									$titleName = 'Baron';
								}else if($realmaward->name === 'Viscount' || $realmaward->name === 'Viscountess' || $realmaward->name === 'Vicarius' || $realmaward->name === 'Viscountex'){
									$titleName = 'Viscount';
								}else if($realmaward->name === 'Marquis' || $realmaward->name === 'Marquise' || $realmaward->name === 'Warden' || $realmaward->name === 'Marchioness' || $realmaward->name === 'Marquex'){
									$titleName = 'Marquis';
								}else if($realmaward->name === 'Count' || $realmaward->name === 'Countess' || $realmaward->name === 'Castellan' || $realmaward->name === 'Jarl' || $realmaward->name === 'Countex'){
									$titleName = 'Count';
								}else if($realmaward->name === 'Duke' || $realmaward->name === 'Duchess' || $realmaward->name === 'Dux'){
									$titleName = 'Duke';
								}else if($realmaward->name === 'Archduke' || $realmaward->name === 'Arch Duke' || $realmaward->name === 'Arch-Duke' || $realmaward->name === 'Archduchess' || $realmaward->name === 'Arch Duchess' || $realmaward->name === 'Arch-Duchess' || $realmaward->name === 'Arci Dux'){
									$titleName = 'Archduke';
								}else if($realmaward->name === 'Grand Duke' || $realmaward->name === 'Grand-Duke' || $realmaward->name === 'Grand Duchess' || $realmaward->name === 'Grand-Duchess' || $realmaward->name === 'Magnus Dux'){
									$titleName = 'Grand Duke';
								}else if($realmaward->name === 'Grand Marquis' || $realmaward->name === 'Grand Marquise'){
									$titleName = 'Grand Marquis';
								}else{
									$titleName = $realmaward->name;
								}
								//check titles & customtitles
								$this->info('checking ' .  $realmaward->kingdomaward_id);
								$this->info('     $titleName = ' . $titleName);
								$this->info('     In $knownTitles? = ' . 
									(
										(
											array_key_exists($titleName, $knownTitles) &&
											array_key_exists($kingdomID, $knownTitles[$titleName]) &&
											is_array($knownTitles[$titleName][$kingdomID])
										) ? 
											' true' : 
											' false'
									)
								);
								$this->info('     In $oldCustomTitles = ' . (in_array($realmaward->kingdomaward_id, $oldCustomTitles) ? ' true' : ' false'));
								$this->info('     In $oldCustomAwards = ' . (in_array($realmaward->kingdomaward_id, $oldCustomAwards) ? ' true' : ' false'));
								if(
									(
										(
											array_key_exists($titleName, $knownTitles) &&
											array_key_exists($kingdomID, $knownTitles[$titleName]) &&
											is_array($knownTitles[$titleName][$kingdomID])
										)||
										in_array($realmaward->kingdomaward_id, $oldCustomTitles)
									)
								){
									$issuable_type = 'Title';
									$rank = null;
									while(
										!array_key_exists($kingdomID, $transRealmTitles) ||
										!array_key_exists($realmaward->kingdomaward_id, $transRealmTitles[$kingdomID])
									){
										$this->info('waiting for custom realm title ' . $kingdomID . '|' . $realmaward->kingdomaward_id);
										sleep(5);
										$transRealmTitles = $this->getTrans('realmtitles');
									}
									DB::reconnect("mysqlBak");
									$issuable_id = $transRealmTitles[$kingdomID][$realmaward->kingdomaward_id];
								//check award
								}elseif(in_array($realmaward->kingdomaward_id, $oldCustomAwards)) {
									$issuable_type = 'Award';
									$rank = $oldIssuance->rank != '' ? $oldIssuance->rank : null;
									while(!array_key_exists($realmaward->kingdomaward_id, $transRealmawards)){
										$this->info('waiting for custom realmaward ' . $realmaward->kingdomaward_id);
										sleep(5);
										$transRealmawards = $this->getTrans('realmawards');
									}
									DB::reconnect("mysqlBak");
									$issuable_id = $transRealmawards[(int)$realmaward->kingdomaward_id];
								//check custom non-noble titles
								}elseif($realmaward->kingdomaward_id == 6036){
									//make sure it's going to exist
									if($oldIssuance->note == '' || ($oldIssuance->park_id == '0' && $oldIssuance->at_park_id == '0')){
										DB::table('crypt')->insert([
												'model' 		=> 'Issuance',
												'cause' 		=> 'NoNonNobleTitleData',
												'model_id'		=> $oldIssuance->awards_id,
												'model_value'	=> json_encode($oldIssuance)
										]);
										$bar->advance();
										continue;
									}
									while(!array_key_exists($oldIssuance->awards_id, $transNonNobles)){
										$this->info('waiting for custom non-noble title ' . $oldIssuance->awards_id);
										sleep(5);
										$transNonNobles = $this->getTrans('nonnobletitles');
									}
									DB::reconnect("mysqlBak");
									$issuable_id = $transNonNobles[(int)$oldIssuance->awards_id];
									$nameFor = $this->cleanCustomNonNobles($oldIssuance->note);
									$reason = $nameFor['for'];
								}else{
									DB::table('crypt')->insert([
											'model' 		=> 'Issuance',
											'cause' 		=> 'NoCustomAward',
											'model_id'		=> $oldIssuance->awards_id,
											'model_value'	=> json_encode($oldIssuance)
									]);
									$bar->advance();
									continue;
								}
							//awards
							}else if (in_array($oldIssuance->award_id, $oldAwardsCheck)) {
								$issuable_type = 'Award';
								//make sure the $rid/award exists in $knownAwards
								$selectedAward = array_search($realmaward->award_id, array_column($oldAwards, 'award_id'));
								$awardName = $oldAwards[$selectedAward]->name;
								if(
									in_array($realmaward->award_id, $ropLadders) || 
									(
										array_key_exists($awardName, $knownAwards) && 
										array_key_exists($kingdomID, $knownAwards[$awardName]) && 
										is_array($knownAwards[$awardName][$kingdomID])
									)
								){
									while(!array_key_exists($oldIssuance->kingdomaward_id, $transRealmawards)){
										$this->info('waiting for realmaward ' . $oldIssuance->kingdomaward_id);
										sleep(5);
										$transRealmawards = $this->getTrans('realmawards');
									}
									DB::reconnect("mysqlBak");
									$issuable_id = $transRealmawards[(int)$oldIssuance->kingdomaward_id];
									$rank = $oldIssuance->rank != '' ? $oldIssuance->rank : null;
								}else{
									DB::table('crypt')->insert([
											'model' 		=> 'Issuance',
											'cause' 		=> 'NoRealmaward',
											'model_id'		=> $oldIssuance->awards_id,
											'model_value'	=> json_encode($oldIssuance)
									]);
									$bar->advance();
									continue;
								}
							//titles
							}else if(in_array($oldIssuance->award_id, $oldTitles)){
								$issuable_type = 'Title';
								$rank = null;
								if(in_array($oldIssuance->award_id, $ropTitles)){
									while(
										!array_key_exists(0, $transTitles) ||
										!array_key_exists($oldIssuance->award_id, $transTitles[0])
									){
										$this->info('waiting for general title ' . $oldIssuance->award_id);
										sleep(5);
										$transTitles = $this->getTrans('titles');
									}
									DB::reconnect("mysqlBak");
									$issuable_id = $transTitles[0][$oldIssuance->award_id];
								}else{
									//check $knownTitles
									if($realmaward->name === 'Master' || $realmaward->name === 'Mistress'){
										$titleName = 'Master';
									}else if($realmaward->name === 'Lord' || $realmaward->name === 'Lady' || $realmaward->name === 'Noble' || $realmaward->name === 'Liege'){
										$titleName = 'Lord';
									}else if($realmaward->name === 'Baronet' || $realmaward->name === 'Baronetess' || $realmaward->name === 'Constable' || $realmaward->name === 'Baronetex'){
										$titleName = 'Baronet';
									}else if($realmaward->name === 'Baron' || $realmaward->name === 'Baroness' || $realmaward->name === 'Viceroy' || $realmaward->name === 'Baronex'){
										$titleName = 'Baron';
									}else if($realmaward->name === 'Viscount' || $realmaward->name === 'Viscountess' || $realmaward->name === 'Vicarius' || $realmaward->name === 'Viscountex'){
										$titleName = 'Viscount';
									}else if($realmaward->name === 'Marquis' || $realmaward->name === 'Marquise' || $realmaward->name === 'Warden' || $realmaward->name === 'Marchioness' || $realmaward->name === 'Marquex'){
										$titleName = 'Marquis';
									}else if($realmaward->name === 'Count' || $realmaward->name === 'Countess' || $realmaward->name === 'Castellan' || $realmaward->name === 'Jarl' || $realmaward->name === 'Countex'){
										$titleName = 'Count';
									}else if($realmaward->name === 'Duke' || $realmaward->name === 'Duchess' || $realmaward->name === 'Dux'){
										$titleName = 'Duke';
									}else if($realmaward->name === 'Archduke' || $realmaward->name === 'Arch Duke' || $realmaward->name === 'Arch-Duke' || $realmaward->name === 'Archduchess' || $realmaward->name === 'Arch Duchess' || $realmaward->name === 'Arch-Duchess' || $realmaward->name === 'Arci Dux'){
										$titleName = 'Archduke';
									}else if($realmaward->name === 'Grand Duke' || $realmaward->name === 'Grand-Duke' || $realmaward->name === 'Grand Duchess' || $realmaward->name === 'Grand-Duchess' || $realmaward->name === 'Magnus Dux'){
										$titleName = 'Grand Duke';
									}else if($realmaward->name === 'Grand Marquis' || $realmaward->name === 'Grand Marquise'){
										$titleName = 'Grand Marquis';
									}else{
										$titleName = $realmaward->name;
									}
									if(
										array_key_exists($titleName, $knownTitles) &&
										array_key_exists($kingdomID, $knownTitles[$titleName]) &&
										is_array($knownTitles[$titleName][$kingdomID])
									){
										while(
											!array_key_exists($kingdomID, $transTitles) ||
											!array_key_exists($oldIssuance->award_id, $transTitles[$kingdomID])
										){
											$this->info('waiting for realm/title ' . $kingdomID . '/' . $oldIssuance->award_id);
											sleep(5);
											$transTitles = $this->getTrans('titles');
										}
										DB::reconnect("mysqlBak");
										$issuable_id = $transTitles[$kingdomID][$oldIssuance->award_id];
									}else{
										//they don't have that, toss it
										DB::table('crypt')->insert([
												'model' 		=> 'Issuance',
												'cause' 		=> 'NoRealmTitle',
												'model_id'		=> $oldIssuance->awards_id,
												'model_value'	=> json_encode($oldIssuance)
										]);
										$bar->advance();
										continue;
									}
								}
							}
							//this one isn't an issuance, it's an office held.  Consider it isolated from here on.
							else if(in_array($oldIssuance->award_id, $oldOffices)){
								if($oldIssuance->mundane_id == '0'){
									DB::table('crypt')->insert([
											'model' 		=> 'Issuance',
											'cause' 		=> 'OfficerNullPersona',
											'model_id'		=> $oldIssuance->awards_id,
											'model_value'	=> json_encode($oldIssuance)
									]);
									$bar->advance();
									continue;
								}
								$personaCheck = $backupConnect->table('ork_mundane')->where('mundane_id', $oldIssuance->mundane_id)->first();
								if(!$personaCheck){
									DB::table('crypt')->insert([
											'model' 		=> 'Issuance',
											'cause' 		=> 'PersonaGone',
											'model_id'		=> $oldIssuance->awards_id,
											'model_value'	=> json_encode($oldIssuance)
									]);
									$bar->advance();
									continue;
								}
								if($oldIssuance->date == '0000-00-00'){
									//try to figure it out
									$matches = [];
									$pattern = '/\b(\d{1,2}\/\d{4}|(?:January|February|March|April|May|June|July|August|September|October|November|December)\s?\d{4}|[a-zA-Z]+\s?\d{4}|\d{1,2}\/\d{1,2}\/\d{4})\b/';
									preg_match_all($pattern, $oldIssuance->date, $matches);
									$dates = $matches[0];
									// Parse dates using Carbon and find the earliest date
									$earliestDate = null;
									foreach ($dates as $tDate) {
										$parsedDate = Carbon::parse($tDate, 'UTC');
										if (!$earliestDate || $parsedDate->lt($earliestDate)) {
											$earliestDate = $parsedDate;
										}
									}
									if($earliestDate){
										$date = date('Y-m-d', strtotime($earliestDate->toDateString()));
									}else{
										DB::table('crypt')->insert([
												'model' 		=> 'Officer',
												'cause' 		=> 'BadDate',
												'model_id'		=> $oldIssuance->awards_id,
												'model_value'	=> json_encode($oldIssuance)
										]);
										$bar->advance();
										continue;
									}
								}else{
									$date = date('Y-m-d', strtotime($oldIssuance->date));
								}
								while(!array_key_exists($oldIssuance->mundane_id, $transPersonas)){
									$this->info('waiting for persona1 ' . $oldIssuance->mundane_id);
									sleep(5);
									$transPersonas = $this->getTrans('personas');
								}
								DB::reconnect("mysqlBak");
								$fromID = $oldIssuance->by_whom_id != '0' ? $oldIssuance->by_whom_id : ($oldIssuance->given_by_id != '0' ? $oldIssuance->given_by_id : 1);
								$fromCheck = $backupConnect->table('ork_mundane')->where('mundane_id', $fromID)->first();
								if(!$fromCheck){
									$fromID = 1;
								}
								$officeCheck = $backupConnect->table('ork_kingdomaward')->where('kingdomaward_id', $oldIssuance->kingdomaward_id)->first();
								if(!$officeCheck){
									DB::table('crypt')->insert([
											'model' 		=> 'Officer',
											'cause' 		=> 'NoRealmOffice1',
											'model_id'		=> $oldIssuance->awards_id,
											'model_value'	=> json_encode($oldIssuance)
									]);
									$bar->advance();
									continue;
								}
								if($oldIssuance->park_id == '0' && $oldIssuance->kingdom_id == '0'){
									//if it's a kingdom office, we can work with that
									$officeAwardCheck = $backupConnect->table('ork_award')->where('award_id', $officeCheck->award_id)->first();
									if($officeAwardCheck->officer_role !== 'park' && $officeAwardCheck->officer_role !== 'none'){
										$oldKingdomID = $officeCheck->kingdom_id;
									}else{
										DB::table('crypt')->insert([
												'model' 		=> 'Issuance',
												'cause' 		=> 'OfficerNoReignInfo',
												'model_id'		=> $oldIssuance->awards_id,
												'model_value'	=> json_encode($oldIssuance)
										]);
										$bar->advance();
										continue;
									}
								}else{
									//TODO: check me!
									if((int)$oldIssuance->kingdom_id !== (int)$officeCheck->kingdom_id){
										DB::table('crypt')->insert([
												'model' 		=> 'Officer',
												'cause' 		=> 'KingdomMismatch',
												'model_id'		=> $oldIssuance->awards_id,
												'model_value'	=> json_encode($oldIssuance)
										]);
										$bar->advance();
										continue;
									}
									$oldKingdomID = $oldIssuance->kingdom_id;
								}
								$knownCheck = false;
								if(array_key_exists($oldKingdomID, $knownRealmChaptertypesOffices)){
									foreach($knownRealmChaptertypesOffices[$oldKingdomID] as $offices){
										foreach($offices as $office){
											if(is_array($office['award_ids'])) {
												if(array_key_exists('award_ids', $office) && in_array($officeCheck->award_id, $office['award_ids'])) {
													$knownCheck = true;
												}
											}
										}
									}
								}
								if(!$knownCheck){
									DB::table('crypt')->insert([
											'model' 		=> 'Officer',
											'cause' 		=> 'NoRealmOffice2',
											'model_id'		=> $oldIssuance->awards_id,
											'model_value'	=> json_encode($oldIssuance)
									]);
									$bar->advance();
									continue;
								}
								while(!array_key_exists($oldIssuance->kingdomaward_id, $transOffices)){
									$this->info('waiting for office ' . $oldIssuance->kingdomaward_id);
									sleep(5);
									$transOffices = $this->getTrans('offices');
								}
								DB::reconnect("mysqlBak");
								$office = Office::where('id', $transOffices[$oldIssuance->kingdomaward_id])->first();
								$persona = Persona::where('id', $transPersonas[$oldIssuance->mundane_id])->first();
								//work out label by gender (as appropriate)
								if(strpos($office->name, '|') > -1){
									//assign custom term by gender (if known) Also, I'm sorry I'm defaulting to male.  I don't feel like I have a choice.  Please forgive me.
									$officeNames = explode('|', $office->name);
									if($persona->pronoun && $persona->pronoun->subject === 'she'){
										$label = $officeNames[1];
									}else{
										$label = $officeNames[0];
									}
								}else{
									$label = $office->name;
								}
								//TODO: check results for '[A&S]'.  Shouldn't be any, but if so, deal with 'em
								if($office->officeable_type == 'Chaptertype'){
									$reignBaseCheck = $backupConnect->table('ork_park')->where('park_id', $oldIssuance->park_id)->first();
									if($reignBaseCheck){
										while(!array_key_exists($oldIssuance->park_id, $transChapters)){
											$this->info('waiting for chapter ' . $oldIssuance->park_id);
											sleep(5);
											$transChapters = $this->getTrans('chapters');
										}
										DB::reconnect("mysqlBak");
									}else{
										DB::table('crypt')->insert([
												'model' 		=> 'Officer',
												'cause' 		=> 'ChapterGone',
												'model_id'		=> $oldIssuance->awards_id,
												'model_value'	=> json_encode($oldIssuance)
										]);
										$bar->advance();
										continue;
									}
								}else{
									$realmBaseCheck = $backupConnect->table('ork_kingdom')->where('kingdom_id', $oldKingdomID)->first();
									if($realmBaseCheck){
										while(!array_key_exists($oldKingdomID, $transRealms)){
											$this->info('waiting for realm ' . $oldKingdomID);
											sleep(5);
											$transRealms = $this->getTrans('realms');
										}
										DB::reconnect("mysqlBak");
									}else{
										DB::table('crypt')->insert([
												'model' 		=> 'Officer',
												'cause' 		=> 'RealmGone',
												'model_id'		=> $oldIssuance->awards_id,
												'model_value'	=> json_encode($oldIssuance)
										]);
										$bar->advance();
										continue;
									}
								}
								
								//reign
								$getReign = DB::table('reigns')
									->where('reignable_type', $office->officeable_type == 'Chaptertype' ? 'Chapter' : 'Realm')
									->where('reignable_id', $office->officeable_type == 'Chaptertype' ? $transChapters[$oldIssuance->park_id] : $transRealms[$oldKingdomID])
									->where('starts_on', '<=', $date)
									->where('ends_on', '>=', $date)
									->first();
								if($getReign){
									$reignID = $getReign->id;
								}else{
									if(!array_key_exists($oldKingdomID, $knownCurrentReigns)){
										//this shouldn't happen.  let me know if it does
										throw new \Exception('oldIssuanceOfficer ' . $oldIssuance->awards_id . ' has no kingdom detected.');
									}
									$reignID = DB::table('reigns')->insertGetId([
											'reignable_type' => $office->officeable_type == 'Chaptertype' ? 'Chapter' : 'Realm',
											'reignable_id' => $office->officeable_type == 'Chaptertype' ? $transChapters[$oldIssuance->park_id] : $transRealms[$oldKingdomID],
											'name' => $office->officeable_type == 'Chaptertype' ? null : $knownCurrentReigns[$oldKingdomID]['label'],
											'starts_on' => $office->order === 2 || $office->order === 5 ? date('Y-m-d', strtotime($date . ' - 3 months')) : $date,
											'ends_on' => $office->order === 2 || $office->order === 5 ? date('Y-m-d', strtotime($date . '+3 months')) : date('Y-m-d', strtotime($date . '+6 months'))
									]);
								}
								
								DB::table('officers')->insert([
										'officerable_type' => 'Reign',
										'officerable_id' => $reignID,
										'office_id' => $office->id,
										'persona_id' => $persona->id,
										'label' => $label ? $label : null,
										'starts_on' => null,
										'ends_on' => null,
										'created_by' => $transPersonas[$fromID]
								]);
								//all done with this one
								$bar->advance();
								continue;
							}else{
								DB::table('crypt')->insert([
										'model' 		=> 'Issuance',
										'cause' 		=> 'UnknownType',
										'model_id'		=> $oldIssuance->awards_id,
										'model_value'	=> json_encode($oldIssuance)
								]);
								$bar->advance();
								continue;
							}
							
							if($oldIssuance->park_id != '0'){
								while(!array_key_exists($oldIssuance->park_id, $transChapters)){
									$this->info('waiting for chapter ' . $oldIssuance->park_id);
									sleep(5);
									$transChapters = $this->getTrans('chapters');
								}
								DB::reconnect("mysqlBak");
							}else{
								while(!array_key_exists($kingdomID, $transRealms)){
									$this->info('waiting for realm ' . $kingdomID);
									sleep(5);
									$transRealms = $this->getTrans('realms');
								}
								DB::reconnect("mysqlBak");
							}
							
							if($oldIssuance->unit_id != '0'){
								while(!array_key_exists($oldIssuance->unit_id, $transUnits)){
									$this->info('waiting for unit ' . $oldIssuance->unit_id);
									sleep(5);
									$transUnits = $this->getTrans('units');
								}
								DB::reconnect("mysqlBak");
							}else{
								$target = $oldIssuance->mundane_id != '0' ? $oldIssuance->mundane_id : $oldIssuance->stripped_from;
								//check if it exists
								if(in_array($target, $oldPersonas)){
									while(!array_key_exists($target, $transPersonas)){
										$this->info('waiting for persona2 ' . $target);
										sleep(5);
										$transPersonas = $this->getTrans('personas');
									}
									DB::reconnect("mysqlBak");
								}else{
									//nope this bitch
									DB::table('crypt')->insert([
											'model' 		=> 'Issuance',
											'cause' 		=> 'NoTargetPersona',
											'model_id'		=> $oldIssuance->awards_id,
											'model_value'	=> json_encode($oldIssuance)
									]);
									$bar->advance();
									continue;
								}
							}
							if($oldIssuance->given_by_id != '0'){
								if(in_array($oldIssuance->given_by_id, $oldPersonas)){
									while(!array_key_exists($oldIssuance->given_by_id, $transPersonas)){
										$this->info('waiting for persona3 ' . $oldIssuance->given_by_id);
										sleep(5);
										$transPersonas = $this->getTrans('personas');
									}
									DB::reconnect("mysqlBak");
								}else{
									//nope this bitch
									DB::table('crypt')->insert([
											'model' 		=> 'Issuance',
											'cause' 		=> 'NoGivingPersona',
											'model_id'		=> $oldIssuance->awards_id,
											'model_value'	=> json_encode($oldIssuance)
									]);
									$bar->advance();
									continue;
								}
							}
							if($oldIssuance->revoked_by_id != '0'){
								if(in_array($oldIssuance->revoked_by_id, $oldPersonas)){
									while(!array_key_exists($oldIssuance->revoked_by_id, $transPersonas)){
										$this->info('waiting for persona4 ' . $oldIssuance->revoked_by_id);
										sleep(5);
										$transPersonas = $this->getTrans('personas');
									}
									DB::reconnect("mysqlBak");
								}else{
									//nope this bitch
									DB::table('crypt')->insert([
											'model' 		=> 'Issuance',
											'cause' 		=> 'NoRevokingPersona',
											'model_id'		=> $oldIssuance->awards_id,
											'model_value'	=> json_encode($oldIssuance)
									]);
									$bar->advance();
									continue;
								}
							}
							
							if(!$reason){
								$reason = trim($oldIssuance->note) != '' ? trim($oldIssuance->note) : null;
							}
							
							//make it
							DB::table('issuances')->insert([
									'issuable_type' => $issuable_type,
									'issuable_id' => $issuable_id,
									'whereable_type' => $eventcaldet ? 'Event' : 'Location',
									'whereable_id' => $eventcaldet ? $transEventDetails[$eventcaldet->event_calendardetail_id] : $defaultLocationId,
									'authority_type' => $oldIssuance->park_id != '0' ? 'Chapter' : 'Realm',
									'authority_id' => $oldIssuance->park_id != '0' ? $transChapters[$oldIssuance->park_id] : $transRealms[$kingdomID],
									'recipient_type' => $oldIssuance->unit_id != '0' ? 'Unit' : 'Persona',
									'recipient_id' => $oldIssuance->unit_id != '0' ? $transUnits[$oldIssuance->unit_id] : ($oldIssuance->mundane_id != '0' && in_array($oldIssuance->mundane_id, $oldPersonas) ? $transPersonas[$oldIssuance->mundane_id] : $transPersonas[$oldIssuance->stripped_from]),
									'issuer_id' => $oldIssuance->given_by_id != '0' && in_array($oldIssuance->given_by_id, $oldPersonas) ? $transPersonas[$oldIssuance->given_by_id] : null,
									'custom_name' => $oldIssuance->custom_name != '' ? $oldIssuance->custom_name : null,
									'rank' => $rank > 0 ? $rank : null,
									'issued_at' => $issueDate != '0000-00-00' && $issueDate != '0000-00-00 00:00:00' ? $issueDate : ($oldIssuance->entered_at != '0000-00-00' && $oldIssuance->entered_at != '0000-00-00 00:00:00' ? $oldIssuance->entered_at : date('Y-m-d')),
									'reason' => $reason,
									'image' => null,
									'revocation' => trim($oldIssuance->revocation) != '' ? trim($oldIssuance->revocation) : null,
									'revoked_by' => $oldIssuance->revoked_by_id != '0' && in_array($oldIssuance->revoked_by_id, $oldPersonas) ? $transPersonas[$oldIssuance->revoked_by_id] : null,
									'revoked_at' => $oldIssuance->revoked_at != '0000-00-00' ? $oldIssuance->revoked_at : null
							]);
							$bar->advance();
						}
					});
					break;
					//TODO: run and check results when a full rotation is complete
					//TODO: it should only include unused stuff.  Process stuff like 'DPfL' and 'x Qualified'.
				case 'CheckAwards':
					$realmawardsProcessed = $this->getTrans('realmawardsprocessed');
					$processedKeys = array_keys($realmawardsProcessed);
					
					// Retrieve kingdomaward_id values from the old Ork system's table
					$oldAwards = $backupConnect->table('ork_kingdomaward')->pluck('kingdomaward_id')->toArray();
					
					$unfound = [];
					
					// Create a progress bar for better visibility of the process
					$bar = $this->output->createProgressBar(count($oldAwards));
					$bar->start();
					
					foreach ($oldAwards as $oldAward) {
						// Check if the kingdomaward_id is not found in the processed keys
						if (!in_array($oldAward, $processedKeys)) {
							$unfound[] = $oldAward;
						}
						
						// Update the progress bar
						$bar->advance();
					}
					
					// Stop the progress bar and display the unfound awards
					$bar->finish();
					dd($unfound);
					break;
				case 'Default':
					$bar = $this->output->createProgressBar(1);
					$bar->start();
					$this->info('No step given.');
					$bar->advance(); // Advance the progress bar to complete the process
					break;
			}
			
			//clean up
			$bar->finish();
			Schema::enableForeignKeyConstraints();
			
			//TODO: squires, pages, at-arms, and apprentices can't be done, the data is just too jacked.  Stop trying, make them do it.
			//TODO: tell chapter pms to adjust their reign dates
			
			$this->info('All done!');
			Log::info($step . ' is complete.');
		} catch (Throwable $e) {
			$trace = $e->getTrace()[AppHelper::instance()->search_multi_array(__FILE__, 'file', $e->getTrace())];
			Log::error($e->getMessage() . ' (' . $trace['file'] . ':' . $trace['line'] . ')\r\n' . '[stacktrace]' . '\r\n' . $e->getTraceAsString());
			$this->error(sprintf('%s:%d - ' . str_replace('%', '%%', $e->getMessage()), $e->getFile(), $e->getLine()));
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
	private function cleanCustomNonNobles($titleName){
		$awardInfo = ['name' => null, 'for' => null];
		$matches = [];
		
		// Check for specific patterns in the string and extract relevant information
		if (preg_match('/^(.+)\s*\(for\s*(.+)\)$/', $titleName, $matches)) {
			// Check for the pattern: "Award Name (for Reason)"
			$awardInfo['name'] = trim($matches[1]);
			$awardInfo['for'] = trim($matches[2]);
		} elseif (preg_match('/^"([^"]+)" (.+)$/', $titleName, $matches)) {
			// Pattern: ""Award Name" Reason"
			$awardInfo['name'] = trim($matches[1]);
			$awardInfo['for'] = trim($matches[2]);
		} elseif (preg_match('/^([^:]+):(.+)$/', $titleName, $matches)) {
			// Pattern: "Award Name: Reason"
			$awardInfo['name'] = trim($matches[1]);
			$awardInfo['for'] = trim($matches[2]);
		} elseif (preg_match('/^"([^"]+)"\s+"([^"]+)"$/', $titleName, $matches)) {
			// Pattern: ""Award Name" "Reason""
			$awardInfo['name'] = trim($matches[1]);
			$awardInfo['for'] = trim($matches[2]);
		} elseif (preg_match('/^(.+) - (.+)$/', $titleName, $matches)) {
			// Pattern: "Award Name - Reason"
			$awardInfo['name'] = trim($matches[1]);
			$awardInfo['for'] = trim($matches[2]);
		} elseif (preg_match('/^"(.+)" for (.+)$/', $titleName, $matches)) {
			// Pattern: ""Award Name" for Reason"
			$awardInfo['name'] = trim($matches[1]);
			$awardInfo['for'] = trim($matches[2]);
		} elseif (preg_match('/^(.+), for (.+)$/', $titleName, $matches)) {
			// Pattern: "Award Name, for Reason"
			$awardInfo['name'] = trim($matches[1]);
			$awardInfo['for'] = trim($matches[2]);
		} elseif (preg_match('/^(.+) for (.+)$/', $titleName, $matches)) {
			// Pattern: "Award Name for Reason"
			$awardInfo['name'] = trim($matches[1]);
			$awardInfo['for'] = trim($matches[2]);
		} elseif (preg_match('/^(.+) - for (.+)$/', $titleName, $matches)) {
			// Pattern: "Award Name - for Reason"
			$awardInfo['name'] = trim($matches[1]);
			$awardInfo['for'] = trim($matches[2]);
		} elseif (preg_match('/^(.+)\s+for\s+"([^"]+)"$/', $titleName, $matches)) {
			// Pattern: "Award Name for "Reason""
			$awardInfo['name'] = trim($matches[1]);
			$awardInfo['for'] = trim($matches[2]);
		} else {
			// Pattern: Single word award name
			$awardInfo['name'] = trim($titleName);
		}
		
		if($awardInfo['name'] != null){
			$awardInfo['name'] = ltrim($awardInfo['name'], 'NonNoble Title of ');
			$awardInfo['name'] = ltrim($awardInfo['name'], 'Non noble title ');
			$awardInfo['name'] = trim($awardInfo['name'], '"');
			$awardInfo['name'] = rtrim($awardInfo['name'], ',');
			$awardInfo['name'] = rtrim($awardInfo['name'], '"');
			$awardInfo['name'] = ltrim($awardInfo['name'], 'â€œ');
			$awardInfo['name'] = rtrim($awardInfo['name'], 'â€');
			if(str_contains(' given', $awardInfo['name'])){
				$exploded = explode(' given', $awardInfo['name']);
				$awardInfo['name'] = $exploded[0];
			}
			$awardInfo['name'] = substr($awardInfo['name'], 0, 100);
		}
		if($awardInfo['for'] != null){
			$awardInfo['for'] = trim($awardInfo['for'], '"');
			$awardInfo['for'] = str_replace('for ', '', $awardInfo['for']);
			$awardInfo['for'] = str_replace('- ', '', $awardInfo['for']);
		}
		
		return $awardInfo;
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
		if($personaName === $mundaneName && $mundaneName != 'admin'){
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
		return in_array($country, $countries) ? array_search($country, $countries) : null;
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
		return substr(implode("", $abbreviatedName[0]), 0, 3);
	}
	
	private function getTrans($array){
		$hasTable = Schema::hasTable('trans');
		while(!$hasTable){
			$this->info('waiting for trans');
			sleep(5);
			$hasTable = Schema::hasTable('trans');
		}
		DB::reconnect("mysqlBak");
		$transDatas = DB::table('trans')->where('array', $array)->get()->toArray();
		$response = [];
		foreach($transDatas as $transData){
			if($transData->array === 'titles' || $transData->array === 'realmtitles' ){
				$response[$transData->oldMID ? $transData->oldMID : 0][$transData->oldID] = $transData->newID;
			}else{
				$response[$transData->oldID] = $transData->newID;
			}
		}
		return $response;
	}
}