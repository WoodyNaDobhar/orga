# Online Record Keeper v4 (Orga)

The ORK is a recordkeeping and community management tool for use with the game Amtgard.

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See deployment for notes on how to deploy the project on a live system.

### Prerequisites

It's highly recommended you run Laravel's sail along with Docker to serve your local code.  If you do, and you're not SSL'ed into the server (ie, on WSL), don't forget to prefix your commands with 'sail'.

```
PHP >= 8.0
BCMath PHP Extension
Ctype PHP Extension
Fileinfo PHP extension
JSON PHP Extension
Mbstring PHP Extension
OpenSSL PHP Extension
PDO PHP Extension
Tokenizer PHP Extension
XML PHP Extension
Composer
Docker
```

### Installing

Fork and clone the repo into your local development environment.

```
git clone git@github.com:YourForkAccount/orga.git
```

Update .env file
Run composer

```
composer install
```

Install Node dependancies

```
sail yarn
```

From the resulting directory command line (in WSL for Windows), start sail.  The first time you run this, it'll take a minute.

```
sail up
```

Generate key

```
sail php artisan key:generate
```

Run migrations in the root 

```
sail php artisan migrate
```

Poplulate DB.  If you don't know 'with what', then you can't be doing this.
Start up yarn

```
sail yarn run dev
```

## Search

Searching is handled using Laravel Scout.  It's configured to use meilisearch for its engine, but can also use database (the former has much better results)

## Queueing

We're using Redis for handling queues.  On your local machine, upon sailing up, you should run

```
sail php artisan queue:work redis
```

You'll also need to import the existing records:

```
sail php artisan scout:sync-index-settings
```

Production environments require you to have the workers running all the time. queue:work command itself can fail due to many reasons, such as exceeding the maximum timeout. Checking the server manually to make sure if the queue worker is up is not an option. Instead, you’ll use Supervisor, a process monitor for Linux environments.

After installing the Supervisor on the server, you need to give it a configuration file to interact with Laravel’s queue workers. Let’s create a laravel-worker.conf file that handles the queue:work process.

```
[program:laravel-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /home/project/artisan queue:work redis --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=root
numprocs=4
redirect_stderr=true
stdout_logfile=/home/project/logs/worker.log
stopwaitsecs=3600
```

In this configuration, you should tell the Supervisor to restart the workers automatically and have 4 parallel processes running. Let’s start the processes:

```
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start laravel-worker:*
```

In conclusion, this is as simple as you read it. The Supervisor will keep the workers running. Whenever the queue gets a job, the workers will pick and run it. This way, you ensure the user doesn’t have to wait until PHP processes the task of sending an email and proceeds to the next page by moving this time-consuming job to ‘parallel’ threads.

## Adding Objects

The site uses Infyom generators to create objects.  To do create the object Test, first make the table w/ its various rows in your local db.  Then, use the following command in the root folder:

```
sail php artisan infyom:api_scaffold Test --fromTable --tableName=tests  --datatables=true --skip=dump-autoload --factory
```

It's not a perfect process, and a number of the resulting files need tweaked to work right.

1. testDataTable
   - dataTable: add any fk fields column (generally not created/updated/deleted by)
   
   ```
		$dataTable->addColumn('fk', function (Test $test) {
			return $test->fk ? ( strlen($test->fk->label) > 60 ? (substr($test->fk->label, 0, 60) . "...") : $test->fk->label ) : ' ';
		});
   ```
   - query: add any fk fields column (generally not created/updated/deleted by)
   
   ```
			->with('fk')
   ```
   - getColumns: add any fk fields column (generally not created/updated/deleted by)
   
   ```
            ['data' => 'fk', 'name' => 'fk.label', 'title' => 'Fk', 'orderable' => true, 'searchable' => true],
   ```
   - getColumns: remove _by fields
2. TestController
   - uses: add any fk fields data & View Facade
   
   ```
	use App\Models\Fk;
	use Illuminate\Support\Facades\View;
   ```
   - __construct: add any fk fields data
   
   ```
		$this->fks = Fk::orderBy('label')->pluck('label', 'id')->toArray();
		View::share('fks', $this->fks);
   ```
3. TestAPIController
   - add @OA
   - same for related models' controllers
4. TestPolicy
   - create (generally, just copy AnswerPolicy, update as neccessary)
5. AuthServiceProvider

```
    use App\Models\Test;
```
   
```
    use App\Policies\TestPolicy;
```
   
```
		Test::class => TestPolicy::class,
```
6. Permissions
   - in migration, add (modifying as necessary):
   
```
    use Spatie\Permission\Models\Role;
    use Spatie\Permission\Models\Permission;
```
   
```
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        
        Permission::create(['name' => 'list tests', 'guard_name' => 'api']);
        Permission::create(['name' => 'store tests', 'guard_name' => 'api']);
        Permission::create(['name' => 'display tests', 'guard_name' => 'api']);
        Permission::create(['name' => 'update tests', 'guard_name' => 'api']);
        Permission::create(['name' => 'remove tests', 'guard_name' => 'api']);

        $role = Role::where('name', 'admin')->first();
        $role->givePermissionTo('list tests');
        $role->givePermissionTo('store tests');
        $role->givePermissionTo('display tests');
        $role->givePermissionTo('update tests');
        $role->givePermissionTo('remove tests');

        $role = Role::where('name', 'sales')->first();
        $role->givePermissionTo('list tests');
        $role->givePermissionTo('display tests');

        $role = Role::where('name', 'trainer')->first();
        $role->givePermissionTo('list tests');
        $role->givePermissionTo('display tests');
        
        $role = Role::where('name', 'owner')->first();
        $role->givePermissionTo('list tests');
        $role->givePermissionTo('display tests');

        $role = Role::where('name', 'coach')->first();
        $role->givePermissionTo('list tests');
        $role->givePermissionTo('display tests');

        $role = Role::where('name', 'user')->first();
        $role->givePermissionTo('list tests');
        $role->givePermissionTo('display tests');
```
   
```
        $role = Role::where('name', 'admin')->first();
        $role->revokePermissionTo('list tests');
        $role->revokePermissionTo('store tests');
        $role->revokePermissionTo('display tests');
        $role->revokePermissionTo('update tests');
        $role->revokePermissionTo('remove tests');

        $role = Role::where('name', 'sales')->first();
        $role->revokePermissionTo('list tests');
        $role->revokePermissionTo('display tests');
        $role->revokePermissionTo('list tests');
        $role->revokePermissionTo('display tests');

        $role = Role::where('name', 'trainer')->first();
        $role->revokePermissionTo('list tests');
        $role->revokePermissionTo('display tests');
        
        $role = Role::where('name', 'owner')->first();
        $role->revokePermissionTo('list tests');
        $role->revokePermissionTo('display tests');

        $role = Role::where('name', 'coach')->first();
        $role->revokePermissionTo('list tests');
        $role->revokePermissionTo('display tests');

        $role = Role::where('name', 'user')->first();
        $role->revokePermissionTo('list tests');
        $role->revokePermissionTo('display tests');
        
        Permission::where('name', 'list tests')->delete();
        Permission::where('name', 'store tests')->delete();
        Permission::where('name', 'display tests')->delete();
        Permission::where('name', 'update tests')->delete();
        Permission::where('name', 'remove tests')->delete();

        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
```
    
7. Test
   - use: remove Eloquent
   - add @OA
   - timestamps: if !created/updated/deleted_at: remove use SoftDeletes, protected $dates, and update $timestamps to false.
   - rules: remove created_x
   
   ```
		,
        'created_by' => 'required',
        'created_at' => 'required'
   ```
   
   - extends BaseModel: add relationships map
   
   ```
	/**
	 * The relationships map for the model.
	 *
	 * @var array
	 */
	public $relationships = [
		'x' => 'RelationshipType',
		'createdBy' => 'BelongsTo',
		'updatedBy' => 'BelongsTo',
		'deletedBy' => 'BelongsTo'
	];
   ```
   - relationship methods: reorder alphabetically
   - all the above for related models
8. TestFactory
   - values: update as neccessary.
   - x_id: 
   
   ```
   $xs = App\Models\X::all()->pluck('id');
   'x_id' => $faker->randomElement($xs),
   ```
   - deleted_at: remove
   - x_by: 
   
   ```
		'created_by' => $faker->randomElement($users),
		'updated_by' => 807,
		'deleted_by' => null,
		'created_at' => $faker->date('Y-m-d H:i:s'),
		'updated_at' => $faker->date('Y-m-d H:i:s')
   ```
9. test/fields.blade.php
   - _id fields: update to dd
   
   ```
    @if(isset($test) && $test->x_id)
    {!! Form::select('x_id', $xs, $test->x_id, ['class' => 'form-control']) !!}
    @else
    {!! Form::select('x_id', ['' => 'Select One'] + $xs, null, ['class' => 'form-control']) !!}
    @endif
   ```
   - textarea fields: add summernote
   
   ```
    {!! Form::textarea('fieldname', old('test.answer'), ['class' => 'form-control summernote']) !!}
   ```
   - _by fields: remove
   - enum fields: update to select.  May need to create the $xList variable in AppServiceProvider
   
   ```
    @if(isset($test) && $test->x)
    {!! Form::select('x', $testTypesList, $test->x, ['class' => 'form-control']) !!}
    @else
    {!! Form::select('x', $testXsList, null !== old('test.x') ? old('test.x') : 'someDefault', ['class' => 'form-control']) !!}
    @endif
   ```
   - tooltips: update title value from asdf
10. test/show_fields.blade.php
   - _id fields: add as
   
   ```
    <p>{{ $test->x->label }}</p>
   ```
11. layouts/menu
    - move to admin section in proper alphabetical place
    - copy to sales, if applicable
12. routes/web
    - move to admin section in proper alphabetical place
    - copy to sales, if applicable
13. routes/api
    - move to appropriate section(s)
14. generate & optimize

```
sail php artisan l5-swagger:generate
sail php artisan ide-helper:generate
sail php artisan ide-helper:models (no)
sail php artisan ide-helper:meta
sail php artisan optimize
sail composer dumpautoload
```

## Adding To Objects

You'll want to start by creating the migration. The following describes the naming convention you should use, where 'test' is your table, and 'i' is the update iteration (starting with 1)

```
sail php artisan make:migration update_tests_table_i
```

The contents might be something like:

```
Schema::table('tests', static function (Blueprint $table) {
	$table->unsignedInteger('x_id')->nullable()->after('label');
});
```

```
Schema::table('tests', static function (Blueprint $table) {
	$table->dropColumn('x_id');
});
```

If it's a relationship field, don't forget to add the fk's:

```
Schema::disableForeignKeyConstraints();
Schema::table('tests', function(Blueprint $table)
{
	$table->foreign('x_id', 'test_x_id')->references('id')->on('xs')->onUpdate('NO ACTION')->onDelete('NO ACTION');
});
Schema::enableForeignKeyConstraints();
```

```
Schema::table('tests', function(Blueprint $table)
{
	$table->dropForeign('test_x_id');
});
```

Run the migration, check the results, then roll it back, make any refinements required and run it again. Keep doing that until you've migrated, rolled back, and migrated again and everything is perfect.  Then make the following updates to engage the basic controls. It'll be different for a basic field than a relationship field.

1. App/Http/Controllers/API/TestAPIController
	- index & show OA notation

```
test (Model) {Relationship): Description.<br>
```

2. App/Models/Test
    - @OA\Schema description

```
* field (Model) (Relationship): Description.
```

   - @OA\Schema field

```
* @OA\Property(
* property="test",
* description="Description.",
* readOnly=false,
* nullable=true,
* type="string",
* format="uppercase first letter",
* example="John Smith",
* maxLength=191
* ),
```

   - @OA\Schema relationship

```
* @OA\Property(
* property="test_id",
* description="Description.",
* readOnly=false,
* nullable=true,
* type="integer",
* format="int32",
* example=42
* ),
```

```
* @OA\Property(
* property="test",
* type="object",
* description="Attachable description.",
* ref="#/components/schemas/TestSimple",
* readOnly=true
* ),
```

   - @OA\TestSimple & @OA\TestSuperSimple field

```
* @OA\Property(
* property="test",
* description="Description.",
* readOnly=false,
* nullable=true,
* type="string",
* format="uppercase first letter",
* example="John Smith",
* maxLength=191
* ),
```

- @OA\TestSimple & @OA\TestSuperSimple relationship

```
* @OA\Property(
* property="test_id",
* description="Description.",
* readOnly=false,
* nullable=true,
* type="integer",
* format="int32",
* example=42
* ),
```

- fillable field

```
'test',
```

- fillable relationship

```
'test_id',
```

- casts field

```
'x' => 'y',
```

- casts relationship

```
'x_id' => 'integer',
```

- toSearchableArray - Probably not required, but if you do, be sure to cast integer types.

- rules field

```
'test' => 'nullable|string|max:191', (alter as required)
```

- rules relationship

```
'test_id' => 'nullable|exists:issuances,id', (alter as required)
```

- relationships

```
'x' => 'RelationshipType',
```

- define relationship

```
/**
* @return \Illuminate\Database\Eloquent\Relations\RelationshipType
**/
public function x()
{
	return $this->relationshipType(\App\Models\X::class, 'x_id');
}
```

3. App/Models/X - related model, if relationship
    - relationships

```
'test' => 'RelationshipType',
```

   - define relationship

```
/**
* @return \Illuminate\Database\Eloquent\Relations\RelationshipType
**/
public function test()
{
	return $this->relationshipType(\App\Models\Test::class);
}
```

4. App\Repositories\TestRepository
    - fieldSearchable

```
'x',
```

5. App\Resources\TestResource
    - toArray

```
'test_id' => $this->test_id,
```

6. Database\Factories\TestFactory
    - relationship (not BtM)

```
use App\Models\Test;
$tests = App\Models\Test::all()->pluck('id');
'test_id' => $this->faker->randomElement($tests),
```

   - field

```
'test' => $this->faker->someFakerFunction(),
```

7. resources/@client/interfaces.ts
    - add relevant field to relevant interface with type

```
    x_id: number;
```

8. Add any required inputs or displays for the new data

9. If everything is good, you can then update the schema et al

```
sail php artisan make:schema Test
sail php artisan l5-swagger:generate
sail php artisan ide-helper:generate
sail php artisan ide-helper:models (no)
sail php artisan ide-helper:meta
sail php artisan optimize
sail composer dumpautoload
```

## Running the tests

Testing is done via unit testing, tests are stored in the tests folder.

```
phpunit tests
```

## Updating IDE Helpers

After any major update, you'll probably want to update the IDE helpers thusly

```
php artisan ide-helper:generate
php artisan ide-helper:models (no)
php artisan ide-helper:meta
```

## Deployment

The process for contributing to live code is as follows:

* A branch is made off of development, using the following convention: YY.MM.DD.IssueTitle
* When development is complete, run the unit tests.
* When testing comes up green, build production resources:

```
sail npm run build
```
* Commit the changes and push the branch to our repo.
* When the new branch has been reviewed, it'll be checked and tested.
* When testing is complete, the branch will be added to the Master branch.

## Built With

* [Laravel](https://laravel.com/docs/10.x) - Laravel 10 Framework
* [InfyOm](https://github.com/InfyOmLabs/adminlte-generator/tree/6.0) - InfyOm 6 Generators
* [Laravel Userstamps](https://github.com/WildsideUK/Laravel-Userstamps) - User action tracking
* [Mailchimp](https://github.com/nztim/mailchimp) - MailChimp API wrapper
* [Stripe](https://github.com/stripe/stripe-php) - Stripe API wrapper
* [Deployer](https://deployer.org/) - Code deployment
* [StupidPass](https://github.com/WoodyNaDobhar/laravel-stupid-password) - Password Management
* [Auditing](https://github.com/owen-it/laravel-auditing) - Laravel Auditing
* [Pivot Events](https://github.com/GeneaLabs/laravel-pivot-events) - Laravel Pivot Events
* [User Permissions](https://spatie.be/docs/laravel-permission/v3/introduction) - Laravel Permission
* [OpenAPI Annotations](https://github.com/DarkaOnLine/L5-Swagger) - L5 Swagger (DarkaOnline)

## Contributing

Please read [CONTRIBUTING.md](https://github.com/WoodyNaDobhar/orga/blob/main/CONTRIBUTING.md) for details on our code of conduct, and the process for submitting pull requests to us.

## Versioning

Versioning is for chumps.  But this is v4.  When it's v5, I'll let you know.  Until then, don't worry about it, main is main.

## Authors

* **Woody NaDobhar** - *v4* - [Azurite Design](https://azuriteweb.com/)

See also the list of [contributors](https://github.com/WoodyNaDobhar/orga/contributors) who participated in this project.

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details

## Acknowledgments

ChatGPT - You were often wrong, but you were right in just the right ways to save me gobbs of time.
