<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Wildside\Userstamps\Userstamps;
use App\Traits\ProtectFieldsTrait;
/**
 * @OA\Schema(
 *		schema="Reign",
 *		required={"reignable_type","starts_on","ends_on"},
 *		description="The rule of the Officer team is a Reign, typically six months.<br>The following relationships can be attached, and in the case of plural relations, searched:
 * officers (Officer) (MorphMany): Officers of the Reign.
 * reignable (Chapter or Realm) (MorphTo): The Reign type; Realm or Chapter.
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
 *			property="reignable_type",
 *			description="The Reign type; Chapter or Realm.",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="enum",
 *			enum={"Chapter","Realm"},
 *			example="Chapter"
 *		),
 *		@OA\Property(
 *			property="reignable_id",
 *			description="The ID of the Realm or Chapter this Reign is for.",
 *			readOnly=false,
 *			nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="name",
 *			description="The name of the Reign, if any",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="uppercase first letter",
 *			example="Reign XXXXII",
 *			maxLength=100
 *		),
 *		@OA\Property(
 *			property="starts_on",
 *			description="Date the Reign begins (coronation).",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="date",
 *			example="2020-12-30"
 *		),
 *		@OA\Property(
 *			property="midreign_on",
 *			description="Date of the Reign Midreign.",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="date",
 *			example="2020-03-30"
 *		),
 *		@OA\Property(
 *			property="ends_on",
 *			description="Date the next Reign begins, and this one ends.",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="date",
 *			example="2021-06-30"
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
 *			description="When the entry was softdeleted.  Null if not softdeleted.",
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
 *			property="officers",
 *			description="Attachable & filterable array of Officers of the Reign.",
 *			type="array",
 *			@OA\Items(
 *				title="Officer",
 *				type="object",
 *				ref="#/components/schemas/OfficerSimple"
 *			),
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="reignable",
 *			type="object",
 *			description="Attachable object the Reign is for.",
 *			oneOf={
 *				@OA\Schema(ref="#/components/schemas/ChapterSimple"),
 *				@OA\Schema(ref="#/components/schemas/RealmSimple")
 *			},
 *			readOnly=true
 *		)
 * )
 *	@OA\Schema(
 *		schema="ReignSimple",
 *		title="ReignSimple",
 *		description="Attachable Reign object with no attachments.",
 *		@OA\Property(
 *			property="id",
 *			description="The entry's ID.",
 *			type="integer",
 *			format="int32",
 *			example=42,
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="reignable_type",
 *			description="The Reign type; Chapter or Realm.",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="enum",
 *			enum={"Chapter","Realm"},
 *			example="Chapter"
 *		),
 *		@OA\Property(
 *			property="reignable_id",
 *			description="The ID of the Realm or Chapter this Reign is for.",
 *			readOnly=false,
 *			nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="name",
 *			description="The name of the Reign, if any",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="uppercase first letter",
 *			example="Reign XXXXII",
 *			maxLength=100
 *		),
 *		@OA\Property(
 *			property="starts_on",
 *			description="Date the Reign begins (coronation).",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="date",
 *			example="2020-12-30"
 *		),
 *		@OA\Property(
 *			property="midreign_on",
 *			description="Date of the Reign Midreign.",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="date",
 *			example="2020-03-30"
 *		),
 *		@OA\Property(
 *			property="ends_on",
 *			description="Date the next Reign begins, and this one ends.",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="date",
 *			example="2021-06-30"
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
 *		schema="ReignSuperSimple",
 *		title="ReignSuperSimple",
 *		description="Attachable Reign object with no attachments or CUD data.",
 *		@OA\Property(
 *			property="id",
 *			description="The entry's ID.",
 *			type="integer",
 *			format="int32",
 *			example=42,
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="reignable_type",
 *			description="The Reign type; Chapter or Realm.",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="enum",
 *			enum={"Chapter","Realm"},
 *			example="Chapter"
 *		),
 *		@OA\Property(
 *			property="reignable_id",
 *			description="The ID of the Realm or Chapter this Reign is for.",
 *			readOnly=false,
 *			nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="name",
 *			description="The name of the Reign, if any",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="uppercase first letter",
 *			example="Reign XXXXII",
 *			maxLength=100
 *		),
 *		@OA\Property(
 *			property="starts_on",
 *			description="Date the Reign begins (coronation).",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="date",
 *			example="2020-12-30"
 *		),
 *		@OA\Property(
 *			property="midreign_on",
 *			description="Date of the Reign Midreign.",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="date",
 *			example="2020-03-30"
 *		),
 *		@OA\Property(
 *			property="ends_on",
 *			description="Date the next Reign begins, and this one ends.",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="date",
 *			example="2021-06-30"
 *		)
 *	)
 *	@OA\RequestBody(
 *		request="Reign",
 *		description="Reign object that needs to be added or updated.",
 *		required=true,
 *		@OA\MediaType(
 *			mediaType="multipart/form-data",
 *			@OA\Schema(ref="#/components/schemas/ReignSimple")
 *		)
 *	)
 */

class Reign extends BaseModel
{
	use SoftDeletes;
	use HasFactory;
	use Userstamps;
	use ProtectFieldsTrait;

	public $table = 'reigns';
	public $timestamps = true;
	
	protected $dates = ['created_at', 'updated_at', 'deleted_at'];
	protected $protectedFields = ['reignable_type','reignable_id'];

	public $fillable = [
		  'reignable_type',
		  'reignable_id',
		  'name',
		  'starts_on',
		  'ends_on'
	];

	protected $casts = [
		  'reignable_type' => 'string',
		  'name' => 'string',
		  'starts_on' => 'date',
		  'ends_on' => 'date'
	];

	public static array $rules = [
		'reignable_type' => 'required|in:Realm,Chapter',
		'reignable_id' => 'nullable',
		'name' => 'nullable|string|max:100',
		'starts_on' => 'required|date',
		'midreign_on' => 'required|date',
		'ends_on' => 'required|date|after:midreign_on'
	];
	
	public $relationships = [
		'officers' => 'MorphMany',
		'reignable' => 'MorphTo'
	];
	
	public function reignable(): \Illuminate\Database\Eloquent\Relations\MorphTo
	{
		return $this->morphTo();
	}
	
	public function officers(): \Illuminate\Database\Eloquent\Relations\MorphMany
	{
		return $this->morphMany(Officer::class, 'officerable');
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
