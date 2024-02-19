<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\ProtectFieldsTrait;
use Wildside\Userstamps\Userstamps;
/**
 * @OA\Schema(
 *		schema="Chapter",
 *		required={"realm_id","chaptertype_id","location_id","name","abbreviation","is_active"},
 *		description="Amtgard Chapters<br>The following relationships can be attached, and in the case of plural relations, searched:
 * accounts (Account) (MorphMany): Accounts this Chapter owns.
 * awards (Award) (MorphMany): Awards this Chapter can Issue.
 * chaptertype (Chaptertype) (BelongsTo): The level of the Chapter (Shire, etc).
 * events (Event) (MorphMany): Events this Chapter has run.
 * issuances (Issuance) (MorphMany): Awards and Titles Issued by this Chapter.
 * location (Location) (BelongsTo): The official location for the Chapter.
 * nearbyGuests (Guest) (HasMany): Guests at Demos that live near this Chapter.
 * meetups (Meetup) (HasMany): Meetups hosted by this Chapter.
 * personas (Persona) (HasMany): Personas that claim this as their home.
 * realm (Realm) (BelongsTo): Realm the Chapter is associated with.
 * reign (Reign) (MorphOne): The current Reign for the Chapter.
 * reigns (Reign) (MorphMany): Reigns for the Chapter.
 * socials (Social) (MorphMany): Socials for the Chapter.
 * sponsors (Event) (MorphMany): Persona or Unit Events this Chapter has sponsored.
 * suspensions (Suspension) (MorphMany): Suspensions levied by the Chapter.
 * titles (Title) (MorphMany): Titles the Chapter Issues.
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
 *			property="realm_id",
 *			description="The ID of the Realm sponsoring the Chapter.",
 *			readOnly=false,
 *			nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="chaptertype_id",
 *			description="The ID of the Chaptertype earned by the Chapter.",
 *			readOnly=false,
 *			nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="location_id",
 *			description="The ID of the Location that best describes where the Chapter is.",
 *			readOnly=false,
 *			nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="name",
 *			description="The Chapter name, unique to the Realm.",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="uppercase first letter",
 *			example="Adjective Geography",
 *			maxLength=100
 *		),
 *		@OA\Property(
 *			property="abbreviation",
 *			description="A short abbreviation of the Chapter name, unique to the Realm.",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="uppercase",
 *			maxLength=3,
 *		),
 *		@OA\Property(
 *			property="heraldry",
 *			description="An internal link to an image of the Chapter heraldry, if any.",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="filename",
 *			example="images/chapters/42.jpg",
 *			maxLength=191
 *		),
 *		@OA\Property(
 *			property="is_active",
 *			description="Is the Chapter (default true) still active?",
 *			readOnly=false,
 *			nullable=false,
 *			type="integer",
 *			format="enum",
 *			enum={0, 1},
 *			example=0,
 *			default=1
 *		),
 *		@OA\Property(
 *			property="created_by",
 *			description="The User that created this record.",
 *			type="integer",
 *			format="int32",
 *			example=42,
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="createdBy",
 *			type="object",
 *			allOf={
 *				@OA\Property(
 *					title="User",
 *					description="Attachable User that created this record."
 *				),
 *				@OA\Schema(ref="#/components/schemas/UserSimple"),
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
 *				@OA\Schema(ref="#/components/schemas/UserSimple"),
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
 *				@OA\Schema(ref="#/components/schemas/UserSimple"),
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
 *			property="accounts",
 *			description="Attachable & filterable array of Accounts this Chapter owns.",
 *			type="array",
 *			@OA\Items(
 *				title="Account",
 *				type="object",
 *				ref="#/components/schemas/AccountSimple"
 *			),
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="awards",
 *			description="Attachable & filterable array of Awards this Chapter can Issue.",
 *			type="array",
 *			@OA\Items(
 *				title="Award",
 *				type="object",
 *				ref="#/components/schemas/AwardSimple"
 *			),
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="chaptertype",
 *			type="object",
 *			allOf={
 *				@OA\Property(
 *					title="Chaptertype",
 *					description="Attachable Chaptertype for this Chapter."
 *				),
 *				@OA\Schema(ref="#/components/schemas/ChaptertypeSimple"),
 *			},
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="events",
 *			description="Attachable & filterable array of Events this Chapter has run.",
 *			type="array",
 *			@OA\Items(
 *				title="Event",
 *				type="object",
 *				ref="#/components/schemas/EventSimple"
 *			),
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="issuances",
 *			description="Attachable & filterable array of Issuances this Chapter has made.",
 *			type="array",
 *			@OA\Items(
 *				title="Issuance",
 *				type="object",
 *				ref="#/components/schemas/IssuanceSimple"
 *			),
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="location",
 *			type="object",
 *			allOf={
 *				@OA\Property(
 *					title="Location",
 *					description="Attachable Location for this Chapter."
 *				),
 *				@OA\Schema(ref="#/components/schemas/LocationSimple"),
 *			},
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="meetups",
 *			description="Attachable & filterable array of Meetups for this Chapter.",
 *			type="array",
 *			@OA\Items(
 *				title="Meetup",
 *				type="object",
 *				ref="#/components/schemas/MeetupSimple"
 *			),
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="nearbyGuests",
 *			description="Attachable & filterable array of Demo Guests that live near the Chapter.",
 *			type="array",
 *			@OA\Items(
 *				title="Guest",
 *				type="object",
 *				ref="#/components/schemas/GuestSimple"
 *			),
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="personas",
 *			description="Attachable & filterable array of Personas for this Chapter.",
 *			type="array",
 *			@OA\Items(
 *				title="Persona",
 *				type="object",
 *				ref="#/components/schemas/PersonaSimple"
 *			),
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="realm",
 *			type="object",
 *			allOf={
 *				@OA\Property(
 *					title="Realm",
 *					description="Attachable Realm the Chapter is a member of."
 *				),
 *				@OA\Schema(ref="#/components/schemas/RealmSimple"),
 *			},
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="reign",
 *			description="Attachable & filterable array of the current Reign for the Chapter.",
 *			type="array",
 *			@OA\Items(
 *				title="Reign",
 *				type="object",
 *				ref="#/components/schemas/ReignSimple"
 *			),
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="reigns",
 *			description="Attachable & filterable array of the Reigns of the Chapter.",
 *			type="array",
 *			@OA\Items(
 *				title="Reign",
 *				type="object",
 *				ref="#/components/schemas/ReignSimple"
 *			),
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="socials",
 *			description="Attachable & filterable array of the Socials of the Chapter.",
 *			type="array",
 *			@OA\Items(
 *				title="Social",
 *				type="object",
 *				ref="#/components/schemas/SocialSimple"
 *			),
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="sponsors",
 *			description="Attachable & filterable array of Persona or Unit Events this Chapter has sponsored.",
 *			type="array",
 *			@OA\Items(
 *				title="Event",
 *				type="object",
 *				ref="#/components/schemas/EventSimple"
 *			),
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="suspensions",
 *			description="Attachable & filterable array of Suspensions levied by the Chapter.",
 *			type="array",
 *			@OA\Items(
 *				title="Suspension",
 *				type="object",
 *				ref="#/components/schemas/SuspensionSimple"
 *			),
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="titles",
 *			description="Attachable & filterable array of the Titles the Chapter Issues.",
 *			type="array",
 *			@OA\Items(
 *				title="Title",
 *				type="object",
 *				ref="#/components/schemas/TitleSimple"
 *			),
 *			readOnly=true
 *		)
 * )
 *	@OA\Schema(
 *		schema="ChapterSimple",
 *		@OA\Property(
 *			property="id",
 *			description="The entry's ID.",
 *			type="integer",
 *			format="int32",
 *			example=42,
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="realm_id",
 *			description="The ID of the Realm sponsoring the Chapter.",
 *			readOnly=false,
 *			nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="chaptertype_id",
 *			description="The ID of the Chaptertype earned by the Chapter.",
 *			readOnly=false,
 *			nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="location_id",
 *			description="The ID of the Location that best describes where the Chapter is.",
 *			readOnly=false,
 *			nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="name",
 *			description="The Chapter name, unique to the Realm.",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="uppercase first letter",
 *			example="Adjective Geography",
 *			maxLength=100
 *		),
 *		@OA\Property(
 *			property="abbreviation",
 *			description="A short abbreviation of the Chapter name, unique to the Realm.",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="uppercase",
 *			maxLength=3,
 *		),
 *		@OA\Property(
 *			property="heraldry",
 *			description="An internal link to an image of the Chapter heraldry, if any.",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="filename",
 *			example="/images/heraldry/chapters/42.jpg",
 *			maxLength=191
 *		),
 *		@OA\Property(
 *			property="is_active",
 *			description="Is the Chapter (default true) still active?",
 *			readOnly=false,
 *			nullable=false,
 *			type="integer",
 *			format="enum",
 *			enum={0, 1},
 *			example=0,
 *			default=1
 *		),
 *		@OA\Property(
 *			property="created_by",
 *			description="The User that created this record.",
 *			type="integer",
 *			format="int32",
 *			example=42,
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
 *	)
 *	@OA\Schema(
 *		schema="ChapterSuperSimple",
 *		@OA\Property(
 *			property="id",
 *			description="The entry's ID.",
 *			type="integer",
 *			format="int32",
 *			example=42,
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="realm_id",
 *			description="The ID of the Realm sponsoring the Chapter.",
 *			readOnly=false,
 *			nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="chaptertype_id",
 *			description="The ID of the Chaptertype earned by the Chapter.",
 *			readOnly=false,
 *			nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="location_id",
 *			description="The ID of the Location that best describes where the Chapter is.",
 *			readOnly=false,
 *			nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="name",
 *			description="The Chapter name, unique to the Realm.",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="uppercase first letter",
 *			example="Adjective Geography",
 *			maxLength=100
 *		),
 *		@OA\Property(
 *			property="abbreviation",
 *			description="A short abbreviation of the Chapter name, unique to the Realm.",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="uppercase",
 *			maxLength=3,
 *		),
 *		@OA\Property(
 *			property="heraldry",
 *			description="An internal link to an image of the Chapter heraldry, if any.",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="filename",
 *			example="/images/heraldry/chapters/42.jpg",
 *			maxLength=191
 *		),
 *		@OA\Property(
 *			property="is_active",
 *			description="Is the Chapter (default true) still active?",
 *			readOnly=false,
 *			nullable=false,
 *			type="integer",
 *			format="enum",
 *			enum={0, 1},
 *			example=0,
 *			default=1
 *		)
 *	)
 *	@OA\RequestBody(
 *		request="Chapter",
 *		description="Chapter object that needs to be added or updated.",
 *		required=true,
 *		@OA\MediaType(
 *			mediaType="multipart/form-data",
 *			@OA\Schema(ref="#/components/schemas/ChapterSimple")
 *		)
 *	)
 */

class Chapter extends BaseModel
{
	use SoftDeletes;
	use HasFactory;
	use Userstamps;
	use ProtectFieldsTrait;

	public $table = 'chapters';
	public $timestamps = true;
	
	protected $dates = ['created_at', 'updated_at', 'deleted_at'];
	protected $protectedFields = [];

	public $fillable = [
		  'realm_id',
		  'chaptertype_id',
		  'location_id',
		  'name',
		  'abbreviation',
		  'heraldry',
		  'is_active'
	];

	protected $casts = [
		  'name' => 'string',
		  'abbreviation' => 'string',
		  'heraldry' => 'string',
		  'is_active' => 'boolean'
	];

	public static array $rules = [
		'realm_id' => 'required|exists:realms,id',
		'chaptertype_id' => 'required|exists:chaptertypes,id',
		'location_id' => 'required|exists:locations,id',
   		'name' => 'required|string|max:100',//TODO: unique to Realm
		'abbreviation' => 'required|string|max:3',//TODO: unique to Realm
		'heraldry' => 'nullable|string|max:191',
		'is_active' => 'required|boolean'
	];
	
	public $relationships = [
		'accounts' => 'MorphMany',
		'awards' => 'MorphMany',
		'chaptertype' => 'BelongsTo',
		'events' => 'MorphMany',
		'issuances' => 'MorphMany',
		'location' => 'BelongsTo',
		'meetups' => 'HasMany',
		'nearbyGuests' => 'HasMany',
		'personas' => 'HasMany',
		'realm' => 'BelongsTo',
		'reign' => 'MorphOne',
		'reigns' => 'MorphMany',
		'socials' => 'MorphMany',
		'sponsors' => 'MorphMany',
		'suspensions' => 'MorphMany',
		'titles' => 'MorphMany'
	];
	
	public function accounts(): \Illuminate\Database\Eloquent\Relations\MorphMany
	{
		return $this->morphMany(Account::class, 'accountable');
	}
	
	public function awards(): \Illuminate\Database\Eloquent\Relations\MorphMany
	{
		return $this->morphMany(Award::class, 'awarder');
	}

	public function chaptertype(): \Illuminate\Database\Eloquent\Relations\BelongsTo
	{
		  return $this->belongsTo(\App\Models\Chaptertype::class, 'chaptertype_id');
	}
	
	public function events(): \Illuminate\Database\Eloquent\Relations\MorphMany
	{
		return $this->morphMany(Event::class, 'eventable');
	}
	
	public function issuances(): \Illuminate\Database\Eloquent\Relations\MorphMany
	{
		return $this->morphMany(Issuance::class, 'issuer');
	}
	
	public function location(): \Illuminate\Database\Eloquent\Relations\BelongsTo
	{
		return $this->belongsTo(\App\Models\Location::class, 'location_id');
	}
	
	public function meetups(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Meetup::class, 'chapter_id');
	}
	
	public function nearbyGuests(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Guest::class, 'chapter_id');
	}
	
	public function personas(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Persona::class, 'chapter_id');
	}
	
	public function realm(): \Illuminate\Database\Eloquent\Relations\BelongsTo
	{
		return $this->belongsTo(\App\Models\Realm::class, 'realm_id');
	}
	
	public function reign(): \Illuminate\Database\Eloquent\Relations\MorphOne
	{
		return $this->morphOne(Reign::class, 'reignable')
		->where(function ($query) {
			$today = now()->toDateString();
			$query->where('starts_on', '<=', $today)
			->where('ends_on', '>', $today);
		});
	}
	
	public function reigns(): \Illuminate\Database\Eloquent\Relations\MorphMany
	{
		return $this->morphMany(Reign::class, 'reignable');
	}
	
	public function socials(): \Illuminate\Database\Eloquent\Relations\MorphMany
	{
		return $this->morphMany(Social::class, 'sociable');
	}
	
	public function suspensions(): \Illuminate\Database\Eloquent\Relations\MorphMany
	{
		return $this->morphMany(Social::class, 'suspendable');
	}
	
	public function sponsors(): \Illuminate\Database\Eloquent\Relations\MorphMany
	{
		return $this->morphMany(Event::class, 'sponsorable');
	}
	
	public function titles(): \Illuminate\Database\Eloquent\Relations\MorphMany
	{
		return $this->morphMany(Title::class, 'titleable');
	}

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
}
