<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\ProtectFieldsTrait;
use Wildside\Userstamps\Userstamps;
/**
 * @OA\Schema(
 *      schema="Due",
 *      required={"persona_id","transaction_id","dues_on"},
 *		description="Membership Dues.<br>The following relationships can be attached, and in the case of plural relations, searched:
 * persona (Persona) (BelongsTo): Persona paying Dues.
 * transaction (Transaction) (BelongsTo): Transaction recording the payment.
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
 *			description="ID of the Persona paying Dues.",
 *          readOnly=false,
 *          nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="transaction_id",
 *			description="ID of the Transaction recording the payment.",
 *          readOnly=false,
 *          nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *      @OA\Property(
 *          property="dues_on",
 *          description="The date the dues period begins, not the date paid",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *          format="date",
 *			example="2020-12-30"
 *      ),
 *      @OA\Property(
 *          property="intervals",
 *          description="Number of six month periods the payment covers, null for forever.",
 *          readOnly=false,
 *          nullable=true,
 *     		type="number",
 *     		format="float",
 *     		example=1
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
 *					description="Attachable Persona paying Dues."
 *				),
 *				@OA\Schema(ref="#/components/schemas/Persona"),
 *			},
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="transaction",
 *			type="object",
 *			allOf={
 *				@OA\Property(
 *					title="Transaction",
 *					description="Attachable Transaction recording the payment."
 *				),
 *				@OA\Schema(ref="#/components/schemas/Transaction"),
 *			},
 *			readOnly=true
 *		)
 * )
 */
 
/**
 *	@OA\Schema(
 *		schema="DueSimple",
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
 *			description="ID of the Persona paying Dues.",
 *          readOnly=false,
 *          nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="transaction_id",
 *			description="ID of the Transaction recording the payment.",
 *          readOnly=false,
 *          nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *      @OA\Property(
 *          property="dues_on",
 *          description="The date the dues period begins, not the date paid",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *          format="date",
 *			example="2020-12-30"
 *      ),
 *      @OA\Property(
 *          property="intervals",
 *          description="Number of six month periods the payment covers, null for forever.",
 *          readOnly=false,
 *          nullable=true,
 *     		type="number",
 *     		format="float",
 *     		example=1
 *      )
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
 *		schema="DueSuperSimple",
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
 *			description="ID of the Persona paying Dues.",
 *          readOnly=false,
 *          nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="transaction_id",
 *			description="ID of the Transaction recording the payment.",
 *          readOnly=false,
 *          nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *      @OA\Property(
 *          property="dues_on",
 *          description="The date the dues period begins, not the date paid",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *          format="date",
 *			example="2020-12-30"
 *      ),
 *      @OA\Property(
 *          property="intervals",
 *          description="Number of six month periods the payment covers, null for forever.",
 *          readOnly=false,
 *          nullable=true,
 *     		type="number",
 *     		format="float",
 *     		example=1
 *      )
 *	)
 */
 
/**
 *
 *	@OA\RequestBody(
 *		request="Due",
 *		description="Due object that needs to be added or updated.",
 *		required=true,
 *		@OA\MediaType(
 *			mediaType="multipart/form-data",
 *			@OA\Schema(ref="#/components/schemas/DueSimple")
 *		)
 *	)
 */

class Due extends Model
{
	use SoftDeletes;
	use HasFactory;
	use Userstamps;
	use ProtectFieldsTrait;

	public $table = 'dues';
	public $timestamps = true;
	
	protected $dates = ['created_at', 'updated_at', 'deleted_at'];
	protected $protectedFields = ['persona_id', 'transaction_id', 'intervals'];

    public $fillable = [
        'persona_id',
        'transaction_id',
        'dues_on',
        'intervals'
    ];

    protected $casts = [
        'dues_on' => 'date',
        'intervals' => 'float'
    ];

    public static array $rules = [
        'persona_id' => 'required|exists:personas,id',
    	'transaction_id' => 'required|exists:transactions,id',
    	'dues_on' => 'required|date',
    	'intervals' => 'nullable|numeric',
    ];
    
    public $relationships = [
		'persona' => 'BelongsTo',
		'transaction' => 'BelongsTo'
    ];
    
    public function persona(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
    	return $this->belongsTo(\App\Models\Persona::class, 'persona_id');
    }
    
    public function transaction(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
    	return $this->belongsTo(\App\Models\Transaction::class, 'transaction_id');
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
