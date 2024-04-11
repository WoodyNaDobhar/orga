<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Wildside\Userstamps\Userstamps;
use App\Traits\ProtectFieldsTrait;
/**
 * @OA\Schema(
 *		schema="Waiver",
 *		required={"waiverable_type","waiverable_id","player","signed_at"},
 *		description="Digital storage of legal Waivers.<br>The following relationships can be attached, and in the case of plural relations, searched:
 * ageVerifiedBy (Persona) (BelongsTo): The Persona that verified the Waiver signer age, if it has been.
 * guests (Guest) (BelongsTo): The Guest this Waiver is for, if any.
 * location (Location) (BelongsTo): The Waiver address fields values.
 * persona (Persona) (BelongsTo): Persona this Waiver is for, if any.
 * pronoun (Pronoun) (BelongsTo): Pronoun for the individual being Waivered, if known.
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
 *			property="guest_id",
 *			description="The ID of the Guest this Waiver is for, if any.",
 *			readOnly=false,
 *			nullable=true,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="location_id",
 *			description="The Waiver address fields values.",
 *			readOnly=false,
 *			nullable=true,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="pronoun_id",
 *			description="The ID of the Pronoun for the individual being Waivered, if known.",
 *			readOnly=false,
 *			nullable=true,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="persona_id",
 *			description="The ID of the Persona this Waiver is for, if any.",
 *			readOnly=false,
 *			nullable=true,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="waiverable_type",
 *			description="The type of entity accepting the Waiver; Realm or Event.",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="enum",
 *			enum={"Realm","Event"},
 *			example="Realm"
 *		),
 *		@OA\Property(
 *			property="waiverable_id",
 *			description="The ID of the entity accepting the Waiver.",
 *			readOnly=false,
 *			nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="file",
 *			description="An internal link to an image of the original physical Waiver.",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="filename",
 *			example="images/waivers/42.jpg",
 *			maxLength=191
 *		),
 *		@OA\Property(
 *			property="player",
 *			description="The Waiver Mundane name field value.",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="uppercase first letter",
 *			example="John Smith",
 *			maxLength=150
 *		),
 *		@OA\Property(
 *			property="email",
 *			description="The Waiver email field value, if any",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="email",
 *			example="nobody@nowhere.net",
 *			maxLength=255
 *		),
 *		@OA\Property(
 *			property="phone",
 *			description="The Waiver phone field value, if any",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			maxLength=25,
 *			example="123-456-7890"
 *		),
 *		@OA\Property(
 *			property="dob",
 *			description="The Waiver date of birth field value.",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="date",
 *			example="2020-12-30"
 *		),
 *		@OA\Property(
 *			property="age_verified_at",
 *			description="The date the Waiver signer age is verified, if it has been.",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="date",
 *			example="2020-12-30"
 *		),
 *		@OA\Property(
 *			property="age_verified_by",
 *			description="The ID of the Persona that verified the Waiver signer age, if it has been.",
 *			readOnly=false,
 *			nullable=true,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="guardian",
 *			description="The Waiver guardian name, if any.",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="uppercase first letter",
 *			example="Richard Smith"
 *		),
 *		@OA\Property(
 *			property="emergency_name",
 *			description="The Waiver emergency contact field, if any.",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="uppercase first letter",
 *			example="Becky Smith"
 *		),
 *		@OA\Property(
 *			property="emergency_relationship",
 *			description="The Waiver emergency contact relationship field, if any.",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="uppercase first letter",
 *			example="Mom"
 *		),
 *		@OA\Property(
 *			property="emergency_phone",
 *			description="The Waiver emergency contact phone field, if any.",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			maxLength=25,
 *			example="123-456-7890"
 *		),
 *		@OA\Property(
 *			property="signed_at",
 *			description="Date the Waiver was signed.",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="date",
 *			example="2020-12-30"
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
 *			property="ageVerifiedBy",
 *			type="object",
 *			description="Attachable Persona the Waiver is for.",
 *			ref="#/components/schemas/PersonaSimple",
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="guest",
 *			type="object",
 *			description="Attachable Guest this Waiver is for.",
 *			ref="#/components/schemas/GuestSimple",
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="location",
 *			type="object",
 *			description="Attachable Waiver address fields values.",
 *			ref="#/components/schemas/LocationSimple",
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="persona",
 *			type="object",
 *			description="Attachable Persona this Waiver is for, if any.",
 *			ref="#/components/schemas/PersonaSimple",
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="pronoun",
 *			type="object",
 *			description="Attachable Pronoun for the individual being Waivered.",
 *			ref="#/components/schemas/PronounSimple",
 *			readOnly=true
 *		)
 * )
 *	@OA\Schema(
 *		schema="WaiverSimple",
 *		title="WaiverSimple",
 *		description="Attachable Waiver object with no attachments.",
 *		@OA\Property(
 *			property="id",
 *			description="The entry's ID.",
 *			type="integer",
 *			format="int32",
 *			example=42,
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="guest_id",
 *			description="The ID of the Guest this Waiver is for, if any.",
 *			readOnly=false,
 *			nullable=true,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="location_id",
 *			description="The Waiver address fields values.",
 *			readOnly=false,
 *			nullable=true,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="pronoun_id",
 *			description="The ID of the Pronoun for the individual being Waivered, if known.",
 *			readOnly=false,
 *			nullable=true,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="persona_id",
 *			description="The ID of the Persona this Waiver is for, if any.",
 *			readOnly=false,
 *			nullable=true,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="waiverable_type",
 *			description="The type of entity accepting the Waiver; Realm or Event.",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="enum",
 *			enum={"Realm","Event"},
 *			example="Realm"
 *		),
 *		@OA\Property(
 *			property="waiverable_id",
 *			description="The ID of the entity accepting the Waiver.",
 *			readOnly=false,
 *			nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="file",
 *			description="An internal link to an image of the original physical Waiver.",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="filename",
 *			example="images/waivers/42.jpg",
 *			maxLength=191
 *		),
 *		@OA\Property(
 *			property="player",
 *			description="The Waiver Mundane name field value.",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="uppercase first letter",
 *			example="John Smith",
 *			maxLength=150
 *		),
 *		@OA\Property(
 *			property="email",
 *			description="The Waiver email field value, if any",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="email",
 *			example="nobody@nowhere.net",
 *			maxLength=255
 *		),
 *		@OA\Property(
 *			property="phone",
 *			description="The Waiver phone field value, if any",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			maxLength=25,
 *			example="123-456-7890"
 *		),
 *		@OA\Property(
 *			property="dob",
 *			description="The Waiver date of birth field value.",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="date",
 *			example="2020-12-30"
 *		),
 *		@OA\Property(
 *			property="age_verified_at",
 *			description="The date the Waiver signer age is verified, if it has been.",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="date",
 *			example="2020-12-30"
 *		),
 *		@OA\Property(
 *			property="age_verified_by",
 *			description="The ID of the Persona that verified the Waiver signer age, if it has been.",
 *			readOnly=false,
 *			nullable=true,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="guardian",
 *			description="The Waiver guardian name, if any.",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="uppercase first letter",
 *			example="Richard Smith"
 *		),
 *		@OA\Property(
 *			property="emergency_name",
 *			description="The Waiver emergency contact field, if any.",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="uppercase first letter",
 *			example="Becky Smith"
 *		),
 *		@OA\Property(
 *			property="emergency_relationship",
 *			description="The Waiver emergency contact relationship field, if any.",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="uppercase first letter",
 *			example="Mom"
 *		),
 *		@OA\Property(
 *			property="emergency_phone",
 *			description="The Waiver emergency contact phone field, if any.",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			maxLength=25,
 *			example="123-456-7890"
 *		),
 *		@OA\Property(
 *			property="signed_at",
 *			description="Date the Waiver was signed.",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="date",
 *			example="2020-12-30"
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
 *		schema="WaiverSuperSimple",
 *		title="WaiverSuperSimple",
 *		description="Attachable Waiver object with no attachments or CUD data.",
 *		@OA\Property(
 *			property="id",
 *			description="The entry's ID.",
 *			type="integer",
 *			format="int32",
 *			example=42,
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="guest_id",
 *			description="The ID of the Guest this Waiver is for, if any.",
 *			readOnly=false,
 *			nullable=true,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="location_id",
 *			description="The Waiver address fields values.",
 *			readOnly=false,
 *			nullable=true,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="pronoun_id",
 *			description="The ID of the Pronoun for the individual being Waivered, if known.",
 *			readOnly=false,
 *			nullable=true,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="persona_id",
 *			description="The ID of the Persona this Waiver is for, if any.",
 *			readOnly=false,
 *			nullable=true,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="waiverable_type",
 *			description="The type of entity accepting the Waiver; Realm or Event.",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="enum",
 *			enum={"Realm","Event"},
 *			example="Realm"
 *		),
 *		@OA\Property(
 *			property="waiverable_id",
 *			description="The ID of the entity accepting the Waiver.",
 *			readOnly=false,
 *			nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="file",
 *			description="An internal link to an image of the original physical Waiver.",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="filename",
 *			example="images/waivers/42.jpg",
 *			maxLength=191
 *		),
 *		@OA\Property(
 *			property="player",
 *			description="The Waiver Mundane name field value.",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="uppercase first letter",
 *			example="John Smith",
 *			maxLength=150
 *		),
 *		@OA\Property(
 *			property="email",
 *			description="The Waiver email field value, if any",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="email",
 *			example="nobody@nowhere.net",
 *			maxLength=255
 *		),
 *		@OA\Property(
 *			property="phone",
 *			description="The Waiver phone field value, if any",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			maxLength=25,
 *			example="123-456-7890"
 *		),
 *		@OA\Property(
 *			property="dob",
 *			description="The Waiver date of birth field value.",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="date",
 *			example="2020-12-30"
 *		),
 *		@OA\Property(
 *			property="age_verified_at",
 *			description="The date the Waiver signer age is verified, if it has been.",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="date",
 *			example="2020-12-30"
 *		),
 *		@OA\Property(
 *			property="age_verified_by",
 *			description="The ID of the Persona that verified the Waiver signer age, if it has been.",
 *			readOnly=false,
 *			nullable=true,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="guardian",
 *			description="The Waiver guardian name, if any.",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="uppercase first letter",
 *			example="Richard Smith"
 *		),
 *		@OA\Property(
 *			property="emergency_name",
 *			description="The Waiver emergency contact field, if any.",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="uppercase first letter",
 *			example="Becky Smith"
 *		),
 *		@OA\Property(
 *			property="emergency_relationship",
 *			description="The Waiver emergency contact relationship field, if any.",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="uppercase first letter",
 *			example="Mom"
 *		),
 *		@OA\Property(
 *			property="emergency_phone",
 *			description="The Waiver emergency contact phone field, if any.",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			maxLength=25,
 *			example="123-456-7890"
 *		),
 *		@OA\Property(
 *			property="signed_at",
 *			description="Date the Waiver was signed.",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="date",
 *			example="2020-12-30"
 *		)
 *	)
 *	@OA\RequestBody(
 *		request="Waiver",
 *		description="Waiver object that needs to be added or updated.",
 *		required=true,
 *		@OA\MediaType(
 *			mediaType="multipart/form-data",
 *			@OA\Schema(ref="#/components/schemas/WaiverSimple")
 *		)
 *	)
 */

class Waiver extends BaseModel
{
	use SoftDeletes;
	use HasFactory;
	use Userstamps;
	use ProtectFieldsTrait;

	public $table = 'waivers';
	public $timestamps = true;
	
	protected $dates = ['created_at', 'updated_at', 'deleted_at'];
	protected $protectedFields = [];

	public $fillable = [
		  'pronoun_id',
		  'persona_id',
		  'waiverable_type',
		  'waiverable_id',
		  'file',
		  'player',
		  'email',
		  'phone',
		  'location_id',
		  'dob',
		  'age_verified_at',
		  'age_verified_by',
		  'guardian',
		  'emergency_name',
		  'emergency_relationship',
		  'emergency_phone',
		  'signed_at'
	];

	protected $casts = [
		  'waiverable_type' => 'string',
		  'file' => 'string',
		  'player' => 'string',
		  'email' => 'string',
		  'phone' => 'string',
		  'dob' => 'date',
		  'age_verified_at' => 'date',
		  'guardian' => 'string',
		  'emergency_name' => 'string',
		  'emergency_relationship' => 'string',
		  'emergency_phone' => 'string',
		  'signed_at' => 'date'
	];

	public static array $rules = [
		'pronoun_id' => 'nullable|exists:pronouns,id',
		'persona_id' => 'nullable|exists:personas,id',
		'waiverable_type' => 'required|string|in:Realm,Event',
		'waiverable_id' => 'required|exists:realms,id',
		'file' => 'nullable|string|max:191',
		'player' => 'required|string|max:150',
		'email' => 'nullable|string|email|max:255',
		'phone' => 'nullable|string|max:25',
		'location_id' => 'nullable|exists:locations,id',
		'dob' => 'nullable|date',
		'age_verified_at' => 'nullable|datetime',
		'age_verified_by' => 'nullable|exists:personas,id',
		'guardian' => 'nullable|string|max:150',
		'emergency_name' => 'nullable|string|max:150',
		'emergency_relationship' => 'nullable|string|max:150',
		'emergency_phone' => 'nullable|string|max:25',
		'signed_at' => 'required|date'
	];
	
	public $relationships = [
		'ageVerifiedBy' => 'BelongsTo',
		'guest' => 'BelongsTo',
		'location' => 'BelongsTo',
		'persona' => 'BelongsTo',
		'pronoun' => 'BelongsTo'
	];

	public function ageVerifiedBy(): \Illuminate\Database\Eloquent\Relations\BelongsTo
	{
		  return $this->belongsTo(\App\Models\Persona::class, 'age_verified_by');
	}
	
	public function guest(): \Illuminate\Database\Eloquent\Relations\BelongsTo
	{
		return $this->belongsTo(\App\Models\Guest::class, 'guest_id');
	}

	public function location(): \Illuminate\Database\Eloquent\Relations\BelongsTo
	{
		  return $this->belongsTo(\App\Models\Location::class, 'location_id');
	}

	public function persona(): \Illuminate\Database\Eloquent\Relations\BelongsTo
	{
		  return $this->belongsTo(\App\Models\Persona::class, 'persona_id');
	}

	public function pronoun(): \Illuminate\Database\Eloquent\Relations\BelongsTo
	{
		  return $this->belongsTo(\App\Models\Pronoun::class, 'pronoun_id');
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
