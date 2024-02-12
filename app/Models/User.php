<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\ProtectFieldsTrait;
// use App\Traits\CanGetTableNameStatically;
// use App\Traits\ImageTrait;
// use App\Traits\NullableTrait;
// use GeneaLabs\LaravelPivotEvents\Traits\PivotEventTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\App;
// use Lab404\Impersonate\Models\Impersonate;
use Laravel\Sanctum\HasApiTokens;
// use OwenIt\Auditing\Contracts\Auditable;
// use OwenIt\Auditing\Models\Audit;
use Spatie\Permission\Traits\HasRoles;
use Wildside\Userstamps\Userstamps;

/**
 * @OA\Schema(
 *      schema="User",
 *      required={"email","password","is_restricted"},
 *		description="People signed up to the site.<br>The following relationships can be attached, and in the case of 'many' types, searched:
 * persona (Persona) (BelongsTo): Persona associated with the User.
 * createdBy (User) (BelongsTo): User that created it.
 * updatedBy (User) (BelongsTo): User that last updated it (if any).
 * deletedBy (User) (BelongsTo): User that deleted it (if any).",
 *		@OA\Property(
 *			property="id",
 *			description="The entry's ID.",
 *			type="integer",
 *			format="int32",
 *			example=42,
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="persona_id",
 *			description="ID of the User's Persona.",
 *          readOnly=false,
 *          nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *      @OA\Property(
 *          property="email",
 *          description="Unique email used to identify and communicate with the User.",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *			format="email",
 *			example="nobody@nowhere.net",
 *			maxLength=191
 *      ),
 *      @OA\Property(
 *          property="email_verified_at",
 *          description="When the User email was verified, if at all",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *			format="date-time",
 *			example="2023-12-30 23:59:59",
 *			readOnly=true
 *      ),
 *      @OA\Property(
 *          property="password",
 *          description="Encoded password string.",
 *          nullable=false,
 *          type="string",
 *			format="8-40 characters, at least 1 uppercase, at least 1 lowercase, both letters and numbers, not common",
 *			example="$2y$10$SoNOPPci0zg2xqBzhvVQN.DvkHLqJEhLAxyqTz85UNzJBdLI9asdf",
 *			writeOnly=true
 *      ),
 *      @OA\Property(
 *          property="api_token",
 *          description="The API token for authentication",
 *          type="string",
 *          maxLength=80,
 *          example="eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9...",
 *          readOnly=true
 *      ),
 *      @OA\Property(
 *          property="is_restricted",
 *          description="Is the User (default false) restricted from using the site?",
 *          readOnly=false,
 *          nullable=false,
 *			type="integer",
 *			format="enum",
 *			enum={0, 1},
 *			example=0
 *      ),
 *		@OA\Property(
 *			property="created_by",
 *			description="The User that created this record.",
 *			type="integer",
 *			format="int32",
 *			example=42,
 *			readOnly=true,
 *			default=1
 *		),
 *		@OA\Property(
 *			property="createdBy",
 *			type="object",
 *			allOf={
 *				@OA\Property(
 *					title="User",
 *					description="Attachable User that created this record."
 *				),
 *				@OA\Schema(ref="#/components/schemas/User"),
 *			},
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="updated_by",
 *			description="The last User to update this record.",
 *			type="integer",
 *			format="int32",
 *			example=42,
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="updatedBy",
 *			type="object",
 *			allOf={
 *				@OA\Property(
 *					title="User",
 *					description="Attachable last User to update this record."
 *				),
 *				@OA\Schema(ref="#/components/schemas/User"),
 *			},
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="deleted_by",
 *			description="The User that softdeleted this record.",
 *			type="integer",
 *			format="int32",
 *			example=42,
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="deletedBy",
 *			type="object",
 *			allOf={
 *				@OA\Property(
 *					title="User",
 *					description="Attachable User that softdeleted this record."
 *				),
 *				@OA\Schema(ref="#/components/schemas/User"),
 *			},
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="created_at",
 *			description="When the entry was created.",
 *			type="string",
 *			format="date-time",
 *			example="2020-12-30 23:59:59",
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="updated_at",
 *			description="When the entry was last updated.",
 *			type="string",
 *			format="date-time",
 *			example="2020-12-30 23:59:59",
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="deleted_at",
 *			description="When the entry was softdeleted.  Null if not softdeleted.",
 *			type="string",
 *			format="date-time",
 *			example="2020-12-30 23:59:59",
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="persona",
 *			type="object",
 *			allOf={
 *				@OA\Property(
 *					title="Persona",
 *					description="Attachable Persona for this User."
 *				),
 *				@OA\Schema(ref="#/components/schemas/Persona"),
 *			},
 *			readOnly=true
 *		)
 * )
 */

/**
 *	@OA\Schema(
 *		schema="UserSimple",
 *		@OA\Property(
 *			property="persona_id",
 *			description="ID of the User's Persona.",
 *          readOnly=false,
 *          nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *      @OA\Property(
 *          property="email",
 *          description="Unique email used to identify and communicate with the User.",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *			format="email",
 *			example="nobody@nowhere.net",
 *			maxLength=191
 *      ),
 *      @OA\Property(
 *          property="email_verified_at",
 *          description="When the User email was verified, if at all",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *			format="date-time",
 *			example="2023-12-30 23:59:59",
 *			readOnly=true
 *      ),
 *      @OA\Property(
 *          property="password",
 *          description="Encoded password string.",
 *          nullable=false,
 *          type="string",
 *			format="8-40 characters, at least 1 uppercase, at least 1 lowercase, both letters and numbers, not common",
 *			example="$2y$10$SoNOPPci0zg2xqBzhvVQN.DvkHLqJEhLAxyqTz85UNzJBdLI9asdf",
 *			writeOnly=true
 *      ),
 *      @OA\Property(
 *          property="is_restricted",
 *          description="Is the User (default false) restricted from using the site?",
 *          readOnly=false,
 *          nullable=false,
 *			type="integer",
 *			format="enum",
 *			enum={0, 1},
 *			example=0
 *      ),
 *		@OA\Property(
 *			property="created_by",
 *			description="The User that created this record.",
 *			type="integer",
 *			format="int32",
 *			example=42,
 *			readOnly=true,
 *			default=1
 *		),
 *		@OA\Property(
 *			property="updated_by",
 *			description="The last User to update this record.",
 *			type="integer",
 *			format="int32",
 *			example=42,
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="deleted_by",
 *			description="The User that softdeleted this record.",
 *			type="integer",
 *			format="int32",
 *			example=42,
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="created_at",
 *			description="When the entry was created.",
 *			type="string",
 *			format="date-time",
 *			example="2020-12-30 23:59:59",
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="updated_at",
 *			description="When the entry was last updated.",
 *			type="string",
 *			format="date-time",
 *			example="2020-12-30 23:59:59",
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="deleted_at",
 *			description="When the entry was softdeleted.  Null if not softdeleted.",
 *			type="string",
 *			format="date-time",
 *			example="2020-12-30 23:59:59",
 *			readOnly=true
 *		)
 */

/**
 *	@OA\Schema(
 *		schema="UserSuperSimple",
 *		@OA\Property(
 *			property="persona_id",
 *			description="ID of the User's Persona.",
 *          readOnly=false,
 *          nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *      @OA\Property(
 *          property="email",
 *          description="Unique email used to identify and communicate with the User.",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *			format="email",
 *			example="nobody@nowhere.net",
 *			maxLength=191
 *      ),
 *      @OA\Property(
 *          property="email_verified_at",
 *          description="When the User email was verified, if at all",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *			format="date-time",
 *			example="2023-12-30 23:59:59",
 *			readOnly=true
 *      ),
 *      @OA\Property(
 *          property="password",
 *          description="Encoded password string.",
 *          nullable=false,
 *          type="string",
 *			format="8-40 characters, at least 1 uppercase, at least 1 lowercase, both letters and numbers, not common",
 *			example="$2y$10$SoNOPPci0zg2xqBzhvVQN.DvkHLqJEhLAxyqTz85UNzJBdLI9asdf",
 *			writeOnly=true
 *      ),
 *      @OA\Property(
 *          property="is_restricted",
 *          description="Is the User (default false) restricted from using the site?",
 *          readOnly=false,
 *          nullable=false,
 *			type="integer",
 *			format="enum",
 *			enum={0, 1},
 *			example=0
 *      )
 */

/**
 *
 *	@OA\RequestBody(
 *		request="User",
 *		description="User object that needs to be added or updated.",
 *		required=true,
 *		@OA\MediaType(
 *			mediaType="multipart/form-data",
 *			@OA\Schema(ref="#/components/schemas/UserSimple")
 *		)
 *	)
 */
class User extends Authenticatable implements MustVerifyEmail
{
	use HasFactory;
	use SoftDeletes;
	use Notifiable;
	// use ImageTrait {
	// 	deleteImage as traitDeleteImage;
	// }
	use Userstamps;
	use ProtectFieldsTrait;
	// use NullableTrait;
	// use \OwenIt\Auditing\Auditable;
	// use PivotEventTrait;
	// use Impersonate;
	// use CanGetTableNameStatically;
	use HasRoles;
	use HasApiTokens;
	
	//TODO: Audit stuff

	public $table = 'users';
	public $timestamps = true;
	
	protected $dates = ['created_at', 'updated_at', 'deleted_at'];
	protected $protectedFields = ['persona_id'];
	protected $guard_name = 'api';
	protected $hidden = ['password','api_token','remember_token'];
	
    public $fillable = [
        'email',
        'email_verified_at',
        'password',
        'is_restricted'
    ];

    protected $casts = [
    	'persona_id' => 'required|exists:personas,id',
    	'email' => 'required|email|unique:users,email',
    	'email_verified_at' => 'nullable|datetime',
    	'password' => 'required|string',
    	'remember_token' => 'unique:users,remember_token|nullable|string|max:100',
    	'api_token' => 'unique:users,api_token|nullable|string|max:80',
    	'is_restricted' => 'boolean'
    ];
    public static $createRules = [
		'email' => 'required|email|unique:users,email|regex:/^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/|max:191',
		'password' => 'min:6|required_with:password_confirmation|same:password_confirmation|max:191',
		'is_restricted' => 'required|boolean'
    ];

    public static array $rules = [
        'email' => 'required|email|unique:users,email|regex:/^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/|max:191',
        'email_verified_at' => 'nullable',
    	'password' => 'nullable|min:6|required_with:password_confirmation|same:password_confirmation|max:191',
		'remember_token' => 'nullable|string|max:100',
		'api_token' => 'nullable|string|max:80',
        'is_restricted' => 'required|boolean'
    ];
    
    public static $messages = [
		'email.regex'	  => 'Please enter a valid email.',
    ];
    
    public static $setPasswordRules = [
		'user_id'			   => 'required',
		'password'			  => 'min:6|required_with:password_confirmation|same:password_confirmation',
		'password_confirmation' => 'min:6',
    ];
    
    /**
     * Whether a user can impersonate others
     */
    public function canImpersonate()
    {
    	// For example
    	return $this->hasRole('admin') ? TRUE : FALSE;
    }
    
    /**
     * Whether a user can be impersonated
     */
    public function canBeImpersonated()
    {
    	// For example
    	return $this->hasRole('admin') ? FALSE : TRUE;
    }
    
    /**
     * The relationships map for the model.
     *
     * @var array
     */
	public $relationships = [
		'persona' => 'BelongsTo',
		'createdBy' => 'BelongsTo',
		'updatedBy' => 'BelongsTo',
		'deletedBy' => 'BelongsTo',
	];
    
    public function persona(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
    	return $this->belongsTo(\App\Models\Persona::class, 'persona_id');
    }
    
    //CUDs
    
    public function createdBy(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
    	return $this->belongsTo(\App\Models\User::class, 'created_by');
    }
    
    public function deletedBy(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
    	return $this->belongsTo(\App\Models\User::class, 'deleted_by');
    }
    
    public function updatedBy(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
    	return $this->belongsTo(\App\Models\User::class, 'updated_by');
    }
	
	public function accountsCreated(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Account::class, 'created_by');
	}
	
	public function accountsDeleted(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Account::class, 'deleted_by');
	}
	
	public function accountsUpdated(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Account::class, 'updated_by');
	}
	
	public function archetypesCreated(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Archetype::class, 'created_by');
	}
	
	public function archetypesDeleted(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Archetype::class, 'deleted_by');
	}
	
	public function archetypesUpdated(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Archetype::class, 'updated_by');
	}
	
	public function attendancesCreated(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Attendance::class, 'created_by');
	}
	
	public function attendancesDeleted(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Attendance::class, 'deleted_by');
	}
	
	public function attendancesUpdated(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Attendance::class, 'updated_by');
	}
	
	public function awardsCreated(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Award::class, 'created_by');
	}
	
	public function awardsDeleted(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Award::class, 'deleted_by');
	}
	
	public function awardsUpdated(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Award::class, 'updated_by');
	}
	
	public function chaptersCreated(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Chapter::class, 'created_by');
	}
	
	public function chaptersDeleted(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Chapter::class, 'deleted_by');
	}
	
	public function chaptersUpdated(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Chapter::class, 'updated_by');
	}
	
	public function chaptertypesCreated(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Chaptertype::class, 'created_by');
	}
	
	public function chaptertypesDeleted(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Chaptertype::class, 'deleted_by');
	}
	
	public function chaptertypesUpdated(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Chaptertype::class, 'updated_by');
	}
	
	public function cratsCreated(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Crat::class, 'created_by');
	}
	
	public function cratsDeleted(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Crat::class, 'deleted_by');
	}
	
	public function cratsUpdated(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Crat::class, 'updated_by');
	}
	
	public function duesCreated(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Due::class, 'created_by');
	}
	
	public function duesDeleted(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Due::class, 'deleted_by');
	}
	
	public function duesUpdated(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Due::class, 'updated_by');
	}
	
	public function eventsCreated(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Event::class, 'created_by');
	}
	
	public function eventsDeleted(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Event::class, 'deleted_by');
	}
	
	public function eventsUpdated(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Event::class, 'updated_by');
	}
	
	public function guestsCreated(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Guest::class, 'created_by');
	}
	
	public function guestsDeleted(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Guest::class, 'deleted_by');
	}
	
	public function guestsUpdated(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Guest::class, 'updated_by');
	}
	
	public function issuancesCreated(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Issuance::class, 'created_by');
	}
	
	public function issuancesDeleted(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Issuance::class, 'deleted_by');
	}
	
	public function issuancesUpdated(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Issuance::class, 'updated_by');
	}
	
	public function locationsCreated(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Location::class, 'created_by');
	}
	
	public function locationsDeleted(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Location::class, 'deleted_by');
	}
	
	public function locationsUpdated(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Location::class, 'updated_by');
	}
	
	public function meetupsCreated(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Meetup::class, 'created_by');
	}
	
	public function meetupsDeleted(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Meetup::class, 'deleted_by');
	}
	
	public function meetupsUpdated(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Meetup::class, 'updated_by');
	}
	
	public function membersCreated(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Member::class, 'created_by');
	}
	
	public function membersDeleted(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Member::class, 'deleted_by');
	}
	
	public function membersUpdated(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Member::class, 'updated_by');
	}
	
	public function officersCreated(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Officer::class, 'created_by');
	}
	
	public function officersDeleted(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Officer::class, 'deleted_by');
	}
	
	public function officersUpdated(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Officer::class, 'updated_by');
	}
	
	public function officesCreated(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Office::class, 'created_by');
	}
	
	public function officesDeleted(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Office::class, 'deleted_by');
	}
	
	public function officesUpdated(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Office::class, 'updated_by');
	}
	
	public function personasCreated(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Persona::class, 'created_by');
	}
	
	public function personasDeleted(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Persona::class, 'deleted_by');
	}
	
	public function personasUpdated(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Persona::class, 'updated_by');
	}
	
	public function pronounsCreated(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Pronoun::class, 'created_by');
	}
	
	public function pronounsDeleted(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Pronoun::class, 'deleted_by');
	}
	
	public function pronounsUpdated(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Pronoun::class, 'updated_by');
	}
    
    public function realmsCreated(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
    	return $this->hasMany(\App\Models\Realm::class, 'created_by');
    }
    
    public function realmsDeleted(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
    	return $this->hasMany(\App\Models\Realm::class, 'deleted_by');
    }

    public function realmsUpdated(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Realm::class, 'updated_by');
    }
	
	public function recommendationsCreated(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Recommendation::class, 'created_by');
	}
	
	public function recommendationsDeleted(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Recommendation::class, 'deleted_by');
	}
	
	public function recommendationsUpdated(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Recommendation::class, 'updated_by');
	}
	
	public function reconciliationsCreated(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Reconciliation::class, 'created_by');
	}
	
	public function reconciliationsDeleted(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Reconciliation::class, 'deleted_by');
	}
	
	public function reconciliationsUpdated(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Reconciliation::class, 'updated_by');
	}
	
	public function reignsCreated(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Reign::class, 'created_by');
	}

    public function reignsDeleted(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Reign::class, 'deleted_by');
    }

    public function reignsUpdated(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Reign::class, 'updated_by');
    }
    
    public function socialsCreated(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
    	return $this->hasMany(\App\Models\Social::class, 'created_by');
    }

    public function socialsDeleted(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Social::class, 'deleted_by');
    }

    public function socialsUpdated(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Social::class, 'updated_by');
    }
	
	public function splitsCreated(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Split::class, 'created_by');
	}
	
	public function splitsDeleted(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Split::class, 'deleted_by');
	}
	
	public function splitsUpdated(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Split::class, 'updated_by');
	}
	
	public function suspensionsCreated(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Suspension::class, 'created_by');
	}
	
	public function suspensionsDeleted(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Suspension::class, 'deleted_by');
	}
	
	public function suspensionsUpdated(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Suspension::class, 'updated_by');
	}
	
	public function titlesCreated(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Title::class, 'created_by');
	}
	
	public function titlesDeleted(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Title::class, 'deleted_by');
	}
	
	public function titlesUpdated(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Title::class, 'updated_by');
	}
	
	public function tournamentsCreated(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Tournament::class, 'created_by');
	}
	
	public function tournamentsDeleted(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Tournament::class, 'deleted_by');
	}
	
	public function tournamentsUpdated(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Tournament::class, 'updated_by');
	}
	
	public function transactionsCreated(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Transaction::class, 'created_by');
	}
	
	public function transactionsDeleted(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Transaction::class, 'deleted_by');
	}
	
	public function transactionsUpdated(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Transaction::class, 'updated_by');
	}
	
	public function unitsCreated(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Unit::class, 'created_by');
	}
	
	public function unitsDeleted(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Unit::class, 'deleted_by');
	}
	
	public function unitsUpdated(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Unit::class, 'updated_by');
	}
	
	public function usersCreated(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\User::class, 'created_by');
	}
	
	public function usersDeleted(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\User::class, 'deleted_by');
	}
	
	public function usersUpdated(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\User::class, 'updated_by');
	}
	
	public function waiversCreated(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Waiver::class, 'created_by');
	}
	
	public function waiversDeleted(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Waiver::class, 'deleted_by');
	}
	
	public function waiversUpdated(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Waiver::class, 'updated_by');
	}
}
