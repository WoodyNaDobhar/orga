<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\ProtectFieldsTrait;
use Wildside\Userstamps\Userstamps;
/**
 * @OA\Schema(
 *      schema="Account",
 *      required={"accountable_type","accountable_id","name","type"},
 *		description="Financial Accounts for Realms, Chapters, and Units<br>The following relationships can be attached, and in the case of plural relations, searched:
 * accountable (Realm, Chapter, or Unit) (MorphTo): Realm, Chapter, or Unit that owns this Account.
 * parent (Account) (BelongsTo): Parent Account, if any.
 * splits (Split) (HasMany): Splits for this Account.
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
 *			property="parent_id",
 *			description="The superior Account ID, if any.",
 *          readOnly=false,
 *          nullable=true,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *      @OA\Property(
 *          property="accountable_type",
 *          description="Who owns the account; Realm, Chapter, or Unit",
 *          readOnly=false,
 *          nullable=false,
 *			type="string",
 *			format="enum",
 *			enum={"Realm","Chapter","Unit"},
 *			example="Realm"
 *      ),
 *		@OA\Property(
 *			property="accountable_id",
 *			description="The ID of the owner of this Account.",
 *          readOnly=false,
 *          nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *      @OA\Property(
 *          property="name",
 *          description="Account label.",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *			format="uppercase first letter",
 *			example="Dues",
 *          maxLength=50
 *      ),
 *      @OA\Property(
 *          property="type",
 *          description="The type of Account this is; Imbalance, Income, Expense, Asset, Liability, or Equity",
 *          readOnly=false,
 *          nullable=false,
 *			type="string",
 *			format="enum",
 *			enum={"Imbalance","Income","Expense","Asset","Liability","Equity"},
 *			example="Imbalance"
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
 *			property="parent",
 *			type="object",
 *			allOf={
 *				@OA\Property(
 *					title="Account",
 *					description="The superior Account."
 *				),
 *				@OA\Schema(ref="#/components/schemas/Account"),
 *			},
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="splits",
 *			description="Attachable & filterable array of Splits for this Account.",
 *			type="array",
 *			@OA\Items(
 *				title="Split",
 *				type="object",
 *				ref="#/components/schemas/Split"
 *			),
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="accountable",
 *			type="object",
 *			oneOf={
 *				@OA\Property(
 *					title="Realm",
 *					description="Attachable Realm that owns the Account.",
 *					@OA\Schema(ref="#/components/schemas/Realm")
 *				),
 *				@OA\Property(
 *					title="Chapter",
 *					description="Attachable Chapter that owns the Account.",
 *					@OA\Schema(ref="#/components/schemas/Chapter")
 *				),
 *				@OA\Property(
 *					title="Unit",
 *					description="Attachable Unit that owns the Account.",
 *					@OA\Schema(ref="#/components/schemas/Unit")
 *				)
 *			},
 *			readOnly=true
 *		)
 * )
 */
 
/**
 *	@OA\Schema(
 *		schema="AccountSimple",
 *		@OA\Property(
 *			property="id",
 *			description="The entry's ID.",
 *			type="integer",
 *			format="int32",
 *			example=42,
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="parent_id",
 *			description="The superior Account ID, if any.",
 *          readOnly=false,
 *          nullable=true,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *      @OA\Property(
 *          property="accountable_type",
 *          description="Who owns the account; Realm, Chapter, or Unit",
 *          readOnly=false,
 *          nullable=false,
 *			type="string",
 *			format="enum",
 *			enum={"Realm","Chapter","Unit"},
 *			example="Realm"
 *      ),
 *      @OA\Property(
 *          property="name",
 *          description="Account label.",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *          maxLength=50
 *      ),
 *      @OA\Property(
 *          property="type",
 *          description="The type of Account this is; Imbalance, Income, Expense, Asset, Liability, or Equity",
 *          readOnly=false,
 *          nullable=false,
 *			type="string",
 *			format="enum",
 *			enum={"Imbalance","Income","Expense","Asset","Liability","Equity"},
 *			example="Imbalance"
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
 *		schema="AccountSuperSimple",
 *		@OA\Property(
 *			property="id",
 *			description="The entry's ID.",
 *			type="integer",
 *			format="int32",
 *			example=42,
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="parent_id",
 *			description="The superior Account ID, if any.",
 *          readOnly=false,
 *          nullable=true,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *      @OA\Property(
 *          property="accountable_type",
 *          description="Who owns the account; Realm, Chapter, or Unit",
 *          readOnly=false,
 *          nullable=false,
 *			type="string",
 *			format="enum",
 *			enum={"Realm","Chapter","Unit"},
 *			example="Realm"
 *      ),
 *      @OA\Property(
 *          property="name",
 *          description="Account label.",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *          maxLength=50
 *      ),
 *      @OA\Property(
 *          property="type",
 *          description="The type of Account this is; Imbalance, Income, Expense, Asset, Liability, or Equity",
 *          readOnly=false,
 *          nullable=false,
 *			type="string",
 *			format="enum",
 *			enum={"Imbalance","Income","Expense","Asset","Liability","Equity"},
 *			example="Imbalance"
 *      )
 *	)
 */
 
/**
 *
 *	@OA\RequestBody(
 *		request="Account",
 *		description="Account object that needs to be added or updated.",
 *		required=true,
 *		@OA\MediaType(
 *			mediaType="multipart/form-data",
 *			@OA\Schema(ref="#/components/schemas/AccountSimple")
 *		)
 *	)
 */
 
 class Account extends Model
{
	use SoftDeletes;
	use HasFactory;
	use Userstamps;
	use ProtectFieldsTrait;
     
	public $table = 'accounts';
	public $timestamps = true;
	
	protected $dates = ['created_at', 'updated_at', 'deleted_at'];
	protected $protectedFields = ['accountable_type','accountable_id','type'];

    public $fillable = [
        'parent_id',
        'accountable_type',
        'accountable_id',
        'name',
        'type'
    ];

    protected $casts = [
    	'accountable_type' => 'string',
    	'accountable_id' => 'integer',
        'name' => 'string',
        'type' => 'string'
    ];

    public static array $rules = [
    	'parent_id' => 'nullable|exists:accounts,id',
    	'accountable_type' => 'required|in:Realm,Chapter,Unit',
    	'accountable_id' => 'required',//TODO: better handling for all these?
    	'name' => 'required|string|max:50',
    	'type' => 'required|in:Imbalance,Income,Expense,Asset,Liability,Equity',
    ];
    
    public $relationships = [
    	'accountable' => 'MorphTo',
    	'parent' => 'BelongsTo',
    	'splits' => 'HasMany'
    ];
    
    public function accountable(): \Illuminate\Database\Eloquent\Relations\MorphTo
    {
    	return $this->morphTo();
    }
    
    public function parent(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
    	return $this->belongsTo(\App\Models\Account::class, 'parent_id');
    }
    
    public function splits(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
    	return $this->hasMany(\App\Models\Split::class, 'account_id');
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
