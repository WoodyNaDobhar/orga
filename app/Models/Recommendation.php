<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Wildside\Userstamps\Userstamps;
use App\Traits\ProtectFieldsTrait;
/**
 * @OA\Schema(
 *		schema="Recommendation",
 *		required={"persona_id","recommendable_type","is_anonymous","reason"},
 *		description="Recommendations for Personas to be Issued an Award or Title.<br>The following relationships can be attached, and in the case of plural relations, searched:
 * persona (Persona) (BelongsTo): Persona the Recommendation is for.
 * recommendable (Award or Title) (MorphTo): The Type of Issuances being Recommended; Award or Title.
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
 *			description="The ID of the Persona the Recommendation is for.",
 *			readOnly=false,
 *			nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="recommendable_type",
 *			description="The type of Issuances being Recommended; Award or Title.",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="enum",
 *			enum={"Award","Title"},
 *			example="Award"
 *		),
 *		@OA\Property(
 *			property="recommendable_id",
 *			description="The ID of the Title or Award being Recommended.",
 *			readOnly=false,
 *			nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="rank",
 *			description="If a ranked or ladder award, Recommended level.",
 *			readOnly=false,
 *			nullable=true,
 *			type="integer",
 *			format="int32",
 *			example=3
 *		),
 *		@OA\Property(
 *			property="is_anonymous",
 *			description="Does (default false) the Recommendation creator wish to be anonymous?",
 *			readOnly=false,
 *			nullable=false,
 *			type="integer",
 *			format="enum",
 *			enum={0, 1},
 *			example=0,
 *			default=1
 *		),
 *		@OA\Property(
 *			property="reason",
 *			description="What the Recommendation is for.",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="paragraph",
 *			example="Being teh awesome!",
 *			maxLength=400
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
 *			property="persona",
 *			type="object",
 *			description="Attachable Persona the Recommendation is for.",
 *			ref="#/components/schemas/PersonaSimple",
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="recommendable",
 *			type="object",
 *			description="Attachable object being Recommended.",
 *			oneOf={
 *				@OA\Schema(ref="#/components/schemas/AwardSimple"),
 *				@OA\Schema(ref="#/components/schemas/TitleSimple")
 *			},
 *			readOnly=true
 *		)
 *	)
 *	@OA\Schema(
 *		schema="RecommendationSimple",
 *		title="RecommendationSimple",
 *		description="Attachable Recommendation object with no attachments.",
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
 *			description="The ID of the Persona the Recommendation is for.",
 *			readOnly=false,
 *			nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="recommendable_type",
 *			description="The type of Issuances being Recommended; Award or Title.",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="enum",
 *			enum={"Award","Title"},
 *			example="Award"
 *		),
 *		@OA\Property(
 *			property="recommendable_id",
 *			description="The ID of the Title or Award being Recommended.",
 *			readOnly=false,
 *			nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="rank",
 *			description="If a ranked or ladder award, Recommended level.",
 *			readOnly=false,
 *			nullable=true,
 *			type="integer",
 *			format="int32",
 *			example=3
 *		),
 *		@OA\Property(
 *			property="is_anonymous",
 *			description="Does (default false) the Recommendation creator wish to be anonymous?",
 *			readOnly=false,
 *			nullable=false,
 *			type="integer",
 *			format="enum",
 *			enum={0, 1},
 *			example=0,
 *			default=1
 *		),
 *		@OA\Property(
 *			property="reason",
 *			description="What the Recommendation is for.",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="paragraph",
 *			example="Being teh awesome!",
 *			maxLength=400
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
 *		schema="RecommendationSuperSimple",
 *		title="RecommendationSuperSimpleSimple",
 *		description="Attachable Recommendation object with no attachments or CUD data.",
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
 *			description="The ID of the Persona the Recommendation is for.",
 *			readOnly=false,
 *			nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="recommendable_type",
 *			description="The type of Issuances being Recommended; Award or Title.",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="enum",
 *			enum={"Award","Title"},
 *			example="Award"
 *		),
 *		@OA\Property(
 *			property="recommendable_id",
 *			description="The ID of the Title or Award being Recommended.",
 *			readOnly=false,
 *			nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="rank",
 *			description="If a ranked or ladder award, Recommended level.",
 *			readOnly=false,
 *			nullable=true,
 *			type="integer",
 *			format="int32",
 *			example=3
 *		),
 *		@OA\Property(
 *			property="is_anonymous",
 *			description="Does (default false) the Recommendation creator wish to be anonymous?",
 *			readOnly=false,
 *			nullable=false,
 *			type="integer",
 *			format="enum",
 *			enum={0, 1},
 *			example=0,
 *			default=1
 *		),
 *		@OA\Property(
 *			property="reason",
 *			description="What the Recommendation is for.",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="paragraph",
 *			example="Being teh awesome!",
 *			maxLength=400
 *		)
 *	)
 *	@OA\RequestBody(
 *		request="Recommendation",
 *		description="Recommendation object that needs to be added or updated.",
 *		required=true,
 *		@OA\MediaType(
 *			mediaType="multipart/form-data",
 *			@OA\Schema(ref="#/components/schemas/RecommendationSimple")
 *		)
 *	)
 */

class Recommendation extends BaseModel
{
	use SoftDeletes;
	use HasFactory;
	use Userstamps;
	use ProtectFieldsTrait;

	public $table = 'recommendations';
	public $timestamps = true;
	
	protected $dates = ['created_at', 'updated_at', 'deleted_at'];
	protected $protectedFields = ['persona_id','recommendable_type','recommendable_id','rank'];

	public $fillable = [
		  'persona_id',
		  'recommendable_type',
		  'recommendable_id',
		  'rank',
		  'is_anonymous',
		  'reason'
	];

	protected $casts = [
		  'recommendable_type' => 'string',
		  'is_anonymous' => 'boolean',
		  'reason' => 'string'
	];

	public static array $rules = [
		'persona_id' => 'required|exists:personas,id',
		'recommendable_type' => 'required|in:Award,Title',
		'recommendable_id' => 'required|exists:awards,id|exists:titles,id',
		'rank' => 'nullable|integer',
		'is_anonymous' => 'boolean',
		'reason' => 'required|string|max:400'
	];
	
	public $relationships = [
		'persona' => 'BelongsTo',
		'recommendable' => 'MorphTo'
	];
	
	public function persona(): \Illuminate\Database\Eloquent\Relations\BelongsTo
	{
		return $this->belongsTo(\App\Models\Persona::class, 'persona_id');
	}
	
	public function recommendable(): \Illuminate\Database\Eloquent\Relations\MorphTo
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
