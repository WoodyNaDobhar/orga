<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Wildside\Userstamps\Userstamps;
use App\Traits\ProtectFieldsTrait;
/**
 * @OA\Schema(
 *		schema="Reconciliation",
 *		required={"archetype_id","persona_id","credits"},
 *		description="Reconciliations allow us to make sum adjustments to a Persona's credits.<br>The following relationships can be attached, and in the case of plural relations, searched:
 * archetype (Archetype) (BelongsTo): Archetype credits being Reconciled.
 * persona (Persona) (BelongsTo): Persona credits being Reconciled.
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
 *			property="archetype_id",
 *			description="The ID of the Archetype the Reconcilliation credits are for.",
 *			readOnly=false,
 *			nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=16
 *		),
 *		@OA\Property(
 *			property="persona_id",
 *			description="The ID of the Persona getting Reconciled.",
 *			readOnly=false,
 *			nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="credits",
 *			description="The number of credits to be given or removed (with negative value) from the Persona for the Archetype.",
 *			readOnly=false,
 *			nullable=false,
 *			type="number",
 *			format="float",
 *			example=400
 *		),
 *		@OA\Property(
 *			property="notes",
 *			description="Why the Reconciliation was required, and how they might be removed.",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="paragraph",
 *			example="Credits earned sometime in the late 90s across several parks."
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
 *			property="archetype",
 *			type="object",
 *			description="Attachable Archetype credits being Reconciled.",
 *			ref="#/components/schemas/ArchetypeSimple",
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="persona",
 *			type="object",
 *			description="Attachable Persona credits being Reconciled.",
 *			ref="#/components/schemas/PersonaSimple",
 *			readOnly=true
 *		)
 * )
 *	@OA\Schema(
 *		schema="ReconciliationSimple",
 *		title="ReconciliationSimple",
 *		description="Attachable Reconciliation object with no attachments.",
 *		@OA\Property(
 *			property="id",
 *			description="The entry's ID.",
 *			type="integer",
 *			format="int32",
 *			example=42,
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="archetype_id",
 *			description="The ID of the Archetype the Reconcilliation credits are for.",
 *			readOnly=false,
 *			nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=16
 *		),
 *		@OA\Property(
 *			property="persona_id",
 *			description="The ID of the Persona getting Reconciled.",
 *			readOnly=false,
 *			nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="credits",
 *			description="The number of credits to be given or removed (with negative value) from the Persona for the Archetype.",
 *			readOnly=false,
 *			nullable=false,
 *			type="number",
 *			format="float",
 *			example=400
 *		),
 *		@OA\Property(
 *			property="notes",
 *			description="Why the Reconciliation was required, and how they might be removed.",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="paragraph",
 *			example="Credits earned sometime in the late 90s across several parks."
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
 *		schema="ReconciliationSuperSimple",
 *		title="ReconciliationSuperSimple",
 *		description="Attachable Reconciliation object with no attachments or CUD data.",
 *		@OA\Property(
 *			property="id",
 *			description="The entry's ID.",
 *			type="integer",
 *			format="int32",
 *			example=42,
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="archetype_id",
 *			description="The ID of the Archetype the Reconcilliation credits are for.",
 *			readOnly=false,
 *			nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=16
 *		),
 *		@OA\Property(
 *			property="persona_id",
 *			description="The ID of the Persona getting Reconciled.",
 *			readOnly=false,
 *			nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="credits",
 *			description="The number of credits to be given or removed (with negative value) from the Persona for the Archetype.",
 *			readOnly=false,
 *			nullable=false,
 *			type="number",
 *			format="float",
 *			example=400
 *		),
 *		@OA\Property(
 *			property="notes",
 *			description="Why the Reconciliation was required, and how they might be removed.",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="paragraph",
 *			example="Credits earned sometime in the late 90s across several parks."
 *		)
 *	)
 *	@OA\RequestBody(
 *		request="Reconciliation",
 *		description="Reconciliation object that needs to be added or updated.",
 *		required=true,
 *		@OA\MediaType(
 *			mediaType="multipart/form-data",
 *			@OA\Schema(ref="#/components/schemas/ReconciliationSimple")
 *		)
 *	)
 */

class Reconciliation extends BaseModel
{
	use SoftDeletes;
	use HasFactory;
	use Userstamps;
	use ProtectFieldsTrait;

	public $table = 'reconciliations';
	public $timestamps = true;
	
	protected $dates = ['created_at', 'updated_at', 'deleted_at'];
	protected $protectedFields = ['archetype_id','persona_id'];

	public $fillable = [
		  'archetype_id',
		  'persona_id',
		  'credits',
		  'notes'
	];

	protected $casts = [
		  'credits' => 'float',
		  'notes' => 'string'
	];

	public static array $rules = [
		'archetype_id' => 'required|exists:archetypes,id',
		'persona_id' => 'required|exists:personas,id',
		'credits' => 'required|numeric|min:-9999.99|max:9999.99',
		'notes' => 'nullable|string|max:191'
	];
	
	public $relationships = [
		'archetype' => 'BelongsTo',
   		'persona' => 'BelongsTo'
	];

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
