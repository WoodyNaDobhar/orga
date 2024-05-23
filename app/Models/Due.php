<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\ProtectFieldsTrait;
use Wildside\Userstamps\Userstamps;
/**
 * @OA\Schema(
 *		schema="Due",
 *		required={"persona_id","transaction_id","dues_on","amount"},
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
 *			readOnly=false,
 *			nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="transaction_id",
 *			description="ID of the Transaction recording the payment.",
 *			readOnly=false,
 *			nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="dues_on",
 *			description="The date the dues period begins, not the date paid",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="date",
 *			example="2020-12-30"
 *		),
 *		@OA\Property(
 *			property="intervals",
 *			description="Number of six month periods the payment covers, null for forever.",
 *			readOnly=false,
 *			nullable=true,
 *	 		type="number",
 *	 		format="float",
 *	 		example=1
 *		),
 *		@OA\Property(
 *	 		property="amount",
 *	 		description="Amount paid by the Persona.",
 *	 		readOnly=true,
 *	 		nullable=false,
 *	 		type="number",
 *	 		format="double",
 *	 		maximum=9999999.9999,
 *	 		minimum=-9999999.9999,
 *		),
 *		@OA\Property(
 *	 		property="memo",
 *	 		description="Any special information about the Due Transaction.",
 *	 		readOnly=true,
 *	 		nullable=false,
 *			type="string",
 *			format="sentence",
 *			example="They paid in equipment."
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
 *			description="When the entry was softdeleted.Null if not softdeleted.",
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
 *			property="persona",
 *			type="object",
 *			description="Attachable Persona paying Dues.",
 *			ref="#/components/schemas/PersonaSimple",
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="transaction",
 *			type="object",
 *			description="Attachable Transaction recording the payment.",
 *			ref="#/components/schemas/TransactionSimple",
 *			readOnly=true
 *		)
 * )
 * 
 *	@OA\Schema(
 *		schema="DueCreate",
 *		title="DueCreate",
 *		required={"persona_id","recipient_type","recipient_id","dues_on","amount","type"},
 *		description="Due Creation.",
 *		@OA\Property(
 *			property="persona_id",
 *			description="ID of the Persona paying Dues.",
 *			readOnly=false,
 *			nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="recipient_type",
 *			description="Who is receiving the payment, Chapter or Realm.",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="enum",
 *			enum={"Realm","Chapter"},
 *			example="Realm"
 *		),
 *		@OA\Property(
 *			property="recipient_id",
 *			description="ID of the Chapter or Realm accepting payment.",
 *			readOnly=false,
 *			nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="dues_on",
 *			description="The date the dues period begins, not the date paid",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="date",
 *			example="2020-12-30"
 *		),
 *		@OA\Property(
 *	 		property="amount",
 *	 		description="Amount paid by the Persona.",
 *	 		readOnly=true,
 *	 		nullable=false,
 *	 		type="number",
 *	 		format="double",
 *	 		maximum=9999999.9999,
 *	 		minimum=-9999999.9999,
 *		),
 *		@OA\Property(
 *	 		property="type",
 *	 		description="How the Due payment was made, Asset (physical donation), Cash (including digital), or Checking (ACH transfer).",
 *	 		readOnly=true,
 *	 		nullable=false,
 *			type="string",
 *			format="enum",
 *			enum={"Assets","Cash","Checking"},
 *			example="Cash"
 *		),
 *		@OA\Property(
 *	 		property="memo",
 *	 		description="Any special information about the Due Transaction.",
 *	 		readOnly=true,
 *	 		nullable=false,
 *			type="string",
 *			format="sentence",
 *			example="They paid with a new banner."
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
 *			description="When the entry was softdeleted.Null if not softdeleted.",
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
 *		schema="DueSimple",
 *		title="DueSimple",
 *		description="Attachable Due object with no attachments.",
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
 *			readOnly=false,
 *			nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="transaction_id",
 *			description="ID of the Transaction recording the payment.",
 *			readOnly=false,
 *			nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="dues_on",
 *			description="The date the dues period begins, not the date paid",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="date",
 *			example="2020-12-30"
 *		),
 *		@OA\Property(
 *			property="intervals",
 *			description="Number of six month periods the payment covers, null for forever.",
 *			readOnly=false,
 *			nullable=true,
 *	 		type="number",
 *	 		format="float",
 *	 		example=1
 *		),
 *		@OA\Property(
 *	 		property="amount",
 *	 		description="Amount paid by the Persona.",
 *	 		readOnly=true,
 *	 		nullable=false,
 *	 		type="number",
 *	 		format="double",
 *	 		maximum=9999999.9999,
 *	 		minimum=-9999999.9999,
 *		),
 *		@OA\Property(
 *	 		property="memo",
 *	 		description="Any special information about the Due Transaction.",
 *	 		readOnly=true,
 *	 		nullable=false,
 *			type="string",
 *			format="sentence",
 *			example="They paid in equipment."
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
 *			description="When the entry was softdeleted.Null if not softdeleted.",
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
 *		schema="DueSuperSimple",
 *		title="DueSuperSimple",
 *		description="Attachable Due object with no attachments or CUD data.",
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
 *			readOnly=false,
 *			nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="transaction_id",
 *			description="ID of the Transaction recording the payment.",
 *			readOnly=false,
 *			nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="dues_on",
 *			description="The date the dues period begins, not the date paid",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="date",
 *			example="2020-12-30"
 *		),
 *		@OA\Property(
 *			property="intervals",
 *			description="Number of six month periods the payment covers, null for forever.",
 *			readOnly=false,
 *			nullable=true,
 *	 		type="number",
 *	 		format="float",
 *	 		example=1
 *		),
 *		@OA\Property(
 *	 		property="amount",
 *	 		description="Amount paid by the Persona.",
 *	 		readOnly=true,
 *	 		nullable=false,
 *	 		type="number",
 *	 		format="double",
 *	 		maximum=9999999.9999,
 *	 		minimum=-9999999.9999,
 *		),
 *		@OA\Property(
 *	 		property="memo",
 *	 		description="Any special information about the Due Transaction.",
 *	 		readOnly=true,
 *	 		nullable=false,
 *			type="string",
 *			format="sentence",
 *			example="They paid in equipment."
 *		)
 *	)
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

class Due extends BaseModel
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
	
	public static array $createRules = [
		'persona_id' => 'required|exists:personas,id',
		'recipient_type' => 'required|string|in:Realm,Chapter',
		'recipient_id' => 'required',
		'dues_on' => 'required|date',
		'amount' => ['required', 'regex:/^\d+(\.\d{1,2})?$/'],
		'type' => 'required|string|in:Assets,Cash,Checking',
		'memo' => 'string|max:191'
	];
	
	public static array $rules = [
		'persona_id' => 'required|exists:personas,id',
		'transaction_id' => 'required|exists:transactions,id',
		'dues_on' => 'required|date',
		'amount' => ['required', 'regex:/^\d+(\.\d{1,2})?$/']
	];
	
	protected function amount(): Attribute
	{
		return Attribute::make(
			get: function () {
				$split = $this->transaction->splits->firstWhere('account.name', 'Dues Paid');
				return $split ? $split->amount : null;
			}
		);
	}
	
	protected function memo(): Attribute
	{
		return Attribute::make(
			get: function () {
				return $this->transaction->memo;
			}
		);
	}
	
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
