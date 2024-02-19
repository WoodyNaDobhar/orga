<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Wildside\Userstamps\Userstamps;
use App\Traits\ProtectFieldsTrait;
/**
 * @OA\Schema(
 *		schema="Unit",
 *		required={"type","name"},
 *		description="Organizations within the broader scope of Amtgard.<br>The following relationships can be attached, and in the case of plural relations, searched:
 * accounts (Account) (MorphMany): Accounts held by the Unit.
 * awards (Award) (MorphMany): Awards Unit can Issue.
 * awardIssuances (Issuance) (MorphMany): Awards Unit has been Issued.
 * events (Event) (MorphMany): Events run by this Unit.
 * issuanceGivens (Issuance) (MorphMany): All Issuances made by the Unit.
 * issuanceReceived (Issuance) (MorphMany): All Issuances received by the Unit.
 * members (Member) (HasMany): Unit Members.
 * officers (Officer) (MorphMany): Officers of the Unit.
 * offices (Office) (MorphMany): Unit Offices.
 * socials (Social) (MorphMany): Social media links or IDs.
 * titles (Title) (MorphMany): Titles Unit can Issue.
 * titleIssuances (Issuance) (MorphMany): Titles Unit has been Issued.
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
 *			property="type",
 *			description="Unit type; Company, Event, or Household.",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="enum",
 *			enum={"Company","Event","Household"},
 *			example="Company",
 *			default="Household"
 *		),
 *		@OA\Property(
 *			property="name",
 *			description="Name of the Unit.",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="uppercase first letter",
 *			example="Team Alpha Male",
 *			maxLength=100
 *		),
 *		@OA\Property(
 *			property="heraldry",
 *			description="An internal link to an image of the Unit heraldry, if any.",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="filename",
 *			example="images/units/42.jpg",
 *			maxLength=191
 *		),
 *		@OA\Property(
 *			property="description",
 *			description="A public facing description of the Unit.",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="paragraph",
 *			example="We like to hang out in the most exclusive way possible.",
 *			maxLength=16777215
 *		),
 *		@OA\Property(
 *			property="history",
 *			description="For use as the Unit requires, history of the Unit, if any.",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="paragraph",
 *			example="No shit there we were...",
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
 *			description="Attachable & filterable array of Accounts held by the Unit.",
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
 *			description="Attachable & filterable array of Awards this Unit can Issue.",
 *			type="array",
 *			@OA\Items(
 *				title="Award",
 *				type="object",
 *				ref="#/components/schemas/AwardSimple"
 *			),
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="awardIssuances",
 *			description="Attachable & filterable array of Awards this Unit has been Issued.",
 *			type="array",
 *			@OA\Items(
 *				title="Issuance",
 *				type="object",
 *				ref="#/components/schemas/IssuanceSimple"
 *			),
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="events",
 *			description="Attachable & filterable array of Events run by this Unit.",
 *			type="array",
 *			@OA\Items(
 *				title="Event",
 *				type="object",
 *				ref="#/components/schemas/EventSimple"
 *			),
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="issuanceGivens",
 *			description="Attachable & filterable array of Issuances made by the Unit",
 *			type="array",
 *			@OA\Items(
 *				title="Issuance",
 *				type="object",
 *				ref="#/components/schemas/IssuanceSimple"
 *			),
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="issuanceReceived",
 *			description="Attachable & filterable array of Issuances received by the Unit.",
 *			type="array",
 *			@OA\Items(
 *				title="Issuance",
 *				type="object",
 *				ref="#/components/schemas/IssuanceSimple"
 *			),
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="members",
 *			description="Attachable & filterable array of Unit Members.",
 *			type="array",
 *			@OA\Items(
 *				title="Member",
 *				type="object",
 *				ref="#/components/schemas/MemberSimple"
 *			),
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="officers",
 *			description="Attachable & filterable array of Officers of the Unit.",
 *			type="array",
 *			@OA\Items(
 *				title="Officer",
 *				type="object",
 *				ref="#/components/schemas/OfficerSimple"
 *			),
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="offices",
 *			description="Attachable & filterable array of Unit Offices.",
 *			type="array",
 *			@OA\Items(
 *				title="Office",
 *				type="object",
 *				ref="#/components/schemas/OfficeSimple"
 *			),
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="socials",
 *			description="Attachable & filterable array of Social media links or IDs.",
 *			type="array",
 *			@OA\Items(
 *				title="Social",
 *				type="object",
 *				ref="#/components/schemas/SocialSimple"
 *			),
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="titles",
 *			description="Attachable & filterable array of Titles the Unit Issues.",
 *			type="array",
 *			@OA\Items(
 *				title="Title",
 *				type="object",
 *				ref="#/components/schemas/TitleSimple"
 *			),
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="titleIssueds",
 *			description="Attachable & filterable array of Titles the Unit has been Issued.",
 *			type="array",
 *			@OA\Items(
 *				title="Issuance",
 *				type="object",
 *				ref="#/components/schemas/IssuanceSimple"
 *			),
 *			readOnly=true
 *		)
 * )
 *	@OA\Schema(
 *		schema="UnitSimple",
 *		@OA\Property(
 *			property="id",
 *			description="The entry's ID.",
 *			type="integer",
 *			format="int32",
 *			example=42,
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="type",
 *			description="Unit type; Company, Event, or Household.",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="enum",
 *			enum={"Company","Event","Household"},
 *			example="Company",
 *			default="Household"
 *		),
 *		@OA\Property(
 *			property="name",
 *			description="Name of the Unit.",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="uppercase first letter",
 *			example="Team Alpha Male",
 *			maxLength=100
 *		),
 *		@OA\Property(
 *			property="heraldry",
 *			description="An internal link to an image of the Unit heraldry, if any.",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="filename",
 *			example="images/units/42.jpg",
 *			maxLength=191
 *		),
 *		@OA\Property(
 *			property="description",
 *			description="A public facing description of the Unit.",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="paragraph",
 *			example="We like to hang out in the most exclusive way possible.",
 *			maxLength=16777215
 *		),
 *		@OA\Property(
 *			property="history",
 *			description="For use as the Unit requires, history of the Unit, if any.",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="paragraph",
 *			example="No shit there we were...",
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
 *			description="When the entry was softdeleted.  Null if not softdeleted.",
 *			type="string",
 *			format="date-time",
 *			example="2020-12-30 23:59:59",
 *			readOnly=true
 *		)
 *	)
 *	@OA\Schema(
 *		schema="UnitSuperSimple",
 *		@OA\Property(
 *			property="id",
 *			description="The entry's ID.",
 *			type="integer",
 *			format="int32",
 *			example=42,
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="type",
 *			description="Unit type; Company, Event, or Household.",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="enum",
 *			enum={"Company","Event","Household"},
 *			example="Company",
 *			default="Household"
 *		),
 *		@OA\Property(
 *			property="name",
 *			description="Name of the Unit.",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="uppercase first letter",
 *			example="Team Alpha Male",
 *			maxLength=100
 *		),
 *		@OA\Property(
 *			property="heraldry",
 *			description="An internal link to an image of the Unit heraldry, if any.",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="filename",
 *			example="images/units/42.jpg",
 *			maxLength=191
 *		),
 *		@OA\Property(
 *			property="description",
 *			description="A public facing description of the Unit.",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="paragraph",
 *			example="We like to hang out in the most exclusive way possible.",
 *			maxLength=16777215
 *		),
 *		@OA\Property(
 *			property="history",
 *			description="For use as the Unit requires, history of the Unit, if any.",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="paragraph",
 *			example="No shit there we were...",
 *			maxLength=16777215
 *		)
 *	)
 *	@OA\RequestBody(
 *		request="Unit",
 *		description="Unit object that needs to be added or updated.",
 *		required=true,
 *		@OA\MediaType(
 *			mediaType="multipart/form-data",
 *			@OA\Schema(ref="#/components/schemas/UnitSimple")
 *		)
 *	)
 */

class Unit extends BaseModel
{
	use SoftDeletes;
	use HasFactory;
	use Userstamps;
	use ProtectFieldsTrait;

	public $table = 'units';
	public $timestamps = true;
	
	protected $dates = ['created_at', 'updated_at', 'deleted_at'];
	protected $protectedFields = [];

	public $fillable = [
		  'type',
		  'name',
		  'heraldry',
		  'description',
		  'history'
	];

	protected $casts = [
		  'type' => 'string',
		  'name' => 'string',
		  'heraldry' => 'string',
		  'description' => 'string',
		  'history' => 'string'
	];

	public static array $rules = [
		'type' => 'required|in:Company,Event,Household',
		'name' => 'required|string|max:100',
		'heraldry' => 'nullable|string|max:191',
		'description' => 'nullable|string|max:16777215',
		'history' => 'nullable|string|max:16777215'
	];
	
	public $relationships = [
		'accounts' => 'MorphMany',
		'awards' => 'MorphMany',
		'awardIssuances' => 'MorphMany',
		'events' => 'MorphMany',
		'issuanceGivens' => 'MorphMany',
		'issuanceReceiveds' => 'MorphMany',
		'members' => 'HasMany',
		'officers' => 'MorphMany',
		'offices' => 'MorphMany',
		'socials' => 'MorphMany',
		'titles' => 'MorphMany',
		'titleIssuances' => 'MorphMany'
	];
	
	public function accounts(): \Illuminate\Database\Eloquent\Relations\MorphMany
	{
		return $this->morphMany(Account::class, 'accountable');
	}
	
	public function awards(): \Illuminate\Database\Eloquent\Relations\MorphMany
	{
		return $this->morphMany(Award::class, 'awarder');
	}
	
	public function awardIssuances(): \Illuminate\Database\Eloquent\Relations\MorphMany
	{
		return $this->morphMany(Issuance::class, 'recipient')->where('issuable_type', 'Award');
	}
	
	public function events(): \Illuminate\Database\Eloquent\Relations\MorphMany
	{
		return $this->morphMany(Event::class, 'eventable');
	}
	
	public function issuanceGivens(): \Illuminate\Database\Eloquent\Relations\MorphMany
	{
		return $this->morphMany(Issuance::class, 'issuer');
	}
	
	public function members(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Member::class, 'unit_id');
	}
	
	public function officers(): \Illuminate\Database\Eloquent\Relations\MorphMany
	{
		return $this->morphMany(Officer::class, 'officerable');
	}
	
	public function offices(): \Illuminate\Database\Eloquent\Relations\MorphMany
	{
		return $this->morphMany(Office::class, 'officeable');
	}
	
	public function socials(): \Illuminate\Database\Eloquent\Relations\MorphMany
	{
		return $this->morphMany(Social::class, 'sociable');
	}
	
	public function titles(): \Illuminate\Database\Eloquent\Relations\MorphMany
	{
		return $this->morphMany(Award::class, 'awarder');
	}
	
	public function titleIssuances(): \Illuminate\Database\Eloquent\Relations\MorphMany
	{
		return $this->morphMany(Issuance::class, 'recipient')->where('issuable_type', 'Title');
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
