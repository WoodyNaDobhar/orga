<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Wildside\Userstamps\Userstamps;
use App\Traits\ProtectFieldsTrait;
/**
 * @OA\Schema(
 *      schema="Reconciliation",
 *      required={"archetype_id","persona_id","credits"},
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
 *          readOnly=false,
 *          nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=16
 *		),
 *		@OA\Property(
 *			property="persona_id",
 *			description="The ID of the Persona getting Reconciled.",
 *          readOnly=false,
 *          nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *      @OA\Property(
 *          property="credits",
 *          description="The number of credits to be given or removed (with negative value) from the Persona for the Archetype.",
 *          readOnly=false,
 *          nullable=false,
 *          type="number",
 *          format="float",
 *          example=400
 *      ),
 *      @OA\Property(
 *          property="notes",
 *          description="Why the Reconciliation was required, and how they might be removed.",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *          format="paragraph",
 *          example="Credits earned sometime in the late 90s across several parks."
 *      ),
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
 *				@OA\Schema(ref="#/components/schemas/User"),
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
 *				@OA\Schema(ref="#/components/schemas/User"),
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
 *				@OA\Schema(ref="#/components/schemas/User"),
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
 *			property="archetype",
 *			type="object",
 *			allOf={
 *				@OA\Property(
 *					title="Archetype",
 *					description="Attachable Archetype credits being Reconciled."
 *				),
 *				@OA\Schema(ref="#/components/schemas/Archetype"),
 *			},
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="persona",
 *			type="object",
 *			allOf={
 *				@OA\Property(
 *					title="Persona",
 *					description="Attachable Persona credits being Reconciled."
 *				),
 *				@OA\Schema(ref="#/components/schemas/Persona"),
 *			},
 *			readOnly=true
 *		)
 * )
 */
 
/**
 *	@OA\Schema(
 *		schema="ReconciliationSimple",
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
 *          readOnly=false,
 *          nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=16
 *		),
 *		@OA\Property(
 *			property="persona_id",
 *			description="The ID of the Persona getting Reconciled.",
 *          readOnly=false,
 *          nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *      @OA\Property(
 *          property="credits",
 *          description="The number of credits to be given or removed (with negative value) from the Persona for the Archetype.",
 *          readOnly=false,
 *          nullable=false,
 *          type="number",
 *          format="float",
 *          example=400
 *      ),
 *      @OA\Property(
 *          property="notes",
 *          description="Why the Reconciliation was required, and how they might be removed.",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *          format="paragraph",
 *          example="Credits earned sometime in the late 90s across several parks."
 *      ),
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
 */
 
/**
 *	@OA\Schema(
 *		schema="ReconciliationSuperSimple",
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
 *          readOnly=false,
 *          nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=16
 *		),
 *		@OA\Property(
 *			property="persona_id",
 *			description="The ID of the Persona getting Reconciled.",
 *          readOnly=false,
 *          nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *      @OA\Property(
 *          property="credits",
 *          description="The number of credits to be given or removed (with negative value) from the Persona for the Archetype.",
 *          readOnly=false,
 *          nullable=false,
 *          type="number",
 *          format="float",
 *          example=400
 *      ),
 *      @OA\Property(
 *          property="notes",
 *          description="Why the Reconciliation was required, and how they might be removed.",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *          format="paragraph",
 *          example="Credits earned sometime in the late 90s across several parks."
 *      )
 *	)
 */
 
/**
 *
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

class Reconciliation extends Model
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
