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
 *			property="attendable",
 *			type="object",
 *			oneOf={
 *				@OA\Property(
 *					title="Meetup",
 *					description="Attachable Meetup that was attended.",
 *					@OA\Schema(ref="#/components/schemas/MeetupSimple")
 *				),
 *				@OA\Property(
 *					title="Event",
 *					description="Attachable Event that was attended.",
 *					@OA\Schema(ref="#/components/schemas/EventSimple")
 *				)
 *			},
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="archetype",
 *			type="object",
 *			allOf={
 *				@OA\Property(
 *					title="Archetype",
 *					description="Attachable Archetype for the Attendance."
 *				),
 *				@OA\Schema(ref="#/components/schemas/ArchetypeSimple"),
 *			},
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="persona",
 *			type="object",
 *			allOf={
 *				@OA\Property(
 *					title="Persona",
 *					description="Attachable Persona receiveing the Attendance credit."
 *				),
 *				@OA\Schema(ref="#/components/schemas/PersonaSimple"),
 *			},
 *			readOnly=true
 *		)
 * )
 *	@OA\Schema(
 *		schema="AttendanceSimple",
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
 *		)
 *	)
 *	@OA\Schema(
 *		schema="AttendanceSuperSimple",
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
