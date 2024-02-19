<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\ProtectFieldsTrait;
use Wildside\Userstamps\Userstamps;
/**
 * @OA\Schema(
 *		schema="Chaptertype",
 *		required={"realm_id","name","minimumattendance","minimumcutoff"},
 *		description="Levels available for Chapters by Realm<br>The following relationships can be attached, and in the case of plural relations, searched:
 * chapters (Chapter) (HasMany): Chapters that share this Chaptertype.
 * offices (Office) (MorphMany): Offices for this Chaptertype.
 * realm (Realm) (BelongsTo): Realm for the Chaptertype.
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
 *			property="realm_id",
 *			description="The ID of the Realm that has this Chaptertype.",
 *			readOnly=false,
 *			nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="name",
 *			description="The name of the Chaptertype",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="uppercase first letter",
 *			example="Shire",
 *			maxLength=50
 *		),
 *		@OA\Property(
 *			property="rank",
 *			description="The order rank of the Chaptertype expressed in multiples of 10 where Shire is 20.",
 *			readOnly=false,
 *			nullable=true,
 *			type="integer",
 *			format="int32",
 *			example=20
 *		),
 *		@OA\Property(
 *			property="minimumattendance",
 *			description="Minimum (default 5) average Attendance required by the Realm to achieve the Chaptertype.",
 *			readOnly=false,
 *			nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=5,
 *	 		default=5
 *		),
 *		@OA\Property(
 *			property="minimumcutoff",
 *			description="Minimum (default 1) average Attendance required by the Realm to maintain the Chaptertype.",
 *			readOnly=false,
 *			nullable=true,
 *			type="integer",
 *			format="int32",
 *			example=1,
 *	 		default=1
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
 *			allOf={
 *				@OA\Property(
 *					title="User",
 *					description="Attachable User that created this record."
 *				),
 *				@OA\Schema(ref="#/components/schemas/UserSimple"),
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
 *				@OA\Schema(ref="#/components/schemas/UserSimple"),
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
 *				@OA\Schema(ref="#/components/schemas/UserSimple"),
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
 *			property="chapters",
 *			description="Attachable & filterable array of Chapters with this Chaptertype.",
 *			type="array",
 *			@OA\Items(
 *				title="Chapter",
 *				type="object",
 *				ref="#/components/schemas/ChapterSimple"
 *			),
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="offices",
 *			description="Attachable & filterable array of Offices for this Chaptertype.",
 *			type="array",
 *			@OA\Items(
 *				title="Office",
 *				type="object",
 *				ref="#/components/schemas/OfficeSimple"
 *			),
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="realm",
 *			type="object",
 *			allOf={
 *				@OA\Property(
 *					title="Realm",
 *					description="Attachable Realm this Chaptertype is for."
 *				),
 *				@OA\Schema(ref="#/components/schemas/RealmSimple"),
 *			},
 *			readOnly=true
 *		)
 * )
 *	@OA\Schema(
 *		schema="ChaptertypeSimple",
 *		@OA\Property(
 *			property="id",
 *			description="The entry's ID.",
 *			type="integer",
 *			format="int32",
 *			example=42,
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="realm_id",
 *			description="The ID of the Realm that has this Chaptertype.",
 *			readOnly=false,
 *			nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="name",
 *			description="The name of the Chaptertype",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="uppercase first letter",
 *			example="Shire",
 *			maxLength=50
 *		),
 *		@OA\Property(
 *			property="rank",
 *			description="The order rank of the Chaptertype expressed in multiples of 10 where Shire is 20.",
 *			readOnly=false,
 *			nullable=true,
 *			type="integer",
 *			format="int32",
 *			example=20
 *		),
 *		@OA\Property(
 *			property="minimumattendance",
 *			description="Minimum (default 5) average Attendance required by the Realm to achieve the Chaptertype.",
 *			readOnly=false,
 *			nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=5,
 *	 		default=5
 *		),
 *		@OA\Property(
 *			property="minimumcutoff",
 *			description="Minimum (default 1) average Attendance required by the Realm to maintain the Chaptertype.",
 *			readOnly=false,
 *			nullable=true,
 *			type="integer",
 *			format="int32",
 *			example=1,
 *	 		default=1
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
 *		schema="ChaptertypeSuperSimple",
 *		@OA\Property(
 *			property="id",
 *			description="The entry's ID.",
 *			type="integer",
 *			format="int32",
 *			example=42,
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="realm_id",
 *			description="The ID of the Realm that has this Chaptertype.",
 *			readOnly=false,
 *			nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="name",
 *			description="The name of the Chaptertype",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="uppercase first letter",
 *			example="Shire",
 *			maxLength=50
 *		),
 *		@OA\Property(
 *			property="rank",
 *			description="The order rank of the Chaptertype expressed in multiples of 10 where Shire is 20.",
 *			readOnly=false,
 *			nullable=true,
 *			type="integer",
 *			format="int32",
 *			example=20
 *		),
 *		@OA\Property(
 *			property="minimumattendance",
 *			description="Minimum (default 5) average Attendance required by the Realm to achieve the Chaptertype.",
 *			readOnly=false,
 *			nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=5,
 *	 		default=5
 *		),
 *		@OA\Property(
 *			property="minimumcutoff",
 *			description="Minimum (default 1) average Attendance required by the Realm to maintain the Chaptertype.",
 *			readOnly=false,
 *			nullable=true,
 *			type="integer",
 *			format="int32",
 *			example=1,
 *	 		default=1
 *		)
 *	)
 *	@OA\RequestBody(
 *		request="Chaptertype",
 *		description="Chaptertype object that needs to be added or updated.",
 *		required=true,
 *		@OA\MediaType(
 *			mediaType="multipart/form-data",
 *			@OA\Schema(ref="#/components/schemas/ChaptertypeSimple")
 *		)
 *	)
 */

class Chaptertype extends BaseModel
{
	use SoftDeletes;
	use HasFactory;
	use Userstamps;
	use ProtectFieldsTrait;

	public $table = 'chaptertypes';
	public $timestamps = true;
	
	protected $dates = ['created_at', 'updated_at', 'deleted_at'];
	protected $protectedFields = ['realm_id'];

	public $fillable = [
		  'realm_id',
		  'name',
		  'rank',
		  'minimumattendance',
		  'minimumcutoff'
	];

	protected $casts = [
		  'name' => 'string'
	];

	public static array $rules = [
		'realm_id' => 'required|exists:realms,id',
		'name' => 'required|string|max:50',//TODO: unique to Realm
		'rank' => 'nullable|integer',
		'minimumattendance' => 'integer',
		'minimumcutoff' => 'integer'
	];
	
	public $relationships = [
		'chapters' => 'HasMany',
		'offices' => 'MorphMany',
		'realm' => 'BelongsTo'
	];
	
	public function chapters(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Chapter::class, 'chaptertype_id');
	}
	
	public function offices(): \Illuminate\Database\Eloquent\Relations\MorphMany
	{
		return $this->morphMany(Office::class, 'officeable');
	}
	
	public function realm(): \Illuminate\Database\Eloquent\Relations\BelongsTo
	{
		return $this->belongsTo(\App\Models\Realm::class, 'realm_id');
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
