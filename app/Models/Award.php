<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\ProtectFieldsTrait;
use Wildside\Userstamps\Userstamps;
/**
 * @OA\Schema(
 *		schema="Award",
 *		required={"awarder_type","name","is_ladder"},
 *		description="Awards available in a given (or all) Realm(s), Chapter, or Unit.<br>The following relationships can be attached, and in the case of plural relations, searched:
 * awarder (Chapter, Realm, or Unit) (MorphTo): The Realm, Chapter, or Unit that Issues this Award.
 * issuances (Issuance) (MorphMany): Issuances of this Award.
 * personas (Persona) (MorphMany): Personas that have received this Award.
 * recommendations (Recommendation) (MorphMany): Recommendations to Issue this Award.
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
 *			property="awarder_type",
 *			description="Who issues the Award; Realm, Chapter, or Unit.",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="enum",
 *			enum={"Realm","Chapter","Unit"},
 *			example="Realm"
 *		),
 *		@OA\Property(
 *			property="awarder_id",
 *			description="The ID of the award issuer, null for all.",
 *			readOnly=false,
 *			nullable=true,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="name",
 *			description="The Award label, with options for the label seperated with |.",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="uppercase first letter",
 *			example="Order of the Rose",
 *			maxLength=100
 *		),
 *		@OA\Property(
 *			property="is_ladder",
 *			description="Is this (default false) a ranked/ladder award?",
 *			readOnly=false,
 *			nullable=false,
 *			type="integer",
 *			format="enum",
 *			enum={0, 1},
 *			example=0,
 *			default=0
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
 *			property="awarder",
 *			type="object",
 *			description="Attachable object that Issues the Award.",
 *			oneOf={
 *				@OA\Schema(ref="#/components/schemas/RealmSimple"),
 *				@OA\Schema(ref="#/components/schemas/ChapterSimple"),
 *				@OA\Schema(ref="#/components/schemas/UnitSimple")
 *			},
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="issuances",
 *			description="Attachable & filterable array of Issuances of this Award.",
 *			type="array",
 *			@OA\Items(
 *				title="Issuance",
 *				type="object",
 *				ref="#/components/schemas/IssuanceSimple"
 *			),
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="recommendations",
 *			description="Attachable & filterable array of Recommendations to Issue this Award.",
 *			type="array",
 *			@OA\Items(
 *				title="Recommendation",
 *				type="object",
 *				ref="#/components/schemas/RecommendationSimple"
 *			),
 *			readOnly=true
 *		)
 * )
 *	@OA\Schema(
 *		schema="AwardSimple",
 *		title="AwardSimple",
 *		description="Attachable Award object with no attachments.",
 *		@OA\Property(
 *			property="id",
 *			description="The entry's ID.",
 *			type="integer",
 *			format="int32",
 *			example=42,
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="awarder_type",
 *			description="Who issues the Award; Realm, Chapter, or Unit.",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="enum",
 *			enum={"Realm","Chapter","Unit"},
 *			example="Realm"
 *		),
 *		@OA\Property(
 *			property="awarder_id",
 *			description="The ID of the award issuer, null for all.",
 *			readOnly=false,
 *			nullable=true,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="name",
 *			description="The Award label, with options for the label seperated with |.",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="uppercase first letter",
 *			example="Order of the Rose",
 *			maxLength=100
 *		),
 *		@OA\Property(
 *			property="is_ladder",
 *			description="Is this (default false) a ranked/ladder award?",
 *			readOnly=false,
 *			nullable=false,
 *			type="integer",
 *			format="enum",
 *			enum={0, 1},
 *			example=0,
 *			default=0
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
 *		schema="AwardSuperSimple",
 *		title="AwardSuperSimpleSimple",
 *		description="Attachable Award object with no attachments or CUD data.",
 *		@OA\Property(
 *			property="id",
 *			description="The entry's ID.",
 *			type="integer",
 *			format="int32",
 *			example=42,
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="awarder_type",
 *			description="Who issues the Award; Realm, Chapter, or Unit.",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="enum",
 *			enum={"Realm","Chapter","Unit"},
 *			example="Realm"
 *		),
 *		@OA\Property(
 *			property="awarder_id",
 *			description="The ID of the award issuer, null for all.",
 *			readOnly=false,
 *			nullable=true,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="name",
 *			description="The Award label, with options for the label seperated with |.",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="uppercase first letter",
 *			example="Order of the Rose",
 *			maxLength=100
 *		),
 *		@OA\Property(
 *			property="is_ladder",
 *			description="Is this (default false) a ranked/ladder award?",
 *			readOnly=false,
 *			nullable=false,
 *			type="integer",
 *			format="enum",
 *			enum={0, 1},
 *			example=0,
 *			default=0
 *		)
 *	)
 *	@OA\RequestBody(
 *		request="Award",
 *		description="Award object that needs to be added or updated.",
 *		required=true,
 *		@OA\MediaType(
 *			mediaType="multipart/form-data",
 *			@OA\Schema(ref="#/components/schemas/AwardSimple")
 *		)
 *	)
 */

class Award extends BaseModel
{
	use SoftDeletes;
	use HasFactory;
	use Userstamps;
	use ProtectFieldsTrait;

	public $table = 'awards';
	public $timestamps = true;
	
	protected $dates = ['created_at', 'updated_at', 'deleted_at'];
	protected $protectedFields = ['awarder_type', 'awarder_id'];

	public $fillable = [
		'awarder_type',
		'awarder_id',
		'name',
		'is_ladder'
	];

	protected $casts = [
		'awarder_type' => 'string',
		'awarder_id' => 'integer',
		'name' => 'string',
		'is_ladder' => 'boolean'
	];

	public static array $rules = [
		'awarder_type' => 'required|string|in:Realm,Chapter,Unit',
		'awarder_id' => 'nullable',
		'name' => 'required|string|max:100',
		'is_ladder' => 'required|boolean'
	];
	
	public $relationships = [
		'awarder' => 'MorphTo',
		'issuances' => 'MorphMany',
		'personas' => 'MorphMany',
		'recommendations' => 'MorphMany'
	];
	
	public function awarder(): \Illuminate\Database\Eloquent\Relations\MorphTo
	{
//	 	if($this->awarder_id){
			return $this->morphTo();
//	 	}
//	 	return null;
	}
	
	public function issuances(): \Illuminate\Database\Eloquent\Relations\MorphMany
	{
		return $this->morphMany(Issuance::class, 'issuable');
	}
	
	public function personas(): \Illuminate\Database\Eloquent\Relations\MorphMany
	{
		return $this->morphMany(Persona::class, 'issuable', 'issuable_type', 'issuable_id', 'id');
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
