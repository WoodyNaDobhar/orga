<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Wildside\Userstamps\Userstamps;
use App\Traits\ProtectFieldsTrait;
/**
 * @OA\Schema(
 *		schema="Pronoun",
 *		required={"subject","object","possessive","possessivepronoun","reflexive"},
 *		description="Pronouns perfered.<br>The following relationships can be attached, and in the case of plural relations, searched:
 * personas (Persona) (HasMany): Personas using the Pronoun.
 * waivers (Waivers) (HasMany): Waivers using the Pronoun.
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
 *			property="subject",
 *			description="Pronoun Subject",
 *			readOnly=false,
 *			nullable=false,
 *			type="string"
 *		),
 *		@OA\Property(
 *			property="object",
 *			description="Pronoun Object",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *		),
 *		@OA\Property(
 *			property="possessive",
 *			description="Pronoun Possessive",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *		),
 *		@OA\Property(
 *			property="Pronoun Possessive Pronoun",
 *			description="",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *		),
 *		@OA\Property(
 *			property="Pronoun Reflexive",
 *			description="",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
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
 *		)
 *	)
 *	@OA\Schema(
 *		schema="PronounSimple",
 *		title="PronounSimple",
 *		description="Attachable Pronoun object with no attachments.",
 *		@OA\Property(
 *			property="id",
 *			description="The entry's ID.",
 *			type="integer",
 *			format="int32",
 *			example=42,
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="subject",
 *			description="Pronoun Subject",
 *			readOnly=false,
 *			nullable=false,
 *			type="string"
 *		),
 *		@OA\Property(
 *			property="object",
 *			description="Pronoun Object",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *		),
 *		@OA\Property(
 *			property="possessive",
 *			description="Pronoun Possessive",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *		),
 *		@OA\Property(
 *			property="Pronoun Possessive Pronoun",
 *			description="",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *		),
 *		@OA\Property(
 *			property="Pronoun Reflexive",
 *			description="",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
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
 *		schema="PronounSuperSimple",
 *		title="PronounSuperSimple",
 *		description="Attachable Pronoun object with no attachments or CUD data.",
 *		@OA\Property(
 *			property="id",
 *			description="The entry's ID.",
 *			type="integer",
 *			format="int32",
 *			example=42,
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="subject",
 *			description="Pronoun Subject",
 *			readOnly=false,
 *			nullable=false,
 *			type="string"
 *		),
 *		@OA\Property(
 *			property="object",
 *			description="Pronoun Object",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *		),
 *		@OA\Property(
 *			property="possessive",
 *			description="Pronoun Possessive",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *		),
 *		@OA\Property(
 *			property="Pronoun Possessive Pronoun",
 *			description="",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *		),
 *		@OA\Property(
 *			property="Pronoun Reflexive",
 *			description="",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *		)
 *	)
 *	@OA\RequestBody(
 *		request="Pronoun",
 *		description="Pronoun object that needs to be added or updated.",
 *		required=true,
 *		@OA\MediaType(
 *			mediaType="multipart/form-data",
 *			@OA\Schema(ref="#/components/schemas/PronounSimple")
 *		)
 *	)
 */

class Pronoun extends BaseModel
{
	use SoftDeletes;
	use HasFactory;
	use Userstamps;
	use ProtectFieldsTrait;

	public $table = 'pronouns';
	public $timestamps = true;
	
	protected $dates = ['created_at', 'updated_at', 'deleted_at'];
	protected $protectedFields = ['subject', 'object', 'possessive', 'possessivepronoun', 'reflexive'];

	public $fillable = [
		  'subject',
		  'object',
		  'possessive',
		  'possessivepronoun',
		  'reflexive'
	];

	protected $casts = [
		  'subject' => 'string',
		  'object' => 'string',
		  'possessive' => 'string',
		  'possessivepronoun' => 'string',
		  'reflexive' => 'string'
	];

	public static array $rules = [
		'subject' => 'required|string|max:30',
		'object' => 'required|string|max:30',
		'possessive' => 'required|string|max:30',
		'possessivepronoun' => 'required|string|max:30',
		'reflexive' => 'required|string|max:30'
	];
	
	public $relationships = [
		'personas' => 'HasMany',
		'waivers' => 'HasMany'
	];
	
	public function personas(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Persona::class, 'pronoun_id');
	}
	
	public function waivers(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Waiver::class, 'pronoun_id');
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
