<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Wildside\Userstamps\Userstamps;
use App\Traits\ProtectFieldsTrait;
/**
 * @OA\Schema(
 *		schema="Officer",
 *		required={"officerable_type","officerable_id","office_id","persona_id"},
 *		description="Officers for the given Reign or Unit<br>The following relationships can be attached, and in the case of plural relations, searched:
 * office (Office) (BelongsTo): Office held.
 * officerable (Reign or Unit) (MorphTo): Reign or Unit the Persona is an Officer of.
 * persona (Persona) (BelongsTo): Persona holding the given Office.
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
 *			property="officerable_type",
 *			description="Type of that which the Persona is Officer of; Reign or Unit.",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="enum",
 *			enum={"Reign","Unit"},
 *			example="Reign"
 *		),
 *		@OA\Property(
 *			property="officerable_id",
 *			description="The ID of the Reign or Unit they are Officer of.",
 *			readOnly=false,
 *			nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="office_id",
 *			description="The ID of the Office this Persona held.",
 *			readOnly=false,
 *			nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="persona_id",
 *			description="The ID of the Persona holding this Office.",
 *			readOnly=false,
 *			nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="label",
 *			description="If the Office name has options, or allows customization, the selected label, if any.",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="capitalize first letter",
 *			example="Queen",
 *			maxLength=50
 *		),
 *		@OA\Property(
 *			property="starts_on",
 *			description="If the Officer is pro-tem, or is for a Unit, when the Office began, otherwise null to use Reign data.",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="date",
 *			example="2020-12-30"
 *		),
 *		@OA\Property(
 *			property="ends_on",
 *			description="If the Officer ends their term early, or is for a Unit, when the Office was exited, otherwise null to use Reign data.",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="date",
 *			example="2020-12-30"
 *		),
 *		@OA\Property(
 *			property="notes",
 *			description="Notes about the Officer or their time in office, or explaining pro-tem, if any",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="paragraph",
 *			example="Took over after the last guy got banned.",
 *			maxLength=191
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
 *			property="office",
 *			type="object",
 *			description="Attachable Office held.",
 *			ref="#/components/schemas/OfficeSimple",
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="officerable",
 *			type="object",
 *			description="Attachable object the Persona is an Officer of.",
 *			oneOf={
 *				@OA\Schema(ref="#/components/schemas/ReignSimple"),
 *				@OA\Schema(ref="#/components/schemas/UnitSimple")
 *			},
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="persona",
 *			type="object",
 *			description="Attachable Persona holding the given Office.",
 *			ref="#/components/schemas/PersonaSimple",
 *			readOnly=true
 *		)
 * )
 *	@OA\Schema(
 *		schema="OfficerSimple",
 *		title="OfficerSimple",
 *		description="Attachable Officer object with no attachments.",
 *		@OA\Property(
 *			property="id",
 *			description="The entry's ID.",
 *			type="integer",
 *			format="int32",
 *			example=42,
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="officerable_type",
 *			description="Type of that which the Persona is Officer of; Reign or Unit.",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="enum",
 *			enum={"Reign","Unit"},
 *			example="Reign"
 *		),
 *		@OA\Property(
 *			property="officerable_id",
 *			description="The ID of the Reign or Unit they are Officer of.",
 *			readOnly=false,
 *			nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="office_id",
 *			description="The ID of the Office this Persona held.",
 *			readOnly=false,
 *			nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="persona_id",
 *			description="The ID of the Persona holding this Office.",
 *			readOnly=false,
 *			nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="label",
 *			description="If the Office name has options, or allows customization, the selected label, if any.",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="capitalize first letter",
 *			example="Queen",
 *			maxLength=50
 *		),
 *		@OA\Property(
 *			property="starts_on",
 *			description="If the Officer is pro-tem, or is for a Unit, when the Office began, otherwise null to use Reign data.",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="date",
 *			example="2020-12-30"
 *		),
 *		@OA\Property(
 *			property="ends_on",
 *			description="If the Officer ends their term early, or is for a Unit, when the Office was exited, otherwise null to use Reign data.",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="date",
 *			example="2020-12-30"
 *		),
 *		@OA\Property(
 *			property="notes",
 *			description="Notes about the Officer or their time in office, or explaining pro-tem, if any",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="paragraph",
 *			example="Took over after the last guy got banned.",
 *			maxLength=191
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
 *		schema="OfficerSuperSimple",
 *		title="OfficerSuperSimple",
 *		description="Attachable Officer object with no attachments or CUD data.",
 *		@OA\Property(
 *			property="id",
 *			description="The entry's ID.",
 *			type="integer",
 *			format="int32",
 *			example=42,
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="officerable_type",
 *			description="Type of that which the Persona is Officer of; Reign or Unit.",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="enum",
 *			enum={"Reign","Unit"},
 *			example="Reign"
 *		),
 *		@OA\Property(
 *			property="officerable_id",
 *			description="The ID of the Reign or Unit they are Officer of.",
 *			readOnly=false,
 *			nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="office_id",
 *			description="The ID of the Office this Persona held.",
 *			readOnly=false,
 *			nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="persona_id",
 *			description="The ID of the Persona holding this Office.",
 *			readOnly=false,
 *			nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="label",
 *			description="If the Office name has options, or allows customization, the selected label, if any.",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="capitalize first letter",
 *			example="Queen",
 *			maxLength=50
 *		),
 *		@OA\Property(
 *			property="starts_on",
 *			description="If the Officer is pro-tem, or is for a Unit, when the Office began, otherwise null to use Reign data.",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="date",
 *			example="2020-12-30"
 *		),
 *		@OA\Property(
 *			property="ends_on",
 *			description="If the Officer ends their term early, or is for a Unit, when the Office was exited, otherwise null to use Reign data.",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="date",
 *			example="2020-12-30"
 *		),
 *		@OA\Property(
 *			property="notes",
 *			description="Notes about the Officer or their time in office, or explaining pro-tem, if any",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="paragraph",
 *			example="Took over after the last guy got banned.",
 *			maxLength=191
 *		)
 *	)
 *	@OA\RequestBody(
 *		request="Officer",
 *		description="Officer object that needs to be added or updated.",
 *		required=true,
 *		@OA\MediaType(
 *			mediaType="multipart/form-data",
 *			@OA\Schema(ref="#/components/schemas/OfficerSimple")
 *		)
 *	)
 */

class Officer extends BaseModel
{
	use SoftDeletes;
	use HasFactory;
	use Userstamps;
	use ProtectFieldsTrait;

	public $table = 'officers';
	public $timestamps = true;
	
	protected $dates = ['created_at', 'updated_at', 'deleted_at'];
	protected $protectedFields = ['officerable_type', 'officerable_id', 'office_id', 'persona_id'];

	public $fillable = [
		  'officerable_type',
		  'officerable_id',
		  'office_id',
		  'persona_id',
		  'label',
		  'starts_on',
		  'ends_on',
		  'notes'
	];

	protected $casts = [
		  'officerable_type' => 'string',
		  'label' => 'string',
		  'starts_on' => 'date',
		  'ends_on' => 'date',
		  'notes' => 'string'
	];

	public static array $rules = [
		'officerable_type' => 'required|in:Reign,Unit',
		'officerable_id' => 'required',
		'office_id' => 'required|exists:offices,id',
		'persona_id' => 'required|exists:personas,id',
		'label' => 'nullable|string|max:50',
		'starts_on' => 'nullable|date',
		'ends_on' => 'nullable|date|after_or_equal:starts_on',
		'notes' => 'nullable|string|max:191'
	];
	
	public $relationships = [
		'office' => 'BelongsTo',
		'officerable' => 'MorphTo',
		'persona' => 'BelongsTo'
	];
	
	public function office(): \Illuminate\Database\Eloquent\Relations\BelongsTo
	{
		return $this->belongsTo(\App\Models\Office::class, 'office_id');
	}
	
	public function officerable(): \Illuminate\Database\Eloquent\Relations\MorphTo
	{
		return $this->morphTo();
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
