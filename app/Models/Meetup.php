<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Wildside\Userstamps\Userstamps;
use App\Traits\ProtectFieldsTrait;
/**
 * @OA\Schema(
 *		schema="Meetup",
 *		required={"chapter_id","is_active","purpose","recurrence","week_day","occurs_at"},
 *		description="Regular gatherings for a given Chapter.<br>The following relationships can be attached, and in the case of plural relations, searched:
 * attendances (Attendance) (MorphMany): Attendances for the Meetup.
 * chapter (Chapter) (BelongsTo): Chapter that sponsors the Meetup.
 * issuances (Issuance) (MorphMany): Issuances made at the Meetup.
 * location (Location) (BelongsTo): Location of the Meetup.
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
 *			property="chapter_id",
 *			description="The ID of the Chapter hosting the Meetup.",
 *			readOnly=false,
 *			nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="location_id",
 *			description="The ID of the Location the Meetup occurs at.",
 *			readOnly=false,
 *			nullable=true,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="is_active",
 *			description="Is the Meetup (default true) still occuring?",
 *			readOnly=false,
 *			nullable=false,
 *			type="integer",
 *			format="enum",
 *			enum={0, 1},
 *			example=0,
 *			default=1
 *		),
 *		@OA\Property(
 *			property="purpose",
 *			description="The nature of the Meetup; Park Day, Fighter Practice, A&S Gathering, or Other.",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="enum",
 *			enum={"Park Day","Fighter Practice","A&S Gathering","Other"},
 *			example="Park Day"
 *		),
 *		@OA\Property(
 *			property="recurrence",
 *			description="The frequency with which this Meetup occurs",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="enum",
 *			enum={"Weekly","Monthly","Week-of-Month"},
 *			example="Weekly"
 *		),
 *		@OA\Property(
 *			property="week_of_month",
 *			description="The week of the month the Meetup occurs, if recurrence is Week-of-Month",
 *			readOnly=false,
 *			nullable=true,
 *			type="integer",
 *			example=2
 *		),
 *		@OA\Property(
 *			property="week_day",
 *			description="",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="enum",
 *			enum={"None","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"},
 *			example="Sunday"
 *		),
 *		@OA\Property(
 *			property="month_day",
 *			description="The day of the month the Meetup occurs, if recurrence is Monthly",
 *			readOnly=false,
 *			nullable=true,
 *			type="integer",
 *			example=2
 *		),
 *		@OA\Property(
 *			property="occurs_at",
 *			description="The time of day the Meetup takes place.",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="time",
 *			example="12:00:00"
 *		),
 *		@OA\Property(
 *			property="description",
 *			description="A description of the Meetup, if any.",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="paragraph",
 *			example="Join us for whacks!"
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
 *			property="attendances",
 *			description="Attachable & filterable array of Attendance for the Meetup.",
 *			type="array",
 *			@OA\Items(
 *				title="Attendance",
 *				type="object",
 *				ref="#/components/schemas/AttendanceSimple"
 *			),
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="chapter",
 *			type="object",
 *			description="Attachable Chapter that sponsors the Meetup.",
 *			ref="#/components/schemas/ChapterSimple",
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="issuances",
 *			description="Attachable & filterable array of Issuances made at the Meetup.",
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
 *			description="Attachable Location of the Meetup.",
 *			ref="#/components/schemas/LocationSimple",
 *			readOnly=true
 *		)
 * )
 *	@OA\Schema(
 *		schema="MeetupSimple",
 *		title="MeetupSimple",
 *		description="Attachable Meetup object with no attachments.",
 *		@OA\Property(
 *			property="id",
 *			description="The entry's ID.",
 *			type="integer",
 *			format="int32",
 *			example=42,
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="chapter_id",
 *			description="The ID of the Chapter hosting the Meetup.",
 *			readOnly=false,
 *			nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="location_id",
 *			description="The ID of the Location the Meetup occurs at.",
 *			readOnly=false,
 *			nullable=true,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="is_active",
 *			description="Is the Meetup (default true) still occuring?",
 *			readOnly=false,
 *			nullable=false,
 *			type="integer",
 *			format="enum",
 *			enum={0, 1},
 *			example=0,
 *			default=1
 *		),
 *		@OA\Property(
 *			property="purpose",
 *			description="The nature of the Meetup; Park Day, Fighter Practice, A&S Gathering, or Other.",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="enum",
 *			enum={"Park Day","Fighter Practice","A&S Gathering","Other"},
 *			example="Park Day"
 *		),
 *		@OA\Property(
 *			property="recurrence",
 *			description="The frequency with which this Meetup occurs",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="enum",
 *			enum={"Weekly","Monthly","Week-of-Month"},
 *			example="Weekly"
 *		),
 *		@OA\Property(
 *			property="week_of_month",
 *			description="The week of the month the Meetup occurs, if recurrence is Week-of-Month",
 *			readOnly=false,
 *			nullable=true,
 *			type="integer",
 *			example=2
 *		),
 *		@OA\Property(
 *			property="week_day",
 *			description="",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="enum",
 *			enum={"None","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"},
 *			example="Sunday"
 *		),
 *		@OA\Property(
 *			property="month_day",
 *			description="The day of the month the Meetup occurs, if recurrence is Monthly",
 *			readOnly=false,
 *			nullable=true,
 *			type="integer",
 *			example=2
 *		),
 *		@OA\Property(
 *			property="occurs_at",
 *			description="The time of day the Meetup takes place.",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="time",
 *			example="12:00:00"
 *		),
 *		@OA\Property(
 *			property="description",
 *			description="A description of the Meetup, if any.",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="paragraph",
 *			example="Join us for whacks!"
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
 *		schema="MeetupSuperSimple",
 *		title="MeetupSuperSimple",
 *		description="Attachable Meetup object with no attachments or CUD data.",
 *		@OA\Property(
 *			property="id",
 *			description="The entry's ID.",
 *			type="integer",
 *			format="int32",
 *			example=42,
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="chapter_id",
 *			description="The ID of the Chapter hosting the Meetup.",
 *			readOnly=false,
 *			nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="location_id",
 *			description="The ID of the Location the Meetup occurs at.",
 *			readOnly=false,
 *			nullable=true,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="is_active",
 *			description="Is the Meetup (default true) still occuring?",
 *			readOnly=false,
 *			nullable=false,
 *			type="integer",
 *			format="enum",
 *			enum={0, 1},
 *			example=0,
 *			default=1
 *		),
 *		@OA\Property(
 *			property="purpose",
 *			description="The nature of the Meetup; Park Day, Fighter Practice, A&S Gathering, or Other.",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="enum",
 *			enum={"Park Day","Fighter Practice","A&S Gathering","Other"},
 *			example="Park Day"
 *		),
 *		@OA\Property(
 *			property="recurrence",
 *			description="The frequency with which this Meetup occurs",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="enum",
 *			enum={"Weekly","Monthly","Week-of-Month"},
 *			example="Weekly"
 *		),
 *		@OA\Property(
 *			property="week_of_month",
 *			description="The week of the month the Meetup occurs, if recurrence is Week-of-Month",
 *			readOnly=false,
 *			nullable=true,
 *			type="integer",
 *			example=2
 *		),
 *		@OA\Property(
 *			property="week_day",
 *			description="",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="enum",
 *			enum={"None","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"},
 *			example="Sunday"
 *		),
 *		@OA\Property(
 *			property="month_day",
 *			description="The day of the month the Meetup occurs, if recurrence is Monthly",
 *			readOnly=false,
 *			nullable=true,
 *			type="integer",
 *			example=2
 *		),
 *		@OA\Property(
 *			property="occurs_at",
 *			description="The time of day the Meetup takes place.",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="time",
 *			example="12:00:00"
 *		),
 *		@OA\Property(
 *			property="description",
 *			description="A description of the Meetup, if any.",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="paragraph",
 *			example="Join us for whacks!"
 *		)
 *	)
 *	@OA\RequestBody(
 *		request="Meetup",
 *		description="Meetup object that needs to be added or updated.",
 *		required=true,
 *		@OA\MediaType(
 *			mediaType="multipart/form-data",
 *			@OA\Schema(ref="#/components/schemas/MeetupSimple")
 *		)
 *	)
 */

class Meetup extends BaseModel
{
	use SoftDeletes;
	use HasFactory;
	use Userstamps;
	use ProtectFieldsTrait;

	public $table = 'meetups';
	public $timestamps = true;
	
	protected $dates = ['created_at', 'updated_at', 'deleted_at'];
	protected $protectedFields = ['chapter_id', 'location_id', 'recurrence', 'week_of_month', 'week_day', 'month_day'];

	public $fillable = [
		  'chapter_id',
		  'location_id',
		  'is_active',
		  'purpose',
		  'recurrence',
		  'week_of_month',
		  'week_day',
		  'month_day',
		  'occurs_at',
		  'description'
	];

	protected $casts = [
		  'is_active' => 'boolean',
		  'purpose' => 'string',
		  'recurrence' => 'string',
		  'week_day' => 'string',
		  'description' => 'string'
	];

	public static array $rules = [
		'chapter_id' => 'required|exists:chapters,id',
		'location_id' => 'nullable|exists:locations,id',
		'is_active' => 'required|boolean',
		'purpose' => 'required|in:Park Day,Fighter Practice,A&S Gathering,Other',
		'recurrence' => 'required|in:Weekly,Monthly,Week-of-Month',
		'week_of_month' => 'nullable|integer|min:1|max:5',
		'week_day' => 'required_if:recurrence,Weekly|in:None,Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
		'month_day' => 'nullable|integer|min:1|max:31',
		'occurs_at' => 'required|date_format:H:i',
		'description' => 'nullable|string|max:191'
	];
	
	public $relationships = [
		'attendances' => 'MorphMany',
		'chapter' => 'BelongsTo',
		'issuances' => 'MorphMany',
		'location' => 'BelongsTo'
	];
	
	public function attendances(): \Illuminate\Database\Eloquent\Relations\MorphMany
	{
		return $this->morphMany(Attendance::class, 'attendable');
	}

	public function chapter(): \Illuminate\Database\Eloquent\Relations\BelongsTo
	{
		  return $this->belongsTo(\App\Models\Chapter::class, 'chapter_id');
	}
	
	public function issuances(): \Illuminate\Database\Eloquent\Relations\MorphMany
	{
		return $this->morphMany(Issuance::class, 'whereable');
	}
	
	public function location(): \Illuminate\Database\Eloquent\Relations\BelongsTo
	{
		return $this->belongsTo(\App\Models\Location::class, 'location_id');
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
