<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Scout\Searchable;
use App\Traits\ProtectFieldsTrait;
use Wildside\Userstamps\Userstamps;
/**
 * @OA\Schema(
 *		schema="Location",
 *		required={"created_at"},
 *		description="Location information for Chapters, Events, Meetups, and Waivers.<br>The following relationships can be attached, and in the case of plural relations, searched:
 * chapters (Chapter) (HasMany): Chapters using this Location.
 * events (Event) (HasMany): Events using this Location.
 * issuances (Issuance) (MorphMany): Issuances made at this Location.
 * meetups (Meetup) (HasMany): Meetups using this Location.
 * waivers (Waiver) (HasMany): Waivers using this Location.
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
 *			property="name",
 *			description="The Location name, as it might appear on a map.",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="uppercase first letter",
 *			example="McCullum Park",
 *			maxLength=50
 *		),
 *		@OA\Property(
 *			property="address",
 *			description="The street address of the Location, if any.",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="street",
 *			example="123 Fake St.",
 *			maxLength=191
 *		),
 *		@OA\Property(
 *			property="city",
 *			description="The city of the Location, if any.",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="city",
 *			example="Seattle",
 *			maxLength=50
 *		),
 *		@OA\Property(
 *			property="province",
 *			description="The state or provice of the Location, if any.",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="state",
 *			example="Texas",
 *			maxLength=35
 *		),
 *		@OA\Property(
 *			property="postal_code",
 *			description="The zip or postal code of the Location, if any.",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="zip",
 *			example="98666",
 *			maxLength=10
 *		),
 *		@OA\Property(
 *			property="country",
 *			description="The two letter country code of the Location (default US), if any.",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="country",
 *			example="US",
 *			maxLength=2,
 *	 		default="US"
 *		),
 *		@OA\Property(
 *			property="google_geocode",
 *			description="JSON encoded Google Geocode data of the Location, if any.",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="json",
 *			maxLength=16777215
 *		),
 *		@OA\Property(
 *			property="latitude",
 *			description="Latitude of the Location, if any.",
 *			readOnly=false,
 *			nullable=true,
 *			type="number",
 *			format="double"
 *		),
 *		@OA\Property(
 *			property="longitude",
 *			description="Longitude of the Location, if any.",
 *			readOnly=false,
 *			nullable=true,
 *			type="number",
 *			format="double"
 *		),
 *		@OA\Property(
 *			property="location",
 *			description="JSON encoded Google location services data of the Location, if any",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="json",
 *			maxLength=16777215
 *		),
 *		@OA\Property(
 *			property="map_url",
 *			description="An external map link of the Location, if any",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="url",
 *			maxLength=16777215
 *		),
 *		@OA\Property(
 *			property="directions",
 *			description="Directions required to properly navigate the last part of the journey to, or park at, the Location, if any.",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="paragraph",
 *			example="Take the first right and park next to the abandoned pool.Go down the path until you see the sign for the designated LARP area.",
 *			maxLength=16777215
 *		),
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
 *			ref="#/components/schemas/UserSimple",
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
 *			ref="#/components/schemas/UserSimple",
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
 *			ref="#/components/schemas/UserSimple",
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
 *			description="When the entry was softdeleted.Null if not softdeleted.",
 *			type="string",
 *			format="date-time",
 *			example="2020-12-30 23:59:59",
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="can_list",
 *			description="Can the User (default false) perform list actions with the entry model?",
 *			readOnly=true,
 *			nullable=false,
 *			type="integer",
 *			format="enum",
 *			enum={0, 1},
 *			example=0,
 *			default=0
 *		),
 *		@OA\Property(
 *			property="can_view",
 *			description="Can the User (default false) perform view actions with the entry model?",
 *			readOnly=true,
 *			nullable=false,
 *			type="integer",
 *			format="enum",
 *			enum={0, 1},
 *			example=0,
 *			default=0
 *		),
 *		@OA\Property(
 *			property="can_create",
 *			description="Can the User (default false) perform create actions with the entry model?",
 *			readOnly=true,
 *			nullable=false,
 *			type="integer",
 *			format="enum",
 *			enum={0, 1},
 *			example=0,
 *			default=0
 *		),
 *		@OA\Property(
 *			property="can_update",
 *			description="Can the User (default false) perform update actions with the entry model?",
 *			readOnly=true,
 *			nullable=false,
 *			type="integer",
 *			format="enum",
 *			enum={0, 1},
 *			example=0,
 *			default=0
 *		),
 *		@OA\Property(
 *			property="can_delete",
 *			description="Can the User (default false) perform soft delete actions with the entry model?",
 *			readOnly=true,
 *			nullable=false,
 *			type="integer",
 *			format="enum",
 *			enum={0, 1},
 *			example=0,
 *			default=0
 *		),
 *		@OA\Property(
 *			property="can_restore",
 *			description="Can the User (default false) perform restore actions with the entry model?",
 *			readOnly=true,
 *			nullable=false,
 *			type="integer",
 *			format="enum",
 *			enum={0, 1},
 *			example=0,
 *			default=0
 *		),
 *		@OA\Property(
 *			property="can_nuke",
 *			description="Can the User (default false) perform hard delete actions with the entry model?",
 *			readOnly=true,
 *			nullable=false,
 *			type="integer",
 *			format="enum",
 *			enum={0, 1},
 *			example=0,
 *			default=0
 *		),
 *		@OA\Property(
 *			property="chapters",
 *			description="Attachable & filterable array of Chapters using this Location.",
 *			type="array",
 *			@OA\Items(
 *				title="Chapter",
 *				type="object",
 *				ref="#/components/schemas/ChapterSimple"
 *			),
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="events",
 *			description="Attachable & filterable array of Events using this Location.",
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
 *			description="Attachable & filterable array of Issuances at this Location.",
 *			type="array",
 *			@OA\Items(
 *				title="Issuance",
 *				type="object",
 *				ref="#/components/schemas/IssuanceSimple"
 *			),
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="meetups",
 *			description="Attachable & filterable array of Meetups using this Location.",
 *			type="array",
 *			@OA\Items(
 *				title="Meetup",
 *				type="object",
 *				ref="#/components/schemas/MeetupSimple"
 *			),
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="waivers",
 *			description="Attachable & filterable array of Waivers using this Location.",
 *			type="array",
 *			@OA\Items(
 *				title="Waiver",
 *				type="object",
 *				ref="#/components/schemas/WaiverSimple"
 *			),
 *			readOnly=true
 *		)
 *	)
 *	@OA\Schema(
 *		schema="LocationSimple",
 *		title="LocationSimple",
 *		description="Attachable Location object with no attachments.",
 *		@OA\Property(
 *			property="id",
 *			description="The entry's ID.",
 *			type="integer",
 *			format="int32",
 *			example=42,
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="name",
 *			description="The Location name, as it might appear on a map.",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="uppercase first letter",
 *			example="McCullum Park",
 *			maxLength=50
 *		),
 *		@OA\Property(
 *			property="address",
 *			description="The street address of the Location, if any.",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="street",
 *			example="123 Fake St.",
 *			maxLength=191
 *		),
 *		@OA\Property(
 *			property="city",
 *			description="The city of the Location, if any.",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="city",
 *			example="Seattle",
 *			maxLength=50
 *		),
 *		@OA\Property(
 *			property="province",
 *			description="The state or provice of the Location, if any.",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="state",
 *			example="Texas",
 *			maxLength=35
 *		),
 *		@OA\Property(
 *			property="postal_code",
 *			description="The zip or postal code of the Location, if any.",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="zip",
 *			example="98666",
 *			maxLength=10
 *		),
 *		@OA\Property(
 *			property="country",
 *			description="The two letter country code of the Location (default US), if any.",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="country",
 *			example="US",
 *			maxLength=2,
 *	 		default="US"
 *		),
 *		@OA\Property(
 *			property="google_geocode",
 *			description="JSON encoded Google Geocode data of the Location, if any.",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="json",
 *			maxLength=16777215
 *		),
 *		@OA\Property(
 *			property="latitude",
 *			description="Latitude of the Location, if any.",
 *			readOnly=false,
 *			nullable=true,
 *			type="number",
 *			format="double"
 *		),
 *		@OA\Property(
 *			property="longitude",
 *			description="Longitude of the Location, if any.",
 *			readOnly=false,
 *			nullable=true,
 *			type="number",
 *			format="double"
 *		),
 *		@OA\Property(
 *			property="location",
 *			description="JSON encoded Google location services data of the Location, if any",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="json",
 *			maxLength=16777215
 *		),
 *		@OA\Property(
 *			property="map_url",
 *			description="An external map link of the Location, if any",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="url",
 *			maxLength=16777215
 *		),
 *		@OA\Property(
 *			property="directions",
 *			description="Directions required to properly navigate the last part of the journey to, or park at, the Location, if any.",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="paragraph",
 *			example="Take the first right and park next to the abandoned pool.Go down the path until you see the sign for the designated LARP area.",
 *			maxLength=16777215
 *		),
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
 *			description="When the entry was softdeleted.Null if not softdeleted.",
 *			type="string",
 *			format="date-time",
 *			example="2020-12-30 23:59:59",
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="can_list",
 *			description="Can the User (default false) perform list actions with the entry model?",
 *			readOnly=true,
 *			nullable=false,
 *			type="integer",
 *			format="enum",
 *			enum={0, 1},
 *			example=0,
 *			default=0
 *		),
 *		@OA\Property(
 *			property="can_view",
 *			description="Can the User (default false) perform view actions with the entry model?",
 *			readOnly=true,
 *			nullable=false,
 *			type="integer",
 *			format="enum",
 *			enum={0, 1},
 *			example=0,
 *			default=0
 *		),
 *		@OA\Property(
 *			property="can_create",
 *			description="Can the User (default false) perform create actions with the entry model?",
 *			readOnly=true,
 *			nullable=false,
 *			type="integer",
 *			format="enum",
 *			enum={0, 1},
 *			example=0,
 *			default=0
 *		),
 *		@OA\Property(
 *			property="can_update",
 *			description="Can the User (default false) perform update actions with the entry model?",
 *			readOnly=true,
 *			nullable=false,
 *			type="integer",
 *			format="enum",
 *			enum={0, 1},
 *			example=0,
 *			default=0
 *		),
 *		@OA\Property(
 *			property="can_delete",
 *			description="Can the User (default false) perform soft delete actions with the entry model?",
 *			readOnly=true,
 *			nullable=false,
 *			type="integer",
 *			format="enum",
 *			enum={0, 1},
 *			example=0,
 *			default=0
 *		),
 *		@OA\Property(
 *			property="can_restore",
 *			description="Can the User (default false) perform restore actions with the entry model?",
 *			readOnly=true,
 *			nullable=false,
 *			type="integer",
 *			format="enum",
 *			enum={0, 1},
 *			example=0,
 *			default=0
 *		),
 *		@OA\Property(
 *			property="can_nuke",
 *			description="Can the User (default false) perform hard delete actions with the entry model?",
 *			readOnly=true,
 *			nullable=false,
 *			type="integer",
 *			format="enum",
 *			enum={0, 1},
 *			example=0,
 *			default=0
 *		)
 *	)
 *	@OA\Schema(
 *		schema="LocationSuperSimple",
 *		title="LocationSuperSimple",
 *		description="Attachable Location object with no attachments or CUD data.",
 *		@OA\Property(
 *			property="id",
 *			description="The entry's ID.",
 *			type="integer",
 *			format="int32",
 *			example=42,
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="name",
 *			description="The Location name, as it might appear on a map.",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="uppercase first letter",
 *			example="McCullum Park",
 *			maxLength=50
 *		),
 *		@OA\Property(
 *			property="address",
 *			description="The street address of the Location, if any.",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="street",
 *			example="123 Fake St.",
 *			maxLength=191
 *		),
 *		@OA\Property(
 *			property="city",
 *			description="The city of the Location, if any.",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="city",
 *			example="Seattle",
 *			maxLength=50
 *		),
 *		@OA\Property(
 *			property="province",
 *			description="The state or provice of the Location, if any.",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="state",
 *			example="Texas",
 *			maxLength=35
 *		),
 *		@OA\Property(
 *			property="postal_code",
 *			description="The zip or postal code of the Location, if any.",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="zip",
 *			example="98666",
 *			maxLength=10
 *		),
 *		@OA\Property(
 *			property="country",
 *			description="The two letter country code of the Location (default US), if any.",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="country",
 *			example="US",
 *			maxLength=2,
 *	 		default="US"
 *		),
 *		@OA\Property(
 *			property="google_geocode",
 *			description="JSON encoded Google Geocode data of the Location, if any.",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="json",
 *			maxLength=16777215
 *		),
 *		@OA\Property(
 *			property="latitude",
 *			description="Latitude of the Location, if any.",
 *			readOnly=false,
 *			nullable=true,
 *			type="number",
 *			format="double"
 *		),
 *		@OA\Property(
 *			property="longitude",
 *			description="Longitude of the Location, if any.",
 *			readOnly=false,
 *			nullable=true,
 *			type="number",
 *			format="double"
 *		),
 *		@OA\Property(
 *			property="location",
 *			description="JSON encoded Google location services data of the Location, if any",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="json",
 *			maxLength=16777215
 *		),
 *		@OA\Property(
 *			property="map_url",
 *			description="An external map link of the Location, if any",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="url",
 *			maxLength=16777215
 *		),
 *		@OA\Property(
 *			property="directions",
 *			description="Directions required to properly navigate the last part of the journey to, or park at, the Location, if any.",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="paragraph",
 *			example="Take the first right and park next to the abandoned pool.Go down the path until you see the sign for the designated LARP area.",
 *			maxLength=16777215
 *		)
 *	)
 *	@OA\RequestBody(
 *		request="Location",
 *		description="Location object that needs to be added or updated.",
 *		required=true,
 *		@OA\MediaType(
 *			mediaType="multipart/form-data",
 *			@OA\Schema(ref="#/components/schemas/LocationSimple")
 *		)
 *	)
 */

class Location extends BaseModel
{
	use SoftDeletes;
	use HasFactory;
	use Userstamps;
	use ProtectFieldsTrait;
	use Searchable;

	public $table = 'locations';
	public $timestamps = true;
	
	protected $dates = ['created_at', 'updated_at', 'deleted_at'];
	protected $protectedFields = [];

	public $fillable = [
		'name',
		'address',
		'city',
		'province',
		'postal_code',
		'country',
		'google_geocode',
		'latitude',
		'longitude',
		'location',
		'map_url',
		'directions'
	];

	protected $casts = [
		'name' => 'string',
		'address' => 'string',
		'city' => 'string',
		'province' => 'string',
		'postal_code' => 'string',
		'country' => 'string',
		'google_geocode' => 'string',
		'latitude' => 'float',
		'longitude' => 'float',
		'location' => 'string',
		'map_url' => 'string',
		'directions' => 'string'
	];
	
	public function toSearchableArray(): array
	{
		return [
			'id' => (int) $this->id,
			'name' => $this->name,
			'address' => $this->address,
			'city' => $this->city,
			'province' => $this->province
		];
	}

	public static array $rules = [
		'name' => 'nullable|string|max:50',
		'address' => 'nullable|string|max:191',
		'city' => 'nullable|string|max:50',
		'province' => 'nullable|string|max:35',
		'postal_code' => 'nullable|string|max:10',
		'country' => 'nullable|string|max:2|default:US',
		'google_geocode' => 'nullable|string|max:16777215',
		'latitude' => 'nullable|numeric',
		'longitude' => 'nullable|numeric',
		'location' => 'nullable|string|max:16777215',
		'map_url' => 'nullable|string|max:16777215|active_url',
		'directions' => 'nullable|string|max:16777215'
	];
	
	public $relationships = [
		'chapters' => 'HasMany',
		'events' => 'HasMany',
		'issuances' => 'MorphMany',
		'meetups' => 'HasMany',
		'waivers' => 'HasMany'
	];
	
	public function chapters(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Chapter::class, 'location_id');
	}
	
	public function events(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Event::class, 'location_id');
	}
	
	public function issuances(): \Illuminate\Database\Eloquent\Relations\MorphMany
	{
		return $this->morphMany(Issuance::class, 'whereable');
	}
	
	public function meetups(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Meetup::class, 'location_id');
	}
	
	public function waivers(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Waiver::class, 'location_id');
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
