<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Wildside\Userstamps\Userstamps;
use App\Traits\ProtectFieldsTrait;
/**
 * @OA\Schema(
 *		schema="Title",
 *		required={"titleable_type","name","peerage","is_roaming","is_active"},
 *		description="Titles Issued by the Chapter, Persona, Realm, or Unit.<br>The following relationships can be attached, and in the case of plural relations, searched:
 * issuances (Issuance) (MorphMany): Issuances of this Title.
 * titleable (Chapter, Persona, Realm, or Unit) (MorphTo): Who can issue the Title; Chapter, Persona, Realm, or Unit
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
 *			property="titleable_type",
 *			description="Who can issue the Title; Chapter, Persona, Realm, or Unit.",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="enum",
 *			enum={"Chapter","Persona","Realm","Unit"},
 *			example="Chapter"
 *		),
 *		@OA\Property(
 *			property="titleable_id",
 *			description="The ID of the Title Issuer.",
 *			readOnly=false,
 *			nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="name",
 *			description="The Title name with options seperated by a single |",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="uppercase first letter",
 *			example="Lord|Lady",
 *			maxLength=100
 *		),
 *		@OA\Property(
 *			property="rank",
 *			description="For Realm Titles or where appropriate, their order of prescidence in that Realm expressed (usually) in multiples of 10, where Lord|Lady are typically 30.",
 *			readOnly=false,
 *			nullable=true,
 *			type="integer",
 *			format="int32",
 *			example=30
 *		),
 *		@OA\Property(
 *			property="peerage",
 *			description="The peerage (default None) of the Title; Gentry, Knight, Master, Nobility, None, Paragon, Retainer, or Squire",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="enum",
 *			enum={"Gentry","Knight","Master","Nobility","None","Paragon","Retainer","Squire"},
 *			example=1,
 *			default="None"
 *		),
 *		@OA\Property(
 *			property="is_roaming",
 *			description="Is the Title (default false) roaming, such as Dragonmaster?",
 *			readOnly=false,
 *			nullable=false,
 *			type="integer",
 *			format="enum",
 *			enum={0, 1},
 *			example=0,
 *			default=0
 *		),
 *		@OA\Property(
 *			property="is_active",
 *			description="Is this Title (default true) still being given out?",
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
 *			property="issuances",
 *			description="Attachable & filterable array of Issuances of this Title.",
 *			type="array",
 *			@OA\Items(
 *				title="Issuance",
 *				type="object",
 *				ref="#/components/schemas/IssuanceSimple"
 *			),
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="titleable",
 *			type="object",
 *			oneOf={
 *				@OA\Property(
 *					title="Chapter",
 *					description="Attachable Chapter that can Issue the Title.",
 *					@OA\Schema(ref="#/components/schemas/ChapterSimple")
 *				),
 *				@OA\Property(
 *					title="Persona",
 *					description="Attachable Persona that can Issue the Title.",
 *					@OA\Schema(ref="#/components/schemas/PersonaSimple")
 *				),
 *				@OA\Property(
 *					title="Realm",
 *					description="Attachable Realm that can Issue the Title.",
 *					@OA\Schema(ref="#/components/schemas/RealmSimple")
 *				),
 *				@OA\Property(
 *					title="Unit",
 *					description="Attachable Unit that can Issue the Title.",
 *					@OA\Schema(ref="#/components/schemas/UnitSimple")
 *				)
 *			},
 *			readOnly=true
 *		)
 * )
 *	@OA\Schema(
 *		schema="TitleSimple",
 *		@OA\Property(
 *			property="id",
 *			description="The entry's ID.",
 *			type="integer",
 *			format="int32",
 *			example=42,
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="titleable_type",
 *			description="Who can issue the Title; Chapter, Persona, Realm, or Unit.",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="enum",
 *			enum={"Chapter","Persona","Realm","Unit"},
 *			example="Chapter"
 *		),
 *		@OA\Property(
 *			property="titleable_id",
 *			description="The ID of the Title Issuer.",
 *			readOnly=false,
 *			nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="name",
 *			description="The Title name with options seperated by a single |",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="uppercase first letter",
 *			example="Lord|Lady",
 *			maxLength=100
 *		),
 *		@OA\Property(
 *			property="rank",
 *			description="For Realm Titles or where appropriate, their order of prescidence in that Realm expressed (usually) in multiples of 10, where Lord|Lady are typically 30.",
 *			readOnly=false,
 *			nullable=true,
 *			type="integer",
 *			format="int32",
 *			example=30
 *		),
 *		@OA\Property(
 *			property="peerage",
 *			description="The peerage (default None) of the Title; Gentry, Knight, Master, Nobility, None, Paragon, Retainer, or Squire",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="enum",
 *			enum={"Gentry","Knight","Master","Nobility","None","Paragon","Retainer","Squire"},
 *			example=1,
 *			default="None"
 *		),
 *		@OA\Property(
 *			property="is_roaming",
 *			description="Is the Title (default false) roaming, such as Dragonmaster?",
 *			readOnly=false,
 *			nullable=false,
 *			type="integer",
 *			format="enum",
 *			enum={0, 1},
 *			example=0,
 *			default=0
 *		),
 *		@OA\Property(
 *			property="is_active",
 *			description="Is this Title (default true) still being given out?",
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
 *		schema="TitleSuperSimple",
 *		@OA\Property(
 *			property="id",
 *			description="The entry's ID.",
 *			type="integer",
 *			format="int32",
 *			example=42,
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="titleable_type",
 *			description="Who can issue the Title; Chapter, Persona, Realm, or Unit.",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="enum",
 *			enum={"Chapter","Persona","Realm","Unit"},
 *			example="Chapter"
 *		),
 *		@OA\Property(
 *			property="titleable_id",
 *			description="The ID of the Title Issuer.",
 *			readOnly=false,
 *			nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="name",
 *			description="The Title name with options seperated by a single |",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="uppercase first letter",
 *			example="Lord|Lady",
 *			maxLength=100
 *		),
 *		@OA\Property(
 *			property="rank",
 *			description="For Realm Titles or where appropriate, their order of prescidence in that Realm expressed (usually) in multiples of 10, where Lord|Lady are typically 30.",
 *			readOnly=false,
 *			nullable=true,
 *			type="integer",
 *			format="int32",
 *			example=30
 *		),
 *		@OA\Property(
 *			property="peerage",
 *			description="The peerage (default None) of the Title; Gentry, Knight, Master, Nobility, None, Paragon, Retainer, or Squire",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="enum",
 *			enum={"Gentry","Knight","Master","Nobility","None","Paragon","Retainer","Squire"},
 *			example=1,
 *			default="None"
 *		),
 *		@OA\Property(
 *			property="is_roaming",
 *			description="Is the Title (default false) roaming, such as Dragonmaster?",
 *			readOnly=false,
 *			nullable=false,
 *			type="integer",
 *			format="enum",
 *			enum={0, 1},
 *			example=0,
 *			default=0
 *		),
 *		@OA\Property(
 *			property="is_active",
 *			description="Is this Title (default true) still being given out?",
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
 *		request="Title",
 *		description="Title object that needs to be added or updated.",
 *		required=true,
 *		@OA\MediaType(
 *			mediaType="multipart/form-data",
 *			@OA\Schema(ref="#/components/schemas/TitleSimple")
 *		)
 *	)
 */

class Title extends BaseModel
{
	use SoftDeletes;
	use HasFactory;
	use Userstamps;
	use ProtectFieldsTrait;

	public $table = 'titles';
	public $timestamps = true;
	
	protected $dates = ['created_at', 'updated_at', 'deleted_at'];
	protected $protectedFields = ['titleable_type','titleable_id'];

	public $fillable = [
		  'titleable_type',
		  'titleable_id',
		  'name',
		  'rank',
		  'peerage',
		  'is_roaming',
		  'is_active'
	];

	protected $casts = [
		  'titleable_type' => 'string',
		  'name' => 'string',
		  'peerage' => 'string',
		  'is_roaming' => 'boolean',
		  'is_active' => 'boolean'
	];

	public static array $rules = [
		'titleable_type' => 'required|in:Chapter,Persona,Realm,Unit',
		'titleable_id' => 'nullable',
		'name' => 'required|string|max:100',
		'rank' => 'nullable|integer',
		'peerage' => 'required|in:Gentry,Knight,Master,Nobility,None,Paragon,Retainer,Squire',
		'is_roaming' => 'boolean',
		'is_active' => 'boolean'
	];
	
	public $relationships = [
		'issuances' => 'MorphMany',
		'titleable' => 'MorphTo'
	];
	
	public function issuances(): \Illuminate\Database\Eloquent\Relations\MorphMany
	{
		return $this->morphMany(Issuance::class, 'issuable');
	}
	
	public function titleable(): \Illuminate\Database\Eloquent\Relations\MorphTo
	{
		return $this->morphTo();
	}
	
	public function recommendations(): \Illuminate\Database\Eloquent\Relations\MorphMany
	{
		return $this->morphMany(Recommendation::class, 'recommendable');
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
