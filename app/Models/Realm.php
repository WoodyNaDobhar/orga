<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Wildside\Userstamps\Userstamps;
use App\Traits\ProtectFieldsTrait;
/**
 * @OA\Schema(
 *	  schema="Realm",
 *	  required={"name","abbreviation","color","is_active"},
 *		description="Collective of Chapters, often Kingdoms, but including Principalities and Grand Duchies.<br>The following relationships can be attached, and in the case of plural relations, searched:
 * accounts (Account) (MorphMany): Accounts for the Realm.
 * awards (Awards) (MorphMany): Awards this Realm can issue.
 * chapters (Chapter) (HasMany): Chapters of the Realm.
 * chaptertypes (Chaptertype) (HasMany): Chaptertypes the Realm uses.
 * events (Event) (MorphMany): Events run by the Realm.
 * issuances (Issuance) (MorphMany): Issuances made by the Realm.
 * offices (Office) (MorphMany): Offices of the Realm.
 * reign (Reign) (MorphOne): The current Reign for the Realm.
 * reigns (Reign) (MorphMany): Reigns of the Realm.
 * socials (Social) (MorphMany): Socials for the Realm.
 * sponsors (Event) (MorphMany): Persona or Unit Events this Realm has sponsored.
 * suspensions (Suspension) (MorphMany): Suspensions levied by the Realm.
 * titles (Title) (MorphMany): Titles the Realm Issues.
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
 *			property="parent_id",
 *			description="If sponsored by another Realm, that Realm ID.",
 *		  readOnly=false,
 *		  nullable=true,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *	  @OA\Property(
 *		  property="name",
 *		  description="The label for the Realm.",
 *		  readOnly=false,
 *		  nullable=false,
 *		  type="string",
 *			format="uppercase first letter",
 *			example="The Republic of Futurama",
 *			maxLength=100
 *	  ),
 *	  @OA\Property(
 *		  property="abbreviation",
 *		  description="A simple, unique, usually two letter abbreviation commonly used for the Realm",
 *		  readOnly=false,
 *		  nullable=false,
 *		  type="string",
 *		  format="uppercase",
 *		  example="FR",
 *		  maxLength=4
 *	  ),
 *	  @OA\Property(
 *		  property="color",
 *		  description="The hexidecimal code (default FACADE) for the color used for the Realm on various UIs.",
 *		  readOnly=false,
 *		  nullable=false,
 *		  type="string",
 *		  format="hexidecimal",
 *		  example="000000",
 *	 		default="FACADE"
 *	  ),
 *	  @OA\Property(
 *		  property="heraldry",
 *		  description="An internal link to an image of the Realm heraldry.",
 *		  readOnly=false,
 *		  nullable=true,
 *			type="string",
 *			format="filename",
 *			example="images/realms/42.jpg",
 *			maxLength=191
 *	  ),
 *	  @OA\Property(
 *		  property="is_active",
 *		  description="Is (default true) the Realm active?",
 *		  readOnly=false,
 *		  nullable=false,
 *			type="integer",
 *			format="enum",
 *			enum={0, 1},
 *			example=0,
 *			default=1
 *	  ),
 *		@OA\Property(
 *			property="credit_minimum",
 *			description="Realm Credit Minimum setting, if any.",
 *		  readOnly=false,
 *		  nullable=true,
 *			type="integer",
 *			format="int32",
 *			example=6
 *		),
 *		@OA\Property(
 *			property="credit_maximum",
 *			description="Realm Credit Maximum setting, if any.",
 *		  readOnly=false,
 *		  nullable=true,
 *			type="integer",
 *			format="int32",
 *			example=32
 *		),
 *		@OA\Property(
 *			property="daily_minimum",
 *			description="Realm Daily Minimum setting, if any",
 *		  readOnly=false,
 *		  nullable=true,
 *			type="integer",
 *			format="int32",
 *			example=6
 *		),
 *		@OA\Property(
 *			property="weekly_minimum",
 *			description="Realm Weekly Minimum setting, if any",
 *		  readOnly=false,
 *		  nullable=true,
 *			type="integer",
 *			format="int32",
 *			example=9
 *		),
 *	  @OA\Property(
 *		  property="average_period_type",
 *		  description="Realm Average Period Type setting, if any.",
 *		  readOnly=false,
 *		  nullable=true,
 *			type="string",
 *			format="enum",
 *			enum={"Week","Month"},
 *			example="Week"
 *	  ),
 *		@OA\Property(
 *			property="average_period",
 *			description="Realm Average Period setting, if any.",
 *		  readOnly=false,
 *		  nullable=true,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="dues_amount",
 *			description="Dues cost per interval for the Realm, if any.",
 *		  readOnly=false,
 *		  nullable=true,
 *			type="integer",
 *			format="int32",
 *			example=12
 *		),
 *	  @OA\Property(
 *		  property="dues_intervals_type",
 *		  description="Dues intervals type for the Realm, if any.",
 *		  readOnly=false,
 *		  nullable=true,
 *			type="string",
 *			format="enum",
 *			enum={"Week","Month"},
 *			example="Week"
 *	  ),
 *		@OA\Property(
 *			property="dues_intervals",
 *			description="Dues intervals count for the Realm, if any.",
 *		  readOnly=false,
 *		  nullable=true,
 *			type="integer",
 *			format="int32",
 *			example=6
 *		),
 *		@OA\Property(
 *			property="dues_take",
 *			description="Realm take of Dues paid to Chapters, if any.",
 *		  readOnly=false,
 *		  nullable=true,
 *			type="integer",
 *			format="int32",
 *			example=5
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
 *			description="Attachable & filterable array of Accounts for the Realm.",
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
 *			description="Attachable & filterable array of Awards this Realm can issue.",
 *			type="array",
 *			@OA\Items(
 *				title="Award",
 *				type="object",
 *				ref="#/components/schemas/AwardSimple"
 *			),
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="chapters",
 *			description="Attachable & filterable array of Chapters of the Realm.",
 *			type="array",
 *			@OA\Items(
 *				title="Chapter",
 *				type="object",
 *				ref="#/components/schemas/ChapterSimple"
 *			),
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="chaptertypes",
 *			description="Attachable & filterable array of Chaptertypes the Realm uses.",
 *			type="array",
 *			@OA\Items(
 *				title="Chaptertype",
 *				type="object",
 *				ref="#/components/schemas/ChaptertypeSimple"
 *			),
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="events",
 *			description="Attachable & filterable array of Events sponsored by the Realm.",
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
 *			description="Attachable & filterable array of Issuances made by the Realm.",
 *			type="array",
 *			@OA\Items(
 *				title="Issuance",
 *				type="object",
 *				ref="#/components/schemas/IssuanceSimple"
 *			),
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="offices",
 *			description="Attachable & filterable array of Offices of the Realm.",
 *			type="array",
 *			@OA\Items(
 *				title="Office",
 *				type="object",
 *				ref="#/components/schemas/OfficeSimple"
 *			),
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="reign",
 *			description="Attachable & filterable array of the current Reign for the Realm.",
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
 *			description="Attachable & filterable array of the Reigns of the Realm.",
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
 *			description="Attachable & filterable array of the Socials of the Realm.",
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
 *			description="Attachable & filterable array of Persona or Unit Events this Realm has sponsored.",
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
 *			description="Attachable & filterable array of Suspensions levied by the Realm.",
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
 *			description="Attachable & filterable array of the Titles the Realm Issues.",
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
 *		schema="RealmSimple",
 *		@OA\Property(
 *			property="id",
 *			description="The entry's ID.",
 *			type="integer",
 *			format="int32",
 *			example=42,
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="parent_id",
 *			description="If sponsored by another Realm, that Realm ID.",
 *		  readOnly=false,
 *		  nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *	  @OA\Property(
 *		  property="name",
 *		  description="The label for the Realm.",
 *		  readOnly=false,
 *		  nullable=false,
 *		  type="string",
 *			format="uppercase first letter",
 *			example="The Republic of Futurama",
 *			maxLength=100
 *	  ),
 *	  @OA\Property(
 *		  property="abbreviation",
 *		  description="A simple, unique, usually two letter abbreviation commonly used for the Realm",
 *		  readOnly=false,
 *		  nullable=false,
 *		  type="string",
 *		  format="uppercase",
 *		  example="FR",
 *		  maxLength=4
 *	  ),
 *	  @OA\Property(
 *		  property="color",
 *		  description="The hexidecimal code (default FACADE) for the color used for the Realm on various UIs.",
 *		  readOnly=false,
 *		  nullable=false,
 *		  type="string",
 *		  format="hexidecimal",
 *		  example="000000",
 *	 		default="FACADE"
 *	  ),
 *	  @OA\Property(
 *		  property="heraldry",
 *		  description="An internal link to an image of the Realm heraldry.",
 *		  readOnly=false,
 *		  nullable=true,
 *			type="string",
 *			format="filename",
 *			example="images/realms/42.jpg",
 *			maxLength=191
 *	  ),
 *	  @OA\Property(
 *		  property="is_active",
 *		  description="Is (default true) the Realm active?",
 *		  readOnly=false,
 *		  nullable=false,
 *			type="integer",
 *			format="enum",
 *			enum={0, 1},
 *			example=0,
 *			default=1
 *	  ),
 *		@OA\Property(
 *			property="credit_minimum",
 *			description="Realm Credit Minimum setting, if any.",
 *		  readOnly=false,
 *		  nullable=true,
 *			type="integer",
 *			format="int32",
 *			example=6
 *		),
 *		@OA\Property(
 *			property="credit_maximum",
 *			description="Realm Credit Maximum setting, if any.",
 *		  readOnly=false,
 *		  nullable=true,
 *			type="integer",
 *			format="int32",
 *			example=32
 *		),
 *		@OA\Property(
 *			property="daily_minimum",
 *			description="Realm Daily Minimum setting, if any",
 *		  readOnly=false,
 *		  nullable=true,
 *			type="integer",
 *			format="int32",
 *			example=6
 *		),
 *		@OA\Property(
 *			property="weekly_minimum",
 *			description="Realm Weekly Minimum setting, if any",
 *		  readOnly=false,
 *		  nullable=true,
 *			type="integer",
 *			format="int32",
 *			example=9
 *		),
 *	  @OA\Property(
 *		  property="average_period_type",
 *		  description="Realm Average Period Type setting, if any.",
 *		  readOnly=false,
 *		  nullable=true,
 *			type="string",
 *			format="enum",
 *			enum={"Week","Month"},
 *			example="Week"
 *	  ),
 *		@OA\Property(
 *			property="average_period",
 *			description="Realm Average Period setting, if any.",
 *		  readOnly=false,
 *		  nullable=true,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="dues_amount",
 *			description="Dues cost per interval for the Realm, if any.",
 *		  readOnly=false,
 *		  nullable=true,
 *			type="integer",
 *			format="int32",
 *			example=12
 *		),
 *	  @OA\Property(
 *		  property="dues_intervals_type",
 *		  description="Dues intervals type for the Realm, if any.",
 *		  readOnly=false,
 *		  nullable=true,
 *			type="string",
 *			format="enum",
 *			enum={"Week","Month"},
 *			example="Week"
 *	  ),
 *		@OA\Property(
 *			property="dues_intervals",
 *			description="Dues intervals count for the Realm, if any.",
 *		  readOnly=false,
 *		  nullable=true,
 *			type="integer",
 *			format="int32",
 *			example=6
 *		),
 *		@OA\Property(
 *			property="dues_take",
 *			description="Realm take of Dues paid to Chapters, if any.",
 *		  readOnly=false,
 *		  nullable=true,
 *			type="integer",
 *			format="int32",
 *			example=5
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
 *			description="When the entry was softdeleted.  Null if not softdeleted.",
 *			type="string",
 *			format="date-time",
 *			example="2020-12-30 23:59:59",
 *			readOnly=true
 *		)
 *	)
 *	@OA\Schema(
 *		schema="RealmSuperSimple",
 *		@OA\Property(
 *			property="id",
 *			description="The entry's ID.",
 *			type="integer",
 *			format="int32",
 *			example=42,
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="parent_id",
 *			description="If sponsored by another Realm, that Realm ID.",
 *		  readOnly=false,
 *		  nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *	  @OA\Property(
 *		  property="name",
 *		  description="The label for the Realm.",
 *		  readOnly=false,
 *		  nullable=false,
 *		  type="string",
 *			format="uppercase first letter",
 *			example="The Republic of Futurama",
 *			maxLength=100
 *	  ),
 *	  @OA\Property(
 *		  property="abbreviation",
 *		  description="A simple, unique, usually two letter abbreviation commonly used for the Realm",
 *		  readOnly=false,
 *		  nullable=false,
 *		  type="string",
 *		  format="uppercase",
 *		  example="FR",
 *		  maxLength=4
 *	  ),
 *	  @OA\Property(
 *		  property="color",
 *		  description="The hexidecimal code (default FACADE) for the color used for the Realm on various UIs.",
 *		  readOnly=false,
 *		  nullable=false,
 *		  type="string",
 *		  format="hexidecimal",
 *		  example="000000",
 *	 		default="FACADE"
 *	  ),
 *	  @OA\Property(
 *		  property="heraldry",
 *		  description="An internal link to an image of the Realm heraldry.",
 *		  readOnly=false,
 *		  nullable=true,
 *			type="string",
 *			format="filename",
 *			example="images/realms/42.jpg",
 *			maxLength=191
 *	  ),
 *	  @OA\Property(
 *		  property="is_active",
 *		  description="Is (default true) the Realm active?",
 *		  readOnly=false,
 *		  nullable=false,
 *			type="integer",
 *			format="enum",
 *			enum={0, 1},
 *			example=0,
 *			default=1
 *	  ),
 *		@OA\Property(
 *			property="credit_minimum",
 *			description="Realm Credit Minimum setting, if any.",
 *		  readOnly=false,
 *		  nullable=true,
 *			type="integer",
 *			format="int32",
 *			example=6
 *		),
 *		@OA\Property(
 *			property="credit_maximum",
 *			description="Realm Credit Maximum setting, if any.",
 *		  readOnly=false,
 *		  nullable=true,
 *			type="integer",
 *			format="int32",
 *			example=32
 *		),
 *		@OA\Property(
 *			property="daily_minimum",
 *			description="Realm Daily Minimum setting, if any",
 *		  readOnly=false,
 *		  nullable=true,
 *			type="integer",
 *			format="int32",
 *			example=6
 *		),
 *		@OA\Property(
 *			property="weekly_minimum",
 *			description="Realm Weekly Minimum setting, if any",
 *		  readOnly=false,
 *		  nullable=true,
 *			type="integer",
 *			format="int32",
 *			example=9
 *		),
 *	  @OA\Property(
 *		  property="average_period_type",
 *		  description="Realm Average Period Type setting, if any.",
 *		  readOnly=false,
 *		  nullable=true,
 *			type="string",
 *			format="enum",
 *			enum={"Week","Month"},
 *			example="Week"
 *	  ),
 *		@OA\Property(
 *			property="average_period",
 *			description="Realm Average Period setting, if any.",
 *		  readOnly=false,
 *		  nullable=true,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="dues_amount",
 *			description="Dues cost per interval for the Realm, if any.",
 *		  readOnly=false,
 *		  nullable=true,
 *			type="integer",
 *			format="int32",
 *			example=12
 *		),
 *	  @OA\Property(
 *		  property="dues_intervals_type",
 *		  description="Dues intervals type for the Realm, if any.",
 *		  readOnly=false,
 *		  nullable=true,
 *			type="string",
 *			format="enum",
 *			enum={"Week","Month"},
 *			example="Week"
 *	  ),
 *		@OA\Property(
 *			property="dues_intervals",
 *			description="Dues intervals count for the Realm, if any.",
 *		  readOnly=false,
 *		  nullable=true,
 *			type="integer",
 *			format="int32",
 *			example=6
 *		),
 *		@OA\Property(
 *			property="dues_take",
 *			description="Realm take of Dues paid to Chapters, if any.",
 *		  readOnly=false,
 *		  nullable=true,
 *			type="integer",
 *			format="int32",
 *			example=5
 *		)
 *	)
 *	@OA\RequestBody(
 *		request="Realm",
 *		description="Realm object that needs to be added or updated.",
 *		required=true,
 *		@OA\MediaType(
 *			mediaType="multipart/form-data",
 *			@OA\Schema(ref="#/components/schemas/RealmSimple")
 *		)
 *	)
 */

class Realm extends BaseModel
{
	use SoftDeletes;
	use HasFactory;
	use Userstamps;
	use ProtectFieldsTrait;

	public $table = 'realms';
	public $timestamps = true;
	
	protected $dates = ['created_at', 'updated_at', 'deleted_at'];
	protected $protectedFields = ['parent_id'];

	public $fillable = [
		'parent_id',
		'name',
		'abbreviation',
		'color',
		'heraldry',
		'is_active',
		'credit_minimum',
		'credit_maximum',
		'daily_minimum',
		'weekly_minimum',
		'average_period_type',
		'average_period',
		'dues_amount',
		'dues_intervals_type',
		'dues_intervals',
		'dues_take'
	];

	protected $casts = [
		'name' => 'string',
		'abbreviation' => 'string',
		'color' => 'string',
		'heraldry' => 'string',
		'is_active' => 'boolean',
		'average_period_type' => 'string',
		'dues_intervals_type' => 'string'
	];

	public static array $rules = [
		'parent_id' => 'nullable|exists:realms,id',
		'name' => 'required|string|max:100|unique:realms,name',
		'abbreviation' => 'required|string|max:4|unique:realms,abbreviation',
		'color' => 'required|string|max:6',
		'heraldry' => 'nullable|string|max:191',
		'is_active' => 'boolean',
		'credit_minimum' => 'nullable|integer',
		'credit_maximum' => 'nullable|integer',
		'daily_minimum' => 'nullable|integer',
		'weekly_minimum' => 'nullable|integer',
		'average_period_type' => 'nullable|in:Week,Month',
		'average_period' => 'nullable|integer',
		'dues_amount' => 'nullable|integer',
		'dues_intervals_type' => 'nullable|in:Week,Month',
		'dues_intervals' => 'nullable|integer',
		'dues_take' => 'nullable|integer'
	];
	
//	 protected $appends = [
//	 		'awards'
//	 ];
	
//	 public function getAwardsAttribute(){
//	 	return Award::where('awarder_type', 'Realm')->whereNull('awarder_id')->get();
//	 }
	
	public $relationships = [
		'accounts' => 'MorphMany',
		'awards' => 'MorphMany',
		'chapters' => 'HasMany',
		'chaptertypes' => 'HasMany',
		'events' => 'MorphMany',
		'issuances' => 'MorphMany',
		'offices' => 'MorphMany',
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
	
	public function chapters(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Chapter::class, 'realm_id');
	}
	
	public function chaptertypes(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Chaptertype::class, 'realm_id');
	}
	
	public function events(): \Illuminate\Database\Eloquent\Relations\MorphMany
	{
		return $this->morphMany(Event::class, 'eventable');
	}
	
	public function issuances(): \Illuminate\Database\Eloquent\Relations\MorphMany
	{
		return $this->morphMany(Issuance::class, 'issuer');
	}
	
	public function offices(): \Illuminate\Database\Eloquent\Relations\MorphMany
	{
		return $this->morphMany(Office::class, 'officeable');
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
	
	public function sponsors(): \Illuminate\Database\Eloquent\Relations\MorphMany
	{
		return $this->morphMany(Event::class, 'sponsorable');
	}
	
	public function titles(): \Illuminate\Database\Eloquent\Relations\MorphMany
	{
		return $this->morphMany(Title::class, 'titleable');
	}
	
	public function suspensions(): \Illuminate\Database\Eloquent\Relations\MorphMany
	{
		return $this->morphMany(Social::class, 'suspendable');
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
