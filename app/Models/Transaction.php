<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Wildside\Userstamps\Userstamps;
use App\Traits\ProtectFieldsTrait;
/**
 * @OA\Schema(
 *		schema="Transaction",
 *		required={"description","transaction_at"},
 *		description="Accounting Transactions.<br>The following relationships can be attached, and in the case of plural relations, searched:
 * dues (Due) (HasMany): Dues linked to the Transaction
 * splits (Split) (HasMany): Splits for the Transaction
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
 *			property="description",
 *			description="A description of the Transaction.",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="paragraph",
 *			example="Dues Paid for Chibasama",
 *			maxLength=191
 *		),
 *		@OA\Property(
 *			property="memo",
 *			description="A memo for the Transaction, if any",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			example="Paid in $2 bills.",
 *			maxLength=191
 *		),
 *		@OA\Property(
 *			property="transaction_at",
 *			description="Date the Transaction occured.",
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
 *			property="dues",
 *			description="Attachable & filterable array of Dues linked to the Transaction.",
 *			type="array",
 *			@OA\Items(
 *				title="Due",
 *				type="object",
 *				ref="#/components/schemas/DueSimple"
 *			),
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="splits",
 *			description="Attachable & filterable array of Splits for the Transaction.",
 *			type="array",
 *			@OA\Items(
 *				title="Split",
 *				type="object",
 *				ref="#/components/schemas/SplitSimple"
 *			),
 *			readOnly=true
 *		)
 * )
 *	@OA\Schema(
 *		schema="TransactionSimple",
 *		title="TransactionSimple",
 *		description="Attachable Transaction object with no attachments.",
 *		@OA\Property(
 *			property="id",
 *			description="The entry's ID.",
 *			type="integer",
 *			format="int32",
 *			example=42,
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="description",
 *			description="A description of the Transaction.",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="paragraph",
 *			example="Dues Paid for Chibasama",
 *			maxLength=191
 *		),
 *		@OA\Property(
 *			property="memo",
 *			description="A memo for the Transaction, if any",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			example="Paid in $2 bills.",
 *			maxLength=191
 *		),
 *		@OA\Property(
 *			property="transaction_at",
 *			description="Date the Transaction occured.",
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
 *		schema="TransactionSuperSimple",
 *		title="TransactionSuperSimpleSimple",
 *		description="Attachable Transaction object with no attachments or CUD data.",
 *		@OA\Property(
 *			property="id",
 *			description="The entry's ID.",
 *			type="integer",
 *			format="int32",
 *			example=42,
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="description",
 *			description="A description of the Transaction.",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="paragraph",
 *			example="Dues Paid for Chibasama",
 *			maxLength=191
 *		),
 *		@OA\Property(
 *			property="memo",
 *			description="A memo for the Transaction, if any",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			example="Paid in $2 bills.",
 *			maxLength=191
 *		),
 *		@OA\Property(
 *			property="transaction_at",
 *			description="Date the Transaction occured.",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="date",
 *			example="2020-12-30"
 *		)
 *	)
 *	@OA\RequestBody(
 *		request="Transaction",
 *		description="Transaction object that needs to be added or updated.",
 *		required=true,
 *		@OA\MediaType(
 *			mediaType="multipart/form-data",
 *			@OA\Schema(ref="#/components/schemas/TransactionSimple")
 *		)
 *	)
 */

class Transaction extends BaseModel
{
	use SoftDeletes;
	use HasFactory;
	use Userstamps;
	use ProtectFieldsTrait;

	public $table = 'transactions';
	public $timestamps = true;
	
	protected $dates = ['created_at', 'updated_at', 'deleted_at'];
	protected $protectedFields = [];

	public $fillable = [
		  'description',
		  'memo',
		  'transaction_at'
	];

	protected $casts = [
		  'description' => 'string',
		  'memo' => 'string',
		  'transaction_at' => 'date'
	];

	public static array $rules = [
		'description' => 'required|string|max:191',
		'memo' => 'nullable|string|max:16777215',
		'transaction_at' => 'required|date'
	];
	
	public $relationships = [
		'dues' => 'HasMany',
		'splits' => 'HasMany'
	];
	
	public function dues(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Due::class, 'transaction_id');
	}
	
	public function splits(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Split::class, 'transaction_id');
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
