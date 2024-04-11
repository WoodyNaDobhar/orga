<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Wildside\Userstamps\Userstamps;
use App\Traits\ProtectFieldsTrait;
/**
 * @OA\Schema(
 *		schema="Tournament",
 *		required={"tournamentable_type","tournamentable_id","name","description","occured_at"},
 *		description="Tournament details.<br>The following relationships can be attached, and in the case of plural relations, searched:
 * tournamentable (Chapter, Event, or Realm) (MorphTo): The Tournament sponsor type; Chapter, Event, or Realm.
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
 *			property="tournamentable_type",
 *			description="The Tournament sponsor type; Chapter, Event, or Realm.",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="enum",
 *			enum={"Chapter","Event","Realm"},
 *			example="Chapter"
 *		),
 *		@OA\Property(
 *			property="tournamentable_id",
 *			description="The ID of the Tournament sponsor.",
 *			readOnly=false,
 *			nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="name",
 *			description="The name of the Tournament.",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="uppercase first letter",
 *			example="KotB Tournament",
 *			maxLength=50
 *		),
 *		@OA\Property(
 *			property="description",
 *			description="A description of the Tournament.",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="paragraph",
 *			example="Keep on the Boarderlands annual tournament.",
 *			maxLength=16777215
 *		),
 *		@OA\Property(
 *			property="occured_at",
 *			description="Date and time the Tournament occured.",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="date-time",
 *			example="2020-12-30 23:59:59"
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
 *			property="tournamentable",
 *			type="object",
 *			description="Attachable object that sponsored the Tournament.",
 *			oneOf={
 *				@OA\Schema(ref="#/components/schemas/ChapterSimple"),
 *				@OA\Schema(ref="#/components/schemas/EventSimple"),
 *				@OA\Schema(ref="#/components/schemas/RealmSimple")
 *			},
 *			readOnly=true
 *		)
 * )
 *	@OA\Schema(
 *		schema="TournamentSimple",
 *		title="TournamentSimple",
 *		description="Attachable Tournament object with no attachments.",
 *		@OA\Property(
 *			property="id",
 *			description="The entry's ID.",
 *			type="integer",
 *			format="int32",
 *			example=42,
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="tournamentable_type",
 *			description="The Tournament sponsor type; Chapter, Event, or Realm.",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="enum",
 *			enum={"Chapter","Event","Realm"},
 *			example="Chapter"
 *		),
 *		@OA\Property(
 *			property="tournamentable_id",
 *			description="The ID of the Tournament sponsor.",
 *			readOnly=false,
 *			nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="name",
 *			description="The name of the Tournament.",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="uppercase first letter",
 *			example="KotB Tournament",
 *			maxLength=50
 *		),
 *		@OA\Property(
 *			property="description",
 *			description="A description of the Tournament.",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="paragraph",
 *			example="Keep on the Boarderlands annual tournament.",
 *			maxLength=16777215
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
 *		schema="TournamentSuperSimple",
 *		title="TournamentSuperSimple",
 *		description="Attachable Tournament object with no attachments or CUD data.",
 *		@OA\Property(
 *			property="id",
 *			description="The entry's ID.",
 *			type="integer",
 *			format="int32",
 *			example=42,
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="tournamentable_type",
 *			description="The Tournament sponsor type; Chapter, Event, or Realm.",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="enum",
 *			enum={"Chapter","Event","Realm"},
 *			example="Chapter"
 *		),
 *		@OA\Property(
 *			property="tournamentable_id",
 *			description="The ID of the Tournament sponsor.",
 *			readOnly=false,
 *			nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="name",
 *			description="The name of the Tournament.",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="uppercase first letter",
 *			example="KotB Tournament",
 *			maxLength=50
 *		),
 *		@OA\Property(
 *			property="description",
 *			description="A description of the Tournament.",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="paragraph",
 *			example="Keep on the Boarderlands annual tournament.",
 *			maxLength=16777215
 *		)
 *	)
 *	@OA\RequestBody(
 *		request="Tournament",
 *		description="Tournament object that needs to be added or updated.",
 *		required=true,
 *		@OA\MediaType(
 *			mediaType="multipart/form-data",
 *			@OA\Schema(ref="#/components/schemas/TournamentSimple")
 *		)
 *	)
 */

class Tournament extends BaseModel
{
	use SoftDeletes;
	use HasFactory;
	use Userstamps;
	use ProtectFieldsTrait;

	public $table = 'tournaments';
	public $timestamps = true;
	
	protected $dates = ['created_at', 'updated_at', 'deleted_at'];
	protected $protectedFields = ['tourmentable_type','tourmentable_id'];

	public $fillable = [
		  'tournamentable_type',
		  'tournamentable_id',
		  'name',
		  'description',
		  'occured_at'
	];

	protected $casts = [
		  'tournamentable_type' => 'string',
		  'name' => 'string',
		  'description' => 'string',
		  'occured_at' => 'datetime'
	];

	public static array $rules = [
		'tournamentable_type' => 'required|string|in:Realm,Chapter,Event',
		'tournamentable_id' => 'required|integer',
		'name' => 'required|string|max:50',
		'description' => 'required|string|max:16777215',
		'occured_at' => 'required|date'
	];
	
	public $relationships = [
		'tournamentable' => 'MorphTo'
	];
	
	public function tournamentable(): \Illuminate\Database\Eloquent\Relations\MorphTo
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
