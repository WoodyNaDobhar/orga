<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Wildside\Userstamps\Userstamps;
use App\Traits\ProtectFieldsTrait;
//TODO: for all @OA\Properties of fields with a default, add default=whatever (do this when done filling out all the base stuff, using parenthetical data)
/**
 * @OA\Schema (
 * 	schema="Office",
 * 	required={"officeable_type","name"},
 * 	description="Offices available for the given Chaptertype, Realm, or Unit.<br>The following relationships can be attached, and in the case of plural relations, searched:
 * officeable (Chaptertype, Realm, or Unit) (MorphTo): Type for what the Office is for; Chaptertype, Realm, or Unit.
 * officers (Officer) (HasMany): Officers having held this Office.
 * createdBy (User) (BelongsTo): User that created it.
 * updatedBy (User) (BelongsTo): User that last updated it (if any).
 * deletedBy (User) (BelongsTo): User that deleted it (if any).",
 * 	@OA\Property(
 * 		property="id",
 * 		description="The entry's ID.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="officeable_type",
 * 		description="Type for what the Office is for; Chaptertype, Realm, or Unit.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="enum",
 * 		enum={"Chaptertype","Realm","Unit"},
 * 		example="Chaptertype"
 * 	),
 * 	@OA\Property(
 * 		property="officeable_id",
 * 		description="The ID of what the Office is for.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="name",
 * 		description="The name of the Office, options delineated with a single |",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="uppercase first letter",
 * 		example="Prime Minister",
 * 		maxLength=100
 * 	),
 * 		@OA\Property(
 *  		property="duration",
 *  		description="Duration, in months, of the office (default 6)",
 *  		type="integer",
 *  		format="int32",
 *  		nullable=true,
 *  		example=6,
 *  		default=6
 * 	),
 * 		@OA\Property(
 *  		property="is_forgiven",
 *  		description="Is (default false) the Persona credited Dues while holding this Office?",
 *  		type="integer",
 * 		format="enum",
 * 		enum={0, 1},
 * 		example=0,
 * 		default=0
 * 	),
 * 		@OA\Property(
 *  		property="is_midreign",
 *  		description="Is (default false) the Office held between midreigns?",
 *  		type="integer",
 * 		format="enum",
 * 		enum={0, 1},
 * 		example=0,
 * 		default=0
 * 	),
 * 		@OA\Property(
 * 		property="order",
 * 		description="If the Realm has an order of precedence, the office level where Monarch = 1, else null",
 * 		type="integer",
 *  		format="int32",
 * 		nullable=true,
 * 		example=1
 * 	),
 * 	@OA\Property(
 * 		property="created_by",
 * 		description="The User that created this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true,
 * 		default=1
 * 	),
 * 	@OA\Property(
 * 		property="createdBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_by",
 * 		description="The last User to update this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updatedBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_by",
 * 		description="The User that softdeleted this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deletedBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="created_at",
 * 		description="When the entry was created.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_at",
 * 		description="When the entry was last updated.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_at",
 * 		description="When the entry was softdeleted.  Null if not softdeleted.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="officeable",
 * 		type="object",
 * 		description="Attachable object the Office is for.",
 * 		oneOf={
 * 			@OA\Schema(ref="#/components/schemas/ChaptertypeSimple"),
 * 			@OA\Schema(ref="#/components/schemas/RealmSimple"),
 * 			@OA\Schema(ref="#/components/schemas/UnitSimple")
 * 		},
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="officers",
 * 		description="Attachable & filterable array of Officers having held the Office.",
 * 		type="array",
 * 		@OA\Items(
 * 			title="Officer",
 * 			type="object",
 * 			ref="#/components/schemas/OfficerSimple"
 * 		),
 * 		readOnly=true
 * 	)
 * )
 * @OA\Schema (
 * 	schema="OfficeSimple",
 * 	title="OfficeSimple",
 * 	description="Attachable Office object with no attachments.",
 * 	@OA\Property(
 * 		property="id",
 * 		description="The entry's ID.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="officeable_type",
 * 		description="Type for what the Office is for; Chaptertype, Realm, or Unit.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="enum",
 * 		enum={"Chaptertype","Realm","Unit"},
 * 		example="Chaptertype"
 * 	),
 * 	@OA\Property(
 * 		property="officeable_id",
 * 		description="The ID of what the Office is for.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="name",
 * 		description="The name of the Office, options delineated with a single |",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="uppercase first letter",
 * 		example="Prime Minister",
 * 		maxLength=100
 * 	),
 * 		@OA\Property(
 *  		property="duration",
 *  		description="Duration, in months, of the office (default 6)",
 *  		type="integer",
 *  		format="int32",
 *  		nullable=true,
 *  		example=6,
 *  		default=6
 * 	),
 * 		@OA\Property(
 *  		property="is_forgiven",
 *  		description="Is (default false) the Persona credited Dues while holding this Office?",
 *  		type="integer",
 * 		format="enum",
 * 		enum={0, 1},
 * 		example=0,
 * 		default=0
 * 	),
 * 		@OA\Property(
 *  		property="is_midreign",
 *  		description="Is (default false) the Office held between midreigns?",
 *  		type="integer",
 * 		format="enum",
 * 		enum={0, 1},
 * 		example=0,
 * 		default=0
 * 	),
 * 		@OA\Property(
 * 		property="order",
 * 		description="If the Realm has an order of precedence, the office level where Monarch = 1, else null",
 * 		type="integer",
 *  		format="int32",
 * 		nullable=true,
 * 		example=1
 * 	),
 * 	@OA\Property(
 * 		property="created_by",
 * 		description="The User that created this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true,
 * 		default=1
 * 	),
 * 	@OA\Property(
 * 		property="updated_by",
 * 		description="The last User to update this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_by",
 * 		description="The User that softdeleted this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="created_at",
 * 		description="When the entry was created.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_at",
 * 		description="When the entry was last updated.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_at",
 * 		description="When the entry was softdeleted.  Null if not softdeleted.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	)
 * )
 * @OA\Schema (
 * 	schema="OfficeSuperSimple",
 * 	title="OfficeSuperSimple",
 * 	description="Attachable Office object with no attachments or CUD data.",
 * 	@OA\Property(
 * 		property="id",
 * 		description="The entry's ID.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="officeable_type",
 * 		description="Type for what the Office is for; Chaptertype, Realm, or Unit.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="enum",
 * 		enum={"Chaptertype","Realm","Unit"},
 * 		example="Chaptertype"
 * 	),
 * 	@OA\Property(
 * 		property="officeable_id",
 * 		description="The ID of what the Office is for.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="name",
 * 		description="The name of the Office, options delineated with a single |",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="uppercase first letter",
 * 		example="Prime Minister",
 * 		maxLength=100
 * 	),
 * 		@OA\Property(
 *  		property="duration",
 *  		description="Duration, in months, of the office (default 6)",
 *  		type="integer",
 *  		format="int32",
 *  		nullable=true,
 *  		example=6,
 *  		default=6
 * 	),
 * 		@OA\Property(
 *  		property="is_forgiven",
 *  		description="Is (default false) the Persona credited Dues while holding this Office?",
 *  		type="integer",
 * 		format="enum",
 * 		enum={0, 1},
 * 		example=0,
 * 		default=0
 * 	),
 * 		@OA\Property(
 *  		property="is_midreign",
 *  		description="Is (default false) the Office held between midreigns?",
 *  		type="integer",
 * 		format="enum",
 * 		enum={0, 1},
 * 		example=0,
 * 		default=0
 * 	),
 * 		@OA\Property(
 * 		property="order",
 * 		description="If the Realm has an order of precedence, the office level where Monarch = 1, else null",
 * 		type="integer",
 *  		format="int32",
 * 		nullable=true,
 * 		example=1
 * 	)
 * )
 * @OA\RequestBody (
 * 	request="Office",
 * 	description="Office object that needs to be added or updated.",
 * 	required=true,
 * 	@OA\MediaType(
 * 		mediaType="multipart/form-data",
 * 		@OA\Schema(ref="#/components/schemas/OfficeSimple")
 * 	)
 * )
 */

class Office extends BaseModel
{
	use SoftDeletes;
	use HasFactory;
	use Userstamps;
	use ProtectFieldsTrait;

	public $table = 'offices';
	public $timestamps = true;
	
	protected $dates = ['created_at', 'updated_at', 'deleted_at'];
	protected $protectedFields = ['officeable_type', 'officeable_id'];

	public $fillable = [
		'officeable_type',
		'officeable_id',
		'name',
		'duration',
		'is_forgiven',
		'is_midreign',
		'order'
	];

	protected $casts = [
		  'officeable_type' => 'string',
		  'name' => 'string'
	];

	public static array $rules = [
		'officeable_type' => 'required|in:Chaptertype,Realm,Unit',
		'officeable_id' => 'required',
		'name' => 'required|string|max:100',
		'duration' => 'nullable|integer',
		'is_forgiven' => 'boolean',
		'is_midreign' => 'boolean',
		'order' => 'nullable|integer'
	];
	
	public $relationships = [
		'officeable' => 'MorphTo',
		'officers' => 'HasMany'
	];
	
	public function officeable(): \Illuminate\Database\Eloquent\Relations\MorphTo
	{
		return $this->morphTo();
	}
	
	public function officers(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Officer::class, 'office_id');
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
