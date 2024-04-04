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
```

### Installing

Fork and clone the repo into your local development environment.

```
git clone git@github.com:YourForkAccount/orga.git
```

Update .env file
Generate key

```
php artisan key:generate
```

Run composer

```
composer install
```

Run migrations in the root 

```
php artisan migrate
```

Poplulate DB.  If you don't know 'with what', then you can't be doing this.

```
...
```

## Adding Objects

The site uses Infyom generators to create objects.  To do create the object Test, first make the table w/ its various rows in your local db.  Then, use the following command in the root folder:

```
php artisan infyom:api_scaffold Test --fromTable --tableName=tests  --datatables=true --skip=dump-autoload --factory
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
    php artisan l5-swagger:generate
    php artisan ide-helper:generate
    php artisan ide-helper:models (no)
    php artisan ide-helper:meta
    php artisan optimize
    composer dumpautoload
    ```

## Adding To Objects

You'll want to start by creating the migration.  The following describes the naming convention you should use, where 'test' is your table, and 'i' is the update iteration (starting with 1)

```
php artisan make:migration update_tests_table_i
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

Run the migration, then roll it back, and run it again.

Then make the following updates to engage the basic controls.  It'll be different for a basic field than a relationship field.

1. TestDataTable
   - dataTable
     - field
     - relationship (not BtM): addColumn
     ```
		$dataTable->addColumn('x', function (Test $test) {
			return $test->x ? ( strlen($test->x->label) > 60 ? (substr($test->x->label, 0, 60) . "...") : $test->x->label ) : ' ';
		});
     ```
   - query
     - field
     - relationship (not BtM): with
     ```
     ->with('x')
     ```
   - getColumns
     - field: add to return
     ```
            'label',
     ```
     - relationship (not BtM): add to return
     ```
            ['data' => 'x', 'name' => 'x.label', 'title' => 'X', 'orderable' => true, 'searchable' => true],
     ```
2. TestController
   - uses
     - field
     - relationship: model & view
     ```
     use App\Models\Test;
     use Illuminate\Support\Facades\View;
     ```
   - construct
     - field
     - relationship
     ```
		$this->xs = X::orderBy('label')->pluck('label', 'id')->toArray();
		View::share('xs', $this->xs);
     ```
3. XController (BtM)
   - uses
     - relationship: model & view
     ```
     use App\Models\Test;
     use Illuminate\Support\Facades\View;
     ```
   - construct
     - relationship
     ```
		$this->xs = X::orderBy('label')->pluck('label', 'id')->toArray();
		View::share('xs', $this->xs);
     ```
4. Test
   - @OA\Schema
     - description
     ```
 * field (Model) (Relationship): Description.
     ```
     - field
     ```
	 *		@OA\Property(
	 *			property="x",
	 *			description="x",
	 *			type="y"
	 *		),
     ```
     - relationship (not BtM)
     ```
	 *		@OA\Property(
	 *			property="x_id",
	 *			description="x_id",
	 *			type="integer",
	 *			format="int32"
	 *		),
     ```
     - add relationship object (if any)
   - fillable
     - field
        ```
        'x', 
        ```
     - relationship (not BtM)
        ```
        'x_id', 
        ```
   - casts
     - field
        ```
        'x' => 'y',
        ```
     - relationship (not BtM)
        ```
        'x_id' => 'integer',
        ```
   - relationships array
     - field
     - relationship
        ```
		'x' => 'RelationshipType',
        ```
   - relationships
     - field
     - relationship:
     ```
      /**
      * @return \Illuminate\Database\Eloquent\Relations\RelationshipType
      **/
      public function x()
      {
         return $this->relationshipType(\App\Models\X::class, 'x_id');
      }
     ```
5. X
   - relationships array
   ```
    'test' => 'RelationshipType',
   ```
   - relationships
   ```
    /**
     * @return \Illuminate\Database\Eloquent\Relations\RelationshipType
     **/
    public function test()
    {
        return $this->relationshipType(\App\Models\Test::class);
    }
   ```
6. TestRepository
   - fieldSearchable
     - field
     ```
        'x',
     ```
     - relationship (not BtM)
     ```
        'x_id',
     ```
7. TestFactory
   - define
     - setup
       - field
       - relationship (not BtM)
       ```
       $xs = App\Models\X::all()->pluck('id');
       ```
     - return
       - field
       ```
        'x' => $faker->fakerFunction,
       ```
       - relationship (not BtM)
       ```
        'x_id' => $faker->randomElement($xs),
       ```
8. tests/edit.blade
   - add table
     - relationship (BtM)
     ```
        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                <h4>Xs</h4>
                <div>
                    <div>
                        <a class="btn btn-default buttons-create btn-sm no-corner" tabindex="0" aria-controls="dataTableBuilder" href="/admin/resources/create">
                            <span><i class="fa fa-plus"></i>Create</span>
                        </a>
                    </div>
                    <table class="table table-striped table-bordered" width="100%" style="width: 100%;">
                        <thead>
                            <tr role="row">
                                <th title="Field">Field</th>
                                <th title="Action">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @if($test->xs)
                        @foreach($test->xs as $key => $x)
                            <tr role="row" class="{{$key%2 == 0 ? 'even' : 'odd'}}">
                                <td>{{$x->field}}</td>
                                <td>
                                    <form method="POST" action="/admin/xs/{{$x->id}}" accept-charset="UTF-8">
                                        <input name="_method" type="hidden" value="DELETE">
                                        {{Form::token()}}
                                        <div class="btn-group">
                                            <a href="/admin/xs/{{$x->id}}" class="btn btn-default btn-xs">
                                                <i class="glyphicon glyphicon-eye-open"></i>
                                            </a>
                                            <a href="/admin/xs/{{$x->id}}/edit" class="btn btn-default btn-xs">
                                                <i class="glyphicon glyphicon-edit"></i>
                                            </a>
                                            @if($x->id != $test->x_id)
                                            <button type="submit" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure?')"><i class="glyphicon glyphicon-trash"></i></button>
                                            @endif
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
     ```
9. tests/fields.blade
   - add field
     - field
     ```
      <!-- X Field -->
      <div class="form-group col-sm-5">
         {!! Form::label('x', 'X:', array('data-toggle' => "tooltip", 'title' => "X description"))) !!}
         {!! Form::text('x', null, ['class' => 'form-control']) !!}
      </div>
     ```
     - relationship
     ```
      <!-- X Id Field -->
      <div class="form-group col-sm-6">
         {!! Form::label('x_id', 'Landing Page:') !!}
         @if(isset($test) && $test->x_id)
         {!! Form::select('x_id', ['' => 'None'] + $xs, $test->x_id, ['class' => 'form-control']) !!}
         @else
         {!! Form::select('x_id', ['' => 'None'] + $xs, null, ['class' => 'form-control']) !!}
         @endif
      </div>
     ```
10. xs/fields.blade (BtM)
   - add field
     - relationship
     ```
      <!-- Collections Field -->
      <div class="form-group col-sm-6">
         <input type="hidden" name="collections[]" value="" />
         {!! Form::label('collections', 'Collections:') !!}
         @if(isset($resource) && $resource->collections)
         {!! Form::select('collections[][id]', $collections, $resource->collections()->pluck('collections.id')->toArray(), ['title' => 'None', 'multiple' => 'multiple', 'class' => 'selectpicker form-control']) !!}
         @else
         {!! Form::select('collections[][id]', $collections, 0, ['title' => 'None', 'multiple' => 'multiple', 'class' => 'selectpicker form-control']) !!}
         @endif
      </div>
     ```
11. tests/show_fields.blade
   - add field
     - field
     ```
      <!-- X Field -->
      <div class="form-group">
         {!! Form::label('x', 'X:') !!}
         <p>{{ $test->x }}</p>
      </div>
     ```
     - relationship (not BtM)
     ```
      <!-- X Field -->
      <div class="form-group">
         {!! Form::label('x_id', 'X:') !!}
         <p>{{ $test->x->label }}</p>
      </div>
     ```
     - relationship (BtM)
     ```
        @if($test->xs && count($test->xs) > 0)
        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                <h4>Xs</h4>
                <div>
                    <table class="table table-striped table-bordered" width="100%" style="width: 100%;">
                        <thead>
                            <tr role="row">
                                <th title="Field">Field</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($test->xs as $key => $x)
                            <tr role="row" class="{{$key%2 == 0 ? 'even' : 'odd'}}">
                                <td>{{$x->field}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
     ```

If everything is good, you can then update the schema

```
php artisan make:schema Test
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
* When testing comes up green, commit the changes and push the branch to our repo.
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
