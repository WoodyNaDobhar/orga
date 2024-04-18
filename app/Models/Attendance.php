<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\ProtectFieldsTrait;
use Wildside\Userstamps\Userstamps;
/**
 * @OA\Schema(
 *		schema="Attendance",
 *		required={"persona_id","attendable_type","attendable_id","attended_at","credits"},
 *		description="Records of Attendance at an Event or Meetup.<br>The following relationships can be attached, and in the case of plural relations, searched:
 * attendable (Event or Meetup) (MorphTo): Event or Meetup the Attendance is for.
 * archetype (Archetype) (BelongsTo): Selected Archetype for the Attendance.
 * persona (Persona) (BelongsTo): Selected Persona receiveing the Attendance credit.
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
 *			description="Attendee Persona ID.",
 *			readOnly=false,
 *			nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="archetype_id",
 *			description="ID of the selected Archetype for the Attendance.",
 *			readOnly=false,
 *			nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="attendable_type",
 *			description="Where the Attendance occured; Meetup or Event",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="enum",
 *			enum={"Meetup","Event"},
 *			example="Meetup"
 *		),
 *		@OA\Property(
 *			property="attendable_id",
 *			description="The ID of where the Attendance occured.",
 *			readOnly=false,
 *			nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="attended_at",
 *			description="The date of the Attendance.",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="date-time",
 *			example="2020-12-30 23:59:59"
 *		),
 *		@OA\Property(
 *			property="credits",
 *			description="Credits (default 1) awarded for the Attendance",
 *			readOnly=false,
 *			nullable=false,
 *	 		type="number",
 *	 		format="float",
 *	 		example=1,
 *	 		default=1
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
 *			property="attendable",
 *			type="object",
 *			description="Attachable object that was attended.",
 *			oneOf={
 *				@OA\Schema(ref="#/components/schemas/MeetupSimple"),
 *				@OA\Schema(ref="#/components/schemas/EventSimple")
 *			},
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="archetype",
 *			type="object",
 *			description="Attachable Archetype for the Attendance.",
 *			ref="#/components/schemas/ArchetypeSimple",
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="persona",
 *			type="object",
 *			description="Attachable Persona receiveing the Attendance credit.",
 *			ref="#/components/schemas/PersonaSimple",
 *			readOnly=true
 *		)
 * )
 *	@OA\Schema(
 *		schema="AttendanceSimple",
 *		title="AttendanceSimple",
 *		description="Attachable Attendance object with no attachments.",
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
 *			description="Attendee Persona ID.",
 *			readOnly=false,
 *			nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="archetype_id",
 *			description="ID of the selected Archetype for the Attendance.",
 *			readOnly=false,
 *			nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="attendable_type",
 *			description="Where the Attendance occured; Meetup or Event",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="enum",
 *			enum={"Meetup","Event"},
 *			example="Meetup"
 *		),
 *		@OA\Property(
 *			property="attendable_id",
 *			description="The ID of where the Attendance occured.",
 *			readOnly=false,
 *			nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="attended_at",
 *			description="The date of the Attendance.",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="date-time",
 *			example="2020-12-30 23:59:59"
 *		),
 *		@OA\Property(
 *			property="credits",
 *			description="Credits (default 1) awarded for the Attendance",
 *			readOnly=false,
 *			nullable=false,
 *	 		type="number",
 *	 		format="float",
 *	 		default=1
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
 *		schema="AttendanceSuperSimple",
 *		title="AttendanceSuperSimple",
 *		description="Attachable Attendance object with no attachments or CUD data.",
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
 *			description="Attendee Persona ID.",
 *			readOnly=false,
 *			nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="archetype_id",
 *			description="ID of the selected Archetype for the Attendance.",
 *			readOnly=false,
 *			nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="attendable_type",
 *			description="Where the Attendance occured; Meetup or Event",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="enum",
 *			enum={"Meetup","Event"},
 *			example="Meetup"
 *		),
 *		@OA\Property(
 *			property="attendable_id",
 *			description="The ID of where the Attendance occured.",
 *			readOnly=false,
 *			nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="attended_at",
 *			description="The date of the Attendance.",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="date-time",
 *			example="2020-12-30 23:59:59"
 *		),
 *		@OA\Property(
 *			property="credits",
 *			description="Credits (default 1) awarded for the Attendance",
 *			readOnly=false,
 *			nullable=false,
 *	 		type="number",
 *	 		format="float",
 *	 		default=1
 *		)
 *	)
 *	@OA\RequestBody(
 *		request="Attendance",
 *		description="Attendance object that needs to be added or updated.",
 *		required=true,
 *		@OA\MediaType(
 *			mediaType="multipart/form-data",
 *			@OA\Schema(ref="#/components/schemas/AttendanceSimple")
 *		)
 *	)
 */

class Attendance extends BaseModel
{
	use SoftDeletes;
	use HasFactory;
	use Userstamps;
	use ProtectFieldsTrait;

	public $table = 'attendances';
	public $timestamps = true;
	
	protected $dates = ['created_at', 'updated_at', 'deleted_at'];
	protected $protectedFields = ['persona_id','attendable_type','attendable_id'];

	public $fillable = [
		  'persona_id',
		  'archetype_id',
		  'attendable_type',
		  'attendable_id',
		  'attended_at',
		  'credits'
	];

	protected $casts = [
		  'attendable_type' => 'string',
		  'attended_at' => 'date',
		  'credits' => 'float'
	];

	public static array $rules = [
		'archetype_id' => 'required|exists:archetypes,id',
		'attendable_type' => 'required|in:Meetup,Event',
		'attendable_id' => 'required',
		'persona_id' => 'required|exists:personas,id',
		'attended_at' => 'required|date',
		'credits' => 'numeric|between:0,9999.99',
	];
	
	public $relationships = [
		'archetype' => 'BelongsTo',
		'attendable' => 'MorphTo',
		'persona' => 'BelongsTo',
	];
	
	public function attendable(): \Illuminate\Database\Eloquent\Relations\MorphTo
	{
		return $this->morphTo();
	}

	public function archetype(): \Illuminate\Database\Eloquent\Relations\BelongsTo
	{
		  return $this->belongsTo(\App\Models\Archetype::class, 'archetype_id');
	}
	
	public function persona(): \Illuminate\Database\Eloquent\Relations\BelongsTo
	{
		return $this->belongsTo(\App\Models\Persona::class, 'persona_id');
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
