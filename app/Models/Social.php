<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Wildside\Userstamps\Userstamps;
use App\Traits\ProtectFieldsTrait;
/**
 * @OA\Schema(
 *		schema="Social",
 *		required={"sociable_type","media","value"},
 *		description="Various web and app accounts and links associated with a Chapter, Event, Persona, Realm, or Unit.<br>The following relationships can be attached, and in the case of plural relations, searched:
 * sociable (Social) (MorphTo): Model the Social is being attached to.
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
 *			property="sociable_type",
 *			description="The Model for which the Social is for; Chapter, Event, Persona, Realm, or Unit.",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="enum",
 *			enum={"Chapter","Event","Persona","Realm","Unit"},
 *			example="Chapter"
 *		),
 *		@OA\Property(
 *			property="sociable_id",
 *			description="The ID of the entry with this Social.",
 *			readOnly=false,
 *			nullable=true,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="media",
 *			description="The type of Social; Discord, Facebook, Instagram, TicToc, YouTube, or Web",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="enum",
 *			enum={"Discord","Facebook","Instagram","TicToc","YouTube","Web"},
 *			example="Web"
 *		),
 *		@OA\Property(
 *			property="value",
 *			description="The link, username, or other identifier for the given media.",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			example="https://ork.amtgard.com",
 *			maxLength=255
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
 *			property="sociable",
 *			type="object",
 *			allOf={
 *				@OA\Property(
 *					title="Social",
 *					description="Attachable model the Social is being attached to."
 *				),
 *				@OA\Schema(ref="#/components/schemas/SocialSimple"),
 *			},
 *			readOnly=true
 *		)
 * )
 *	@OA\Schema(
 *		schema="SocialSimple",
 *		@OA\Property(
 *			property="id",
 *			description="The entry's ID.",
 *			type="integer",
 *			format="int32",
 *			example=42,
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="sociable_type",
 *			description="The Model for which the Social is for; Chapter, Event, Persona, Realm, or Unit.",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="enum",
 *			enum={"Chapter","Event","Persona","Realm","Unit"},
 *			example="Chapter"
 *		),
 *		@OA\Property(
 *			property="sociable_id",
 *			description="The ID of the entry with this Social.",
 *			readOnly=false,
 *			nullable=true,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="media",
 *			description="The type of Social; Discord, Facebook, Instagram, TicToc, YouTube, or Web",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="enum",
 *			enum={"Discord","Facebook","Instagram","TicToc","YouTube","Web"},
 *			example="Web"
 *		),
 *		@OA\Property(
 *			property="value",
 *			description="The link, username, or other identifier for the given media.",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			example="https://ork.amtgard.com",
 *			maxLength=255
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
 *		schema="SocialSuperSimple",
 *		@OA\Property(
 *			property="id",
 *			description="The entry's ID.",
 *			type="integer",
 *			format="int32",
 *			example=42,
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="sociable_type",
 *			description="The Model for which the Social is for; Chapter, Event, Persona, Realm, or Unit.",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="enum",
 *			enum={"Chapter","Event","Persona","Realm","Unit"},
 *			example="Chapter"
 *		),
 *		@OA\Property(
 *			property="sociable_id",
 *			description="The ID of the entry with this Social.",
 *			readOnly=false,
 *			nullable=true,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="media",
 *			description="The type of Social; Discord, Facebook, Instagram, TicToc, YouTube, or Web",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="enum",
 *			enum={"Discord","Facebook","Instagram","TicToc","YouTube","Web"},
 *			example="Web"
 *		),
 *		@OA\Property(
 *			property="value",
 *			description="The link, username, or other identifier for the given media.",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			example="https://ork.amtgard.com",
 *			maxLength=255
 *		)
 *	)
 *	@OA\RequestBody(
 *		request="Social",
 *		description="Social object that needs to be added or updated.",
 *		required=true,
 *		@OA\MediaType(
 *			mediaType="multipart/form-data",
 *			@OA\Schema(ref="#/components/schemas/SocialSimple")
 *		)
 *	)
 */

class Social extends BaseModel
{
	use SoftDeletes;
	use HasFactory;
	use Userstamps;
	use ProtectFieldsTrait;

	public $table = 'socials';
	public $timestamps = true;
	
	protected $dates = ['created_at', 'updated_at', 'deleted_at'];
	protected $protectedFields = ['sociable_type'];

	public $fillable = [
		  'sociable_type',
		  'sociable_id',
		  'media',
		  'value'
	];

	protected $casts = [
		  'sociable_type' => 'string',
		  'media' => 'string',
		  'value' => 'string'
	];

	public static array $rules = [
		'sociable_type' => 'required|in:Realm,Chapter,Event,Unit,Persona',
		'sociable_id' => 'nullable',
		'media' => 'required|in:Web,Facebook,Discord,Instagram,YouTube,TicToc',
		'value' => 'required|string|max:255'
	];
	
	public $relationships = [
		'sociable' => 'MorphTo'
	];
	
	public function sociable(): \Illuminate\Database\Eloquent\Relations\MorphTo
	{
		return $this->morphTo();
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
