<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Wildside\Userstamps\Userstamps;
use App\Traits\ProtectFieldsTrait;
/**
 * @OA\Schema(
 *      schema="Suspension",
 *      required={"persona_id","realm_id","suspended_by","cause","is_propogating"},
 *		description="On the occasion when an Amtgarder must be disciplined, we record it here.<br>The following relationships can be attached, and in the case of plural relations, searched:
 * persona (Persona) (BelongsTo): The Persona that has been Suspended.
 * realm (Realm) (BelongsTo): The Realm issuing the Suspension.
 * suspendedBy (User) (BelongsTo): The Persona issuing the Suspension.
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
 *			description="The ID of the Persona that has been Suspended.",
 *          readOnly=false,
 *          nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="realm_id",
 *			description="The ID of the Realm issuing the Suspension.",
 *          readOnly=false,
 *          nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="suspended_by",
 *			description="The ID of the Persona issuing the Suspension.",
 *          readOnly=false,
 *          nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *      @OA\Property(
 *          property="suspended_at",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *          format="date",
 *			example="2020-12-30"
 *      ),
 *      @OA\Property(
 *          property="expires_at",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *          format="date",
 *			example="2020-12-30"
 *      ),
 *      @OA\Property(
 *          property="cause",
 *          description="Why the suspension was issued.",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *          format="paragraph",
 *          maxLength=191
 *      ),
 *      @OA\Property(
 *          property="is_propogating",
 *          description="Does the Suspension (default false) propogate to all Realms?",
 *          readOnly=false,
 *          nullable=false,
 *			type="integer",
 *			format="enum",
 *			enum={0, 1},
 *			example=0
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
 *			property="persona",
 *			type="object",
 *			allOf={
 *				@OA\Property(
 *					title="Persona",
 *					description="Attachable Persona that has been Suspended."
 *				),
 *				@OA\Schema(ref="#/components/schemas/Persona"),
 *			},
 *			readOnly=true
 *		), 
 *		@OA\Property(
 *			property="realm",
 *			type="object",
 *			allOf={
 *				@OA\Property(
 *					title="Realm",
 *					description="Attachable Realm issuing the Suspension."
 *				),
 *				@OA\Schema(ref="#/components/schemas/Realm"),
 *			},
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="suspendedBy",
 *			type="object",
 *			allOf={
 *				@OA\Property(
 *					title="Persona",
 *					description="Attachable Persona issuing the Suspension."
 *				),
 *				@OA\Schema(ref="#/components/schemas/Persona"),
 *			},
 *			readOnly=true
 *		)
 * )
 */
 
/**
 *	@OA\Schema(
 *		schema="SuspensionSimple",
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
 *			description="The ID of the Persona that has been Suspended.",
 *          readOnly=false,
 *          nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="realm_id",
 *			description="The ID of the Realm issuing the Suspension.",
 *          readOnly=false,
 *          nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="suspended_by",
 *			description="The ID of the Persona issuing the Suspension.",
 *          readOnly=false,
 *          nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *      @OA\Property(
 *          property="suspended_at",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *          format="date",
 *			example="2020-12-30"
 *      ),
 *      @OA\Property(
 *          property="expires_at",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *          format="date",
 *			example="2020-12-30"
 *      ),
 *      @OA\Property(
 *          property="cause",
 *          description="Why the suspension was issued.",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *          format="paragraph",
 *          maxLength=191
 *      ),
 *      @OA\Property(
 *          property="is_propogating",
 *          description="Does the Suspension (default false) propogate to all Realms?",
 *          readOnly=false,
 *          nullable=false,
 *			type="integer",
 *			format="enum",
 *			enum={0, 1},
 *			example=0
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
 *		schema="SuspensionSuperSimple",
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
 *			description="The ID of the Persona that has been Suspended.",
 *          readOnly=false,
 *          nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="realm_id",
 *			description="The ID of the Realm issuing the Suspension.",
 *          readOnly=false,
 *          nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="suspended_by",
 *			description="The ID of the Persona issuing the Suspension.",
 *          readOnly=false,
 *          nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *      @OA\Property(
 *          property="suspended_at",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *          format="date",
 *			example="2020-12-30"
 *      ),
 *      @OA\Property(
 *          property="expires_at",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *          format="date",
 *			example="2020-12-30"
 *      ),
 *      @OA\Property(
 *          property="cause",
 *          description="Why the suspension was issued.",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *          format="paragraph",
 *          maxLength=191
 *      ),
 *      @OA\Property(
 *          property="is_propogating",
 *          description="Does the Suspension (default false) propogate to all Realms?",
 *          readOnly=false,
 *          nullable=false,
 *			type="integer",
 *			format="enum",
 *			enum={0, 1},
 *			example=0
 *      )
 *	)
 */
 
/**
 *
 *	@OA\RequestBody(
 *		request="Suspension",
 *		description="Suspension object that needs to be added or updated.",
 *		required=true,
 *		@OA\MediaType(
 *			mediaType="multipart/form-data",
 *			@OA\Schema(ref="#/components/schemas/SuspensionSimple")
 *		)
 *	)
 */

class Suspension extends Model
{
	use SoftDeletes;
	use HasFactory;
	use Userstamps;
	use ProtectFieldsTrait;

	public $table = 'suspensions';
	public $timestamps = true;
	
	protected $dates = ['created_at', 'updated_at', 'deleted_at'];
	protected $protectedFields = ['persona_id','realm_id','suspended_by','suspended_at','expires_at'];

    public $fillable = [
        'persona_id',
        'realm_id',
        'suspended_by',
        'suspended_at',
        'expires_at',
        'cause',
        'is_propogating'
    ];

    protected $casts = [
        'suspended_at' => 'date',
        'expires_at' => 'date',
        'cause' => 'string',
        'is_propogating' => 'boolean'
    ];

    public static array $rules = [
    	'persona_id' => 'required|exists:personas,id',
    	'realm_id' => 'required|exists:realms,id',
    	'suspended_by' => 'required|exists:personas,id',
    	'suspended_at' => 'required|date',
    	'expires_at' => 'nullable|date|after:suspended_at',
    	'cause' => 'required|string|max:191',
    	'is_propogating' => 'required|boolean'
    ];
    
    public $relationships = [
    	'persona' => 'BelongsTo',
    	'realm' => 'BelongsTo',
    	'suspendedBy' => 'BelongsTo'
    ];
    
    public function persona(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
    	return $this->belongsTo(\App\Models\Persona::class, 'persona_id');
    }
    
    public function realm(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
    	return $this->belongsTo(\App\Models\Realm::class, 'realm_id');
    }
    
    public function suspendedBy(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
    	return $this->belongsTo(\App\Models\Persona::class, 'suspended_by');
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
