<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Account
 *
 * @OA\Schema (
 * 	schema="Account",
 * 	required={"accountable_type","accountable_id","name","type"},
 * 	description="Financial Accounts for Realms, Chapters, and Units<br>The following relationships can be attached, and in the case of plural relations, searched:
 * accountable (Realm, Chapter, or Unit) (MorphTo): Realm, Chapter, or Unit that owns this Account.
 * parent (Account) (BelongsTo): Parent Account, if any.
 * splits (Split) (HasMany): Splits for this Account.
 * createdBy (User) (BelongsTo): User that created it.
 * updatedBy (User) (BelongsTo): User that last updated it (if any).
 * deletedBy (User) (BelongsTo): User that deleted it (if any).",
 * 	@OA\Property(
 * 		property="id",
 * 		description="The entry's ID.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="parent_id",
 * 		description="The superior Account ID, if any.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="accountable_type",
 * 		description="Who owns the account; Realm, Chapter, or Unit",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="enum",
 * 		enum={"Realm","Chapter","Unit"},
 * 		example="Realm"
 * 	),
 * 	@OA\Property(
 * 		property="accountable_id",
 * 		description="The ID of the owner of this Account.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="name",
 * 		description="Account label.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="uppercase first letter",
 * 		example="Dues",
 * 		maxLength=50
 * 	),
 * 	@OA\Property(
 * 		property="type",
 * 		description="The type of Account this is; Imbalance, Income, Expense, Asset, Liability, or Equity",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="enum",
 * 		enum={"Imbalance","Income","Expense","Asset","Liability","Equity"},
 * 		example="Imbalance"
 * 	),
 * 	@OA\Property(
 * 		property="created_by",
 * 		description="The User that created this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true,
 * 		default=1
 * 	),
 * 	@OA\Property(
 * 		property="createdBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_by",
 * 		description="The last User to update this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updatedBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_by",
 * 		description="The User that softdeleted this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deletedBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="created_at",
 * 		description="When the entry was created.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_at",
 * 		description="When the entry was last updated.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_at",
 * 		description="When the entry was softdeleted.  Null if not softdeleted.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="parent",
 * 		type="object",
 * 		description="The superior Account.",
 * 		ref="#/components/schemas/AccountSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="splits",
 * 		description="Attachable & filterable array of Splits for this Account.",
 * 		type="array",
 * 		@OA\Items(
 * 			title="Split",
 * 			type="object",
 * 			ref="#/components/schemas/SplitSimple"
 * 		),
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="accountable",
 * 		type="object",
 * 		description="Attachable object that owns the Account.",
 * 		oneOf={
 * 			@OA\Schema(ref="#/components/schemas/RealmSimple"),
 * 			@OA\Schema(ref="#/components/schemas/ChapterSimple"),
 * 			@OA\Schema(ref="#/components/schemas/UnitSimple")
 * 		},
 * 		readOnly=true
 * 	)
 * )
 * @OA\Schema (
 * 	schema="AccountSimple",
 * 	title="AccountSimple",
 * 	description="Attachable Account object with no attachments.",
 * 	@OA\Property(
 * 		property="id",
 * 		description="The entry's ID.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="parent_id",
 * 		description="The superior Account ID, if any.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="accountable_type",
 * 		description="Who owns the account; Realm, Chapter, or Unit",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="enum",
 * 		enum={"Realm","Chapter","Unit"},
 * 		example="Realm"
 * 	),
 * 	@OA\Property(
 * 		property="accountable_id",
 * 		description="The ID of the owner of this Account.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="name",
 * 		description="Account label.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		maxLength=50
 * 	),
 * 	@OA\Property(
 * 		property="type",
 * 		description="The type of Account this is; Imbalance, Income, Expense, Asset, Liability, or Equity",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="enum",
 * 		enum={"Imbalance","Income","Expense","Asset","Liability","Equity"},
 * 		example="Imbalance"
 * 	),
 * 	@OA\Property(
 * 		property="created_by",
 * 		description="The User that created this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true,
 * 		default=1
 * 	),
 * 	@OA\Property(
 * 		property="updated_by",
 * 		description="The last User to update this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_by",
 * 		description="The User that softdeleted this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="created_at",
 * 		description="When the entry was created.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_at",
 * 		description="When the entry was last updated.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_at",
 * 		description="When the entry was softdeleted.  Null if not softdeleted.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	)
 * )
 * @OA\Schema (
 * 	schema="AccountSuperSimple",
 * 	title="AccountSuperSimpleSimple",
 * 	description="Attachable Account object with no attachments or CUD data.",
 * 	@OA\Property(
 * 		property="id",
 * 		description="The entry's ID.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="parent_id",
 * 		description="The superior Account ID, if any.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="accountable_type",
 * 		description="Who owns the account; Realm, Chapter, or Unit",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="enum",
 * 		enum={"Realm","Chapter","Unit"},
 * 		example="Realm"
 * 	),
 * 	@OA\Property(
 * 		property="accountable_id",
 * 		description="The ID of the owner of this Account.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="name",
 * 		description="Account label.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		maxLength=50
 * 	),
 * 	@OA\Property(
 * 		property="type",
 * 		description="The type of Account this is; Imbalance, Income, Expense, Asset, Liability, or Equity",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="enum",
 * 		enum={"Imbalance","Income","Expense","Asset","Liability","Equity"},
 * 		example="Imbalance"
 * 	)
 * )
 * @OA\RequestBody (
 * 	request="Account",
 * 	description="Account object that needs to be added or updated.",
 * 	required=true,
 * 	@OA\MediaType(
 * 		mediaType="multipart/form-data",
 * 		@OA\Schema(ref="#/components/schemas/AccountSimple")
 * 	)
 * )
 * @property int $id Model ID
 * @property int|null $parent_id The superior Account ID, if any
 * @property string $accountable_type Who owns the account; Chapter, Realm, or Unit
 * @property int $accountable_id The ID of the owner of this account
 * @property string $name Account label
 * @property string $type Asset, Equity, Expense, Imbalance, Income, or Liability
 * @property int $created_by
 * @property \Illuminate\Support\Carbon $created_at
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $deleted_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $accountable
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\User $createdBy
 * @property-read \App\Models\User $creator
 * @property-read \App\Models\User|null $deletedBy
 * @property-read \App\Models\User|null $destroyer
 * @property-read \App\Models\User|null $editor
 * @property-read Account|null $parent
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Split> $splits
 * @property-read int|null $splits_count
 * @property-read \App\Models\User|null $updatedBy
 * @method static \Database\Factories\AccountFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Account newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Account newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Account onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Account query()
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereAccountableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereAccountableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Account withoutTrashed()
 */
	class Account extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Archetype
 *
 * @OA\Schema (
 * 	schema="Archetype",
 * 	required={"name","is_active"},
 * 	description="Archetypes (Classes) one could take credits in.<br>The following relationships can be attached, and in the case of plural relations, searched:
 * attendances (Attendance) (HasMany): Attendances with this Archetype.
 * reconciliations (Reconciliation) (HasMany): Reconciliations with this Archetype.
 * createdBy (User) (BelongsTo): User that created it.
 * updatedBy (User) (BelongsTo): User that last updated it (if any).
 * deletedBy (User) (BelongsTo): User that deleted it (if any).",
 * 	@OA\Property(
 * 		property="id",
 * 		description="The entry's ID.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="name",
 * 		description="Archetype label.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="uppercase first letter",
 * 		example="Barbarian",
 * 		maxLength=50
 * 	),
 * 	@OA\Property(
 * 		property="is_active",
 * 		description="Is it (default true) a current option?",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="enum",
 * 		enum={0, 1},
 * 		example=0,
 * 		default=1
 * 	),
 * 	@OA\Property(
 * 		property="created_by",
 * 		description="The User that created this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true,
 * 		default=1
 * 	),
 * 	@OA\Property(
 * 		property="createdBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_by",
 * 		description="The last User to update this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updatedBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_by",
 * 		description="The User that softdeleted this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deletedBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="created_at",
 * 		description="When the entry was created.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_at",
 * 		description="When the entry was last updated.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_at",
 * 		description="When the entry was softdeleted.  Null if not softdeleted.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="attendances",
 * 		description="Attachable & filterable array of Attendances with this Archetype.",
 * 		type="array",
 * 		@OA\Items(
 * 			title="Attendance",
 * 			type="object",
 * 			ref="#/components/schemas/AttendanceSimple"
 * 		),
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="reconciliations",
 * 		description="Attachable & filterable array of Reconciliations with this Archetype.",
 * 		type="array",
 * 		@OA\Items(
 * 			title="Reconciliation",
 * 			type="object",
 * 			ref="#/components/schemas/ReconciliationSimple"
 * 		),
 * 		readOnly=true
 * 	)
 * )
 * )
 * @OA\Schema (
 * 	schema="ArchetypeSimple",
 * 	title="ArchetypeSimple",
 * 	description="Attachable Archetype object with no attachments.",
 * 	@OA\Property(
 * 		property="id",
 * 		description="The entry's ID.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="name",
 * 		description="Archetype label.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="uppercase first letter",
 * 		example="Barbarian",
 * 		maxLength=50
 * 	),
 * 	@OA\Property(
 * 		property="is_active",
 * 		description="Is it (default true) a current option?",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="enum",
 * 		enum={0, 1},
 * 		example=0,
 * 		default=1
 * 	),
 * 	@OA\Property(
 * 		property="created_by",
 * 		description="The User that created this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true,
 * 		default=1
 * 	),
 * 	@OA\Property(
 * 		property="updated_by",
 * 		description="The last User to update this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_by",
 * 		description="The User that softdeleted this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="created_at",
 * 		description="When the entry was created.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_at",
 * 		description="When the entry was last updated.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_at",
 * 		description="When the entry was softdeleted.  Null if not softdeleted.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	)
 * )
 * @OA\Schema (
 * 	schema="ArchetypeSuperSimple",
 * 	title="ArchetypeSuperSimpleSimple",
 * 	description="Attachable Archetype object with no attachments or CUD data.",
 * 	@OA\Property(
 * 		property="id",
 * 		description="The entry's ID.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="name",
 * 		description="Archetype label.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="uppercase first letter",
 * 		example="Barbarian",
 * 		maxLength=50
 * 	),
 * 	@OA\Property(
 * 		property="is_active",
 * 		description="Is it (default true) a current option?",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="enum",
 * 		enum={0, 1},
 * 		example=0,
 * 		default=1
 * 	)
 * )
 * @OA\RequestBody (
 * 	request="Archetype",
 * 	description="Archetype object that needs to be added or updated.",
 * 	required=true,
 * 	@OA\MediaType(
 * 		mediaType="multipart/form-data",
 * 		@OA\Schema(ref="#/components/schemas/ArchetypeSimple")
 * 	)
 * )
 * @property int $id Model ID
 * @property string $name Archetype label
 * @property bool $is_active Is it (default true) a current option?
 * @property int $created_by
 * @property \Illuminate\Support\Carbon $created_at
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $deleted_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Attendance> $attendances
 * @property-read int|null $attendances_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\User $createdBy
 * @property-read \App\Models\User $creator
 * @property-read \App\Models\User|null $deletedBy
 * @property-read \App\Models\User|null $destroyer
 * @property-read \App\Models\User|null $editor
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Reconciliation> $reconciliations
 * @property-read int|null $reconciliations_count
 * @property-read \App\Models\User|null $updatedBy
 * @method static \Database\Factories\ArchetypeFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Archetype newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Archetype newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Archetype onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Archetype query()
 * @method static \Illuminate\Database\Eloquent\Builder|Archetype whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Archetype whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Archetype whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Archetype whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Archetype whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Archetype whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Archetype whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Archetype whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Archetype whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Archetype withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Archetype withoutTrashed()
 */
	class Archetype extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Attendance
 *
 * @OA\Schema (
 * 	schema="Attendance",
 * 	required={"persona_id","attendable_type","attendable_id","attended_at","credits"},
 * 	description="Records of Attendance at an Event or Meetup.<br>The following relationships can be attached, and in the case of plural relations, searched:
 * attendable (Event or Meetup) (MorphTo): Event or Meetup the Attendance is for.
 * archetype (Archetype) (BelongsTo): Selected Archetype for the Attendance.
 * persona (Persona) (BelongsTo): Selected Persona receiveing the Attendance credit.
 * createdBy (User) (BelongsTo): User that created it.
 * updatedBy (User) (BelongsTo): User that last updated it (if any).
 * deletedBy (User) (BelongsTo): User that deleted it (if any).",
 * 	@OA\Property(
 * 		property="id",
 * 		description="The entry's ID.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="persona_id",
 * 		description="Attendee Persona ID.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="archetype_id",
 * 		description="ID of the selected Archetype for the Attendance.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="attendable_type",
 * 		description="Where the Attendance occured; Meetup or Event",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="enum",
 * 		enum={"Meetup","Event"},
 * 		example="Meetup"
 * 	),
 * 	@OA\Property(
 * 		property="attendable_id",
 * 		description="The ID of where the Attendance occured.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="attended_at",
 * 		description="The date of the Attendance.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59"
 * 	),
 * 	@OA\Property(
 * 		property="credits",
 * 		description="Credits (default 1) awarded for the Attendance",
 * 		readOnly=false,
 * 		nullable=false,
 *  		type="number",
 *  		format="float",
 *  		example=1,
 *  		default=1
 * 	),
 * 	@OA\Property(
 * 		property="created_by",
 * 		description="The User that created this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true,
 * 		default=1
 * 	),
 * 	@OA\Property(
 * 		property="createdBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_by",
 * 		description="The last User to update this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updatedBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_by",
 * 		description="The User that softdeleted this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deletedBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="created_at",
 * 		description="When the entry was created.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_at",
 * 		description="When the entry was last updated.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_at",
 * 		description="When the entry was softdeleted.  Null if not softdeleted.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="attendable",
 * 		type="object",
 * 		description="Attachable object that was attended.",
 * 		oneOf={
 * 			@OA\Schema(ref="#/components/schemas/MeetupSimple"),
 * 			@OA\Schema(ref="#/components/schemas/EventSimple")
 * 		},
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="archetype",
 * 		type="object",
 * 		description="Attachable Archetype for the Attendance.",
 * 		ref="#/components/schemas/ArchetypeSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="persona",
 * 		type="object",
 * 		description="Attachable Persona receiveing the Attendance credit.",
 * 		ref="#/components/schemas/PersonaSimple",
 * 		readOnly=true
 * 	)
 * )
 * @OA\Schema (
 * 	schema="AttendanceSimple",
 * 	title="AttendanceSimple",
 * 	description="Attachable Attendance object with no attachments.",
 * 	@OA\Property(
 * 		property="id",
 * 		description="The entry's ID.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="persona_id",
 * 		description="Attendee Persona ID.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="archetype_id",
 * 		description="ID of the selected Archetype for the Attendance.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="attendable_type",
 * 		description="Where the Attendance occured; Meetup or Event",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="enum",
 * 		enum={"Meetup","Event"},
 * 		example="Meetup"
 * 	),
 * 	@OA\Property(
 * 		property="attendable_id",
 * 		description="The ID of where the Attendance occured.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="attended_at",
 * 		description="The date of the Attendance.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59"
 * 	),
 * 	@OA\Property(
 * 		property="credits",
 * 		description="Credits (default 1) awarded for the Attendance",
 * 		readOnly=false,
 * 		nullable=false,
 *  		type="number",
 *  		format="float",
 *  		default=1
 * 	),
 * 	@OA\Property(
 * 		property="created_by",
 * 		description="The User that created this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true,
 * 		default=1
 * 	),
 * 	@OA\Property(
 * 		property="updated_by",
 * 		description="The last User to update this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_by",
 * 		description="The User that softdeleted this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="created_at",
 * 		description="When the entry was created.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_at",
 * 		description="When the entry was last updated.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_at",
 * 		description="When the entry was softdeleted.  Null if not softdeleted.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	)
 * )
 * @OA\Schema (
 * 	schema="AttendanceSuperSimple",
 * 	title="AttendanceSuperSimpleSimple",
 * 	description="Attachable Attendance object with no attachments or CUD data.",
 * 	@OA\Property(
 * 		property="id",
 * 		description="The entry's ID.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="persona_id",
 * 		description="Attendee Persona ID.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="archetype_id",
 * 		description="ID of the selected Archetype for the Attendance.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="attendable_type",
 * 		description="Where the Attendance occured; Meetup or Event",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="enum",
 * 		enum={"Meetup","Event"},
 * 		example="Meetup"
 * 	),
 * 	@OA\Property(
 * 		property="attendable_id",
 * 		description="The ID of where the Attendance occured.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="attended_at",
 * 		description="The date of the Attendance.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59"
 * 	),
 * 	@OA\Property(
 * 		property="credits",
 * 		description="Credits (default 1) awarded for the Attendance",
 * 		readOnly=false,
 * 		nullable=false,
 *  		type="number",
 *  		format="float",
 *  		default=1
 * 	)
 * )
 * @OA\RequestBody (
 * 	request="Attendance",
 * 	description="Attendance object that needs to be added or updated.",
 * 	required=true,
 * 	@OA\MediaType(
 * 		mediaType="multipart/form-data",
 * 		@OA\Schema(ref="#/components/schemas/AttendanceSimple")
 * 	)
 * )
 * @property int $id Model ID
 * @property int $archetype_id Selected Archetype for Attendance
 * @property string $attendable_type Where the Attendance occured; Event or Meetup
 * @property int $attendable_id The ID of where the Attendance occured
 * @property int $persona_id Attendee Persona ID
 * @property \Illuminate\Support\Carbon $attended_at The date of the Attendance
 * @property float $credits Credits (default 1) awarded for the Attendance
 * @property int $created_by
 * @property \Illuminate\Support\Carbon $created_at
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $deleted_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Archetype $archetype
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $attendable
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\User $createdBy
 * @property-read \App\Models\User $creator
 * @property-read \App\Models\User|null $deletedBy
 * @property-read \App\Models\User|null $destroyer
 * @property-read \App\Models\User|null $editor
 * @property-read \App\Models\Persona $persona
 * @property-read \App\Models\User|null $updatedBy
 * @method static \Database\Factories\AttendanceFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance query()
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance whereArchetypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance whereAttendableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance whereAttendableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance whereAttendedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance whereCredits($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance wherePersonaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance withoutTrashed()
 */
	class Attendance extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Award
 *
 * @OA\Schema (
 * 	schema="Award",
 * 	required={"awarder_type","name","is_ladder"},
 * 	description="Awards available in a given (or all) Realm(s), Chapter, or Unit.<br>The following relationships can be attached, and in the case of plural relations, searched:
 * awarder (Chapter, Realm, or Unit) (MorphTo): The Realm, Chapter, or Unit that Issues this Award.
 * issuances (Issuance) (MorphMany): Issuances of this Award.
 * recommendations (Recommendation) (MorphMany): Recommendations to Issue this Award.
 * createdBy (User) (BelongsTo): User that created it.
 * updatedBy (User) (BelongsTo): User that last updated it (if any).
 * deletedBy (User) (BelongsTo): User that deleted it (if any).",
 * 	@OA\Property(
 * 		property="id",
 * 		description="The entry's ID.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="awarder_type",
 * 		description="Who issues the Award; Realm, Chapter, or Unit.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="enum",
 * 		enum={"Realm","Chapter","Unit"},
 * 		example="Realm"
 * 	),
 * 	@OA\Property(
 * 		property="awarder_id",
 * 		description="The ID of the award issuer, null for all.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="name",
 * 		description="The Award label, with options for the label seperated with |.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="uppercase first letter",
 * 		example="Order of the Rose",
 * 		maxLength=100
 * 	),
 * 	@OA\Property(
 * 		property="is_ladder",
 * 		description="Is this (default false) a ranked/ladder award?",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="enum",
 * 		enum={0, 1},
 * 		example=0,
 * 		default=0
 * 	),
 * 	@OA\Property(
 * 		property="created_by",
 * 		description="The User that created this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true,
 * 		default=1
 * 	),
 * 	@OA\Property(
 * 		property="createdBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_by",
 * 		description="The last User to update this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updatedBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_by",
 * 		description="The User that softdeleted this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deletedBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="created_at",
 * 		description="When the entry was created.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_at",
 * 		description="When the entry was last updated.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_at",
 * 		description="When the entry was softdeleted.  Null if not softdeleted.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="awarder",
 * 		type="object",
 * 		description="Attachable object that Issues the Award.",
 * 		oneOf={
 * 			@OA\Schema(ref="#/components/schemas/RealmSimple"),
 * 			@OA\Schema(ref="#/components/schemas/ChapterSimple"),
 * 			@OA\Schema(ref="#/components/schemas/UnitSimple")
 * 		},
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="issuances",
 * 		description="Attachable & filterable array of Issuances of this Award.",
 * 		type="array",
 * 		@OA\Items(
 * 			title="Issuance",
 * 			type="object",
 * 			ref="#/components/schemas/IssuanceSimple"
 * 		),
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="recommendations",
 * 		description="Attachable & filterable array of Recommendations to Issue this Award.",
 * 		type="array",
 * 		@OA\Items(
 * 			title="Recommendation",
 * 			type="object",
 * 			ref="#/components/schemas/RecommendationSimple"
 * 		),
 * 		readOnly=true
 * 	)
 * )
 * @OA\Schema (
 * 	schema="AwardSimple",
 * 	title="AwardSimple",
 * 	description="Attachable Award object with no attachments.",
 * 	@OA\Property(
 * 		property="id",
 * 		description="The entry's ID.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="awarder_type",
 * 		description="Who issues the Award; Realm, Chapter, or Unit.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="enum",
 * 		enum={"Realm","Chapter","Unit"},
 * 		example="Realm"
 * 	),
 * 	@OA\Property(
 * 		property="awarder_id",
 * 		description="The ID of the award issuer, null for all.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="name",
 * 		description="The Award label, with options for the label seperated with |.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="uppercase first letter",
 * 		example="Order of the Rose",
 * 		maxLength=100
 * 	),
 * 	@OA\Property(
 * 		property="is_ladder",
 * 		description="Is this (default false) a ranked/ladder award?",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="enum",
 * 		enum={0, 1},
 * 		example=0,
 * 		default=0
 * 	),
 * 	@OA\Property(
 * 		property="created_by",
 * 		description="The User that created this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true,
 * 		default=1
 * 	),
 * 	@OA\Property(
 * 		property="updated_by",
 * 		description="The last User to update this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_by",
 * 		description="The User that softdeleted this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="created_at",
 * 		description="When the entry was created.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_at",
 * 		description="When the entry was last updated.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_at",
 * 		description="When the entry was softdeleted.  Null if not softdeleted.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	)
 * )
 * @OA\Schema (
 * 	schema="AwardSuperSimple",
 * 	title="AwardSuperSimpleSimple",
 * 	description="Attachable Award object with no attachments or CUD data.",
 * 	@OA\Property(
 * 		property="id",
 * 		description="The entry's ID.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="awarder_type",
 * 		description="Who issues the Award; Realm, Chapter, or Unit.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="enum",
 * 		enum={"Realm","Chapter","Unit"},
 * 		example="Realm"
 * 	),
 * 	@OA\Property(
 * 		property="awarder_id",
 * 		description="The ID of the award issuer, null for all.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="name",
 * 		description="The Award label, with options for the label seperated with |.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="uppercase first letter",
 * 		example="Order of the Rose",
 * 		maxLength=100
 * 	),
 * 	@OA\Property(
 * 		property="is_ladder",
 * 		description="Is this (default false) a ranked/ladder award?",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="enum",
 * 		enum={0, 1},
 * 		example=0,
 * 		default=0
 * 	)
 * )
 * @OA\RequestBody (
 * 	request="Award",
 * 	description="Award object that needs to be added or updated.",
 * 	required=true,
 * 	@OA\MediaType(
 * 		mediaType="multipart/form-data",
 * 		@OA\Schema(ref="#/components/schemas/AwardSimple")
 * 	)
 * )
 * @property int $id Model ID
 * @property string $awarder_type Who issues the Award; Chapter, Realm, or Unit
 * @property int|null $awarder_id The ID of the award issuer, null for everybody
 * @property string $name The Award label, with options for the label seperated with |
 * @property bool $is_ladder Is this (default false) a ranked/ladder award?
 * @property int $created_by
 * @property \Illuminate\Support\Carbon $created_at
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $deleted_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $awarder
 * @property-read \App\Models\User $createdBy
 * @property-read \App\Models\User $creator
 * @property-read \App\Models\User|null $deletedBy
 * @property-read \App\Models\User|null $destroyer
 * @property-read \App\Models\User|null $editor
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Issuance> $issuances
 * @property-read int|null $issuances_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Recommendation> $recommendations
 * @property-read int|null $recommendations_count
 * @property-read \App\Models\User|null $updatedBy
 * @method static \Database\Factories\AwardFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Award newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Award newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Award onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Award query()
 * @method static \Illuminate\Database\Eloquent\Builder|Award whereAwarderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Award whereAwarderType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Award whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Award whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Award whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Award whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Award whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Award whereIsLadder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Award whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Award whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Award whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Award withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Award withoutTrashed()
 */
	class Award extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\BaseModel
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel query()
 */
	class BaseModel extends \Eloquent implements \OwenIt\Auditing\Contracts\Auditable {}
}

namespace App\Models{
/**
 * App\Models\Chapter
 *
 * @OA\Schema (
 * 	schema="Chapter",
 * 	required={"realm_id","chaptertype_id","location_id","name","abbreviation","is_active"},
 * 	description="Amtgard Chapters<br>The following relationships can be attached, and in the case of plural relations, searched:
 * accounts (Account) (MorphMany): Accounts this Chapter owns.
 * awards (Award) (MorphMany): Awards this Chapter can Issue.
 * chaptertype (Chaptertype) (BelongsTo): The level of the Chapter (Shire, etc).
 * events (Event) (MorphMany): Events this Chapter has run.
 * issuances (Issuance) (MorphMany): Awards and Titles Issued by this Chapter.
 * location (Location) (BelongsTo): The official location for the Chapter.
 * nearbyGuests (Guest) (HasMany): Guests at Demos that live near this Chapter.
 * meetups (Meetup) (HasMany): Meetups hosted by this Chapter.
 * personas (Persona) (HasMany): Personas that claim this as their home.
 * realm (Realm) (BelongsTo): Realm the Chapter is associated with.
 * reign (Reign) (MorphOne): The current Reign for the Chapter.
 * reigns (Reign) (MorphMany): Reigns for the Chapter.
 * socials (Social) (MorphMany): Socials for the Chapter.
 * sponsors (Event) (MorphMany): Persona or Unit Events this Chapter has sponsored.
 * suspensions (Suspension) (MorphMany): Suspensions levied by the Chapter.
 * titles (Title) (MorphMany): Titles the Chapter Issues.
 * createdBy (User) (BelongsTo): User that created it.
 * updatedBy (User) (BelongsTo): User that last updated it (if any).
 * deletedBy (User) (BelongsTo): User that deleted it (if any).",
 * 	@OA\Property(
 * 		property="id",
 * 		description="The entry's ID.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="realm_id",
 * 		description="The ID of the Realm sponsoring the Chapter.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="chaptertype_id",
 * 		description="The ID of the Chaptertype earned by the Chapter.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="location_id",
 * 		description="The ID of the Location that best describes where the Chapter is.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="name",
 * 		description="The Chapter name, unique to the Realm.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="uppercase first letter",
 * 		example="Adjective Geography",
 * 		maxLength=100
 * 	),
 * 	@OA\Property(
 * 		property="abbreviation",
 * 		description="A short abbreviation of the Chapter name, unique to the Realm.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="uppercase",
 * 		maxLength=3,
 * 	),
 * 	@OA\Property(
 * 		property="heraldry",
 * 		description="An internal link to an image of the Chapter heraldry, if any.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="filename",
 * 		example="images/chapters/42.jpg",
 * 		maxLength=191
 * 	),
 * 	@OA\Property(
 * 		property="is_active",
 * 		description="Is the Chapter (default true) still active?",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="enum",
 * 		enum={0, 1},
 * 		example=0,
 * 		default=1
 * 	),
 * 	@OA\Property(
 * 		property="created_by",
 * 		description="The User that created this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="createdBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_by",
 * 		description="The last User to update this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updatedBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_by",
 * 		description="The User that softdeleted this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deletedBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="created_at",
 * 		description="When the entry was created.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_at",
 * 		description="When the entry was last updated.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_at",
 * 		description="When the entry was softdeleted.  Null if not softdeleted.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="accounts",
 * 		description="Attachable & filterable array of Accounts this Chapter owns.",
 * 		type="array",
 * 		@OA\Items(
 * 			title="Account",
 * 			type="object",
 * 			ref="#/components/schemas/AccountSimple"
 * 		),
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="awards",
 * 		description="Attachable & filterable array of Awards this Chapter can Issue.",
 * 		type="array",
 * 		@OA\Items(
 * 			title="Award",
 * 			type="object",
 * 			ref="#/components/schemas/AwardSimple"
 * 		),
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="chaptertype",
 * 		type="object",
 * 		description="Attachable Chaptertype for this Chapter.",
 * 		ref="#/components/schemas/ChaptertypeSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="events",
 * 		description="Attachable & filterable array of Events this Chapter has run.",
 * 		type="array",
 * 		@OA\Items(
 * 			title="Event",
 * 			type="object",
 * 			ref="#/components/schemas/EventSimple"
 * 		),
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="issuances",
 * 		description="Attachable & filterable array of Issuances this Chapter has made.",
 * 		type="array",
 * 		@OA\Items(
 * 			title="Issuance",
 * 			type="object",
 * 			ref="#/components/schemas/IssuanceSimple"
 * 		),
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="location",
 * 		type="object",
 * 		description="Attachable Location for this Chapter.",
 * 		ref="#/components/schemas/LocationSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="meetups",
 * 		description="Attachable & filterable array of Meetups for this Chapter.",
 * 		type="array",
 * 		@OA\Items(
 * 			title="Meetup",
 * 			type="object",
 * 			ref="#/components/schemas/MeetupSimple"
 * 		),
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="nearbyGuests",
 * 		description="Attachable & filterable array of Demo Guests that live near the Chapter.",
 * 		type="array",
 * 		@OA\Items(
 * 			title="Guest",
 * 			type="object",
 * 			ref="#/components/schemas/GuestSimple"
 * 		),
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="personas",
 * 		description="Attachable & filterable array of Personas for this Chapter.",
 * 		type="array",
 * 		@OA\Items(
 * 			title="Persona",
 * 			type="object",
 * 			ref="#/components/schemas/PersonaSimple"
 * 		),
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="realm",
 * 		type="object",
 * 		description="Attachable Realm the Chapter is a member of.",
 * 		ref="#/components/schemas/RealmSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="reign",
 * 		description="Attachable & filterable array of the current Reign for the Chapter.",
 * 		type="array",
 * 		@OA\Items(
 * 			title="Reign",
 * 			type="object",
 * 			ref="#/components/schemas/ReignSimple"
 * 		),
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="reigns",
 * 		description="Attachable & filterable array of the Reigns of the Chapter.",
 * 		type="array",
 * 		@OA\Items(
 * 			title="Reign",
 * 			type="object",
 * 			ref="#/components/schemas/ReignSimple"
 * 		),
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="socials",
 * 		description="Attachable & filterable array of the Socials of the Chapter.",
 * 		type="array",
 * 		@OA\Items(
 * 			title="Social",
 * 			type="object",
 * 			ref="#/components/schemas/SocialSimple"
 * 		),
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="sponsors",
 * 		description="Attachable & filterable array of Persona or Unit Events this Chapter has sponsored.",
 * 		type="array",
 * 		@OA\Items(
 * 			title="Event",
 * 			type="object",
 * 			ref="#/components/schemas/EventSimple"
 * 		),
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="suspensions",
 * 		description="Attachable & filterable array of Suspensions levied by the Chapter.",
 * 		type="array",
 * 		@OA\Items(
 * 			title="Suspension",
 * 			type="object",
 * 			ref="#/components/schemas/SuspensionSimple"
 * 		),
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="titles",
 * 		description="Attachable & filterable array of the Titles the Chapter Issues.",
 * 		type="array",
 * 		@OA\Items(
 * 			title="Title",
 * 			type="object",
 * 			ref="#/components/schemas/TitleSimple"
 * 		),
 * 		readOnly=true
 * 	)
 * )
 * @OA\Schema (
 * 	schema="ChapterSimple",
 * 	title="ChapterSimple",
 * 	description="Attachable Chapter object with no attachments.",
 * 	@OA\Property(
 * 		property="id",
 * 		description="The entry's ID.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="realm_id",
 * 		description="The ID of the Realm sponsoring the Chapter.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="chaptertype_id",
 * 		description="The ID of the Chaptertype earned by the Chapter.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="location_id",
 * 		description="The ID of the Location that best describes where the Chapter is.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="name",
 * 		description="The Chapter name, unique to the Realm.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="uppercase first letter",
 * 		example="Adjective Geography",
 * 		maxLength=100
 * 	),
 * 	@OA\Property(
 * 		property="abbreviation",
 * 		description="A short abbreviation of the Chapter name, unique to the Realm.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="uppercase",
 * 		maxLength=3,
 * 	),
 * 	@OA\Property(
 * 		property="heraldry",
 * 		description="An internal link to an image of the Chapter heraldry, if any.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="filename",
 * 		example="/images/heraldry/chapters/42.jpg",
 * 		maxLength=191
 * 	),
 * 	@OA\Property(
 * 		property="is_active",
 * 		description="Is the Chapter (default true) still active?",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="enum",
 * 		enum={0, 1},
 * 		example=0,
 * 		default=1
 * 	),
 * 	@OA\Property(
 * 		property="created_by",
 * 		description="The User that created this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_by",
 * 		description="The last User to update this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_by",
 * 		description="The User that softdeleted this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="created_at",
 * 		description="When the entry was created.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_at",
 * 		description="When the entry was last updated.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_at",
 * 		description="When the entry was softdeleted.  Null if not softdeleted.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	)
 * )
 * @OA\Schema (
 * 	schema="ChapterSuperSimple",
 * 	title="ChapterSuperSimpleSimple",
 * 	description="Attachable Chapter object with no attachments or CUD data.",
 * 	@OA\Property(
 * 		property="id",
 * 		description="The entry's ID.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="realm_id",
 * 		description="The ID of the Realm sponsoring the Chapter.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="chaptertype_id",
 * 		description="The ID of the Chaptertype earned by the Chapter.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="location_id",
 * 		description="The ID of the Location that best describes where the Chapter is.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="name",
 * 		description="The Chapter name, unique to the Realm.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="uppercase first letter",
 * 		example="Adjective Geography",
 * 		maxLength=100
 * 	),
 * 	@OA\Property(
 * 		property="abbreviation",
 * 		description="A short abbreviation of the Chapter name, unique to the Realm.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="uppercase",
 * 		maxLength=3,
 * 	),
 * 	@OA\Property(
 * 		property="heraldry",
 * 		description="An internal link to an image of the Chapter heraldry, if any.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="filename",
 * 		example="/images/heraldry/chapters/42.jpg",
 * 		maxLength=191
 * 	),
 * 	@OA\Property(
 * 		property="is_active",
 * 		description="Is the Chapter (default true) still active?",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="enum",
 * 		enum={0, 1},
 * 		example=0,
 * 		default=1
 * 	)
 * )
 * @OA\RequestBody (
 * 	request="Chapter",
 * 	description="Chapter object that needs to be added or updated.",
 * 	required=true,
 * 	@OA\MediaType(
 * 		mediaType="multipart/form-data",
 * 		@OA\Schema(ref="#/components/schemas/ChapterSimple")
 * 	)
 * )
 * @property int $id Model ID
 * @property int $realm_id The ID of the Realm sponsoring the Chapter
 * @property int $chaptertype_id The ID of the Chaptertype earned by the Chapter
 * @property int $location_id The ID of the Location that best describes where the Chapter is
 * @property string $name The Chapter name
 * @property string $abbreviation A short abbreviation of the Chapter name, unique for the Realm
 * @property string|null $heraldry An internal link to an image of the Chapter heraldry, if any
 * @property bool $is_active Is (default true) the Chapter still active?
 * @property int $created_by
 * @property \Illuminate\Support\Carbon $created_at
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $deleted_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Account> $accounts
 * @property-read int|null $accounts_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Award> $awards
 * @property-read int|null $awards_count
 * @property-read \App\Models\Chaptertype $chaptertype
 * @property-read \App\Models\User $createdBy
 * @property-read \App\Models\User $creator
 * @property-read \App\Models\User|null $deletedBy
 * @property-read \App\Models\User|null $destroyer
 * @property-read \App\Models\User|null $editor
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Event> $events
 * @property-read int|null $events_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Issuance> $issuances
 * @property-read int|null $issuances_count
 * @property-read \App\Models\Location $location
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Meetup> $meetups
 * @property-read int|null $meetups_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Guest> $nearbyGuests
 * @property-read int|null $nearby_guests_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Persona> $personas
 * @property-read int|null $personas_count
 * @property-read \App\Models\Realm $realm
 * @property-read \App\Models\Reign|null $reign
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Reign> $reigns
 * @property-read int|null $reigns_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Social> $socials
 * @property-read int|null $socials_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Event> $sponsors
 * @property-read int|null $sponsors_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Social> $suspensions
 * @property-read int|null $suspensions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Title> $titles
 * @property-read int|null $titles_count
 * @property-read \App\Models\User|null $updatedBy
 * @method static \Database\Factories\ChapterFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Chapter newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Chapter newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Chapter onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Chapter query()
 * @method static \Illuminate\Database\Eloquent\Builder|Chapter whereAbbreviation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chapter whereChaptertypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chapter whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chapter whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chapter whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chapter whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chapter whereHeraldry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chapter whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chapter whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chapter whereLocationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chapter whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chapter whereRealmId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chapter whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chapter whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chapter withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Chapter withoutTrashed()
 */
	class Chapter extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Chaptertype
 *
 * @OA\Schema (
 * 	schema="Chaptertype",
 * 	required={"realm_id","name","minimumattendance","minimumcutoff"},
 * 	description="Levels available for Chapters by Realm<br>The following relationships can be attached, and in the case of plural relations, searched:
 * chapters (Chapter) (HasMany): Chapters that share this Chaptertype.
 * offices (Office) (MorphMany): Offices for this Chaptertype.
 * realm (Realm) (BelongsTo): Realm for the Chaptertype.
 * createdBy (User) (BelongsTo): User that created it.
 * updatedBy (User) (BelongsTo): User that last updated it (if any).
 * deletedBy (User) (BelongsTo): User that deleted it (if any).",
 * 	@OA\Property(
 * 		property="id",
 * 		description="The entry's ID.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="realm_id",
 * 		description="The ID of the Realm that has this Chaptertype.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="name",
 * 		description="The name of the Chaptertype",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="uppercase first letter",
 * 		example="Shire",
 * 		maxLength=50
 * 	),
 * 	@OA\Property(
 * 		property="rank",
 * 		description="The order rank of the Chaptertype expressed in multiples of 10 where Shire is 20.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="integer",
 * 		format="int32",
 * 		example=20
 * 	),
 * 	@OA\Property(
 * 		property="minimumattendance",
 * 		description="Minimum (default 5) average Attendance required by the Realm to achieve the Chaptertype.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=5,
 *  		default=5
 * 	),
 * 	@OA\Property(
 * 		property="minimumcutoff",
 * 		description="Minimum (default 1) average Attendance required by the Realm to maintain the Chaptertype.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="integer",
 * 		format="int32",
 * 		example=1,
 *  		default=1
 * 	),
 * 	@OA\Property(
 * 		property="created_by",
 * 		description="The User that created this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true,
 * 		default=1
 * 	),
 * 	@OA\Property(
 * 		property="createdBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_by",
 * 		description="The last User to update this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updatedBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_by",
 * 		description="The User that softdeleted this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deletedBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="created_at",
 * 		description="When the entry was created.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_at",
 * 		description="When the entry was last updated.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_at",
 * 		description="When the entry was softdeleted.  Null if not softdeleted.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="chapters",
 * 		description="Attachable & filterable array of Chapters with this Chaptertype.",
 * 		type="array",
 * 		@OA\Items(
 * 			title="Chapter",
 * 			type="object",
 * 			ref="#/components/schemas/ChapterSimple"
 * 		),
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="offices",
 * 		description="Attachable & filterable array of Offices for this Chaptertype.",
 * 		type="array",
 * 		@OA\Items(
 * 			title="Office",
 * 			type="object",
 * 			ref="#/components/schemas/OfficeSimple"
 * 		),
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="realm",
 * 		type="object",
 * 		description="Attachable Realm this Chaptertype is for.",
 * 		ref="#/components/schemas/RealmSimple",
 * 		readOnly=true
 * 	)
 * )
 * @OA\Schema (
 * 	schema="ChaptertypeSimple",
 * 	title="ChaptertypeSimple",
 * 	description="Attachable Chaptertype object with no attachments.",
 * 	@OA\Property(
 * 		property="id",
 * 		description="The entry's ID.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="realm_id",
 * 		description="The ID of the Realm that has this Chaptertype.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="name",
 * 		description="The name of the Chaptertype",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="uppercase first letter",
 * 		example="Shire",
 * 		maxLength=50
 * 	),
 * 	@OA\Property(
 * 		property="rank",
 * 		description="The order rank of the Chaptertype expressed in multiples of 10 where Shire is 20.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="integer",
 * 		format="int32",
 * 		example=20
 * 	),
 * 	@OA\Property(
 * 		property="minimumattendance",
 * 		description="Minimum (default 5) average Attendance required by the Realm to achieve the Chaptertype.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=5,
 *  		default=5
 * 	),
 * 	@OA\Property(
 * 		property="minimumcutoff",
 * 		description="Minimum (default 1) average Attendance required by the Realm to maintain the Chaptertype.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="integer",
 * 		format="int32",
 * 		example=1,
 *  		default=1
 * 	),
 * 	@OA\Property(
 * 		property="created_by",
 * 		description="The User that created this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true,
 * 		default=1
 * 	),
 * 	@OA\Property(
 * 		property="updated_by",
 * 		description="The last User to update this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_by",
 * 		description="The User that softdeleted this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="created_at",
 * 		description="When the entry was created.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_at",
 * 		description="When the entry was last updated.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_at",
 * 		description="When the entry was softdeleted.  Null if not softdeleted.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	)
 * )
 * @OA\Schema (
 * 	schema="ChaptertypeSuperSimple",
 * 	title="ChaptertypeSuperSimpleSimple",
 * 	description="Attachable Chaptertype object with no attachments or CUD data.",
 * 	@OA\Property(
 * 		property="id",
 * 		description="The entry's ID.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="realm_id",
 * 		description="The ID of the Realm that has this Chaptertype.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="name",
 * 		description="The name of the Chaptertype",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="uppercase first letter",
 * 		example="Shire",
 * 		maxLength=50
 * 	),
 * 	@OA\Property(
 * 		property="rank",
 * 		description="The order rank of the Chaptertype expressed in multiples of 10 where Shire is 20.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="integer",
 * 		format="int32",
 * 		example=20
 * 	),
 * 	@OA\Property(
 * 		property="minimumattendance",
 * 		description="Minimum (default 5) average Attendance required by the Realm to achieve the Chaptertype.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=5,
 *  		default=5
 * 	),
 * 	@OA\Property(
 * 		property="minimumcutoff",
 * 		description="Minimum (default 1) average Attendance required by the Realm to maintain the Chaptertype.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="integer",
 * 		format="int32",
 * 		example=1,
 *  		default=1
 * 	)
 * )
 * @OA\RequestBody (
 * 	request="Chaptertype",
 * 	description="Chaptertype object that needs to be added or updated.",
 * 	required=true,
 * 	@OA\MediaType(
 * 		mediaType="multipart/form-data",
 * 		@OA\Schema(ref="#/components/schemas/ChaptertypeSimple")
 * 	)
 * )
 * @property int $id Model ID
 * @property int $realm_id The ID of the Realm that has this Chaptertype
 * @property string $name The name of the Chaptertype
 * @property int|null $rank The rank of the Chaptertype expressed in multiples of 10 where Shire is 20
 * @property int $minimumattendance Minimum average Attendance required by the Realm to achieve the Chaptertype
 * @property int $minimumcutoff Minimum average Attendance required by the Realm to maintain the Chaptertype
 * @property int $created_by
 * @property \Illuminate\Support\Carbon $created_at
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $deleted_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Chapter> $chapters
 * @property-read int|null $chapters_count
 * @property-read \App\Models\User $createdBy
 * @property-read \App\Models\User $creator
 * @property-read \App\Models\User|null $deletedBy
 * @property-read \App\Models\User|null $destroyer
 * @property-read \App\Models\User|null $editor
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Office> $offices
 * @property-read int|null $offices_count
 * @property-read \App\Models\Realm $realm
 * @property-read \App\Models\User|null $updatedBy
 * @method static \Database\Factories\ChaptertypeFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Chaptertype newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Chaptertype newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Chaptertype onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Chaptertype query()
 * @method static \Illuminate\Database\Eloquent\Builder|Chaptertype whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chaptertype whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chaptertype whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chaptertype whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chaptertype whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chaptertype whereMinimumattendance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chaptertype whereMinimumcutoff($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chaptertype whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chaptertype whereRank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chaptertype whereRealmId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chaptertype whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chaptertype whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chaptertype withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Chaptertype withoutTrashed()
 */
	class Chaptertype extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Crat
 *
 * @OA\Schema (
 * 	schema="Crat",
 * 	required={"event_id","persona_id","role","is_autocrat"},
 * 	description="Those running things at Events.<br>The following relationships can be attached, and in the case of plural relations, searched:
 * event (Event) (BelongsTo): Event the Persona cratted for.
 * persona (Persona) (BelongsTo): The Persona cratting the given Event.
 * createdBy (User) (BelongsTo): User that created it.
 * updatedBy (User) (BelongsTo): User that last updated it (if any).
 * deletedBy (User) (BelongsTo): User that deleted it (if any).",
 * 	@OA\Property(
 * 		property="id",
 * 		description="The entry's ID.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="event_id",
 * 		description="Event the Persona cratted for.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="persona_id",
 * 		description="The Persona cratting the Event.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="name",
 * 		description="The role of the Crat.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="uppercase first letter",
 * 		example="FeastOCrat",
 * 		maxLength=50
 * 	),
 * 	@OA\Property(
 * 		property="is_autocrat",
 * 		description="Are they (default false) the person in charge?",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="enum",
 * 		enum={0, 1},
 * 		example=0,
 * 		default=0
 * 	),
 * 	@OA\Property(
 * 		property="created_by",
 * 		description="The User that created this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true,
 * 		default=1
 * 	),
 * 	@OA\Property(
 * 		property="createdBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_by",
 * 		description="The last User to update this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updatedBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_by",
 * 		description="The User that softdeleted this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deletedBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="created_at",
 * 		description="When the entry was created.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_at",
 * 		description="When the entry was last updated.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_at",
 * 		description="When the entry was softdeleted.  Null if not softdeleted.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="event",
 * 		type="object",
 * 		description="Attachable Event the Persona cratted for.",
 * 		ref="#/components/schemas/EventSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="persona",
 * 		type="object",
 * 		description="Attachable Persona cratting the Event.",
 * 		ref="#/components/schemas/PersonaSimple",
 * 		readOnly=true
 * 	)
 * )
 * @OA\Schema (
 * 	schema="CratSimple",
 * 	title="CratSimple",
 * 	description="Attachable Crat object with no attachments.",
 * 	@OA\Property(
 * 		property="id",
 * 		description="The entry's ID.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="event_id",
 * 		description="Event the Persona cratted for.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="persona_id",
 * 		description="The Persona cratting the Event.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="name",
 * 		description="The role of the Crat.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="uppercase first letter",
 * 		example="FeastOCrat",
 * 		maxLength=50
 * 	),
 * 	@OA\Property(
 * 		property="is_autocrat",
 * 		description="Are they (default false) the person in charge?",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="enum",
 * 		enum={0, 1},
 * 		example=0,
 * 		default=0
 * 	),
 * 	@OA\Property(
 * 		property="created_by",
 * 		description="The User that created this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true,
 * 		default=1
 * 	),
 * 	@OA\Property(
 * 		property="updated_by",
 * 		description="The last User to update this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_by",
 * 		description="The User that softdeleted this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="created_at",
 * 		description="When the entry was created.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_at",
 * 		description="When the entry was last updated.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_at",
 * 		description="When the entry was softdeleted.  Null if not softdeleted.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	)
 * )
 * @OA\Schema (
 * 	schema="CratSuperSimple",
 * 	title="CratSuperSimpleSimple",
 * 	description="Attachable Crat object with no attachments or CUD data.",
 * 	@OA\Property(
 * 		property="id",
 * 		description="The entry's ID.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="event_id",
 * 		description="Event the Persona cratted for.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="persona_id",
 * 		description="The Persona cratting the Event.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="name",
 * 		description="The role of the Crat.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="uppercase first letter",
 * 		example="FeastOCrat",
 * 		maxLength=50
 * 	),
 * 	@OA\Property(
 * 		property="is_autocrat",
 * 		description="Are they (default false) the person in charge?",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="enum",
 * 		enum={0, 1},
 * 		example=0,
 * 		default=0
 * 	)
 * )
 * @OA\RequestBody (
 * 	request="Crat",
 * 	description="Crat object that needs to be added or updated.",
 * 	required=true,
 * 	@OA\MediaType(
 * 		mediaType="multipart/form-data",
 * 		@OA\Schema(ref="#/components/schemas/CratSimple")
 * 	)
 * )
 * @property int $id Model ID
 * @property int $event_id Event the Persona cratted for
 * @property int $persona_id The Persona cratting the Event
 * @property string $role The role of the Crat
 * @property bool $is_autocrat Are they (default false) the person in charge?
 * @property int $created_by
 * @property \Illuminate\Support\Carbon $created_at
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $deleted_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\User $createdBy
 * @property-read \App\Models\User $creator
 * @property-read \App\Models\User|null $deletedBy
 * @property-read \App\Models\User|null $destroyer
 * @property-read \App\Models\User|null $editor
 * @property-read \App\Models\Event $event
 * @property-read \App\Models\Persona $persona
 * @property-read \App\Models\User|null $updatedBy
 * @method static \Database\Factories\CratFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Crat newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Crat newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Crat onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Crat query()
 * @method static \Illuminate\Database\Eloquent\Builder|Crat whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Crat whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Crat whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Crat whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Crat whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Crat whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Crat whereIsAutocrat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Crat wherePersonaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Crat whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Crat whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Crat whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Crat withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Crat withoutTrashed()
 */
	class Crat extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Due
 *
 * @OA\Schema (
 * 	schema="Due",
 * 	required={"persona_id","transaction_id","dues_on"},
 * 	description="Membership Dues.<br>The following relationships can be attached, and in the case of plural relations, searched:
 * persona (Persona) (BelongsTo): Persona paying Dues.
 * transaction (Transaction) (BelongsTo): Transaction recording the payment.
 * createdBy (User) (BelongsTo): User that created it.
 * updatedBy (User) (BelongsTo): User that last updated it (if any).
 * deletedBy (User) (BelongsTo): User that deleted it (if any).",
 * 	@OA\Property(
 * 		property="id",
 * 		description="The entry's ID.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="persona_id",
 * 		description="ID of the Persona paying Dues.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="transaction_id",
 * 		description="ID of the Transaction recording the payment.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="dues_on",
 * 		description="The date the dues period begins, not the date paid",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="date",
 * 		example="2020-12-30"
 * 	),
 * 	@OA\Property(
 * 		property="intervals",
 * 		description="Number of six month periods the payment covers, null for forever.",
 * 		readOnly=false,
 * 		nullable=true,
 *  		type="number",
 *  		format="float",
 *  		example=1
 * 	),
 * 	@OA\Property(
 * 		property="created_by",
 * 		description="The User that created this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true,
 * 		default=1
 * 	),
 * 	@OA\Property(
 * 		property="createdBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_by",
 * 		description="The last User to update this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updatedBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_by",
 * 		description="The User that softdeleted this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deletedBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="created_at",
 * 		description="When the entry was created.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_at",
 * 		description="When the entry was last updated.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_at",
 * 		description="When the entry was softdeleted.  Null if not softdeleted.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="persona",
 * 		type="object",
 * 		description="Attachable Persona paying Dues.",
 * 		ref="#/components/schemas/PersonaSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="transaction",
 * 		type="object",
 * 		description="Attachable Transaction recording the payment.",
 * 		ref="#/components/schemas/TransactionSimple",
 * 		readOnly=true
 * 	)
 * )
 * @OA\Schema (
 * 	schema="DueSimple",
 * 	title="DueSimple",
 * 	description="Attachable Due object with no attachments.",
 * 	@OA\Property(
 * 		property="id",
 * 		description="The entry's ID.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="persona_id",
 * 		description="ID of the Persona paying Dues.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="transaction_id",
 * 		description="ID of the Transaction recording the payment.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="dues_on",
 * 		description="The date the dues period begins, not the date paid",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="date",
 * 		example="2020-12-30"
 * 	),
 * 	@OA\Property(
 * 		property="intervals",
 * 		description="Number of six month periods the payment covers, null for forever.",
 * 		readOnly=false,
 * 		nullable=true,
 *  		type="number",
 *  		format="float",
 *  		example=1
 * 	),
 * 	@OA\Property(
 * 		property="created_by",
 * 		description="The User that created this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true,
 * 		default=1
 * 	),
 * 	@OA\Property(
 * 		property="updated_by",
 * 		description="The last User to update this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_by",
 * 		description="The User that softdeleted this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="created_at",
 * 		description="When the entry was created.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_at",
 * 		description="When the entry was last updated.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_at",
 * 		description="When the entry was softdeleted.  Null if not softdeleted.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	)
 * )
 * @OA\Schema (
 * 	schema="DueSuperSimple",
 * 	title="DueSuperSimpleSimple",
 * 	description="Attachable Due object with no attachments or CUD data.",
 * 	@OA\Property(
 * 		property="id",
 * 		description="The entry's ID.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="persona_id",
 * 		description="ID of the Persona paying Dues.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="transaction_id",
 * 		description="ID of the Transaction recording the payment.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="dues_on",
 * 		description="The date the dues period begins, not the date paid",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="date",
 * 		example="2020-12-30"
 * 	),
 * 	@OA\Property(
 * 		property="intervals",
 * 		description="Number of six month periods the payment covers, null for forever.",
 * 		readOnly=false,
 * 		nullable=true,
 *  		type="number",
 *  		format="float",
 *  		example=1
 * 	)
 * )
 * @OA\RequestBody (
 * 	request="Due",
 * 	description="Due object that needs to be added or updated.",
 * 	required=true,
 * 	@OA\MediaType(
 * 		mediaType="multipart/form-data",
 * 		@OA\Schema(ref="#/components/schemas/DueSimple")
 * 	)
 * )
 * @property int $id Model ID
 * @property int $persona_id Persona paying Dues
 * @property int $transaction_id Transaction recording the payment
 * @property \Illuminate\Support\Carbon $dues_on The date the dues period begins, not the date paid
 * @property float|null $intervals Number of six month periods the payment covers, null for forever
 * @property int $created_by
 * @property \Illuminate\Support\Carbon $created_at
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $deleted_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\User $createdBy
 * @property-read \App\Models\User $creator
 * @property-read \App\Models\User|null $deletedBy
 * @property-read \App\Models\User|null $destroyer
 * @property-read \App\Models\User|null $editor
 * @property-read \App\Models\Persona $persona
 * @property-read \App\Models\Transaction $transaction
 * @property-read \App\Models\User|null $updatedBy
 * @method static \Database\Factories\DueFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Due newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Due newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Due onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Due query()
 * @method static \Illuminate\Database\Eloquent\Builder|Due whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Due whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Due whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Due whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Due whereDuesOn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Due whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Due whereIntervals($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Due wherePersonaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Due whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Due whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Due whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Due withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Due withoutTrashed()
 */
	class Due extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Event
 *
 * @OA\Schema (
 * 	schema="Event",
 * 	required={"eventable_type","eventable_id","name","is_active","is_demo"},
 * 	description="Events typically are either a campout or singular in nature.<br>The following relationships can be attached, and in the case of plural relations, searched:
 * attendances (Attendance) (MorphMany): Attendances for the Event, not including demo Guests.
 * crats (Crat) (HasMany): Crats for the Event.
 * eventable (Chapter, Realm, Persona, or Unit) (MorphTo): Chapter, Realm, Persona, or Unit sponsoring the Event.
 * guests (Guest) (HasMany): If the Event is a demo, those who came to play with us but are not established members.
 * issuances (Issuance) (MorphMany): Awards and Titles Issued at the Event.
 * location (Location) (BelongsTo): Location of the Event.
 * socials (Social) (MorphMany): Socials for the Event.
 * createdBy (User) (BelongsTo): User that created it.
 * updatedBy (User) (BelongsTo): User that last updated it (if any).
 * deletedBy (User) (BelongsTo): User that deleted it (if any).",
 * 	@OA\Property(
 * 		property="id",
 * 		description="The entry's ID.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="eventable_type",
 * 		description="Who made and runs the Event; Chapter, Realm, Persona, or Unit",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="enum",
 * 		enum={"Chapter","Realm","Persona","Unit"},
 * 		example="Realm"
 * 	),
 * 	@OA\Property(
 * 		property="eventable_id",
 * 		description="The ID of who made and runs the Event.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="sponsorable_type",
 * 		description="Who made and runs the Event; Chapter, Realm, Persona, or Unit",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="enum",
 * 		enum={"Chapter","Realm"},
 * 		example="Realm"
 * 	),
 * 	@OA\Property(
 * 		property="sponsorable_id",
 * 		description="The ID of the sponsor of this Event.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="location_id",
 * 		description="ID of the Location the Event takes place at, if any.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="name",
 * 		description="The name of the Event.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="uppercase first letter",
 * 		example="Nerd Wars",
 * 		maxLength=191
 * 	),
 * 	@OA\Property(
 * 		property="description",
 * 		description="A description of the Event, if any",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="paragraph",
 * 		example="This event is all about killing fellow nerds.",
 * 		maxLength=16777215
 * 	),
 * 	@OA\Property(
 * 		property="image",
 * 		description="A internal link to a promotional image for the Event, if any.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="filename",
 * 		example="images/events/42.jpg",
 * 		maxLength=191
 * 	),
 * 	@OA\Property(
 * 		property="is_active",
 * 		description="Is this Event (default true) publicly visible?",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="enum",
 * 		enum={0, 1},
 * 		example=0,
 * 		default=1
 * 	),
 * 	@OA\Property(
 * 		property="is_demo",
 * 		description="Is this Event (default false) a demo?",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="enum",
 * 		enum={0, 1},
 * 		example=0,
 * 		default=0
 * 	),
 * 	@OA\Property(
 * 		property="event_started_at",
 * 		description="When the Event begins.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59"
 * 	),
 * 	@OA\Property(
 * 		property="event_ended_at",
 * 		description="When the Event ends.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59"
 * 	),
 * 	@OA\Property(
 * 		property="price",
 * 		description="The cost of the Event, if any.",
 * 		readOnly=false,
 * 		nullable=true,
 *  		type="number",
 *  		format="float",
 *  		example=40
 * 	),
 * 	@OA\Property(
 * 		property="created_by",
 * 		description="The User that created this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true,
 * 		default=1
 * 	),
 * 	@OA\Property(
 * 		property="createdBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_by",
 * 		description="The last User to update this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updatedBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_by",
 * 		description="The User that softdeleted this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deletedBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="created_at",
 * 		description="When the entry was created.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_at",
 * 		description="When the entry was last updated.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_at",
 * 		description="When the entry was softdeleted.  Null if not softdeleted.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="attendances",
 * 		description="Attachable & filterable array of Attendances for this Event.",
 * 		type="array",
 * 		@OA\Items(
 * 			title="Attendance",
 * 			type="object",
 * 			ref="#/components/schemas/AttendanceSimple"
 * 		),
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="crats",
 * 		description="Attachable & filterable array of Crats for this Event.",
 * 		type="array",
 * 		@OA\Items(
 * 			title="Crat",
 * 			type="object",
 * 			ref="#/components/schemas/CratSimple"
 * 		),
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="eventable",
 * 		type="object",
 * 		description="Attachable object that sponsored the Event.",
 * 		oneOf={
 * 			@OA\Schema(ref="#/components/schemas/ChapterSimple"),
 * 			@OA\Schema(ref="#/components/schemas/RealmSimple"),
 * 			@OA\Schema(ref="#/components/schemas/PersonaSimple"),
 * 			@OA\Schema(ref="#/components/schemas/UnitSimple")
 * 		},
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="guests",
 * 		description="Attachable & filterable array of Guests that played at this demo Event, if so.",
 * 		type="array",
 * 		@OA\Items(
 * 			title="Account",
 * 			type="object",
 * 			ref="#/components/schemas/AccountSimple"
 * 		),
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="issuances",
 * 		description="Attachable & filterable array of Issuances made at the Event.",
 * 		type="array",
 * 		@OA\Items(
 * 			title="Issuance",
 * 			type="object",
 * 			ref="#/components/schemas/IssuanceSimple"
 * 		),
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="location",
 * 		type="object",
 * 		description="Attachable Location for this Event.",
 * 		ref="#/components/schemas/LocationSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="socials",
 * 		description="Attachable & filterable array of the Socials of the Event.",
 * 		type="array",
 * 		@OA\Items(
 * 			title="Social",
 * 			type="object",
 * 			ref="#/components/schemas/SocialSimple"
 * 		),
 * 		readOnly=true
 * 	)
 * )
 * @OA\Schema (
 * 	schema="EventSimple",
 * 	title="EventSimple",
 * 	description="Attachable Event object with no attachments.",
 * 	@OA\Property(
 * 		property="id",
 * 		description="The entry's ID.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="eventable_type",
 * 		description="Who made and runs the Event; Chapter, Realm, Persona, or Unit",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="enum",
 * 		enum={"Realm","Chapter","Unit","Persona"},
 * 		example="Realm"
 * 	),
 * 	@OA\Property(
 * 		property="eventable_id",
 * 		description="The ID of who made and runs the Event.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="sponsorable_type",
 * 		description="Who made and runs the Event; Chapter, Realm, Persona, or Unit",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="enum",
 * 		enum={"Chapter","Realm"},
 * 		example="Realm"
 * 	),
 * 	@OA\Property(
 * 		property="sponsorable_id",
 * 		description="The ID of the sponsor of this Event.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="location_id",
 * 		description="ID of the Location the Event takes place at, if any.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="name",
 * 		description="The name of the Event.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="uppercase first letter",
 * 		example="Nerd Wars",
 * 		maxLength=191
 * 	),
 * 	@OA\Property(
 * 		property="description",
 * 		description="A description of the Event, if any",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="paragraph",
 * 		example="This event is all about killing fellow nerds.",
 * 		maxLength=16777215
 * 	),
 * 	@OA\Property(
 * 		property="image",
 * 		description="A internal link to a promotional image for the Event, if any.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="filename",
 * 		example="images/events/42.jpg",
 * 		maxLength=191
 * 	),
 * 	@OA\Property(
 * 		property="is_active",
 * 		description="Is this Event (default true) publicly visible?",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="enum",
 * 		enum={0, 1},
 * 		example=0,
 * 		default=1
 * 	),
 * 	@OA\Property(
 * 		property="is_demo",
 * 		description="Is this Event (default false) a demo?",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="enum",
 * 		enum={0, 1},
 * 		example=0,
 * 		default=0
 * 	),
 * 	@OA\Property(
 * 		property="event_started_at",
 * 		description="When the Event begins.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59"
 * 	),
 * 	@OA\Property(
 * 		property="event_ended_at",
 * 		description="When the Event ends.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59"
 * 	),
 * 	@OA\Property(
 * 		property="price",
 * 		description="The cost of the Event, if any.",
 * 		readOnly=false,
 * 		nullable=true,
 *  		type="number",
 *  		format="float",
 *  		example=40
 * 	),
 * 	@OA\Property(
 * 		property="created_by",
 * 		description="The User that created this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true,
 * 		default=1
 * 	),
 * 	@OA\Property(
 * 		property="updated_by",
 * 		description="The last User to update this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_by",
 * 		description="The User that softdeleted this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="created_at",
 * 		description="When the entry was created.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_at",
 * 		description="When the entry was last updated.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_at",
 * 		description="When the entry was softdeleted.  Null if not softdeleted.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	)
 * )
 * @OA\Schema (
 * 	schema="EventSuperSimple",
 * 	title="EventSuperSimpleSimple",
 * 	description="Attachable Event object with no attachments or CUD data.",
 * 	@OA\Property(
 * 		property="id",
 * 		description="The entry's ID.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="eventable_type",
 * 		description="Who made and runs the Event; Chapter, Realm, Persona, or Unit",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="enum",
 * 		enum={"Realm","Chapter","Unit","Persona"},
 * 		example="Realm"
 * 	),
 * 	@OA\Property(
 * 		property="eventable_id",
 * 		description="The ID of who made and runs the Event.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="sponsorable_type",
 * 		description="Who made and runs the Event; Chapter, Realm, Persona, or Unit",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="enum",
 * 		enum={"Chapter","Realm"},
 * 		example="Realm"
 * 	),
 * 	@OA\Property(
 * 		property="sponsorable_id",
 * 		description="The ID of the sponsor of this Event.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="location_id",
 * 		description="ID of the Location the Event takes place at, if any.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="name",
 * 		description="The name of the Event.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="uppercase first letter",
 * 		example="Nerd Wars",
 * 		maxLength=191
 * 	),
 * 	@OA\Property(
 * 		property="description",
 * 		description="A description of the Event, if any",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="paragraph",
 * 		example="This event is all about killing fellow nerds.",
 * 		maxLength=16777215
 * 	),
 * 	@OA\Property(
 * 		property="image",
 * 		description="A internal link to a promotional image for the Event, if any.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="filename",
 * 		example="images/events/42.jpg",
 * 		maxLength=191
 * 	),
 * 	@OA\Property(
 * 		property="is_active",
 * 		description="Is this Event (default true) publicly visible?",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="enum",
 * 		enum={0, 1},
 * 		example=0,
 * 		default=1
 * 	),
 * 	@OA\Property(
 * 		property="is_demo",
 * 		description="Is this Event (default false) a demo?",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="enum",
 * 		enum={0, 1},
 * 		example=0,
 * 		default=0
 * 	),
 * 	@OA\Property(
 * 		property="event_started_at",
 * 		description="When the Event begins.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59"
 * 	),
 * 	@OA\Property(
 * 		property="event_ended_at",
 * 		description="When the Event ends.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59"
 * 	),
 * 	@OA\Property(
 * 		property="price",
 * 		description="The cost of the Event, if any.",
 * 		readOnly=false,
 * 		nullable=true,
 *  		type="number",
 *  		format="float",
 *  		example=40
 * 	)
 * )
 * @OA\RequestBody (
 * 	request="Event",
 * 	description="Event object that needs to be added or updated.",
 * 	required=true,
 * 	@OA\MediaType(
 * 		mediaType="multipart/form-data",
 * 		@OA\Schema(ref="#/components/schemas/EventSimple")
 * 	)
 * )
 * @property int $id Model ID
 * @property string $eventable_type Who made and runs the Event; Chapter, Persona, Realm, or Unit
 * @property int $eventable_id The ID of who made and runs the Event
 * @property string|null $sponsorable_type Who is agreeing to accept Attendances for the Event in the case of Persona or Unit types, if any; Chapter or Realm
 * @property int|null $sponsorable_id ID of the Realm or Chapter agreeing to accept Attendances for the Event in the case of Persona or Unit types, if any.
 * @property int|null $location_id ID of the Location the Event takes place at, if any
 * @property string $name The name of the Event
 * @property string|null $description A description of the Event, if any
 * @property string|null $image A promotional image for the Event, if any
 * @property bool $is_active Is this (default true) something people should be seeing yet?
 * @property bool $is_demo Is this (default false) a demo?
 * @property \Illuminate\Support\Carbon $event_started_at When the Event begins
 * @property \Illuminate\Support\Carbon $event_ended_at When the Event ends
 * @property float|null $price The cost of the Event, if any
 * @property int $created_by
 * @property \Illuminate\Support\Carbon $created_at
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $deleted_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Attendance> $attendances
 * @property-read int|null $attendances_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Crat> $crats
 * @property-read int|null $crats_count
 * @property-read \App\Models\User $createdBy
 * @property-read \App\Models\User $creator
 * @property-read \App\Models\User|null $deletedBy
 * @property-read \App\Models\User|null $destroyer
 * @property-read \App\Models\User|null $editor
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $eventable
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Guest> $guests
 * @property-read int|null $guests_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Issuance> $issuances
 * @property-read int|null $issuances_count
 * @property-read \App\Models\Location|null $location
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Social> $socials
 * @property-read int|null $socials_count
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $sponsorable
 * @property-read \App\Models\User|null $updatedBy
 * @method static \Database\Factories\EventFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Event newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Event newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Event onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Event query()
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereEventEndedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereEventStartedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereEventableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereEventableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereIsDemo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereLocationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereSponsorableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereSponsorableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Event withoutTrashed()
 */
	class Event extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Guest
 *
 * @OA\Schema (
 * 	schema="Guest",
 * 	required={"event_id","waiver_id","is_followedup"},
 * 	description="Visitors that play with us at demo Events.<br>The following relationships can be attached, and in the case of plural relations, searched:
 * event (Event) (BelongsTo): Demo Event they played at.
 * chapter (Chapter) (BelongsTo): The closest Chapter to the Guest, if known
 * waiver (Waiver) (BelongsTo): Waiver for the Guest.
 * createdBy (User) (BelongsTo): User that created it.
 * updatedBy (User) (BelongsTo): User that last updated it (if any).
 * deletedBy (User) (BelongsTo): User that deleted it (if any).",
 * 	@OA\Property(
 * 		property="id",
 * 		description="The entry's ID.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="event_id",
 * 		description="ID of the Demo Event they were Guests for.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="chapter_id",
 * 		description="ID of the closest Chapter to the Guest, if known.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="waiver_id",
 * 		description="ID of the Waiver for the Guest.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="is_followedup",
 * 		description="Has this Guest (default false) been followed up with?",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="enum",
 * 		enum={0, 1},
 * 		example=0,
 * 		default=1
 * 	),
 * 	@OA\Property(
 * 		property="notes",
 * 		description="Notes about the Guest, if any",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="sentence",
 * 		maxLength=191,
 * 		example="They are interested in A&S"
 * 	),
 * 	@OA\Property(
 * 		property="created_by",
 * 		description="The User that created this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true,
 * 		default=1
 * 	),
 * 	@OA\Property(
 * 		property="createdBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_by",
 * 		description="The last User to update this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updatedBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_by",
 * 		description="The User that softdeleted this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deletedBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="created_at",
 * 		description="When the entry was created.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_at",
 * 		description="When the entry was last updated.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_at",
 * 		description="When the entry was softdeleted.  Null if not softdeleted.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="event",
 * 		type="object",
 * 		description="Attachable Demo Event they played at.",
 * 		ref="#/components/schemas/EventSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="chapter",
 * 		type="object",
 * 		description="Attachable closest Chapter to the Guest.",
 * 		ref="#/components/schemas/ChapterSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="waiver",
 * 		type="object",
 * 		description="Attachable Waiver for the Guest.",
 * 		ref="#/components/schemas/WaiverSimple",
 * 		readOnly=true
 * 	)
 * )
 * @OA\Schema (
 * 	schema="GuestSimple",
 * 	title="GuestSimple",
 * 	description="Attachable Guest object with no attachments.",
 * 	@OA\Property(
 * 		property="id",
 * 		description="The entry's ID.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="event_id",
 * 		description="ID of the Demo Event they were Guests for.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="chapter_id",
 * 		description="ID of the closest Chapter to the Guest, if known.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="waiver_id",
 * 		description="ID of the Waiver for the Guest.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="is_followedup",
 * 		description="Has this Guest (default false) been followed up with?",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="enum",
 * 		enum={0, 1},
 * 		example=0,
 * 		default=1
 * 	),
 * 	@OA\Property(
 * 		property="notes",
 * 		description="Notes about the Guest, if any",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		maxLength=191,
 * 		example="They are interested in A&S"
 * 	),
 * 	@OA\Property(
 * 		property="created_by",
 * 		description="The User that created this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true,
 * 		default=1
 * 	),
 * 	@OA\Property(
 * 		property="updated_by",
 * 		description="The last User to update this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_by",
 * 		description="The User that softdeleted this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="created_at",
 * 		description="When the entry was created.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_at",
 * 		description="When the entry was last updated.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_at",
 * 		description="When the entry was softdeleted.  Null if not softdeleted.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	)
 * )
 * @OA\Schema (
 * 	schema="GuestSuperSimple",
 * 	title="GuestSuperSimpleSimple",
 * 	description="Attachable Guest object with no attachments or CUD data.",
 * 	@OA\Property(
 * 		property="id",
 * 		description="The entry's ID.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="event_id",
 * 		description="ID of the Demo Event they were Guests for.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="chapter_id",
 * 		description="ID of the closest Chapter to the Guest, if known.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="waiver_id",
 * 		description="ID of the Waiver for the Guest.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="is_followedup",
 * 		description="Has this Guest (default false) been followed up with?",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="enum",
 * 		enum={0, 1},
 * 		example=0,
 * 		default=1
 * 	),
 * 	@OA\Property(
 * 		property="notes",
 * 		description="Notes about the Guest, if any",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		maxLength=191,
 * 		example="They are interested in A&S"
 * 	)
 * )
 * @OA\RequestBody (
 * 	request="Guest",
 * 	description="Guest object that needs to be added or updated.",
 * 	required=true,
 * 	@OA\MediaType(
 * 		mediaType="multipart/form-data",
 * 		@OA\Schema(ref="#/components/schemas/GuestSimple")
 * 	)
 * )
 * @property int $id Model ID
 * @property int $event_id ID of the Demo Event they were Guests for
 * @property int|null $chapter_id ID of the closest Chapter to the Guest, if known
 * @property bool $is_followedup Has this Guest (default false) been followed up with?
 * @property string|null $notes Notes about the Guest, if any
 * @property int $created_by
 * @property \Illuminate\Support\Carbon $created_at
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $deleted_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\Chapter|null $chapter
 * @property-read \App\Models\User $createdBy
 * @property-read \App\Models\User $creator
 * @property-read \App\Models\User|null $deletedBy
 * @property-read \App\Models\User|null $destroyer
 * @property-read \App\Models\User|null $editor
 * @property-read \App\Models\Event $event
 * @property-read \App\Models\User|null $updatedBy
 * @property-read \App\Models\Waiver|null $waiver
 * @method static \Database\Factories\GuestFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Guest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Guest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Guest onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Guest query()
 * @method static \Illuminate\Database\Eloquent\Builder|Guest whereChapterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Guest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Guest whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Guest whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Guest whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Guest whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Guest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Guest whereIsFollowedup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Guest whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Guest whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Guest whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Guest withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Guest withoutTrashed()
 */
	class Guest extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Issuance
 *
 * @OA\Schema (
 * 	schema="Issuance",
 * 	required={"issuable_type","issuable_id","authority_type","authority_id","recipient_type","recipient_id","issued_at"},
 * 	description="Issuances of Awards or Titles.<br>The following relationships can be attached, and in the case of plural relations, searched:
 * issuable (Award or Title) (MorphTo): The Issuance type; Award or Title.
 * issuer (Chapter, Realm, Persona, or Unit) (MorphTo): Issuing authority; Chapter, Realm, Persona, or Unit.
 * recipient (Persona or Unit) (MorphTo): Who recieved the Issuance; Persona or Unit.
 * revokedBy (User) (BelongsTo): User revoked, who authorized the revocation.
 * signator (Persona) (BelongsTo): Persona signing the Issuance, if any.  Leave null when Issuer is Persona.
 * whereable (Event, Location, or Meetup) (MorphTo): Where it was Issued, if known; Event, Location, or Meetup.
 * createdBy (User) (BelongsTo): User that created it.
 * updatedBy (User) (BelongsTo): User that last updated it (if any).
 * deletedBy (User) (BelongsTo): User that deleted it (if any).",
 * 	@OA\Property(
 * 		property="id",
 * 		description="The entry's ID.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="issuable_type",
 * 		description="The Issuance type; Award or Title.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="enum",
 * 		enum={"Award","Title"},
 * 		example="Realm"
 * 	),
 * 	@OA\Property(
 * 		property="issuable_id",
 * 		description="The ID of the Issuance.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="whereable_type",
 * 		description="Where it was Issued, if known; Event, Meetup, or Location.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="enum",
 * 		enum={"Event","Meetup","Location"},
 * 		example="Event"
 * 	),
 * 	@OA\Property(
 * 		property="whereable_id",
 * 		description="The ID of where it was Issued.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="issuer_type",
 * 		description="Issuing authority; Chapter, Realm, Persona, or Unit.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="enum",
 * 		enum={"Chapter","Realm","Persona","Unit"},
 * 		example="Chapter"
 * 	),
 * 	@OA\Property(
 * 		property="issuer_id",
 * 		description="The ID of the Issuing authority.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="recipient_type",
 * 		description="Who recieved the Issuance; Persona or Unit.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="enum",
 * 		enum={"Persona","Unit"},
 * 		example="Persona"
 * 	),
 * 	@OA\Property(
 * 		property="recipient_id",
 * 		description="The ID of the Issuance recipient.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="signator_id",
 * 		description="The ID of the Persona signing the Issuance, if any.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="custom_name",
 * 		description="Where label options are avaiable, or customization allowed, the chosen label, else null",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="uppercase first letter",
 * 		maxLength=64,
 * 		example="Lady"
 * 	),
 * 	@OA\Property(
 * 		property="rank",
 * 		description="For laddered Issuances, the order number, else null.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="integer",
 * 		format="int32",
 * 		example=1
 * 	),
 * 	@OA\Property(
 * 		property="issued_at",
 * 		description="When the Issuance was made or is to be made public (if in the future)",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="date",
 * 		example="2020-12-30"
 * 	),
 * 	@OA\Property(
 * 		property="reason",
 * 		description="A historical record of what the Issuance was for",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="paragraph",
 * 		example="For their work feeding everybody.",
 * 		maxLength=400
 * 	),
 * 	@OA\Property(
 * 		property="image",
 * 		description="An internal link to an image of the Issuance phyrep, if any.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="filename",
 * 		example="images/issuances/42.jpg",
 * 		maxLength=191
 * 	),
 * 	@OA\Property(
 * 		property="revoked_by",
 * 		description="ID of the Persona that revoked the Issuance, if any.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="revoked_at",
 * 		description="Date the revocation is effective, if any.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="date",
 * 		example="2020-12-30"
 * 	),
 * 	@OA\Property(
 * 		property="revocation",
 * 		description="Cause for the revocation, if any.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="paragraph",
 * 		example="He bought it on Etsy",
 * 		maxLength=50
 * 	),
 * 	@OA\Property(
 * 		property="created_by",
 * 		description="The User that created this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true,
 * 		default=1
 * 	),
 * 	@OA\Property(
 * 		property="createdBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_by",
 * 		description="The last User to update this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updatedBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_by",
 * 		description="The User that softdeleted this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deletedBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="created_at",
 * 		description="When the entry was created.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_at",
 * 		description="When the entry was last updated.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_at",
 * 		description="When the entry was softdeleted.  Null if not softdeleted.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="issuable",
 * 		type="object",
 * 		description="Attachable object that was Issued the Award.",
 * 		oneOf={
 * 			@OA\Schema(ref="#/components/schemas/AwardSimple"),
 * 			@OA\Schema(ref="#/components/schemas/TitleSimple")
 * 		},
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="issuer",
 * 		type="object",
 * 		description="Attachable object that Issues the Award.",
 * 		oneOf={
 * 			@OA\Schema(ref="#/components/schemas/ChapterSimple"),
 * 			@OA\Schema(ref="#/components/schemas/RealmSimple"),
 * 			@OA\Schema(ref="#/components/schemas/PersonaSimple"),
 * 			@OA\Schema(ref="#/components/schemas/UnitSimple")
 * 		},
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="recipient",
 * 		type="object",
 * 		description="Attachable object that was Issued the Award.",
 * 		oneOf={
 * 			@OA\Schema(ref="#/components/schemas/PersonaSimple"),
 * 			@OA\Schema(ref="#/components/schemas/UnitSimple")
 * 		},
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="revokedBy",
 * 		type="object",
 * 		description="Attachable Persona that revoked the Issuance.",
 * 		ref="#/components/schemas/PersonaSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="signator",
 * 		type="object",
 * 		description="Attachable Persona signing the Issuance.",
 * 		ref="#/components/schemas/PersonaSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="whereable",
 * 		type="object",
 * 		description="Attachable object that Issues the Award.",
 * 		oneOf={
 * 			@OA\Schema(ref="#/components/schemas/EventSimple"),
 * 			@OA\Schema(ref="#/components/schemas/LocationSimple"),
 * 			@OA\Schema(ref="#/components/schemas/MeetupSimple")
 * 		},
 * 		readOnly=true
 * 	)
 * )
 * @OA\Schema (
 * 	schema="IssuanceSimple",
 * 	title="IssuanceSimple",
 * 	description="Attachable Issuance object with no attachments.",
 * 	@OA\Property(
 * 		property="id",
 * 		description="The entry's ID.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="issuable_type",
 * 		description="The Issuance type; Award or Title.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="enum",
 * 		enum={"Award","Title"},
 * 		example="Realm"
 * 	),
 * 	@OA\Property(
 * 		property="issuable_id",
 * 		description="The ID of the Issuance.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="whereable_type",
 * 		description="Where it was Issued, if known; Event, Meetup, or Location.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="enum",
 * 		enum={"Event","Meetup","Location"},
 * 		example="Event"
 * 	),
 * 	@OA\Property(
 * 		property="whereable_id",
 * 		description="The ID of where it was Issued.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="issuer_type",
 * 		description="Issuing authority; Chapter, Realm, Persona, or Unit.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="enum",
 * 		enum={"Chapter","Realm","Persona","Unit"},
 * 		example="Chapter"
 * 	),
 * 	@OA\Property(
 * 		property="issuer_id",
 * 		description="The ID of the Issuing authority.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="recipient_type",
 * 		description="Who recieved the Issuance; Persona or Unit.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="enum",
 * 		enum={"Persona","Unit"},
 * 		example="Persona"
 * 	),
 * 	@OA\Property(
 * 		property="recipient_id",
 * 		description="The ID of the Issuance recipient.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="signator_id",
 * 		description="The ID of the Persona signing the Issuance, if any.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="custom_name",
 * 		description="Where label options are avaiable, or customization allowed, the chosen label, else null",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="uppercase first letter",
 * 		maxLength=64,
 * 		example="Lady"
 * 	),
 * 	@OA\Property(
 * 		property="rank",
 * 		description="For laddered Issuances, the order number, else null.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="integer",
 * 		format="int32",
 * 		example=1
 * 	),
 * 	@OA\Property(
 * 		property="issued_at",
 * 		description="When the Issuance was made or is to be made public (if in the future)",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="date",
 * 		example="2020-12-30"
 * 	),
 * 	@OA\Property(
 * 		property="reason",
 * 		description="A historical record of what the Issuance was for",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="paragraph",
 * 		example="For their work feeding everybody.",
 * 		maxLength=400
 * 	),
 * 	@OA\Property(
 * 		property="image",
 * 		description="An internal link to an image of the Issuance phyrep, if any.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="filename",
 * 		example="images/issuances/42.jpg",
 * 		maxLength=191
 * 	),
 * 	@OA\Property(
 * 		property="revoked_by",
 * 		description="ID of the Persona that revoked the Issuance, if any.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="revoked_at",
 * 		description="Date the revocation is effective, if any.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="date",
 * 		example="2020-12-30"
 * 	),
 * 	@OA\Property(
 * 		property="revocation",
 * 		description="Cause for the revocation, if any.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="paragraph",
 * 		example="He bought it on Etsy",
 * 		maxLength=50
 * 	),
 * 	@OA\Property(
 * 		property="created_by",
 * 		description="The User that created this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true,
 * 		default=1
 * 	),
 * 	@OA\Property(
 * 		property="updated_by",
 * 		description="The last User to update this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_by",
 * 		description="The User that softdeleted this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="created_at",
 * 		description="When the entry was created.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_at",
 * 		description="When the entry was last updated.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_at",
 * 		description="When the entry was softdeleted.  Null if not softdeleted.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	)
 * )
 * @OA\Schema (
 * 	schema="IssuanceSuperSimple",
 * 	title="IssuanceSuperSimpleSimple",
 * 	description="Attachable Issuance object with no attachments or CUD data.",
 * 	@OA\Property(
 * 		property="id",
 * 		description="The entry's ID.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="issuable_type",
 * 		description="The Issuance type; Award or Title.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="enum",
 * 		enum={"Award","Title"},
 * 		example="Realm"
 * 	),
 * 	@OA\Property(
 * 		property="issuable_id",
 * 		description="The ID of the Issuance.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="whereable_type",
 * 		description="Where it was Issued, if known; Event, Meetup, or Location.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="enum",
 * 		enum={"Event","Meetup","Location"},
 * 		example="Event"
 * 	),
 * 	@OA\Property(
 * 		property="whereable_id",
 * 		description="The ID of where it was Issued.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="issuer_type",
 * 		description="Issuing authority; Chapter, Realm, Persona, or Unit.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="enum",
 * 		enum={"Chapter","Realm","Persona","Unit"},
 * 		example="Chapter"
 * 	),
 * 	@OA\Property(
 * 		property="issuer_id",
 * 		description="The ID of the Issuing authority.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="recipient_type",
 * 		description="Who recieved the Issuance; Persona or Unit.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="enum",
 * 		enum={"Persona","Unit"},
 * 		example="Persona"
 * 	),
 * 	@OA\Property(
 * 		property="recipient_id",
 * 		description="The ID of the Issuance recipient.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="signator_id",
 * 		description="The ID of the Persona signing the Issuance, if any.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="custom_name",
 * 		description="Where label options are avaiable, or customization allowed, the chosen label, else null",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="uppercase first letter",
 * 		maxLength=64,
 * 		example="Lady"
 * 	),
 * 	@OA\Property(
 * 		property="rank",
 * 		description="For laddered Issuances, the order number, else null.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="integer",
 * 		format="int32",
 * 		example=1
 * 	),
 * 	@OA\Property(
 * 		property="issued_at",
 * 		description="When the Issuance was made or is to be made public (if in the future)",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="date",
 * 		example="2020-12-30"
 * 	),
 * 	@OA\Property(
 * 		property="reason",
 * 		description="A historical record of what the Issuance was for",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="paragraph",
 * 		example="For their work feeding everybody.",
 * 		maxLength=400
 * 	),
 * 	@OA\Property(
 * 		property="image",
 * 		description="An internal link to an image of the Issuance phyrep, if any.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="filename",
 * 		example="images/issuances/42.jpg",
 * 		maxLength=191
 * 	),
 * 	@OA\Property(
 * 		property="revoked_by",
 * 		description="ID of the Persona that revoked the Issuance, if any.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="revoked_at",
 * 		description="Date the revocation is effective, if any.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="date",
 * 		example="2020-12-30"
 * 	),
 * 	@OA\Property(
 * 		property="revocation",
 * 		description="Cause for the revocation, if any.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="paragraph",
 * 		example="He bought it on Etsy",
 * 		maxLength=50
 * 	)
 * )
 * @OA\RequestBody (
 * 	request="Issuance",
 * 	description="Issuance object that needs to be added or updated.",
 * 	required=true,
 * 	@OA\MediaType(
 * 		mediaType="multipart/form-data",
 * 		@OA\Schema(ref="#/components/schemas/IssuanceSimple")
 * 	)
 * )
 * @property int $id
 * @property string $issuable_type
 * @property int $issuable_id
 * @property string|null $whereable_type
 * @property int|null $whereable_id
 * @property string $authority_type
 * @property int $authority_id
 * @property string $recipient_type
 * @property int $recipient_id
 * @property int|null $issuer_id
 * @property string|null $custom_name
 * @property int|null $rank
 * @property \Illuminate\Support\Carbon $issued_at
 * @property string|null $reason
 * @property string|null $image
 * @property int|null $revoked_by
 * @property \Illuminate\Support\Carbon|null $revoked_at
 * @property int $created_by
 * @property string|null $revocation
 * @property \Illuminate\Support\Carbon $created_at
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $deleted_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\User $createdBy
 * @property-read \App\Models\User $creator
 * @property-read \App\Models\User|null $deletedBy
 * @property-read \App\Models\User|null $destroyer
 * @property-read \App\Models\User|null $editor
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $issuable
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $issuer
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $recipient
 * @property-read \App\Models\Persona|null $revokedBy
 * @property-read \App\Models\Persona|null $signator
 * @property-read \App\Models\User|null $updatedBy
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $whereable
 * @method static \Database\Factories\IssuanceFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Issuance newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Issuance newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Issuance onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Issuance query()
 * @method static \Illuminate\Database\Eloquent\Builder|Issuance whereAuthorityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Issuance whereAuthorityType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Issuance whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Issuance whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Issuance whereCustomName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Issuance whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Issuance whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Issuance whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Issuance whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Issuance whereIssuableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Issuance whereIssuableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Issuance whereIssuedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Issuance whereIssuerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Issuance whereRank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Issuance whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Issuance whereRecipientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Issuance whereRecipientType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Issuance whereRevocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Issuance whereRevokedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Issuance whereRevokedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Issuance whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Issuance whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Issuance whereWhereableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Issuance whereWhereableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Issuance withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Issuance withoutTrashed()
 */
	class Issuance extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Location
 *
 * @OA\Schema (
 * 	schema="Location",
 * 	required={"created_at"},
 * 	description="Location information for Chapters, Events, Meetups, and Waivers.<br>The following relationships can be attached, and in the case of plural relations, searched:
 * chapters (Chapter) (HasMany): Chapters using this Location.
 * events (Event) (HasMany): Events using this Location.
 * issuances (Issuance) (MorphMany): Issuances made at this Location.
 * meetups (Meetup) (HasMany): Meetups using this Location.
 * waivers (Waiver) (HasMany): Waivers using this Location.
 * createdBy (User) (BelongsTo): User that created it.
 * updatedBy (User) (BelongsTo): User that last updated it (if any).
 * deletedBy (User) (BelongsTo): User that deleted it (if any).",
 * 	@OA\Property(
 * 		property="id",
 * 		description="The entry's ID.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="label",
 * 		description="The Location label, as it might appear on a map.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="uppercase first letter",
 * 		example="McCullum Park",
 * 		maxLength=50
 * 	),
 * 	@OA\Property(
 * 		property="address",
 * 		description="The street address of the Location, if any.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="street",
 * 		example="123 Fake St.",
 * 		maxLength=191
 * 	),
 * 	@OA\Property(
 * 		property="city",
 * 		description="The city of the Location, if any.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="city",
 * 		example="Seattle",
 * 		maxLength=50
 * 	),
 * 	@OA\Property(
 * 		property="province",
 * 		description="The state or provice of the Location, if any.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="state",
 * 		example="Texas",
 * 		maxLength=35
 * 	),
 * 	@OA\Property(
 * 		property="postal_code",
 * 		description="The zip or postal code of the Location, if any.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="zip",
 * 		example="98666",
 * 		maxLength=10
 * 	),
 * 	@OA\Property(
 * 		property="country",
 * 		description="The two letter country code of the Location (default US), if any.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="country",
 * 		example="US",
 * 		maxLength=2,
 *  		default="US"
 * 	),
 * 	@OA\Property(
 * 		property="google_geocode",
 * 		description="JSON encoded Google Geocode data of the Location, if any.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="json",
 * 		maxLength=16777215
 * 	),
 * 	@OA\Property(
 * 		property="latitude",
 * 		description="Latitude of the Location, if any.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="number",
 * 		format="double"
 * 	),
 * 	@OA\Property(
 * 		property="longitude",
 * 		description="Longitude of the Location, if any.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="number",
 * 		format="double"
 * 	),
 * 	@OA\Property(
 * 		property="location",
 * 		description="JSON encoded Google location services data of the Location, if any",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="json",
 * 		maxLength=16777215
 * 	),
 * 	@OA\Property(
 * 		property="map_url",
 * 		description="An external map link of the Location, if any",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="url",
 * 		maxLength=16777215
 * 	),
 * 	@OA\Property(
 * 		property="directions",
 * 		description="Directions required to properly navigate the last part of the journey to, or park at, the Location, if any.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="paragraph",
 * 		example="Take the first right and park next to the abandoned pool.  Go down the path until you see the sign for the designated LARP area.",
 * 		maxLength=16777215
 * 	),
 * 	@OA\Property(
 * 		property="created_by",
 * 		description="The User that created this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true,
 * 		default=1
 * 	),
 * 	@OA\Property(
 * 		property="createdBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_by",
 * 		description="The last User to update this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updatedBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_by",
 * 		description="The User that softdeleted this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deletedBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="created_at",
 * 		description="When the entry was created.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_at",
 * 		description="When the entry was last updated.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_at",
 * 		description="When the entry was softdeleted.  Null if not softdeleted.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="chapters",
 * 		description="Attachable & filterable array of Chapters using this Location.",
 * 		type="array",
 * 		@OA\Items(
 * 			title="Chapter",
 * 			type="object",
 * 			ref="#/components/schemas/ChapterSimple"
 * 		),
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="events",
 * 		description="Attachable & filterable array of Events using this Location.",
 * 		type="array",
 * 		@OA\Items(
 * 			title="Event",
 * 			type="object",
 * 			ref="#/components/schemas/EventSimple"
 * 		),
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="issuances",
 * 		description="Attachable & filterable array of Issuances at this Location.",
 * 		type="array",
 * 		@OA\Items(
 * 			title="Issuance",
 * 			type="object",
 * 			ref="#/components/schemas/IssuanceSimple"
 * 		),
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="meetups",
 * 		description="Attachable & filterable array of Meetups using this Location.",
 * 		type="array",
 * 		@OA\Items(
 * 			title="Meetup",
 * 			type="object",
 * 			ref="#/components/schemas/MeetupSimple"
 * 		),
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="waivers",
 * 		description="Attachable & filterable array of Waivers using this Location.",
 * 		type="array",
 * 		@OA\Items(
 * 			title="Waiver",
 * 			type="object",
 * 			ref="#/components/schemas/WaiverSimple"
 * 		),
 * 		readOnly=true
 * 	)
 * )
 * @OA\Schema (
 * 	schema="LocationSimple",
 * 	title="LocationSimple",
 * 	description="Attachable Location object with no attachments.",
 * 	@OA\Property(
 * 		property="id",
 * 		description="The entry's ID.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="label",
 * 		description="The Location label, as it might appear on a map.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="uppercase first letter",
 * 		example="McCullum Park",
 * 		maxLength=50
 * 	),
 * 	@OA\Property(
 * 		property="address",
 * 		description="The street address of the Location, if any.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="street",
 * 		example="123 Fake St.",
 * 		maxLength=191
 * 	),
 * 	@OA\Property(
 * 		property="city",
 * 		description="The city of the Location, if any.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="city",
 * 		example="Seattle",
 * 		maxLength=50
 * 	),
 * 	@OA\Property(
 * 		property="province",
 * 		description="The state or provice of the Location, if any.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="state",
 * 		example="Texas",
 * 		maxLength=35
 * 	),
 * 	@OA\Property(
 * 		property="postal_code",
 * 		description="The zip or postal code of the Location, if any.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="zip",
 * 		example="98666",
 * 		maxLength=10
 * 	),
 * 	@OA\Property(
 * 		property="country",
 * 		description="The two letter country code of the Location (default US), if any.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="country",
 * 		example="US",
 * 		maxLength=2,
 *  		default="US"
 * 	),
 * 	@OA\Property(
 * 		property="google_geocode",
 * 		description="JSON encoded Google Geocode data of the Location, if any.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="json",
 * 		maxLength=16777215
 * 	),
 * 	@OA\Property(
 * 		property="latitude",
 * 		description="Latitude of the Location, if any.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="number",
 * 		format="double"
 * 	),
 * 	@OA\Property(
 * 		property="longitude",
 * 		description="Longitude of the Location, if any.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="number",
 * 		format="double"
 * 	),
 * 	@OA\Property(
 * 		property="location",
 * 		description="JSON encoded Google location services data of the Location, if any",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="json",
 * 		maxLength=16777215
 * 	),
 * 	@OA\Property(
 * 		property="map_url",
 * 		description="An external map link of the Location, if any",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="url",
 * 		maxLength=16777215
 * 	),
 * 	@OA\Property(
 * 		property="directions",
 * 		description="Directions required to properly navigate the last part of the journey to, or park at, the Location, if any.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="paragraph",
 * 		example="Take the first right and park next to the abandoned pool.  Go down the path until you see the sign for the designated LARP area.",
 * 		maxLength=16777215
 * 	),
 * 	@OA\Property(
 * 		property="created_by",
 * 		description="The User that created this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true,
 * 		default=1
 * 	),
 * 	@OA\Property(
 * 		property="updated_by",
 * 		description="The last User to update this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_by",
 * 		description="The User that softdeleted this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="created_at",
 * 		description="When the entry was created.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_at",
 * 		description="When the entry was last updated.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_at",
 * 		description="When the entry was softdeleted.  Null if not softdeleted.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	)
 * )
 * @OA\Schema (
 * 	schema="LocationSuperSimple",
 * 	title="LocationSuperSimpleSimple",
 * 	description="Attachable Location object with no attachments or CUD data.",
 * 	@OA\Property(
 * 		property="id",
 * 		description="The entry's ID.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="label",
 * 		description="The Location label, as it might appear on a map.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="uppercase first letter",
 * 		example="McCullum Park",
 * 		maxLength=50
 * 	),
 * 	@OA\Property(
 * 		property="address",
 * 		description="The street address of the Location, if any.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="street",
 * 		example="123 Fake St.",
 * 		maxLength=191
 * 	),
 * 	@OA\Property(
 * 		property="city",
 * 		description="The city of the Location, if any.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="city",
 * 		example="Seattle",
 * 		maxLength=50
 * 	),
 * 	@OA\Property(
 * 		property="province",
 * 		description="The state or provice of the Location, if any.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="state",
 * 		example="Texas",
 * 		maxLength=35
 * 	),
 * 	@OA\Property(
 * 		property="postal_code",
 * 		description="The zip or postal code of the Location, if any.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="zip",
 * 		example="98666",
 * 		maxLength=10
 * 	),
 * 	@OA\Property(
 * 		property="country",
 * 		description="The two letter country code of the Location (default US), if any.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="country",
 * 		example="US",
 * 		maxLength=2,
 *  		default="US"
 * 	),
 * 	@OA\Property(
 * 		property="google_geocode",
 * 		description="JSON encoded Google Geocode data of the Location, if any.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="json",
 * 		maxLength=16777215
 * 	),
 * 	@OA\Property(
 * 		property="latitude",
 * 		description="Latitude of the Location, if any.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="number",
 * 		format="double"
 * 	),
 * 	@OA\Property(
 * 		property="longitude",
 * 		description="Longitude of the Location, if any.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="number",
 * 		format="double"
 * 	),
 * 	@OA\Property(
 * 		property="location",
 * 		description="JSON encoded Google location services data of the Location, if any",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="json",
 * 		maxLength=16777215
 * 	),
 * 	@OA\Property(
 * 		property="map_url",
 * 		description="An external map link of the Location, if any",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="url",
 * 		maxLength=16777215
 * 	),
 * 	@OA\Property(
 * 		property="directions",
 * 		description="Directions required to properly navigate the last part of the journey to, or park at, the Location, if any.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="paragraph",
 * 		example="Take the first right and park next to the abandoned pool.  Go down the path until you see the sign for the designated LARP area.",
 * 		maxLength=16777215
 * 	)
 * )
 * @OA\RequestBody (
 * 	request="Location",
 * 	description="Location object that needs to be added or updated.",
 * 	required=true,
 * 	@OA\MediaType(
 * 		mediaType="multipart/form-data",
 * 		@OA\Schema(ref="#/components/schemas/LocationSimple")
 * 	)
 * )
 * @property int $id Model ID
 * @property string|null $label The Location label, as it might appear on a map
 * @property string|null $address The street address of the Location, if any
 * @property string|null $city The city of the Location, if any
 * @property string|null $province The state or provice of the Location, if any
 * @property string|null $postal_code The zip or postal code of the Location, if any
 * @property string|null $country The two letter country code of the Location (default US), if any
 * @property string|null $google_geocode JSON encoded Google Geocode data of the Location, if any
 * @property float|null $latitude Latitude of the Location, if any
 * @property float|null $longitude Longitude of the Location, if any
 * @property string|null $location JSON encoded Google location services data of the Location, if any
 * @property string|null $map_url An external map link of the Location, if any
 * @property string|null $directions Directions required to properly navigate the last part of the journey to, or park at, the Location, if any
 * @property int $created_by
 * @property \Illuminate\Support\Carbon $created_at
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $deleted_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Chapter> $chapters
 * @property-read int|null $chapters_count
 * @property-read \App\Models\User $createdBy
 * @property-read \App\Models\User $creator
 * @property-read \App\Models\User|null $deletedBy
 * @property-read \App\Models\User|null $destroyer
 * @property-read \App\Models\User|null $editor
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Event> $events
 * @property-read int|null $events_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Issuance> $issuances
 * @property-read int|null $issuances_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Meetup> $meetups
 * @property-read int|null $meetups_count
 * @property-read \App\Models\User|null $updatedBy
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Waiver> $waivers
 * @property-read int|null $waivers_count
 * @method static \Database\Factories\LocationFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Location newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Location newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Location onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Location query()
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereDirections($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereGoogleGeocode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereMapUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location wherePostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereProvince($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Location withoutTrashed()
 */
	class Location extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Meetup
 *
 * @OA\Schema (
 * 	schema="Meetup",
 * 	required={"chapter_id","is_active","purpose","recurrence","week_day","occurs_at"},
 * 	description="Regular gatherings for a given Chapter.<br>The following relationships can be attached, and in the case of plural relations, searched:
 * attendances (Attendance) (MorphMany): Attendances for the Meetup.
 * chapter (Chapter) (BelongsTo): Chapter that sponsors the Meetup.
 * issuances (Issuance) (MorphMany): Issuances made at the Meetup.
 * location (Location) (BelongsTo): Location of the Meetup.
 * createdBy (User) (BelongsTo): User that created it.
 * updatedBy (User) (BelongsTo): User that last updated it (if any).
 * deletedBy (User) (BelongsTo): User that deleted it (if any).",
 * 	@OA\Property(
 * 		property="id",
 * 		description="The entry's ID.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="chapter_id",
 * 		description="The ID of the Chapter hosting the Meetup.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="location_id",
 * 		description="The ID of the Location the Meetup occurs at.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="is_active",
 * 		description="Is the Meetup (default true) still occuring?",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="enum",
 * 		enum={0, 1},
 * 		example=0,
 * 		default=1
 * 	),
 * 	@OA\Property(
 * 		property="purpose",
 * 		description="The nature of the Meetup; Park Day, Fighter Practice, A&S Gathering, or Other.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="enum",
 * 		enum={"Park Day","Fighter Practice","A&S Gathering","Other"},
 * 		example="Park Day"
 * 	),
 * 	@OA\Property(
 * 		property="recurrence",
 * 		description="The frequency with which this Meetup occurs",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="enum",
 * 		enum={"Weekly","Monthly","Week-of-Month"},
 * 		example="Weekly"
 * 	),
 * 	@OA\Property(
 * 		property="week_of_month",
 * 		description="The week of the month the Meetup occurs, if recurrence is Week-of-Month",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="integer",
 * 		example=2
 * 	),
 * 	@OA\Property(
 * 		property="week_day",
 * 		description="",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="enum",
 * 		enum={"None","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"},
 * 		example="Sunday"
 * 	),
 * 	@OA\Property(
 * 		property="month_day",
 * 		description="The day of the month the Meetup occurs, if recurrence is Monthly",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="integer",
 * 		example=2
 * 	),
 * 	@OA\Property(
 * 		property="occurs_at",
 * 		description="The time of day the Meetup takes place.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="time",
 * 		example="12:00:00"
 * 	),
 * 	@OA\Property(
 * 		property="description",
 * 		description="A description of the Meetup, if any.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="paragraph",
 * 		example="Join us for whacks!"
 * 	),
 * 	@OA\Property(
 * 		property="created_by",
 * 		description="The User that created this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true,
 * 		default=1
 * 	),
 * 	@OA\Property(
 * 		property="createdBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_by",
 * 		description="The last User to update this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updatedBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_by",
 * 		description="The User that softdeleted this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deletedBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="created_at",
 * 		description="When the entry was created.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_at",
 * 		description="When the entry was last updated.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_at",
 * 		description="When the entry was softdeleted.  Null if not softdeleted.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="attendances",
 * 		description="Attachable & filterable array of Attendance for the Meetup.",
 * 		type="array",
 * 		@OA\Items(
 * 			title="Attendance",
 * 			type="object",
 * 			ref="#/components/schemas/AttendanceSimple"
 * 		),
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="chapter",
 * 		type="object",
 * 		description="Attachable Chapter that sponsors the Meetup.",
 * 		ref="#/components/schemas/ChapterSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="issuances",
 * 		description="Attachable & filterable array of Issuances made at the Meetup.",
 * 		type="array",
 * 		@OA\Items(
 * 			title="Issuance",
 * 			type="object",
 * 			ref="#/components/schemas/IssuanceSimple"
 * 		),
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="location",
 * 		type="object",
 * 		description="Attachable Location of the Meetup.",
 * 		ref="#/components/schemas/LocationSimple",
 * 		readOnly=true
 * 	)
 * )
 * @OA\Schema (
 * 	schema="MeetupSimple",
 * 	title="MeetupSimple",
 * 	description="Attachable Meetup object with no attachments.",
 * 	@OA\Property(
 * 		property="id",
 * 		description="The entry's ID.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="chapter_id",
 * 		description="The ID of the Chapter hosting the Meetup.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="location_id",
 * 		description="The ID of the Location the Meetup occurs at.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="is_active",
 * 		description="Is the Meetup (default true) still occuring?",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="enum",
 * 		enum={0, 1},
 * 		example=0,
 * 		default=1
 * 	),
 * 	@OA\Property(
 * 		property="purpose",
 * 		description="The nature of the Meetup; Park Day, Fighter Practice, A&S Gathering, or Other.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="enum",
 * 		enum={"Park Day","Fighter Practice","A&S Gathering","Other"},
 * 		example="Park Day"
 * 	),
 * 	@OA\Property(
 * 		property="recurrence",
 * 		description="The frequency with which this Meetup occurs",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="enum",
 * 		enum={"Weekly","Monthly","Week-of-Month"},
 * 		example="Weekly"
 * 	),
 * 	@OA\Property(
 * 		property="week_of_month",
 * 		description="The week of the month the Meetup occurs, if recurrence is Week-of-Month",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="integer",
 * 		example=2
 * 	),
 * 	@OA\Property(
 * 		property="week_day",
 * 		description="",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="enum",
 * 		enum={"None","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"},
 * 		example="Sunday"
 * 	),
 * 	@OA\Property(
 * 		property="month_day",
 * 		description="The day of the month the Meetup occurs, if recurrence is Monthly",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="integer",
 * 		example=2
 * 	),
 * 	@OA\Property(
 * 		property="occurs_at",
 * 		description="The time of day the Meetup takes place.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="time",
 * 		example="12:00:00"
 * 	),
 * 	@OA\Property(
 * 		property="description",
 * 		description="A description of the Meetup, if any.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="paragraph",
 * 		example="Join us for whacks!"
 * 	),
 * 	@OA\Property(
 * 		property="created_by",
 * 		description="The User that created this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true,
 * 		default=1
 * 	),
 * 	@OA\Property(
 * 		property="updated_by",
 * 		description="The last User to update this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_by",
 * 		description="The User that softdeleted this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="created_at",
 * 		description="When the entry was created.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_at",
 * 		description="When the entry was last updated.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_at",
 * 		description="When the entry was softdeleted.  Null if not softdeleted.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	)
 * )
 * @OA\Schema (
 * 	schema="MeetupSuperSimple",
 * 	title="MeetupSuperSimpleSimple",
 * 	description="Attachable Meetup object with no attachments or CUD data.",
 * 	@OA\Property(
 * 		property="id",
 * 		description="The entry's ID.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="chapter_id",
 * 		description="The ID of the Chapter hosting the Meetup.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="location_id",
 * 		description="The ID of the Location the Meetup occurs at.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="is_active",
 * 		description="Is the Meetup (default true) still occuring?",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="enum",
 * 		enum={0, 1},
 * 		example=0,
 * 		default=1
 * 	),
 * 	@OA\Property(
 * 		property="purpose",
 * 		description="The nature of the Meetup; Park Day, Fighter Practice, A&S Gathering, or Other.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="enum",
 * 		enum={"Park Day","Fighter Practice","A&S Gathering","Other"},
 * 		example="Park Day"
 * 	),
 * 	@OA\Property(
 * 		property="recurrence",
 * 		description="The frequency with which this Meetup occurs",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="enum",
 * 		enum={"Weekly","Monthly","Week-of-Month"},
 * 		example="Weekly"
 * 	),
 * 	@OA\Property(
 * 		property="week_of_month",
 * 		description="The week of the month the Meetup occurs, if recurrence is Week-of-Month",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="integer",
 * 		example=2
 * 	),
 * 	@OA\Property(
 * 		property="week_day",
 * 		description="",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="enum",
 * 		enum={"None","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"},
 * 		example="Sunday"
 * 	),
 * 	@OA\Property(
 * 		property="month_day",
 * 		description="The day of the month the Meetup occurs, if recurrence is Monthly",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="integer",
 * 		example=2
 * 	),
 * 	@OA\Property(
 * 		property="occurs_at",
 * 		description="The time of day the Meetup takes place.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="time",
 * 		example="12:00:00"
 * 	),
 * 	@OA\Property(
 * 		property="description",
 * 		description="A description of the Meetup, if any.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="paragraph",
 * 		example="Join us for whacks!"
 * 	)
 * )
 * @OA\RequestBody (
 * 	request="Meetup",
 * 	description="Meetup object that needs to be added or updated.",
 * 	required=true,
 * 	@OA\MediaType(
 * 		mediaType="multipart/form-data",
 * 		@OA\Schema(ref="#/components/schemas/MeetupSimple")
 * 	)
 * )
 * @property int $id Model ID
 * @property int $chapter_id The ID of the Chapter hosting the Meetup
 * @property int|null $location_id The ID of the Location the Meetup occurs at
 * @property bool $is_active Is (default true) the Meetup still occuring?
 * @property string $purpose The nature of the Meetup; Park Day, Fighter Practice, A&S Gathering, or Other
 * @property string $recurrence The frequency with which this Meetup occurs
 * @property int|null $week_of_month The week of the month the Meetup occurs, if recurrence is Week-of-Month
 * @property string $week_day They day of the week the Meetup occurs, if recurrence is Weekly
 * @property int|null $month_day The day of the month the Meetup occurs, if recurrence is Monthly
 * @property string $occurs_at The time of day the Meetup takes place
 * @property string|null $description A description of the Meetup, if any
 * @property int $created_by
 * @property \Illuminate\Support\Carbon $created_at
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $deleted_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Attendance> $attendances
 * @property-read int|null $attendances_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\Chapter $chapter
 * @property-read \App\Models\User $createdBy
 * @property-read \App\Models\User $creator
 * @property-read \App\Models\User|null $deletedBy
 * @property-read \App\Models\User|null $destroyer
 * @property-read \App\Models\User|null $editor
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Issuance> $issuances
 * @property-read int|null $issuances_count
 * @property-read \App\Models\Location|null $location
 * @property-read \App\Models\User|null $updatedBy
 * @method static \Database\Factories\MeetupFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Meetup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Meetup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Meetup onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Meetup query()
 * @method static \Illuminate\Database\Eloquent\Builder|Meetup whereChapterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Meetup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Meetup whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Meetup whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Meetup whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Meetup whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Meetup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Meetup whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Meetup whereLocationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Meetup whereMonthDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Meetup whereOccursAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Meetup wherePurpose($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Meetup whereRecurrence($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Meetup whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Meetup whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Meetup whereWeekDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Meetup whereWeekOfMonth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Meetup withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Meetup withoutTrashed()
 */
	class Meetup extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Member
 *
 * @OA\Schema (
 * 	schema="Member",
 * 	required={"unit_id","persona_id","is_head","is_voting"},
 * 	description="Membership data for Units.<br>The following relationships can be attached, and in the case of plural relations, searched:
 * persona (Persona) (BelongsTo): The Persona in the Unit.
 * unit (Unit) (BelongsTo): The Unit the Persona is in.
 * createdBy (User) (BelongsTo): User that created it.
 * updatedBy (User) (BelongsTo): User that last updated it (if any).
 * deletedBy (User) (BelongsTo): User that deleted it (if any).",
 * 	@OA\Property(
 * 		property="id",
 * 		description="The entry's ID.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="persona_id",
 * 		description="The ID of the Persona that has Membership in the given Unit.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="unit_id",
 * 		description="The ID of the Unit of which the Persona is a Member.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="is_head",
 * 		description="Is this Persona (default false) the single point of contact for the Unit?",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="enum",
 * 		enum={0, 1},
 * 		example=0,
 * 		default=0
 * 	),
 * 	@OA\Property(
 * 		property="is_voting",
 * 		description="Is this Persona (default false) a full voting Member?",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="enum",
 * 		enum={0, 1},
 * 		example=0,
 * 		default=0
 * 	),
 * 	@OA\Property(
 * 		property="joined_at",
 * 		description="The date this Persona joined the Unit, if known.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="date",
 * 		example="2020-12-30"
 * 	),
 * 	@OA\Property(
 * 		property="left_at",
 * 		description="The date this Persona left the Unit, if they have.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="date",
 * 		example="2020-12-30"
 * 	),
 * 	@OA\Property(
 * 		property="notes",
 * 		description="Notes on the Membership, if any",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 	),
 * 	@OA\Property(
 * 		property="created_by",
 * 		description="The User that created this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true,
 * 		default=1
 * 	),
 * 	@OA\Property(
 * 		property="createdBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_by",
 * 		description="The last User to update this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updatedBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_by",
 * 		description="The User that softdeleted this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deletedBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="created_at",
 * 		description="When the entry was created.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_at",
 * 		description="When the entry was last updated.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_at",
 * 		description="When the entry was softdeleted.  Null if not softdeleted.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="persona",
 * 		type="object",
 * 		description="Attachable Persona in the Unit.",
 * 		ref="#/components/schemas/PersonaSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="unit",
 * 		type="object",
 * 		description="Attachable Unit the Persona is in.",
 * 		ref="#/components/schemas/UnitSimple",
 * 		readOnly=true
 * 	)
 * )
 * @OA\Schema (
 * 	schema="MemberSimple",
 * 	title="MemberSimple",
 * 	description="Attachable Member object with no attachments.",
 * 	@OA\Property(
 * 		property="id",
 * 		description="The entry's ID.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="persona_id",
 * 		description="The ID of the Persona that has Membership in the given Unit.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="unit_id",
 * 		description="The ID of the Unit of which the Persona is a Member.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="is_head",
 * 		description="Is this Persona (default false) the single point of contact for the Unit?",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="enum",
 * 		enum={0, 1},
 * 		example=0,
 * 		default=0
 * 	),
 * 	@OA\Property(
 * 		property="is_voting",
 * 		description="Is this Persona (default false) a full voting Member?",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="enum",
 * 		enum={0, 1},
 * 		example=0,
 * 		default=0
 * 	),
 * 	@OA\Property(
 * 		property="joined_at",
 * 		description="The date this Persona joined the Unit, if known.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="date",
 * 		example="2020-12-30"
 * 	),
 * 	@OA\Property(
 * 		property="left_at",
 * 		description="The date this Persona left the Unit, if they have.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="date",
 * 		example="2020-12-30"
 * 	),
 * 	@OA\Property(
 * 		property="notes",
 * 		description="Notes on the Membership, if any",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 	),
 * 	@OA\Property(
 * 		property="created_by",
 * 		description="The User that created this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true,
 * 		default=1
 * 	),
 * 	@OA\Property(
 * 		property="updated_by",
 * 		description="The last User to update this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_by",
 * 		description="The User that softdeleted this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="created_at",
 * 		description="When the entry was created.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_at",
 * 		description="When the entry was last updated.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_at",
 * 		description="When the entry was softdeleted.  Null if not softdeleted.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	)
 * )
 * @OA\Schema (
 * 	schema="MemberSuperSimple",
 * 	title="MemberSuperSimpleSimple",
 * 	description="Attachable Member object with no attachments or CUD data.",
 * 	@OA\Property(
 * 		property="id",
 * 		description="The entry's ID.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="persona_id",
 * 		description="The ID of the Persona that has Membership in the given Unit.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="unit_id",
 * 		description="The ID of the Unit of which the Persona is a Member.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="is_head",
 * 		description="Is this Persona (default false) the single point of contact for the Unit?",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="enum",
 * 		enum={0, 1},
 * 		example=0,
 * 		default=0
 * 	),
 * 	@OA\Property(
 * 		property="is_voting",
 * 		description="Is this Persona (default false) a full voting Member?",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="enum",
 * 		enum={0, 1},
 * 		example=0,
 * 		default=0
 * 	),
 * 	@OA\Property(
 * 		property="joined_at",
 * 		description="The date this Persona joined the Unit, if known.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="date",
 * 		example="2020-12-30"
 * 	),
 * 	@OA\Property(
 * 		property="left_at",
 * 		description="The date this Persona left the Unit, if they have.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="date",
 * 		example="2020-12-30"
 * 	),
 * 	@OA\Property(
 * 		property="notes",
 * 		description="Notes on the Membership, if any",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 	)
 * )
 * @OA\RequestBody (
 * 	request="Member",
 * 	description="Member object that needs to be added or updated.",
 * 	required=true,
 * 	@OA\MediaType(
 * 		mediaType="multipart/form-data",
 * 		@OA\Schema(ref="#/components/schemas/MemberSimple")
 * 	)
 * )
 * @property int $id Model ID
 * @property int $persona_id The ID of the Persona that has Membership in the given Unit
 * @property int $unit_id The ID of the Unit of which they are Members
 * @property bool $is_head Is (default false) this Persona the single point of contact for the Unit?
 * @property bool $is_voting Is this Persona (default false) a full voting Member?
 * @property \Illuminate\Support\Carbon|null $joined_at The date this Persona joined the Unit, if known
 * @property \Illuminate\Support\Carbon|null $left_at The date this Persona left the Unit, if they have
 * @property string|null $notes Notes on the Membership, if any
 * @property int $created_by
 * @property \Illuminate\Support\Carbon $created_at
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $deleted_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\User $createdBy
 * @property-read \App\Models\User $creator
 * @property-read \App\Models\User|null $deletedBy
 * @property-read \App\Models\User|null $destroyer
 * @property-read \App\Models\User|null $editor
 * @property-read \App\Models\Persona $persona
 * @property-read \App\Models\Unit $unit
 * @property-read \App\Models\User|null $updatedBy
 * @method static \Database\Factories\MemberFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Member newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Member newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Member onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Member query()
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereIsHead($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereIsVoting($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereJoinedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereLeftAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member wherePersonaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereUnitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Member withoutTrashed()
 */
	class Member extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Office
 *
 * @OA\Schema (
 * 	schema="Office",
 * 	required={"officeable_type","name"},
 * 	description="Offices available for the given Chaptertype, Realm, or Unit.<br>The following relationships can be attached, and in the case of plural relations, searched:
 * officeable (Chaptertype, Realm, or Unit) (MorphTo): Type for what the Office is for; Chaptertype, Realm, or Unit.
 * officers (Officer) (HasMany): Officers having held this Office.
 * createdBy (User) (BelongsTo): User that created it.
 * updatedBy (User) (BelongsTo): User that last updated it (if any).
 * deletedBy (User) (BelongsTo): User that deleted it (if any).",
 * 	@OA\Property(
 * 		property="id",
 * 		description="The entry's ID.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="officeable_type",
 * 		description="Type for what the Office is for; Chaptertype, Realm, or Unit.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="enum",
 * 		enum={"Chaptertype","Realm","Unit"},
 * 		example="Chaptertype"
 * 	),
 * 	@OA\Property(
 * 		property="officeable_id",
 * 		description="The ID of what the Office is for.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="name",
 * 		description="The name of the Office, options delineated with a single |",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="uppercase first letter",
 * 		example="Prime Minister",
 * 		maxLength=100
 * 	),
 * 		@OA\Property(
 *  		property="duration",
 *  		description="Duration, in months, of the office (default 6)",
 *  		type="integer",
 *  		format="int32",
 *  		nullable=true,
 *  		example=6,
 *  		default=6
 * 	),
 * 		@OA\Property(
 * 		property="order",
 * 		description="If the Realm has an order of precedence, the office level where Monarch = 1, else null",
 * 		type="integer",
 *  		format="int32",
 * 		nullable=true,
 * 		example=1
 * 	),
 * 	@OA\Property(
 * 		property="created_by",
 * 		description="The User that created this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true,
 * 		default=1
 * 	),
 * 	@OA\Property(
 * 		property="createdBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_by",
 * 		description="The last User to update this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updatedBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_by",
 * 		description="The User that softdeleted this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deletedBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="created_at",
 * 		description="When the entry was created.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_at",
 * 		description="When the entry was last updated.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_at",
 * 		description="When the entry was softdeleted.  Null if not softdeleted.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="officeable",
 * 		type="object",
 * 		description="Attachable object the Office is for.",
 * 		oneOf={
 * 			@OA\Schema(ref="#/components/schemas/ChaptertypeSimple"),
 * 			@OA\Schema(ref="#/components/schemas/RealmSimple"),
 * 			@OA\Schema(ref="#/components/schemas/UnitSimple")
 * 		},
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="officers",
 * 		description="Attachable & filterable array of Officers having held the Office.",
 * 		type="array",
 * 		@OA\Items(
 * 			title="Officer",
 * 			type="object",
 * 			ref="#/components/schemas/OfficerSimple"
 * 		),
 * 		readOnly=true
 * 	)
 * )
 * @OA\Schema (
 * 	schema="OfficeSimple",
 * 	title="OfficeSimple",
 * 	description="Attachable Office object with no attachments.",
 * 	@OA\Property(
 * 		property="id",
 * 		description="The entry's ID.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="officeable_type",
 * 		description="Type for what the Office is for; Chaptertype, Realm, or Unit.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="enum",
 * 		enum={"Chaptertype","Realm","Unit"},
 * 		example="Chaptertype"
 * 	),
 * 	@OA\Property(
 * 		property="officeable_id",
 * 		description="The ID of what the Office is for.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="name",
 * 		description="The name of the Office, options delineated with a single |",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="uppercase first letter",
 * 		example="Prime Minister",
 * 		maxLength=100
 * 	),
 * 		@OA\Property(
 *  		property="duration",
 *  		description="Duration, in months, of the office (default 6)",
 *  		type="integer",
 *  		format="int32",
 *  		nullable=true,
 *  		example=6,
 *  		default=6
 * 	),
 * 		@OA\Property(
 * 		property="order",
 * 		description="If the Realm has an order of precedence, the office level where Monarch = 1, else null",
 * 		type="integer",
 *  		format="int32",
 * 		nullable=true,
 * 		example=1
 * 	),
 * 	@OA\Property(
 * 		property="created_by",
 * 		description="The User that created this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true,
 * 		default=1
 * 	),
 * 	@OA\Property(
 * 		property="updated_by",
 * 		description="The last User to update this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_by",
 * 		description="The User that softdeleted this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="created_at",
 * 		description="When the entry was created.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_at",
 * 		description="When the entry was last updated.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_at",
 * 		description="When the entry was softdeleted.  Null if not softdeleted.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	)
 * )
 * @OA\Schema (
 * 	schema="OfficeSuperSimple",
 * 	title="OfficeSuperSimpleSimple",
 * 	description="Attachable Office object with no attachments or CUD data.",
 * 	@OA\Property(
 * 		property="id",
 * 		description="The entry's ID.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="officeable_type",
 * 		description="Type for what the Office is for; Chaptertype, Realm, or Unit.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="enum",
 * 		enum={"Chaptertype","Realm","Unit"},
 * 		example="Chaptertype"
 * 	),
 * 	@OA\Property(
 * 		property="officeable_id",
 * 		description="The ID of what the Office is for.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="name",
 * 		description="The name of the Office, options delineated with a single |",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="uppercase first letter",
 * 		example="Prime Minister",
 * 		maxLength=100
 * 	),
 * 		@OA\Property(
 *  		property="duration",
 *  		description="Duration, in months, of the office (default 6)",
 *  		type="integer",
 *  		format="int32",
 *  		nullable=true,
 *  		example=6,
 *  		default=6
 * 	),
 * 		@OA\Property(
 * 		property="order",
 * 		description="If the Realm has an order of precedence, the office level where Monarch = 1, else null",
 * 		type="integer",
 *  		format="int32",
 * 		nullable=true,
 * 		example=1
 * 	)
 * )
 * @OA\RequestBody (
 * 	request="Office",
 * 	description="Office object that needs to be added or updated.",
 * 	required=true,
 * 	@OA\MediaType(
 * 		mediaType="multipart/form-data",
 * 		@OA\Schema(ref="#/components/schemas/OfficeSimple")
 * 	)
 * )
 * @property int $id Model ID
 * @property string $officeable_type Type for what the Office is for; Chaptertype, Realm, or Unit
 * @property int $officeable_id The ID of what the Office is for
 * @property string $name The name of the Office, options delineated with a single |
 * @property int|null $duration Duration, in months, of the office (default 6)
 * @property int|null $order If the Realm has an order of prescidence, the office level where Monarch = 1, else null
 * @property int $created_by
 * @property \Illuminate\Support\Carbon $created_at
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $deleted_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\User $createdBy
 * @property-read \App\Models\User $creator
 * @property-read \App\Models\User|null $deletedBy
 * @property-read \App\Models\User|null $destroyer
 * @property-read \App\Models\User|null $editor
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $officeable
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Officer> $officers
 * @property-read int|null $officers_count
 * @property-read \App\Models\User|null $updatedBy
 * @method static \Database\Factories\OfficeFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Office newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Office newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Office onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Office query()
 * @method static \Illuminate\Database\Eloquent\Builder|Office whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Office whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Office whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Office whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Office whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Office whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Office whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Office whereOfficeableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Office whereOfficeableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Office whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Office whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Office whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Office withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Office withoutTrashed()
 */
	class Office extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Officer
 *
 * @OA\Schema (
 * 	schema="Officer",
 * 	required={"officerable_type","officerable_id","office_id","persona_id"},
 * 	description="Officers for the given Reign or Unit<br>The following relationships can be attached, and in the case of plural relations, searched:
 * office (Office) (BelongsTo): Office held.
 * officerable (Reign or Unit) (MorphTo): Reign or Unit the Persona is an Officer of.
 * persona (Persona) (BelongsTo): Persona holding the given Office.
 * createdBy (User) (BelongsTo): User that created it.
 * updatedBy (User) (BelongsTo): User that last updated it (if any).
 * deletedBy (User) (BelongsTo): User that deleted it (if any).",
 * 	@OA\Property(
 * 		property="id",
 * 		description="The entry's ID.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="officerable_type",
 * 		description="Type of that which the Persona is Officer of; Reign or Unit.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="enum",
 * 		enum={"Reign","Unit"},
 * 		example="Reign"
 * 	),
 * 	@OA\Property(
 * 		property="officerable_id",
 * 		description="The ID of the Reign or Unit they are Officer of.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="office_id",
 * 		description="The ID of the Office this Persona held.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="persona_id",
 * 		description="The ID of the Persona holding this Office.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="label",
 * 		description="If the Office name has options, or allows customization, the selected label, if any.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="capitalize first letter",
 * 		example="Queen",
 * 		maxLength=50
 * 	),
 * 	@OA\Property(
 * 		property="starts_on",
 * 		description="If the Officer is pro-tem, or is for a Unit, when the Office began, otherwise null to use Reign data.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="date",
 * 		example="2020-12-30"
 * 	),
 * 	@OA\Property(
 * 		property="ends_on",
 * 		description="If the Officer ends their term early, or is for a Unit, when the Office was exited, otherwise null to use Reign data.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="date",
 * 		example="2020-12-30"
 * 	),
 * 	@OA\Property(
 * 		property="notes",
 * 		description="Notes about the Officer or their time in office, or explaining pro-tem, if any",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="paragraph",
 * 		example="Took over after the last guy got banned.",
 * 		maxLength=191
 * 	),
 * 	@OA\Property(
 * 		property="created_by",
 * 		description="The User that created this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true,
 * 		default=1
 * 	),
 * 	@OA\Property(
 * 		property="createdBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_by",
 * 		description="The last User to update this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updatedBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_by",
 * 		description="The User that softdeleted this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deletedBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="created_at",
 * 		description="When the entry was created.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_at",
 * 		description="When the entry was last updated.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_at",
 * 		description="When the entry was softdeleted.  Null if not softdeleted.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="office",
 * 		type="object",
 * 		description="Attachable Office held.",
 * 		ref="#/components/schemas/OfficeSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="officerable",
 * 		type="object",
 * 		description="Attachable object the Persona is an Officer of.",
 * 		oneOf={
 * 			@OA\Schema(ref="#/components/schemas/ReignSimple"),
 * 			@OA\Schema(ref="#/components/schemas/UnitSimple")
 * 		},
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="persona",
 * 		type="object",
 * 		description="Attachable Persona holding the given Office.",
 * 		ref="#/components/schemas/PersonaSimple",
 * 		readOnly=true
 * 	)
 * )
 * @OA\Schema (
 * 	schema="OfficerSimple",
 * 	title="OfficerSimple",
 * 	description="Attachable Officer object with no attachments.",
 * 	@OA\Property(
 * 		property="id",
 * 		description="The entry's ID.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="officerable_type",
 * 		description="Type of that which the Persona is Officer of; Reign or Unit.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="enum",
 * 		enum={"Reign","Unit"},
 * 		example="Reign"
 * 	),
 * 	@OA\Property(
 * 		property="officerable_id",
 * 		description="The ID of the Reign or Unit they are Officer of.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="office_id",
 * 		description="The ID of the Office this Persona held.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="persona_id",
 * 		description="The ID of the Persona holding this Office.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="label",
 * 		description="If the Office name has options, or allows customization, the selected label, if any.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="capitalize first letter",
 * 		example="Queen",
 * 		maxLength=50
 * 	),
 * 	@OA\Property(
 * 		property="starts_on",
 * 		description="If the Officer is pro-tem, or is for a Unit, when the Office began, otherwise null to use Reign data.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="date",
 * 		example="2020-12-30"
 * 	),
 * 	@OA\Property(
 * 		property="ends_on",
 * 		description="If the Officer ends their term early, or is for a Unit, when the Office was exited, otherwise null to use Reign data.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="date",
 * 		example="2020-12-30"
 * 	),
 * 	@OA\Property(
 * 		property="notes",
 * 		description="Notes about the Officer or their time in office, or explaining pro-tem, if any",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="paragraph",
 * 		example="Took over after the last guy got banned.",
 * 		maxLength=191
 * 	),
 * 	@OA\Property(
 * 		property="created_by",
 * 		description="The User that created this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true,
 * 		default=1
 * 	),
 * 	@OA\Property(
 * 		property="updated_by",
 * 		description="The last User to update this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_by",
 * 		description="The User that softdeleted this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="created_at",
 * 		description="When the entry was created.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_at",
 * 		description="When the entry was last updated.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_at",
 * 		description="When the entry was softdeleted.  Null if not softdeleted.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	)
 * )
 * @OA\Schema (
 * 	schema="OfficerSuperSimple",
 * 	title="OfficerSuperSimpleSimple",
 * 	description="Attachable Officer object with no attachments or CUD data.",
 * 	@OA\Property(
 * 		property="id",
 * 		description="The entry's ID.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="officerable_type",
 * 		description="Type of that which the Persona is Officer of; Reign or Unit.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="enum",
 * 		enum={"Reign","Unit"},
 * 		example="Reign"
 * 	),
 * 	@OA\Property(
 * 		property="officerable_id",
 * 		description="The ID of the Reign or Unit they are Officer of.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="office_id",
 * 		description="The ID of the Office this Persona held.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="persona_id",
 * 		description="The ID of the Persona holding this Office.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="label",
 * 		description="If the Office name has options, or allows customization, the selected label, if any.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="capitalize first letter",
 * 		example="Queen",
 * 		maxLength=50
 * 	),
 * 	@OA\Property(
 * 		property="starts_on",
 * 		description="If the Officer is pro-tem, or is for a Unit, when the Office began, otherwise null to use Reign data.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="date",
 * 		example="2020-12-30"
 * 	),
 * 	@OA\Property(
 * 		property="ends_on",
 * 		description="If the Officer ends their term early, or is for a Unit, when the Office was exited, otherwise null to use Reign data.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="date",
 * 		example="2020-12-30"
 * 	),
 * 	@OA\Property(
 * 		property="notes",
 * 		description="Notes about the Officer or their time in office, or explaining pro-tem, if any",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="paragraph",
 * 		example="Took over after the last guy got banned.",
 * 		maxLength=191
 * 	)
 * )
 * @OA\RequestBody (
 * 	request="Officer",
 * 	description="Officer object that needs to be added or updated.",
 * 	required=true,
 * 	@OA\MediaType(
 * 		mediaType="multipart/form-data",
 * 		@OA\Schema(ref="#/components/schemas/OfficerSimple")
 * 	)
 * )
 * @property int $id Model ID
 * @property string $officerable_type Type of that which the Persona is Officer of; Reign or Unit
 * @property int $officerable_id The ID of the Reign or Unit they are Officer of
 * @property int $office_id The ID of the Office this Persona held
 * @property int $persona_id The ID of the Persona holding this Office
 * @property string|null $label If the Office name has options, or allows customization, the selected label, if any
 * @property \Illuminate\Support\Carbon|null $starts_on If the Officer is pro-tem, or is for a Unit, when the Office began, otherwise null to use Reign data
 * @property \Illuminate\Support\Carbon|null $ends_on If the Officer ends their term early, or is for a Unit, when the Office was exited, otherwise null to use Reign data
 * @property string|null $notes Notes about the Officer or their time in office, or explaining pro-tem, if any
 * @property int $created_by
 * @property \Illuminate\Support\Carbon $created_at
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $deleted_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\User $createdBy
 * @property-read \App\Models\User $creator
 * @property-read \App\Models\User|null $deletedBy
 * @property-read \App\Models\User|null $destroyer
 * @property-read \App\Models\User|null $editor
 * @property-read \App\Models\Office $office
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $officerable
 * @property-read \App\Models\Persona $persona
 * @property-read \App\Models\User|null $updatedBy
 * @method static \Database\Factories\OfficerFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Officer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Officer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Officer onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Officer query()
 * @method static \Illuminate\Database\Eloquent\Builder|Officer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Officer whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Officer whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Officer whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Officer whereEndsOn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Officer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Officer whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Officer whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Officer whereOfficeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Officer whereOfficerableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Officer whereOfficerableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Officer wherePersonaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Officer whereStartsOn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Officer whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Officer whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Officer withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Officer withoutTrashed()
 */
	class Officer extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PasswordHistory
 *
 * @property int $id
 * @property int $user_id
 * @property string $password
 * @property string $created_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|PasswordHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PasswordHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PasswordHistory query()
 * @method static \Illuminate\Database\Eloquent\Builder|PasswordHistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PasswordHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PasswordHistory wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PasswordHistory whereUserId($value)
 */
	class PasswordHistory extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Persona
 *
 * @OA\Schema (
 * 	schema="Persona",
 * 	required={"chapter_id","name","is_active"},
 * 	description="Members of Amtgard.<br>The following relationships can be attached, and in the case of plural relations, searched:
 * attendances (Attendance) (HasMany): Attendances for the Persona.
 * awards (Issuance) {MorphMany): Awards received by the Persona.
 * chapter (Chapter) (BelongsTo): Chapter the Persona calls home.
 * crats (Crat) (HasMany): Crat positions held by the Persona.
 * dues (Due) (HasMany): Dues paid by the Persona.
 * events (Event) (MorphMany): Events sponsored by the Persona.
 * issuanceGivens (Issuance) {MorphMany): Issuances made by the Persona, typically retainer and squire Titles.
 * issuanceRevokeds (Issuance) {MorphMany): Issuances revoked by the Persona.
 * issuanceSigneds (Issuance) {MorphMany): Issuances signed by the Persona.
 * members (Member) (HasMany): Memberships in Units the Persona has had.
 * officers (Officer) (HasMany): Officer positions held by the Persona.
 * pronoun (Pronoun) (BelongsTo): Prefered selected pronouns for the Persona.
 * recommendations (Recommendation) (HasMany): Issuance Recommendations made for this Persona.
 * reconciliations (Reconciliation) (HasMany): Credit reconciliations for this Persona.
 * socials (Social) (MorphMany): Socials for the Persona.
 * splits (Split) (HasMany): Splits this Persona took part in.
 * suspensions (Suspension) (HasMany): Suspensions the Persona has undergone.
 * suspensionIssueds (Suspension) (HasMany): Suspensions the Persona has issued.
 * titles (Issuance) {MorphMany): Titles received by the Persona.
 * titleIssuables (Title) (MorphMany): Titles the Persona can Issue.
 * units (Unit) (HasManyThrough): Companies and Households the Persona is in.
 * user (User) (BelongsTo): The User for the Persona.
 * waivers (Waiver) (HasMany): The Waivers for the Persona.
 * waiverVerifieds (Waiver) (HasMany): Waivers age verified by the Persona.
 * createdBy (User) (BelongsTo): User that created it.
 * updatedBy (User) (BelongsTo): User that last updated it (if any).
 * deletedBy (User) (BelongsTo): User that deleted it (if any).",
 * 	@OA\Property(
 * 		property="id",
 * 		description="The entry's ID.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="chapter_id",
 * 		description="The ID of the Chapter the Persona is Waivered at.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="pronoun_id",
 * 		description="The ID of the pronouns associated with this Persona, if known.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="mundane",
 * 		description="What the Persona typically enters into the Mundane field of the sign-in.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="uppercase first letter",
 * 		example="John Smith",
 * 		maxLength=191
 * 	),
 * 	@OA\Property(
 * 		property="name",
 * 		description="The Persona name, without titles or honors, but otherwise in full.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="uppercase first letter",
 * 		example="Color Animal",
 * 		maxLength=191
 * 	),
 * 	@OA\Property(
 * 		property="heraldry",
 * 		description="An internal link to an image of the Persona heraldry.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="filename",
 * 		example="images/personaHeraldries/42.jpg",
 * 		maxLength=191
 * 	),
 * 	@OA\Property(
 * 		property="image",
 * 		description="An internal link to an image of the Persona",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="filename",
 * 		example="images/personas/42.jpg",
 * 		maxLength=191
 * 	),
 * 	@OA\Property(
 * 		property="is_active",
 * 		description="Is (default true) the Persona still active?",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="enum",
 * 		enum={0, 1},
 * 		example=0,
 * 		default=1
 * 	),
 * 	@OA\Property(
 * 		property="reeve_qualified_expires_at",
 * 		description="If they are Reeve Qualified, when it expires.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="date",
 * 		example="2020-12-30"
 * 	),
 * 	@OA\Property(
 * 		property="corpora_qualified_expires_at",
 * 		description="If they are Corpora Qualified, when it expires.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="date",
 * 		example="2020-12-30"
 * 	),
 * 	@OA\Property(
 * 		property="joined_chapter_at",
 * 		description="The date the Persona joined the Chapter, either as a newb or a transfer.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="date",
 * 		example="2020-12-30"
 * 	),
 * 	@OA\Property(
 * 		property="created_by",
 * 		description="The User that created this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true,
 * 		default=1
 * 	),
 * 	@OA\Property(
 * 		property="createdBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_by",
 * 		description="The last User to update this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updatedBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_by",
 * 		description="The User that softdeleted this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deletedBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="created_at",
 * 		description="When the entry was created.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_at",
 * 		description="When the entry was last updated.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_at",
 * 		description="When the entry was softdeleted.  Null if not softdeleted.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="attendances",
 * 		description="Attachable & filterable array of Attendances for the Persona.",
 * 		type="array",
 * 		@OA\Items(
 * 			title="Attendance",
 * 			type="object",
 * 			ref="#/components/schemas/AttendanceSimple"
 * 		),
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="awards",
 * 		description="Attachable & filterable array of Issuances received by the Persona.",
 * 		type="array",
 * 		@OA\Items(
 * 			title="Issuance",
 * 			type="object",
 * 			ref="#/components/schemas/IssuanceSimple"
 * 		),
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="chapter",
 * 		type="object",
 * 		description="Attachable Chapter the Persona calls home.",
 * 		ref="#/components/schemas/ChapterSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="crats",
 * 		description="Attachable & filterable array of Crat positions held by the Persona.",
 * 		type="array",
 * 		@OA\Items(
 * 			title="Crat",
 * 			type="object",
 * 			ref="#/components/schemas/CratSimple"
 * 		),
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="dues",
 * 		description="Attachable & filterable array of Dues paid by the Persona.",
 * 		type="array",
 * 		@OA\Items(
 * 			title="Due",
 * 			type="object",
 * 			ref="#/components/schemas/OfficerSimple"
 * 		),
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="events",
 * 		description="Attachable & filterable array of Events sponsored by the Persona.",
 * 		type="array",
 * 		@OA\Items(
 * 			title="Event",
 * 			type="object",
 * 			ref="#/components/schemas/EventSimple"
 * 		),
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="issuanceGivens",
 * 		description="Attachable & filterable array of Issuances made by the Persona, typically retainer and squire Titles.",
 * 		type="array",
 * 		@OA\Items(
 * 			title="Issuance",
 * 			type="object",
 * 			ref="#/components/schemas/IssuanceSimple"
 * 		),
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="issuanceRevokeds",
 * 		description="Attachable & filterable array of Issuances revoked by the Persona.",
 * 		type="array",
 * 		@OA\Items(
 * 			title="Issuance",
 * 			type="object",
 * 			ref="#/components/schemas/IssuanceSimple"
 * 		),
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="issuanceSigneds",
 * 		description="Attachable & filterable array of Issuances signed by the Persona.",
 * 		type="array",
 * 		@OA\Items(
 * 			title="Issuance",
 * 			type="object",
 * 			ref="#/components/schemas/IssuanceSimple"
 * 		),
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="members",
 * 		description="Attachable & filterable array of Memberships in Units the Persona has had.",
 * 		type="array",
 * 		@OA\Items(
 * 			title="Member",
 * 			type="object",
 * 			ref="#/components/schemas/MemberSimple"
 * 		),
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="officers",
 * 		description="Attachable & filterable array of Officer positions held by the Persona.",
 * 		type="array",
 * 		@OA\Items(
 * 			title="Officer",
 * 			type="object",
 * 			ref="#/components/schemas/OfficerSimple"
 * 		),
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="pronoun",
 * 		type="object",
 * 		description="Attachable selected pronouns for the Persona.",
 * 		ref="#/components/schemas/PronounSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="recommendations",
 * 		description="Attachable & filterable array of Issuance Recommendations made for this Persona.",
 * 		type="array",
 * 		@OA\Items(
 * 			title="Recommendation",
 * 			type="object",
 * 			ref="#/components/schemas/RecommendationSimple"
 * 		),
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="reconciliations",
 * 		description="Attachable & filterable array of Credit reconciliations for this Persona.",
 * 		type="array",
 * 		@OA\Items(
 * 			title="Reconciliation",
 * 			type="object",
 * 			ref="#/components/schemas/ReconciliationSimple"
 * 		),
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="splits",
 * 		description="Attachable & filterable array of Splits this Persona took part in.",
 * 		type="array",
 * 		@OA\Items(
 * 			title="Split",
 * 			type="object",
 * 			ref="#/components/schemas/SplitSimple"
 * 		),
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="socials",
 * 		description="Attachable & filterable array of the Socials of the Persona.",
 * 		type="array",
 * 		@OA\Items(
 * 			title="Social",
 * 			type="object",
 * 			ref="#/components/schemas/SocialSimple"
 * 		),
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="suspensions",
 * 		description="Attachable & filterable array of Suspensions the Persona has undergone.",
 * 		type="array",
 * 		@OA\Items(
 * 			title="Suspension",
 * 			type="object",
 * 			ref="#/components/schemas/SuspensionSimple"
 * 		),
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="suspensionIssueds",
 * 		description="Attachable & filterable array of Suspensions the Persona has issued.",
 * 		type="array",
 * 		@OA\Items(
 * 			title="Suspension",
 * 			type="object",
 * 			ref="#/components/schemas/SuspensionSimple"
 * 		),
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="titles",
 * 		description="Attachable & filterable array of Title Issuances received by the Persona.",
 * 		type="array",
 * 		@OA\Items(
 * 			title="Issuance",
 * 			type="object",
 * 			ref="#/components/schemas/IssuanceSimple"
 * 		),
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="titleIssuables",
 * 		description="Attachable & filterable array of the Titles the Persona can Issue.",
 * 		type="array",
 * 		@OA\Items(
 * 			title="Title",
 * 			type="object",
 * 			ref="#/components/schemas/TitleSimple"
 * 		),
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="units",
 * 		description="Attachable & filterable array of the Companies and Households the Persona is in.",
 * 		type="array",
 * 		@OA\Items(
 * 			title="Unit",
 * 			type="object",
 * 			ref="#/components/schemas/UnitSimple"
 * 		),
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="user",
 * 		type="object",
 * 		description="Attachable User for the Persona.",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="waivers",
 * 		description="Attachable & filterable array of Waivers for the Persona.",
 * 		type="array",
 * 		@OA\Items(
 * 			title="Waiver",
 * 			type="object",
 * 			ref="#/components/schemas/WaiverSimple"
 * 		),
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="waiverVerifieds",
 * 		description="Attachable & filterable array of Waivers age verified by the Persona.",
 * 		type="array",
 * 		@OA\Items(
 * 			title="Waiver",
 * 			type="object",
 * 			ref="#/components/schemas/WaiverSimple"
 * 		),
 * 		readOnly=true
 * 	)
 * )
 * @OA\Schema (
 * 	schema="PersonaSimple",
 * 	title="PersonaSimple",
 * 	description="Attachable Persona object with no attachments.",
 * 	@OA\Property(
 * 		property="id",
 * 		description="The entry's ID.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="chapter_id",
 * 		description="The ID of the Chapter the Persona is Waivered at.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="pronoun_id",
 * 		description="The ID of the pronouns associated with this Persona, if known.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="mundane",
 * 		description="What the Persona typically enters into the Mundane field of the sign-in.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="uppercase first letter",
 * 		example="John Smith",
 * 		maxLength=191
 * 	),
 * 	@OA\Property(
 * 		property="name",
 * 		description="The Persona name, without titles or honors, but otherwise in full.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="uppercase first letter",
 * 		example="Color Animal",
 * 		maxLength=191
 * 	),
 * 	@OA\Property(
 * 		property="heraldry",
 * 		description="An internal link to an image of the Persona heraldry.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="filename",
 * 		example="images/personaHeraldries/42.jpg",
 * 		maxLength=191
 * 	),
 * 	@OA\Property(
 * 		property="image",
 * 		description="An internal link to an image of the Persona",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="filename",
 * 		example="images/personas/42.jpg",
 * 		maxLength=191
 * 	),
 * 	@OA\Property(
 * 		property="is_active",
 * 		description="Is (default true) the Persona still active?",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="enum",
 * 		enum={0, 1},
 * 		example=0,
 * 		default=1
 * 	),
 * 	@OA\Property(
 * 		property="reeve_qualified_expires_at",
 * 		description="If they are Reeve Qualified, when it expires.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="date",
 * 		example="2020-12-30"
 * 	),
 * 	@OA\Property(
 * 		property="corpora_qualified_expires_at",
 * 		description="If they are Corpora Qualified, when it expires.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="date",
 * 		example="2020-12-30"
 * 	),
 * 	@OA\Property(
 * 		property="joined_chapter_at",
 * 		description="The date the Persona joined the Chapter, either as a newb or a transfer.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="date",
 * 		example="2020-12-30"
 * 	),
 * 	@OA\Property(
 * 		property="created_by",
 * 		description="The User that created this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true,
 * 		default=1
 * 	),
 * 	@OA\Property(
 * 		property="updated_by",
 * 		description="The last User to update this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_by",
 * 		description="The User that softdeleted this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="created_at",
 * 		description="When the entry was created.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_at",
 * 		description="When the entry was last updated.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_at",
 * 		description="When the entry was softdeleted.  Null if not softdeleted.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	)
 * )
 * @OA\Schema (
 * 	schema="PersonaSuperSimple",
 * 	title="PersonaSuperSimpleSimple",
 * 	description="Attachable Persona object with no attachments or CUD data.",
 * 	@OA\Property(
 * 		property="id",
 * 		description="The entry's ID.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="chapter_id",
 * 		description="The ID of the Chapter the Persona is Waivered at.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="pronoun_id",
 * 		description="The ID of the pronouns associated with this Persona, if known.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="mundane",
 * 		description="What the Persona typically enters into the Mundane field of the sign-in.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="uppercase first letter",
 * 		example="John Smith",
 * 		maxLength=191
 * 	),
 * 	@OA\Property(
 * 		property="name",
 * 		description="The Persona name, without titles or honors, but otherwise in full.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="uppercase first letter",
 * 		example="Color Animal",
 * 		maxLength=191
 * 	),
 * 	@OA\Property(
 * 		property="heraldry",
 * 		description="An internal link to an image of the Persona heraldry.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="filename",
 * 		example="images/personaHeraldries/42.jpg",
 * 		maxLength=191
 * 	),
 * 	@OA\Property(
 * 		property="image",
 * 		description="An internal link to an image of the Persona",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="filename",
 * 		example="images/personas/42.jpg",
 * 		maxLength=191
 * 	),
 * 	@OA\Property(
 * 		property="is_active",
 * 		description="Is (default true) the Persona still active?",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="enum",
 * 		enum={0, 1},
 * 		example=0,
 * 		default=1
 * 	),
 * 	@OA\Property(
 * 		property="reeve_qualified_expires_at",
 * 		description="If they are Reeve Qualified, when it expires.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="date",
 * 		example="2020-12-30"
 * 	),
 * 	@OA\Property(
 * 		property="corpora_qualified_expires_at",
 * 		description="If they are Corpora Qualified, when it expires.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="date",
 * 		example="2020-12-30"
 * 	),
 * 	@OA\Property(
 * 		property="joined_chapter_at",
 * 		description="The date the Persona joined the Chapter, either as a newb or a transfer.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="date",
 * 		example="2020-12-30"
 * 	)
 * )
 * @OA\RequestBody (
 * 	request="Persona",
 * 	description="Persona object that needs to be added or updated.",
 * 	required=true,
 * 	@OA\MediaType(
 * 		mediaType="multipart/form-data",
 * 		@OA\Schema(ref="#/components/schemas/PersonaSimple")
 * 	)
 * )
 * @property int $id Model ID
 * @property int $chapter_id The ID of the Chapter the Persona is Waivered at
 * @property int|null $pronoun_id The ID of the pronouns associated with this Persona, if known
 * @property string|null $mundane What the Persona typically enters into the Mundane field of the sign-in
 * @property string $name The Persona name, without titles or honors, but otherwise in full
 * @property string|null $heraldry An internal link to an image of the Persona heraldry
 * @property-read string|null $image An internal link to an image of the Persona
 * @property bool $is_active Is (default true) the Persona still active?
 * @property \Illuminate\Support\Carbon|null $reeve_qualified_expires_at If they are Reeve Qualified, when it expires
 * @property \Illuminate\Support\Carbon|null $corpora_qualified_expires_at If they are Corpora Qualified, when it expires
 * @property \Illuminate\Support\Carbon|null $joined_chapter_at The date the Persona joined the Chapter, either as a newb or a transfer
 * @property int $created_by
 * @property \Illuminate\Support\Carbon $created_at
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $deleted_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Attendance> $attendances
 * @property-read int|null $attendances_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Issuance> $awards
 * @property-read int|null $awards_count
 * @property-read \App\Models\Chapter $chapter
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Crat> $crats
 * @property-read int|null $crats_count
 * @property-read \App\Models\User $createdBy
 * @property-read \App\Models\User $creator
 * @property-read \App\Models\User|null $deletedBy
 * @property-read \App\Models\User|null $destroyer
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Due> $dues
 * @property-read int|null $dues_count
 * @property-read \App\Models\User|null $editor
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Event> $events
 * @property-read int|null $events_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Issuance> $issuanceGivens
 * @property-read int|null $issuance_givens_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Issuance> $issuanceRevokeds
 * @property-read int|null $issuance_revokeds_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Issuance> $issuanceSigneds
 * @property-read int|null $issuance_signeds_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Member> $members
 * @property-read int|null $members_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Officer> $officers
 * @property-read int|null $officers_count
 * @property-read \App\Models\Pronoun|null $pronoun
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Recommendation> $recommendations
 * @property-read int|null $recommendations_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Reconciliation> $reconciliations
 * @property-read int|null $reconciliations_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Social> $socials
 * @property-read int|null $socials_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Split> $splits
 * @property-read int|null $splits_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Suspension> $suspensionIssueds
 * @property-read int|null $suspension_issueds_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Suspension> $suspensions
 * @property-read int|null $suspensions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Title> $titleIssuables
 * @property-read int|null $title_issuables_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Issuance> $titles
 * @property-read int|null $titles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Unit> $units
 * @property-read int|null $units_count
 * @property-read \App\Models\User|null $updatedBy
 * @property-read \App\Models\User|null $user
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Waiver> $waiverVerifieds
 * @property-read int|null $waiver_verifieds_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Waiver> $waivers
 * @property-read int|null $waivers_count
 * @method static \Database\Factories\PersonaFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Persona newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Persona newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Persona onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Persona query()
 * @method static \Illuminate\Database\Eloquent\Builder|Persona whereChapterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Persona whereCorporaQualifiedExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Persona whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Persona whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Persona whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Persona whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Persona whereHeraldry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Persona whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Persona whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Persona whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Persona whereJoinedChapterAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Persona whereMundane($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Persona whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Persona wherePronounId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Persona whereReeveQualifiedExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Persona whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Persona whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Persona withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Persona withoutTrashed()
 */
	class Persona extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Pronoun
 *
 * @OA\Schema (
 * 	schema="Pronoun",
 * 	required={"subject","object","possessive","possessivepronoun","reflexive"},
 * 	description="Pronouns perfered.<br>The following relationships can be attached, and in the case of plural relations, searched:
 * personas (Persona) (HasMany): Personas using the Pronoun.
 * waivers (Waivers) (HasMany): Waivers using the Pronoun.
 * createdBy (User) (BelongsTo): User that created it.
 * updatedBy (User) (BelongsTo): User that last updated it (if any).
 * deletedBy (User) (BelongsTo): User that deleted it (if any).",
 * 	@OA\Property(
 * 		property="id",
 * 		description="The entry's ID.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="subject",
 * 		description="Pronoun Subject",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string"
 * 	),
 * 	@OA\Property(
 * 		property="object",
 * 		description="Pronoun Object",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 	),
 * 	@OA\Property(
 * 		property="possessive",
 * 		description="Pronoun Possessive",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 	),
 * 	@OA\Property(
 * 		property="Pronoun Possessive Pronoun",
 * 		description="",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 	),
 * 	@OA\Property(
 * 		property="Pronoun Reflexive",
 * 		description="",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 	),
 * 	@OA\Property(
 * 		property="created_by",
 * 		description="The User that created this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true,
 * 		default=1
 * 	),
 * 	@OA\Property(
 * 		property="createdBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_by",
 * 		description="The last User to update this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updatedBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_by",
 * 		description="The User that softdeleted this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deletedBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="created_at",
 * 		description="When the entry was created.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_at",
 * 		description="When the entry was last updated.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_at",
 * 		description="When the entry was softdeleted.  Null if not softdeleted.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	)
 * )
 * @OA\Schema (
 * 	schema="PronounSimple",
 * 	title="PronounSimple",
 * 	description="Attachable Pronoun object with no attachments.",
 * 	@OA\Property(
 * 		property="id",
 * 		description="The entry's ID.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="subject",
 * 		description="Pronoun Subject",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string"
 * 	),
 * 	@OA\Property(
 * 		property="object",
 * 		description="Pronoun Object",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 	),
 * 	@OA\Property(
 * 		property="possessive",
 * 		description="Pronoun Possessive",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 	),
 * 	@OA\Property(
 * 		property="Pronoun Possessive Pronoun",
 * 		description="",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 	),
 * 	@OA\Property(
 * 		property="Pronoun Reflexive",
 * 		description="",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 	),
 * 	@OA\Property(
 * 		property="created_by",
 * 		description="The User that created this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true,
 * 		default=1
 * 	),
 * 	@OA\Property(
 * 		property="updated_by",
 * 		description="The last User to update this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_by",
 * 		description="The User that softdeleted this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="created_at",
 * 		description="When the entry was created.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_at",
 * 		description="When the entry was last updated.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_at",
 * 		description="When the entry was softdeleted.  Null if not softdeleted.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	)
 * )
 * @OA\Schema (
 * 	schema="PronounSuperSimple",
 * 	title="PronounSuperSimpleSimple",
 * 	description="Attachable Pronoun object with no attachments or CUD data.",
 * 	@OA\Property(
 * 		property="id",
 * 		description="The entry's ID.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="subject",
 * 		description="Pronoun Subject",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string"
 * 	),
 * 	@OA\Property(
 * 		property="object",
 * 		description="Pronoun Object",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 	),
 * 	@OA\Property(
 * 		property="possessive",
 * 		description="Pronoun Possessive",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 	),
 * 	@OA\Property(
 * 		property="Pronoun Possessive Pronoun",
 * 		description="",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 	),
 * 	@OA\Property(
 * 		property="Pronoun Reflexive",
 * 		description="",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 	)
 * )
 * @OA\RequestBody (
 * 	request="Pronoun",
 * 	description="Pronoun object that needs to be added or updated.",
 * 	required=true,
 * 	@OA\MediaType(
 * 		mediaType="multipart/form-data",
 * 		@OA\Schema(ref="#/components/schemas/PronounSimple")
 * 	)
 * )
 * @property int $id Model ID
 * @property string $subject Pronoun Subject
 * @property string $object Pronoun Object
 * @property string $possessive Pronoun Possessive
 * @property string $possessivepronoun Pronoun Possessive Pronoun
 * @property string $reflexive Pronoun Reflexive
 * @property int $created_by
 * @property \Illuminate\Support\Carbon $created_at
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $deleted_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\User $createdBy
 * @property-read \App\Models\User $creator
 * @property-read \App\Models\User|null $deletedBy
 * @property-read \App\Models\User|null $destroyer
 * @property-read \App\Models\User|null $editor
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Persona> $personas
 * @property-read int|null $personas_count
 * @property-read \App\Models\User|null $updatedBy
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Waiver> $waivers
 * @property-read int|null $waivers_count
 * @method static \Database\Factories\PronounFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Pronoun newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pronoun newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pronoun onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Pronoun query()
 * @method static \Illuminate\Database\Eloquent\Builder|Pronoun whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pronoun whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pronoun whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pronoun whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pronoun whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pronoun whereObject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pronoun wherePossessive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pronoun wherePossessivepronoun($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pronoun whereReflexive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pronoun whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pronoun whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pronoun whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pronoun withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Pronoun withoutTrashed()
 */
	class Pronoun extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Realm
 *
 * @OA\Schema (
 *   schema="Realm",
 *   required={"name","abbreviation","color","is_active"},
 * 	description="Collective of Chapters, often Kingdoms, but including Principalities and Grand Duchies.<br>The following relationships can be attached, and in the case of plural relations, searched:
 * accounts (Account) (MorphMany): Accounts for the Realm.
 * awards (Awards) (MorphMany): Awards this Realm can issue.
 * chapters (Chapter) (HasMany): Chapters of the Realm.
 * chaptertypes (Chaptertype) (HasMany): Chaptertypes the Realm uses.
 * events (Event) (MorphMany): Events run by the Realm.
 * issuances (Issuance) (MorphMany): Issuances made by the Realm.
 * offices (Office) (MorphMany): Offices of the Realm.
 * reign (Reign) (MorphOne): The current Reign for the Realm.
 * reigns (Reign) (MorphMany): Reigns of the Realm.
 * socials (Social) (MorphMany): Socials for the Realm.
 * sponsors (Event) (MorphMany): Persona or Unit Events this Realm has sponsored.
 * suspensions (Suspension) (MorphMany): Suspensions levied by the Realm.
 * titles (Title) (MorphMany): Titles the Realm Issues.
 * createdBy (User) (BelongsTo): User that created it.
 * updatedBy (User) (BelongsTo): User that last updated it (if any).
 * deletedBy (User) (BelongsTo): User that deleted it (if any).",
 * 	@OA\Property(
 * 		property="id",
 * 		description="The entry's ID.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="parent_id",
 * 		description="If sponsored by another Realm, that Realm ID.",
 * 	  readOnly=false,
 * 	  nullable=true,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 *   @OA\Property(
 * 	  property="name",
 * 	  description="The label for the Realm.",
 * 	  readOnly=false,
 * 	  nullable=false,
 * 	  type="string",
 * 		format="uppercase first letter",
 * 		example="The Republic of Futurama",
 * 		maxLength=100
 *   ),
 *   @OA\Property(
 * 	  property="abbreviation",
 * 	  description="A simple, unique, usually two letter abbreviation commonly used for the Realm",
 * 	  readOnly=false,
 * 	  nullable=false,
 * 	  type="string",
 * 	  format="uppercase",
 * 	  example="FR",
 * 	  maxLength=4
 *   ),
 *   @OA\Property(
 * 	  property="color",
 * 	  description="The hexidecimal code (default FACADE) for the color used for the Realm on various UIs.",
 * 	  readOnly=false,
 * 	  nullable=false,
 * 	  type="string",
 * 	  format="hexidecimal",
 * 	  example="000000",
 *  		default="FACADE"
 *   ),
 *   @OA\Property(
 * 	  property="heraldry",
 * 	  description="An internal link to an image of the Realm heraldry.",
 * 	  readOnly=false,
 * 	  nullable=true,
 * 		type="string",
 * 		format="filename",
 * 		example="images/realms/42.jpg",
 * 		maxLength=191
 *   ),
 *   @OA\Property(
 * 	  property="is_active",
 * 	  description="Is (default true) the Realm active?",
 * 	  readOnly=false,
 * 	  nullable=false,
 * 		type="integer",
 * 		format="enum",
 * 		enum={0, 1},
 * 		example=0,
 * 		default=1
 *   ),
 * 	@OA\Property(
 * 		property="credit_minimum",
 * 		description="Realm Credit Minimum setting, if any.",
 * 	  readOnly=false,
 * 	  nullable=true,
 * 		type="integer",
 * 		format="int32",
 * 		example=6
 * 	),
 * 	@OA\Property(
 * 		property="credit_maximum",
 * 		description="Realm Credit Maximum setting, if any.",
 * 	  readOnly=false,
 * 	  nullable=true,
 * 		type="integer",
 * 		format="int32",
 * 		example=32
 * 	),
 * 	@OA\Property(
 * 		property="daily_minimum",
 * 		description="Realm Daily Minimum setting, if any",
 * 	  readOnly=false,
 * 	  nullable=true,
 * 		type="integer",
 * 		format="int32",
 * 		example=6
 * 	),
 * 	@OA\Property(
 * 		property="weekly_minimum",
 * 		description="Realm Weekly Minimum setting, if any",
 * 	  readOnly=false,
 * 	  nullable=true,
 * 		type="integer",
 * 		format="int32",
 * 		example=9
 * 	),
 *   @OA\Property(
 * 	  property="average_period_type",
 * 	  description="Realm Average Period Type setting, if any.",
 * 	  readOnly=false,
 * 	  nullable=true,
 * 		type="string",
 * 		format="enum",
 * 		enum={"Week","Month"},
 * 		example="Week"
 *   ),
 * 	@OA\Property(
 * 		property="average_period",
 * 		description="Realm Average Period setting, if any.",
 * 	  readOnly=false,
 * 	  nullable=true,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="dues_amount",
 * 		description="Dues cost per interval for the Realm, if any.",
 * 	  readOnly=false,
 * 	  nullable=true,
 * 		type="integer",
 * 		format="int32",
 * 		example=12
 * 	),
 *   @OA\Property(
 * 	  property="dues_intervals_type",
 * 	  description="Dues intervals type for the Realm, if any.",
 * 	  readOnly=false,
 * 	  nullable=true,
 * 		type="string",
 * 		format="enum",
 * 		enum={"Week","Month"},
 * 		example="Week"
 *   ),
 * 	@OA\Property(
 * 		property="dues_intervals",
 * 		description="Dues intervals count for the Realm, if any.",
 * 	  readOnly=false,
 * 	  nullable=true,
 * 		type="integer",
 * 		format="int32",
 * 		example=6
 * 	),
 * 	@OA\Property(
 * 		property="dues_take",
 * 		description="Realm take of Dues paid to Chapters, if any.",
 * 	  readOnly=false,
 * 	  nullable=true,
 * 		type="integer",
 * 		format="int32",
 * 		example=5
 * 	),
 * 	@OA\Property(
 * 		property="created_by",
 * 		description="The User that created this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true,
 * 		default=1
 * 	),
 * 	@OA\Property(
 * 		property="createdBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_by",
 * 		description="The last User to update this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updatedBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_by",
 * 		description="The User that softdeleted this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deletedBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="created_at",
 * 		description="When the entry was created.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_at",
 * 		description="When the entry was last updated.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_at",
 * 		description="When the entry was softdeleted.  Null if not softdeleted.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="accounts",
 * 		description="Attachable & filterable array of Accounts for the Realm.",
 * 		type="array",
 * 		@OA\Items(
 * 			title="Account",
 * 			type="object",
 * 			ref="#/components/schemas/AccountSimple"
 * 		),
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="awards",
 * 		description="Attachable & filterable array of Awards this Realm can issue.",
 * 		type="array",
 * 		@OA\Items(
 * 			title="Award",
 * 			type="object",
 * 			ref="#/components/schemas/AwardSimple"
 * 		),
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="chapters",
 * 		description="Attachable & filterable array of Chapters of the Realm.",
 * 		type="array",
 * 		@OA\Items(
 * 			title="Chapter",
 * 			type="object",
 * 			ref="#/components/schemas/ChapterSimple"
 * 		),
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="chaptertypes",
 * 		description="Attachable & filterable array of Chaptertypes the Realm uses.",
 * 		type="array",
 * 		@OA\Items(
 * 			title="Chaptertype",
 * 			type="object",
 * 			ref="#/components/schemas/ChaptertypeSimple"
 * 		),
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="events",
 * 		description="Attachable & filterable array of Events sponsored by the Realm.",
 * 		type="array",
 * 		@OA\Items(
 * 			title="Event",
 * 			type="object",
 * 			ref="#/components/schemas/EventSimple"
 * 		),
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="issuances",
 * 		description="Attachable & filterable array of Issuances made by the Realm.",
 * 		type="array",
 * 		@OA\Items(
 * 			title="Issuance",
 * 			type="object",
 * 			ref="#/components/schemas/IssuanceSimple"
 * 		),
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="offices",
 * 		description="Attachable & filterable array of Offices of the Realm.",
 * 		type="array",
 * 		@OA\Items(
 * 			title="Office",
 * 			type="object",
 * 			ref="#/components/schemas/OfficeSimple"
 * 		),
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="reign",
 * 		description="Attachable & filterable array of the current Reign for the Realm.",
 * 		type="array",
 * 		@OA\Items(
 * 			title="Reign",
 * 			type="object",
 * 			ref="#/components/schemas/ReignSimple"
 * 		),
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="reigns",
 * 		description="Attachable & filterable array of the Reigns of the Realm.",
 * 		type="array",
 * 		@OA\Items(
 * 			title="Reign",
 * 			type="object",
 * 			ref="#/components/schemas/ReignSimple"
 * 		),
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="socials",
 * 		description="Attachable & filterable array of the Socials of the Realm.",
 * 		type="array",
 * 		@OA\Items(
 * 			title="Social",
 * 			type="object",
 * 			ref="#/components/schemas/SocialSimple"
 * 		),
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="sponsors",
 * 		description="Attachable & filterable array of Persona or Unit Events this Realm has sponsored.",
 * 		type="array",
 * 		@OA\Items(
 * 			title="Event",
 * 			type="object",
 * 			ref="#/components/schemas/EventSimple"
 * 		),
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="suspensions",
 * 		description="Attachable & filterable array of Suspensions levied by the Realm.",
 * 		type="array",
 * 		@OA\Items(
 * 			title="Suspension",
 * 			type="object",
 * 			ref="#/components/schemas/SuspensionSimple"
 * 		),
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="titles",
 * 		description="Attachable & filterable array of the Titles the Realm Issues.",
 * 		type="array",
 * 		@OA\Items(
 * 			title="Title",
 * 			type="object",
 * 			ref="#/components/schemas/TitleSimple"
 * 		),
 * 		readOnly=true
 * 	)
 * )
 * @OA\Schema (
 * 	schema="RealmSimple",
 * 	title="RealmSimple",
 * 	description="Attachable Realm object with no attachments.",
 * 	@OA\Property(
 * 		property="id",
 * 		description="The entry's ID.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="parent_id",
 * 		description="If sponsored by another Realm, that Realm ID.",
 * 	  readOnly=false,
 * 	  nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 *   @OA\Property(
 * 	  property="name",
 * 	  description="The label for the Realm.",
 * 	  readOnly=false,
 * 	  nullable=false,
 * 	  type="string",
 * 		format="uppercase first letter",
 * 		example="The Republic of Futurama",
 * 		maxLength=100
 *   ),
 *   @OA\Property(
 * 	  property="abbreviation",
 * 	  description="A simple, unique, usually two letter abbreviation commonly used for the Realm",
 * 	  readOnly=false,
 * 	  nullable=false,
 * 	  type="string",
 * 	  format="uppercase",
 * 	  example="FR",
 * 	  maxLength=4
 *   ),
 *   @OA\Property(
 * 	  property="color",
 * 	  description="The hexidecimal code (default FACADE) for the color used for the Realm on various UIs.",
 * 	  readOnly=false,
 * 	  nullable=false,
 * 	  type="string",
 * 	  format="hexidecimal",
 * 	  example="000000",
 *  		default="FACADE"
 *   ),
 *   @OA\Property(
 * 	  property="heraldry",
 * 	  description="An internal link to an image of the Realm heraldry.",
 * 	  readOnly=false,
 * 	  nullable=true,
 * 		type="string",
 * 		format="filename",
 * 		example="images/realms/42.jpg",
 * 		maxLength=191
 *   ),
 *   @OA\Property(
 * 	  property="is_active",
 * 	  description="Is (default true) the Realm active?",
 * 	  readOnly=false,
 * 	  nullable=false,
 * 		type="integer",
 * 		format="enum",
 * 		enum={0, 1},
 * 		example=0,
 * 		default=1
 *   ),
 * 	@OA\Property(
 * 		property="credit_minimum",
 * 		description="Realm Credit Minimum setting, if any.",
 * 	  readOnly=false,
 * 	  nullable=true,
 * 		type="integer",
 * 		format="int32",
 * 		example=6
 * 	),
 * 	@OA\Property(
 * 		property="credit_maximum",
 * 		description="Realm Credit Maximum setting, if any.",
 * 	  readOnly=false,
 * 	  nullable=true,
 * 		type="integer",
 * 		format="int32",
 * 		example=32
 * 	),
 * 	@OA\Property(
 * 		property="daily_minimum",
 * 		description="Realm Daily Minimum setting, if any",
 * 	  readOnly=false,
 * 	  nullable=true,
 * 		type="integer",
 * 		format="int32",
 * 		example=6
 * 	),
 * 	@OA\Property(
 * 		property="weekly_minimum",
 * 		description="Realm Weekly Minimum setting, if any",
 * 	  readOnly=false,
 * 	  nullable=true,
 * 		type="integer",
 * 		format="int32",
 * 		example=9
 * 	),
 *   @OA\Property(
 * 	  property="average_period_type",
 * 	  description="Realm Average Period Type setting, if any.",
 * 	  readOnly=false,
 * 	  nullable=true,
 * 		type="string",
 * 		format="enum",
 * 		enum={"Week","Month"},
 * 		example="Week"
 *   ),
 * 	@OA\Property(
 * 		property="average_period",
 * 		description="Realm Average Period setting, if any.",
 * 	  readOnly=false,
 * 	  nullable=true,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="dues_amount",
 * 		description="Dues cost per interval for the Realm, if any.",
 * 	  readOnly=false,
 * 	  nullable=true,
 * 		type="integer",
 * 		format="int32",
 * 		example=12
 * 	),
 *   @OA\Property(
 * 	  property="dues_intervals_type",
 * 	  description="Dues intervals type for the Realm, if any.",
 * 	  readOnly=false,
 * 	  nullable=true,
 * 		type="string",
 * 		format="enum",
 * 		enum={"Week","Month"},
 * 		example="Week"
 *   ),
 * 	@OA\Property(
 * 		property="dues_intervals",
 * 		description="Dues intervals count for the Realm, if any.",
 * 	  readOnly=false,
 * 	  nullable=true,
 * 		type="integer",
 * 		format="int32",
 * 		example=6
 * 	),
 * 	@OA\Property(
 * 		property="dues_take",
 * 		description="Realm take of Dues paid to Chapters, if any.",
 * 	  readOnly=false,
 * 	  nullable=true,
 * 		type="integer",
 * 		format="int32",
 * 		example=5
 * 	),
 * 	@OA\Property(
 * 		property="created_by",
 * 		description="The User that created this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true,
 * 		default=1
 * 	),
 * 	@OA\Property(
 * 		property="updated_by",
 * 		description="The last User to update this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_by",
 * 		description="The User that softdeleted this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="created_at",
 * 		description="When the entry was created.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_at",
 * 		description="When the entry was last updated.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_at",
 * 		description="When the entry was softdeleted.  Null if not softdeleted.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	)
 * )
 * @OA\Schema (
 * 	schema="RealmSuperSimple",
 * 	title="RealmSuperSimpleSimple",
 * 	description="Attachable Realm object with no attachments or CUD data.",
 * 	@OA\Property(
 * 		property="id",
 * 		description="The entry's ID.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="parent_id",
 * 		description="If sponsored by another Realm, that Realm ID.",
 * 	  readOnly=false,
 * 	  nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 *   @OA\Property(
 * 	  property="name",
 * 	  description="The label for the Realm.",
 * 	  readOnly=false,
 * 	  nullable=false,
 * 	  type="string",
 * 		format="uppercase first letter",
 * 		example="The Republic of Futurama",
 * 		maxLength=100
 *   ),
 *   @OA\Property(
 * 	  property="abbreviation",
 * 	  description="A simple, unique, usually two letter abbreviation commonly used for the Realm",
 * 	  readOnly=false,
 * 	  nullable=false,
 * 	  type="string",
 * 	  format="uppercase",
 * 	  example="FR",
 * 	  maxLength=4
 *   ),
 *   @OA\Property(
 * 	  property="color",
 * 	  description="The hexidecimal code (default FACADE) for the color used for the Realm on various UIs.",
 * 	  readOnly=false,
 * 	  nullable=false,
 * 	  type="string",
 * 	  format="hexidecimal",
 * 	  example="000000",
 *  		default="FACADE"
 *   ),
 *   @OA\Property(
 * 	  property="heraldry",
 * 	  description="An internal link to an image of the Realm heraldry.",
 * 	  readOnly=false,
 * 	  nullable=true,
 * 		type="string",
 * 		format="filename",
 * 		example="images/realms/42.jpg",
 * 		maxLength=191
 *   ),
 *   @OA\Property(
 * 	  property="is_active",
 * 	  description="Is (default true) the Realm active?",
 * 	  readOnly=false,
 * 	  nullable=false,
 * 		type="integer",
 * 		format="enum",
 * 		enum={0, 1},
 * 		example=0,
 * 		default=1
 *   ),
 * 	@OA\Property(
 * 		property="credit_minimum",
 * 		description="Realm Credit Minimum setting, if any.",
 * 	  readOnly=false,
 * 	  nullable=true,
 * 		type="integer",
 * 		format="int32",
 * 		example=6
 * 	),
 * 	@OA\Property(
 * 		property="credit_maximum",
 * 		description="Realm Credit Maximum setting, if any.",
 * 	  readOnly=false,
 * 	  nullable=true,
 * 		type="integer",
 * 		format="int32",
 * 		example=32
 * 	),
 * 	@OA\Property(
 * 		property="daily_minimum",
 * 		description="Realm Daily Minimum setting, if any",
 * 	  readOnly=false,
 * 	  nullable=true,
 * 		type="integer",
 * 		format="int32",
 * 		example=6
 * 	),
 * 	@OA\Property(
 * 		property="weekly_minimum",
 * 		description="Realm Weekly Minimum setting, if any",
 * 	  readOnly=false,
 * 	  nullable=true,
 * 		type="integer",
 * 		format="int32",
 * 		example=9
 * 	),
 *   @OA\Property(
 * 	  property="average_period_type",
 * 	  description="Realm Average Period Type setting, if any.",
 * 	  readOnly=false,
 * 	  nullable=true,
 * 		type="string",
 * 		format="enum",
 * 		enum={"Week","Month"},
 * 		example="Week"
 *   ),
 * 	@OA\Property(
 * 		property="average_period",
 * 		description="Realm Average Period setting, if any.",
 * 	  readOnly=false,
 * 	  nullable=true,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="dues_amount",
 * 		description="Dues cost per interval for the Realm, if any.",
 * 	  readOnly=false,
 * 	  nullable=true,
 * 		type="integer",
 * 		format="int32",
 * 		example=12
 * 	),
 *   @OA\Property(
 * 	  property="dues_intervals_type",
 * 	  description="Dues intervals type for the Realm, if any.",
 * 	  readOnly=false,
 * 	  nullable=true,
 * 		type="string",
 * 		format="enum",
 * 		enum={"Week","Month"},
 * 		example="Week"
 *   ),
 * 	@OA\Property(
 * 		property="dues_intervals",
 * 		description="Dues intervals count for the Realm, if any.",
 * 	  readOnly=false,
 * 	  nullable=true,
 * 		type="integer",
 * 		format="int32",
 * 		example=6
 * 	),
 * 	@OA\Property(
 * 		property="dues_take",
 * 		description="Realm take of Dues paid to Chapters, if any.",
 * 	  readOnly=false,
 * 	  nullable=true,
 * 		type="integer",
 * 		format="int32",
 * 		example=5
 * 	)
 * )
 * @OA\RequestBody (
 * 	request="Realm",
 * 	description="Realm object that needs to be added or updated.",
 * 	required=true,
 * 	@OA\MediaType(
 * 		mediaType="multipart/form-data",
 * 		@OA\Schema(ref="#/components/schemas/RealmSimple")
 * 	)
 * )
 * @property int $id Model ID
 * @property int|null $parent_id If sponsored by another Realm, that Realm ID
 * @property string $name The label for the Realm
 * @property string $abbreviation A simple, unique, usually two letter abbreviation commonly used for the Realm
 * @property string $color The hexidecimal code (default FACADE) for the color used for the Realm on various UIs
 * @property string|null $heraldry An internal link to the Realm heraldry image
 * @property bool $is_active Is (default true) the Realm active?
 * @property int|null $credit_minimum Realm Credit Minimum setting, if any
 * @property int|null $credit_maximum Realm Credit Maximum setting, if any
 * @property int|null $daily_minimum Realm Daily Minimum setting, if any
 * @property int|null $weekly_minimum Realm Weekly Minimum setting, if any
 * @property string|null $average_period_type Realm Average Period Type setting, if any
 * @property int|null $average_period Realm Average Period setting, if any
 * @property int|null $dues_amount Dues cost per interval for the Realm, if any
 * @property string|null $dues_intervals_type Dues intervals type for the Realm, if any
 * @property int|null $dues_intervals Dues intervals count for the Realm, if any
 * @property int|null $dues_take Realm take of Dues paid to Chapters, if any
 * @property int $created_by
 * @property \Illuminate\Support\Carbon $created_at
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $deleted_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Account> $accounts
 * @property-read int|null $accounts_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Award> $awards
 * @property-read int|null $awards_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Chapter> $chapters
 * @property-read int|null $chapters_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Chaptertype> $chaptertypes
 * @property-read int|null $chaptertypes_count
 * @property-read \App\Models\User $createdBy
 * @property-read \App\Models\User $creator
 * @property-read \App\Models\User|null $deletedBy
 * @property-read \App\Models\User|null $destroyer
 * @property-read \App\Models\User|null $editor
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Event> $events
 * @property-read int|null $events_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Issuance> $issuances
 * @property-read int|null $issuances_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Office> $offices
 * @property-read int|null $offices_count
 * @property-read \App\Models\Reign|null $reign
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Reign> $reigns
 * @property-read int|null $reigns_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Social> $socials
 * @property-read int|null $socials_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Event> $sponsors
 * @property-read int|null $sponsors_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Social> $suspensions
 * @property-read int|null $suspensions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Title> $titles
 * @property-read int|null $titles_count
 * @property-read \App\Models\User|null $updatedBy
 * @method static \Database\Factories\RealmFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Realm newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Realm newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Realm onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Realm query()
 * @method static \Illuminate\Database\Eloquent\Builder|Realm whereAbbreviation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Realm whereAveragePeriod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Realm whereAveragePeriodType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Realm whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Realm whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Realm whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Realm whereCreditMaximum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Realm whereCreditMinimum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Realm whereDailyMinimum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Realm whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Realm whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Realm whereDuesAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Realm whereDuesIntervals($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Realm whereDuesIntervalsType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Realm whereDuesTake($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Realm whereHeraldry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Realm whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Realm whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Realm whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Realm whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Realm whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Realm whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Realm whereWeeklyMinimum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Realm withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Realm withoutTrashed()
 */
	class Realm extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Recommendation
 *
 * @OA\Schema (
 * 	schema="Recommendation",
 * 	required={"persona_id","recommendable_type","is_anonymous","reason"},
 * 	description="Recommendations for Personas to be Issued an Award or Title.<br>The following relationships can be attached, and in the case of plural relations, searched:
 * persona (Persona) (BelongsTo): Persona the Recommendation is for.
 * recommendable (Award or Title) (MorphTo): The Type of Issuances being Recommended; Award or Title.
 * createdBy (User) (BelongsTo): User that created it.
 * updatedBy (User) (BelongsTo): User that last updated it (if any).
 * deletedBy (User) (BelongsTo): User that deleted it (if any).",
 * 	@OA\Property(
 * 		property="id",
 * 		description="The entry's ID.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="persona_id",
 * 		description="The ID of the Persona the Recommendation is for.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="recommendable_type",
 * 		description="The type of Issuances being Recommended; Award or Title.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="enum",
 * 		enum={"Award","Title"},
 * 		example="Award"
 * 	),
 * 	@OA\Property(
 * 		property="recommendable_id",
 * 		description="The ID of the Title or Award being Recommended.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="rank",
 * 		description="If a ranked or ladder award, Recommended level.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="integer",
 * 		format="int32",
 * 		example=3
 * 	),
 * 	@OA\Property(
 * 		property="is_anonymous",
 * 		description="Does (default false) the Recommendation creator wish to be anonymous?",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="enum",
 * 		enum={0, 1},
 * 		example=0,
 * 		default=1
 * 	),
 * 	@OA\Property(
 * 		property="reason",
 * 		description="What the Recommendation is for.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="paragraph",
 * 		example="Being teh awesome!",
 * 		maxLength=400
 * 	),
 * 	@OA\Property(
 * 		property="created_by",
 * 		description="The User that created this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true,
 * 		default=1
 * 	),
 * 	@OA\Property(
 * 		property="createdBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_by",
 * 		description="The last User to update this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updatedBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_by",
 * 		description="The User that softdeleted this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deletedBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="created_at",
 * 		description="When the entry was created.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_at",
 * 		description="When the entry was last updated.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_at",
 * 		description="When the entry was softdeleted.  Null if not softdeleted.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="persona",
 * 		type="object",
 * 		description="Attachable Persona the Recommendation is for.",
 * 		ref="#/components/schemas/PersonaSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="recommendable",
 * 		type="object",
 * 		description="Attachable object being Recommended.",
 * 		oneOf={
 * 			@OA\Schema(ref="#/components/schemas/AwardSimple"),
 * 			@OA\Schema(ref="#/components/schemas/TitleSimple")
 * 		},
 * 		readOnly=true
 * 	)
 * )
 * @OA\Schema (
 * 	schema="RecommendationSimple",
 * 	title="RecommendationSimple",
 * 	description="Attachable Recommendation object with no attachments.",
 * 	@OA\Property(
 * 		property="id",
 * 		description="The entry's ID.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="persona_id",
 * 		description="The ID of the Persona the Recommendation is for.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="recommendable_type",
 * 		description="The type of Issuances being Recommended; Award or Title.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="enum",
 * 		enum={"Award","Title"},
 * 		example="Award"
 * 	),
 * 	@OA\Property(
 * 		property="recommendable_id",
 * 		description="The ID of the Title or Award being Recommended.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="rank",
 * 		description="If a ranked or ladder award, Recommended level.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="integer",
 * 		format="int32",
 * 		example=3
 * 	),
 * 	@OA\Property(
 * 		property="is_anonymous",
 * 		description="Does (default false) the Recommendation creator wish to be anonymous?",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="enum",
 * 		enum={0, 1},
 * 		example=0,
 * 		default=1
 * 	),
 * 	@OA\Property(
 * 		property="reason",
 * 		description="What the Recommendation is for.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="paragraph",
 * 		example="Being teh awesome!",
 * 		maxLength=400
 * 	),
 * 	@OA\Property(
 * 		property="created_by",
 * 		description="The User that created this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true,
 * 		default=1
 * 	),
 * 	@OA\Property(
 * 		property="updated_by",
 * 		description="The last User to update this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_by",
 * 		description="The User that softdeleted this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="created_at",
 * 		description="When the entry was created.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_at",
 * 		description="When the entry was last updated.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_at",
 * 		description="When the entry was softdeleted.  Null if not softdeleted.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	)
 * )
 * @OA\Schema (
 * 	schema="RecommendationSuperSimple",
 * 	title="RecommendationSuperSimpleSimple",
 * 	description="Attachable Recommendation object with no attachments or CUD data.",
 * 	@OA\Property(
 * 		property="id",
 * 		description="The entry's ID.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="persona_id",
 * 		description="The ID of the Persona the Recommendation is for.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="recommendable_type",
 * 		description="The type of Issuances being Recommended; Award or Title.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="enum",
 * 		enum={"Award","Title"},
 * 		example="Award"
 * 	),
 * 	@OA\Property(
 * 		property="recommendable_id",
 * 		description="The ID of the Title or Award being Recommended.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="rank",
 * 		description="If a ranked or ladder award, Recommended level.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="integer",
 * 		format="int32",
 * 		example=3
 * 	),
 * 	@OA\Property(
 * 		property="is_anonymous",
 * 		description="Does (default false) the Recommendation creator wish to be anonymous?",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="enum",
 * 		enum={0, 1},
 * 		example=0,
 * 		default=1
 * 	),
 * 	@OA\Property(
 * 		property="reason",
 * 		description="What the Recommendation is for.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="paragraph",
 * 		example="Being teh awesome!",
 * 		maxLength=400
 * 	)
 * )
 * @OA\RequestBody (
 * 	request="Recommendation",
 * 	description="Recommendation object that needs to be added or updated.",
 * 	required=true,
 * 	@OA\MediaType(
 * 		mediaType="multipart/form-data",
 * 		@OA\Schema(ref="#/components/schemas/RecommendationSimple")
 * 	)
 * )
 * @property int $id Model ID
 * @property int $persona_id The ID of the Persona the Recommendation is for
 * @property string $recommendable_type The type of Issuances being Recommended; Award or Title
 * @property int $recommendable_id The ID of the Title or Award being Recommended
 * @property int|null $rank If a ranked or ladder award, Recommended level
 * @property bool $is_anonymous Does (default false) the Recommendation creator wish to be anonymous?
 * @property string $reason What the Recommendation is for
 * @property int $created_by
 * @property \Illuminate\Support\Carbon $created_at
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $deleted_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\User $createdBy
 * @property-read \App\Models\User $creator
 * @property-read \App\Models\User|null $deletedBy
 * @property-read \App\Models\User|null $destroyer
 * @property-read \App\Models\User|null $editor
 * @property-read \App\Models\Persona $persona
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $recommendable
 * @property-read \App\Models\User|null $updatedBy
 * @method static \Database\Factories\RecommendationFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Recommendation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Recommendation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Recommendation onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Recommendation query()
 * @method static \Illuminate\Database\Eloquent\Builder|Recommendation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Recommendation whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Recommendation whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Recommendation whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Recommendation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Recommendation whereIsAnonymous($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Recommendation wherePersonaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Recommendation whereRank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Recommendation whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Recommendation whereRecommendableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Recommendation whereRecommendableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Recommendation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Recommendation whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Recommendation withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Recommendation withoutTrashed()
 */
	class Recommendation extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Reconciliation
 *
 * @OA\Schema (
 * 	schema="Reconciliation",
 * 	required={"archetype_id","persona_id","credits"},
 * 	description="Reconciliations allow us to make sum adjustments to a Persona's credits.<br>The following relationships can be attached, and in the case of plural relations, searched:
 * archetype (Archetype) (BelongsTo): Archetype credits being Reconciled.
 * persona (Persona) (BelongsTo): Persona credits being Reconciled.
 * createdBy (User) (BelongsTo): User that created it.
 * updatedBy (User) (BelongsTo): User that last updated it (if any).
 * deletedBy (User) (BelongsTo): User that deleted it (if any).",
 * 	@OA\Property(
 * 		property="id",
 * 		description="The entry's ID.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="archetype_id",
 * 		description="The ID of the Archetype the Reconcilliation credits are for.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=16
 * 	),
 * 	@OA\Property(
 * 		property="persona_id",
 * 		description="The ID of the Persona getting Reconciled.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="credits",
 * 		description="The number of credits to be given or removed (with negative value) from the Persona for the Archetype.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="number",
 * 		format="float",
 * 		example=400
 * 	),
 * 	@OA\Property(
 * 		property="notes",
 * 		description="Why the Reconciliation was required, and how they might be removed.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="paragraph",
 * 		example="Credits earned sometime in the late 90s across several parks."
 * 	),
 * 	@OA\Property(
 * 		property="created_by",
 * 		description="The User that created this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true,
 * 		default=1
 * 	),
 * 	@OA\Property(
 * 		property="createdBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_by",
 * 		description="The last User to update this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updatedBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_by",
 * 		description="The User that softdeleted this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deletedBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="created_at",
 * 		description="When the entry was created.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_at",
 * 		description="When the entry was last updated.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_at",
 * 		description="When the entry was softdeleted.  Null if not softdeleted.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="archetype",
 * 		type="object",
 * 		description="Attachable Archetype credits being Reconciled.",
 * 		ref="#/components/schemas/ArchetypeSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="persona",
 * 		type="object",
 * 		description="Attachable Persona credits being Reconciled.",
 * 		ref="#/components/schemas/PersonaSimple",
 * 		readOnly=true
 * 	)
 * )
 * @OA\Schema (
 * 	schema="ReconciliationSimple",
 * 	title="ReconciliationSimple",
 * 	description="Attachable Reconciliation object with no attachments.",
 * 	@OA\Property(
 * 		property="id",
 * 		description="The entry's ID.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="archetype_id",
 * 		description="The ID of the Archetype the Reconcilliation credits are for.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=16
 * 	),
 * 	@OA\Property(
 * 		property="persona_id",
 * 		description="The ID of the Persona getting Reconciled.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="credits",
 * 		description="The number of credits to be given or removed (with negative value) from the Persona for the Archetype.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="number",
 * 		format="float",
 * 		example=400
 * 	),
 * 	@OA\Property(
 * 		property="notes",
 * 		description="Why the Reconciliation was required, and how they might be removed.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="paragraph",
 * 		example="Credits earned sometime in the late 90s across several parks."
 * 	),
 * 	@OA\Property(
 * 		property="created_by",
 * 		description="The User that created this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true,
 * 		default=1
 * 	),
 * 	@OA\Property(
 * 		property="updated_by",
 * 		description="The last User to update this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_by",
 * 		description="The User that softdeleted this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="created_at",
 * 		description="When the entry was created.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_at",
 * 		description="When the entry was last updated.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_at",
 * 		description="When the entry was softdeleted.  Null if not softdeleted.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	)
 * )
 * @OA\Schema (
 * 	schema="ReconciliationSuperSimple",
 * 	title="ReconciliationSuperSimpleSimple",
 * 	description="Attachable Reconciliation object with no attachments or CUD data.",
 * 	@OA\Property(
 * 		property="id",
 * 		description="The entry's ID.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="archetype_id",
 * 		description="The ID of the Archetype the Reconcilliation credits are for.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=16
 * 	),
 * 	@OA\Property(
 * 		property="persona_id",
 * 		description="The ID of the Persona getting Reconciled.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="credits",
 * 		description="The number of credits to be given or removed (with negative value) from the Persona for the Archetype.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="number",
 * 		format="float",
 * 		example=400
 * 	),
 * 	@OA\Property(
 * 		property="notes",
 * 		description="Why the Reconciliation was required, and how they might be removed.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="paragraph",
 * 		example="Credits earned sometime in the late 90s across several parks."
 * 	)
 * )
 * @OA\RequestBody (
 * 	request="Reconciliation",
 * 	description="Reconciliation object that needs to be added or updated.",
 * 	required=true,
 * 	@OA\MediaType(
 * 		mediaType="multipart/form-data",
 * 		@OA\Schema(ref="#/components/schemas/ReconciliationSimple")
 * 	)
 * )
 * @property int $id Model ID
 * @property int $archetype_id The ID of the Archetype the Reconcilliation credits are for
 * @property int $persona_id The ID of the Persona getting Reconciled
 * @property float $credits The number of credits to be given or removed (with negative value) from the Persona for the Archetype
 * @property string|null $notes Why the Reconciliation was required, and how they might be removed
 * @property int $created_by
 * @property \Illuminate\Support\Carbon $created_at
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $deleted_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Archetype $archetype
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\User $createdBy
 * @property-read \App\Models\User $creator
 * @property-read \App\Models\User|null $deletedBy
 * @property-read \App\Models\User|null $destroyer
 * @property-read \App\Models\User|null $editor
 * @property-read \App\Models\Persona $persona
 * @property-read \App\Models\User|null $updatedBy
 * @method static \Database\Factories\ReconciliationFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Reconciliation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Reconciliation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Reconciliation onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Reconciliation query()
 * @method static \Illuminate\Database\Eloquent\Builder|Reconciliation whereArchetypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reconciliation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reconciliation whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reconciliation whereCredits($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reconciliation whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reconciliation whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reconciliation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reconciliation whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reconciliation wherePersonaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reconciliation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reconciliation whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reconciliation withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Reconciliation withoutTrashed()
 */
	class Reconciliation extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Reign
 *
 * @OA\Schema (
 * 	schema="Reign",
 * 	required={"reignable_type","starts_on","ends_on"},
 * 	description="The rule of the Officer team is a Reign, typically six months.<br>The following relationships can be attached, and in the case of plural relations, searched:
 * officers (Officer) (MorphMany): Officers of the Reign.
 * reignable (Chapter or Realm) (MorphTo): The Reign type; Realm or Chapter.
 * createdBy (User) (BelongsTo): User that created it.
 * updatedBy (User) (BelongsTo): User that last updated it (if any).
 * deletedBy (User) (BelongsTo): User that deleted it (if any).",
 * 	@OA\Property(
 * 		property="id",
 * 		description="The entry's ID.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="reignable_type",
 * 		description="The Reign type; Chapter or Realm.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="enum",
 * 		enum={"Chapter","Realm"},
 * 		example="Chapter"
 * 	),
 * 	@OA\Property(
 * 		property="reignable_id",
 * 		description="The ID of the Realm or Chapter this Reign is for.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="name",
 * 		description="The name of the Reign, if any",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="uppercase first letter",
 * 		example="Reign XXXXII",
 * 		maxLength=100
 * 	),
 * 	@OA\Property(
 * 		property="starts_on",
 * 		description="Date the Reign begins (coronation).",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="date",
 * 		example="2020-12-30"
 * 	),
 * 	@OA\Property(
 * 		property="midreign_on",
 * 		description="Date of the Reign Midreign.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="date",
 * 		example="2020-03-30"
 * 	),
 * 	@OA\Property(
 * 		property="ends_on",
 * 		description="Date the next Reign begins, and this one ends.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="date",
 * 		example="2021-06-30"
 * 	),
 * 	@OA\Property(
 * 		property="created_by",
 * 		description="The User that created this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true,
 * 		default=1
 * 	),
 * 	@OA\Property(
 * 		property="createdBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_by",
 * 		description="The last User to update this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updatedBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_by",
 * 		description="The User that softdeleted this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deletedBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="created_at",
 * 		description="When the entry was created.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_at",
 * 		description="When the entry was last updated.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_at",
 * 		description="When the entry was softdeleted.  Null if not softdeleted.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="officers",
 * 		description="Attachable & filterable array of Officers of the Reign.",
 * 		type="array",
 * 		@OA\Items(
 * 			title="Officer",
 * 			type="object",
 * 			ref="#/components/schemas/OfficerSimple"
 * 		),
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="reignable",
 * 		type="object",
 * 		description="Attachable object the Reign is for.",
 * 		oneOf={
 * 			@OA\Schema(ref="#/components/schemas/ChapterSimple"),
 * 			@OA\Schema(ref="#/components/schemas/RealmSimple")
 * 		},
 * 		readOnly=true
 * 	)
 * )
 * @OA\Schema (
 * 	schema="ReignSimple",
 * 	title="ReignSimple",
 * 	description="Attachable Reign object with no attachments.",
 * 	@OA\Property(
 * 		property="id",
 * 		description="The entry's ID.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="reignable_type",
 * 		description="The Reign type; Chapter or Realm.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="enum",
 * 		enum={"Chapter","Realm"},
 * 		example="Chapter"
 * 	),
 * 	@OA\Property(
 * 		property="reignable_id",
 * 		description="The ID of the Realm or Chapter this Reign is for.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="name",
 * 		description="The name of the Reign, if any",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="uppercase first letter",
 * 		example="Reign XXXXII",
 * 		maxLength=100
 * 	),
 * 	@OA\Property(
 * 		property="starts_on",
 * 		description="Date the Reign begins (coronation).",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="date",
 * 		example="2020-12-30"
 * 	),
 * 	@OA\Property(
 * 		property="midreign_on",
 * 		description="Date of the Reign Midreign.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="date",
 * 		example="2020-03-30"
 * 	),
 * 	@OA\Property(
 * 		property="ends_on",
 * 		description="Date the next Reign begins, and this one ends.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="date",
 * 		example="2021-06-30"
 * 	),
 * 	@OA\Property(
 * 		property="created_by",
 * 		description="The User that created this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true,
 * 		default=1
 * 	),
 * 	@OA\Property(
 * 		property="updated_by",
 * 		description="The last User to update this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_by",
 * 		description="The User that softdeleted this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="created_at",
 * 		description="When the entry was created.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_at",
 * 		description="When the entry was last updated.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_at",
 * 		description="When the entry was softdeleted.  Null if not softdeleted.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	)
 * )
 * @OA\Schema (
 * 	schema="ReignSuperSimple",
 * 	title="ReignSuperSimpleSimple",
 * 	description="Attachable Reign object with no attachments or CUD data.",
 * 	@OA\Property(
 * 		property="id",
 * 		description="The entry's ID.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="reignable_type",
 * 		description="The Reign type; Chapter or Realm.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="enum",
 * 		enum={"Chapter","Realm"},
 * 		example="Chapter"
 * 	),
 * 	@OA\Property(
 * 		property="reignable_id",
 * 		description="The ID of the Realm or Chapter this Reign is for.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="name",
 * 		description="The name of the Reign, if any",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="uppercase first letter",
 * 		example="Reign XXXXII",
 * 		maxLength=100
 * 	),
 * 	@OA\Property(
 * 		property="starts_on",
 * 		description="Date the Reign begins (coronation).",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="date",
 * 		example="2020-12-30"
 * 	),
 * 	@OA\Property(
 * 		property="midreign_on",
 * 		description="Date of the Reign Midreign.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="date",
 * 		example="2020-03-30"
 * 	),
 * 	@OA\Property(
 * 		property="ends_on",
 * 		description="Date the next Reign begins, and this one ends.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="date",
 * 		example="2021-06-30"
 * 	)
 * )
 * @OA\RequestBody (
 * 	request="Reign",
 * 	description="Reign object that needs to be added or updated.",
 * 	required=true,
 * 	@OA\MediaType(
 * 		mediaType="multipart/form-data",
 * 		@OA\Schema(ref="#/components/schemas/ReignSimple")
 * 	)
 * )
 * @property int $id Model ID
 * @property string $reignable_type The Reign type; Chapter or Realm
 * @property int $reignable_id The ID of the Realm or Chapter this Reign is for
 * @property string|null $name The name of the Reign, if any
 * @property \Illuminate\Support\Carbon $starts_on Date the Reign begins (coronation)
 * @property string $midreign_on Date of the Reign Midreign
 * @property \Illuminate\Support\Carbon $ends_on Date the next Reign begins, and this one ends
 * @property int $created_by
 * @property \Illuminate\Support\Carbon $created_at
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $deleted_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\User $createdBy
 * @property-read \App\Models\User $creator
 * @property-read \App\Models\User|null $deletedBy
 * @property-read \App\Models\User|null $destroyer
 * @property-read \App\Models\User|null $editor
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Officer> $officers
 * @property-read int|null $officers_count
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $reignable
 * @property-read \App\Models\User|null $updatedBy
 * @method static \Database\Factories\ReignFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Reign newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Reign newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Reign onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Reign query()
 * @method static \Illuminate\Database\Eloquent\Builder|Reign whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reign whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reign whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reign whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reign whereEndsOn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reign whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reign whereMidreignOn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reign whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reign whereReignableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reign whereReignableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reign whereStartsOn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reign whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reign whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reign withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Reign withoutTrashed()
 */
	class Reign extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Social
 *
 * @OA\Schema (
 * 	schema="Social",
 * 	required={"sociable_type","media","value"},
 * 	description="Various web and app accounts and links associated with a Chapter, Event, Persona, Realm, or Unit.<br>The following relationships can be attached, and in the case of plural relations, searched:
 * sociable (Social) (MorphTo): Model the Social is being attached to.
 * createdBy (User) (BelongsTo): User that created it.
 * updatedBy (User) (BelongsTo): User that last updated it (if any).
 * deletedBy (User) (BelongsTo): User that deleted it (if any).",
 * 	@OA\Property(
 * 		property="id",
 * 		description="The entry's ID.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="sociable_type",
 * 		description="The Model for which the Social is for; Chapter, Event, Persona, Realm, or Unit.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="enum",
 * 		enum={"Chapter","Event","Persona","Realm","Unit"},
 * 		example="Chapter"
 * 	),
 * 	@OA\Property(
 * 		property="sociable_id",
 * 		description="The ID of the entry with this Social.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="media",
 * 		description="The type of Social; Discord, Facebook, Instagram, TicToc, YouTube, or Web",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="enum",
 * 		enum={"Discord","Facebook","Instagram","TicToc","YouTube","Web"},
 * 		example="Web"
 * 	),
 * 	@OA\Property(
 * 		property="value",
 * 		description="The link, username, or other identifier for the given media.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		example="https://ork.amtgard.com",
 * 		maxLength=255
 * 	),
 * 	@OA\Property(
 * 		property="created_by",
 * 		description="The User that created this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true,
 * 		default=1
 * 	),
 * 	@OA\Property(
 * 		property="createdBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_by",
 * 		description="The last User to update this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updatedBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_by",
 * 		description="The User that softdeleted this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deletedBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="created_at",
 * 		description="When the entry was created.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_at",
 * 		description="When the entry was last updated.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_at",
 * 		description="When the entry was softdeleted.  Null if not softdeleted.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="officers",
 * 		description="Attachable & filterable array of Officers of the Reign.",
 * 		type="array",
 * 		@OA\Items(
 * 			title="Officer",
 * 			type="object",
 * 			ref="#/components/schemas/OfficerSimple"
 * 		),
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="sociable",
 * 		type="object",
 * 		description="Attachable model the Social is being attached to.",
 * 		ref="#/components/schemas/SocialSimple",
 * 		readOnly=true
 * 	)
 * )
 * @OA\Schema (
 * 	schema="SocialSimple",
 * 	title="SocialSimple",
 * 	description="Attachable Social object with no attachments.",
 * 	@OA\Property(
 * 		property="id",
 * 		description="The entry's ID.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="sociable_type",
 * 		description="The Model for which the Social is for; Chapter, Event, Persona, Realm, or Unit.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="enum",
 * 		enum={"Chapter","Event","Persona","Realm","Unit"},
 * 		example="Chapter"
 * 	),
 * 	@OA\Property(
 * 		property="sociable_id",
 * 		description="The ID of the entry with this Social.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="media",
 * 		description="The type of Social; Discord, Facebook, Instagram, TicToc, YouTube, or Web",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="enum",
 * 		enum={"Discord","Facebook","Instagram","TicToc","YouTube","Web"},
 * 		example="Web"
 * 	),
 * 	@OA\Property(
 * 		property="value",
 * 		description="The link, username, or other identifier for the given media.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		example="https://ork.amtgard.com",
 * 		maxLength=255
 * 	),
 * 	@OA\Property(
 * 		property="created_by",
 * 		description="The User that created this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true,
 * 		default=1
 * 	),
 * 	@OA\Property(
 * 		property="updated_by",
 * 		description="The last User to update this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_by",
 * 		description="The User that softdeleted this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="created_at",
 * 		description="When the entry was created.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_at",
 * 		description="When the entry was last updated.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_at",
 * 		description="When the entry was softdeleted.  Null if not softdeleted.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	)
 * )
 * @OA\Schema (
 * 	schema="SocialSuperSimple",
 * 	title="SocialSuperSimpleSimple",
 * 	description="Attachable Social object with no attachments or CUD data.",
 * 	@OA\Property(
 * 		property="id",
 * 		description="The entry's ID.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="sociable_type",
 * 		description="The Model for which the Social is for; Chapter, Event, Persona, Realm, or Unit.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="enum",
 * 		enum={"Chapter","Event","Persona","Realm","Unit"},
 * 		example="Chapter"
 * 	),
 * 	@OA\Property(
 * 		property="sociable_id",
 * 		description="The ID of the entry with this Social.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="media",
 * 		description="The type of Social; Discord, Facebook, Instagram, TicToc, YouTube, or Web",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="enum",
 * 		enum={"Discord","Facebook","Instagram","TicToc","YouTube","Web"},
 * 		example="Web"
 * 	),
 * 	@OA\Property(
 * 		property="value",
 * 		description="The link, username, or other identifier for the given media.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		example="https://ork.amtgard.com",
 * 		maxLength=255
 * 	)
 * )
 * @OA\RequestBody (
 * 	request="Social",
 * 	description="Social object that needs to be added or updated.",
 * 	required=true,
 * 	@OA\MediaType(
 * 		mediaType="multipart/form-data",
 * 		@OA\Schema(ref="#/components/schemas/SocialSimple")
 * 	)
 * )
 * @property int $id Model ID
 * @property string $sociable_type The Model for which the Social is for; Chapter, Event, Persona, Realm, or Unit
 * @property int $sociable_id The ID of the entry with this Social
 * @property string $media The type of Social; Discord, Facebook, Instagram, TicToc, YouTube, or Web
 * @property string $value The link, username, or other identifier for the given media
 * @property int $created_by
 * @property \Illuminate\Support\Carbon $created_at
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $deleted_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\User $createdBy
 * @property-read \App\Models\User $creator
 * @property-read \App\Models\User|null $deletedBy
 * @property-read \App\Models\User|null $destroyer
 * @property-read \App\Models\User|null $editor
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $sociable
 * @property-read \App\Models\User|null $updatedBy
 * @method static \Database\Factories\SocialFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Social newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Social newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Social onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Social query()
 * @method static \Illuminate\Database\Eloquent\Builder|Social whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Social whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Social whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Social whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Social whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Social whereMedia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Social whereSociableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Social whereSociableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Social whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Social whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Social whereValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Social withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Social withoutTrashed()
 */
	class Social extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Split
 *
 * @OA\Schema (
 * 	schema="Split",
 * 	required={"transaction_id","persona_id","amount"},
 * 	description="Splits are individual dollar amounts associated with a Transaction.<br>The following relationships can be attached, and in the case of plural relations, searched:
 * account (Account) (BelongsTo): Account this Split is for.
 * persona (Persona) (BelongsTo): Persona performing the Transaction this Split is for.
 * transaction (Transaction) (BelongsTo): Transaction being Split.
 * createdBy (User) (BelongsTo): User that created it.
 * updatedBy (User) (BelongsTo): User that last updated it (if any).
 * deletedBy (User) (BelongsTo): User that deleted it (if any).",
 * 	@OA\Property(
 * 		property="id",
 * 		description="The entry's ID.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="account_id",
 * 		description="The ID of the Account this Split is for.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="persona_id",
 * 		description="The ID of the Persona performing the Transaction.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="transaction_id",
 * 		description="The ID of the Transaction being Split.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="amount",
 * 		description="How much the Split is for.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="number",
 * 		format="float",
 * 		example=12
 * 	),
 * 	@OA\Property(
 * 		property="created_by",
 * 		description="The User that created this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true,
 * 		default=1
 * 	),
 * 	@OA\Property(
 * 		property="createdBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_by",
 * 		description="The last User to update this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updatedBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_by",
 * 		description="The User that softdeleted this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deletedBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="created_at",
 * 		description="When the entry was created.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_at",
 * 		description="When the entry was last updated.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_at",
 * 		description="When the entry was softdeleted.  Null if not softdeleted.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="account",
 * 		type="object",
 * 		description="Attachable Account this Split is for.",
 * 		ref="#/components/schemas/AccountSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="persona",
 * 		type="object",
 * 		description="Attachable Persona performing the Transaction this Split is for.",
 * 		ref="#/components/schemas/PersonaSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="transaction",
 * 		type="object",
 * 		description="Attachable Transaction being Split.",
 * 		ref="#/components/schemas/TransactionSimple",
 * 		readOnly=true
 * 	)
 * )
 * @OA\Schema (
 * 	schema="SplitSimple",
 * 	title="SplitSimple",
 * 	description="Attachable Split object with no attachments.",
 * 	@OA\Property(
 * 		property="id",
 * 		description="The entry's ID.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="account_id",
 * 		description="The ID of the Account this Split is for.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="persona_id",
 * 		description="The ID of the Persona performing the Transaction.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="transaction_id",
 * 		description="The ID of the Transaction being Split.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="amount",
 * 		description="How much the Split is for.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="number",
 * 		format="float",
 * 		example=12
 * 	),
 * 	@OA\Property(
 * 		property="created_by",
 * 		description="The User that created this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true,
 * 		default=1
 * 	),
 * 	@OA\Property(
 * 		property="updated_by",
 * 		description="The last User to update this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_by",
 * 		description="The User that softdeleted this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="created_at",
 * 		description="When the entry was created.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_at",
 * 		description="When the entry was last updated.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_at",
 * 		description="When the entry was softdeleted.  Null if not softdeleted.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	)
 * )
 * @OA\Schema (
 * 	schema="SplitSuperSimple",
 * 	title="SplitSuperSimpleSimple",
 * 	description="Attachable Split object with no attachments or CUD data.",
 * 	@OA\Property(
 * 		property="id",
 * 		description="The entry's ID.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="account_id",
 * 		description="The ID of the Account this Split is for.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="persona_id",
 * 		description="The ID of the Persona performing the Transaction.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="transaction_id",
 * 		description="The ID of the Transaction being Split.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="amount",
 * 		description="How much the Split is for.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="number",
 * 		format="float",
 * 		example=12
 * 	)
 * )
 * @OA\RequestBody (
 * 	request="Split",
 * 	description="Split object that needs to be added or updated.",
 * 	required=true,
 * 	@OA\MediaType(
 * 		mediaType="multipart/form-data",
 * 		@OA\Schema(ref="#/components/schemas/SplitSimple")
 * 	)
 * )
 * @property int $id Model ID
 * @property int $account_id The ID of the Account this Split is for
 * @property int $persona_id The ID of the Persona performing the Transaction
 * @property int $transaction_id The ID of the Transaction being Split
 * @property float $amount How much the Split is for
 * @property int $created_by
 * @property \Illuminate\Support\Carbon $created_at
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $deleted_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Account $account
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\User $createdBy
 * @property-read \App\Models\User $creator
 * @property-read \App\Models\User|null $deletedBy
 * @property-read \App\Models\User|null $destroyer
 * @property-read \App\Models\User|null $editor
 * @property-read \App\Models\Persona $persona
 * @property-read \App\Models\Transaction $transaction
 * @property-read \App\Models\User|null $updatedBy
 * @method static \Database\Factories\SplitFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Split newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Split newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Split onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Split query()
 * @method static \Illuminate\Database\Eloquent\Builder|Split whereAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Split whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Split whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Split whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Split whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Split whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Split whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Split wherePersonaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Split whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Split whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Split whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Split withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Split withoutTrashed()
 */
	class Split extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Suspension
 *
 * @OA\Schema (
 * 	schema="Suspension",
 * 	required={"persona_id","suspendable_type","suspendable_id","suspended_by","cause","is_propogating"},
 * 	description="On the occasion when an Amtgarder must be disciplined, we record it here.<br>The following relationships can be attached, and in the case of plural relations, searched:
 * persona (Persona) (BelongsTo): The Persona that has been Suspended.
 * suspendable (Chapter, Realm) (MorphTo): Chapter or Realm levying the Suspension.
 * realm (Realm) (BelongsTo): The Realm issuing the Suspension.
 * suspendedBy (User) (BelongsTo): User Persona issuing the Suspension.
 * createdBy (User) (BelongsTo): User that created it.
 * updatedBy (User) (BelongsTo): User that last updated it (if any).
 * deletedBy (User) (BelongsTo): User that deleted it (if any).",
 * 	@OA\Property(
 * 		property="id",
 * 		description="The entry's ID.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="persona_id",
 * 		description="The ID of the Persona that has been Suspended.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="suspendable_type",
 * 		description="Who levied the Suspension; Chapter or Realm",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="enum",
 * 		enum={"Chapter","Realm","Persona","Unit"},
 * 		example="Realm"
 * 	),
 * 	@OA\Property(
 * 		property="suspendable_id",
 * 		description="The ID of who levied the Suspension.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="suspended_by",
 * 		description="The ID of the Persona issuing the Suspension.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="suspended_at",
 * 		description="",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="date",
 * 		example="2020-12-30"
 * 	),
 * 	@OA\Property(
 * 		property="expires_at",
 * 		description="",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="date",
 * 		example="2020-12-30"
 * 	),
 * 	@OA\Property(
 * 		property="cause",
 * 		description="Why the suspension was issued.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="paragraph",
 * 		maxLength=191
 * 	),
 * 	@OA\Property(
 * 		property="is_propogating",
 * 		description="Does the Suspension (default false) propogate to all Realms?",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="enum",
 * 		enum={0, 1},
 * 		example=0,
 * 		default=0
 * 	),
 * 	@OA\Property(
 * 		property="created_by",
 * 		description="The User that created this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true,
 * 		default=1
 * 	),
 * 	@OA\Property(
 * 		property="createdBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_by",
 * 		description="The last User to update this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updatedBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_by",
 * 		description="The User that softdeleted this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deletedBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="created_at",
 * 		description="When the entry was created.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_at",
 * 		description="When the entry was last updated.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_at",
 * 		description="When the entry was softdeleted.  Null if not softdeleted.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="persona",
 * 		type="object",
 * 		description="Attachable Persona that has been Suspended.",
 * 		ref="#/components/schemas/PersonaSimple",
 * 		readOnly=true
 * 	), 
 * 	@OA\Property(
 * 		property="realm",
 * 		type="object",
 * 		description="Attachable Realm issuing the Suspension.",
 * 		ref="#/components/schemas/RealmSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="suspendedBy",
 * 		type="object",
 * 		description="Attachable Persona issuing the Suspension.",
 * 		ref="#/components/schemas/PersonaSimple",
 * 		readOnly=true
 * 	)
 * )
 * @OA\Schema (
 * 	schema="SuspensionSimple",
 * 	title="SuspensionSimple",
 * 	description="Attachable Suspension object with no attachments.",
 * 	@OA\Property(
 * 		property="id",
 * 		description="The entry's ID.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="persona_id",
 * 		description="The ID of the Persona that has been Suspended.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="suspendable_type",
 * 		description="Who levied the Suspension; Chapter or Realm",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="enum",
 * 		enum={"Chapter","Realm","Persona","Unit"},
 * 		example="Realm"
 * 	),
 * 	@OA\Property(
 * 		property="suspendable_id",
 * 		description="The ID of who levied the Suspension.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="suspended_by",
 * 		description="The ID of the Persona issuing the Suspension.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="suspended_at",
 * 		description="",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="date",
 * 		example="2020-12-30"
 * 	),
 * 	@OA\Property(
 * 		property="expires_at",
 * 		description="",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="date",
 * 		example="2020-12-30"
 * 	),
 * 	@OA\Property(
 * 		property="cause",
 * 		description="Why the suspension was issued.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="paragraph",
 * 		maxLength=191
 * 	),
 * 	@OA\Property(
 * 		property="is_propogating",
 * 		description="Does the Suspension (default false) propogate to all Realms?",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="enum",
 * 		enum={0, 1},
 * 		example=0,
 * 		default=0
 * 	),
 * 	@OA\Property(
 * 		property="created_by",
 * 		description="The User that created this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true,
 * 		default=1
 * 	),
 * 	@OA\Property(
 * 		property="updated_by",
 * 		description="The last User to update this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_by",
 * 		description="The User that softdeleted this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="created_at",
 * 		description="When the entry was created.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_at",
 * 		description="When the entry was last updated.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_at",
 * 		description="When the entry was softdeleted.  Null if not softdeleted.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	)
 * )
 * @OA\Schema (
 * 	schema="SuspensionSuperSimple",
 * 	title="SuspensionSuperSimpleSimple",
 * 	description="Attachable Suspension object with no attachments or CUD data.",
 * 	@OA\Property(
 * 		property="id",
 * 		description="The entry's ID.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="persona_id",
 * 		description="The ID of the Persona that has been Suspended.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="suspendable_type",
 * 		description="Who levied the Suspension; Chapter or Realm",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="enum",
 * 		enum={"Chapter","Realm","Persona","Unit"},
 * 		example="Realm"
 * 	),
 * 	@OA\Property(
 * 		property="suspendable_id",
 * 		description="The ID of who levied the Suspension.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="suspended_by",
 * 		description="The ID of the Persona issuing the Suspension.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="suspended_at",
 * 		description="",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="date",
 * 		example="2020-12-30"
 * 	),
 * 	@OA\Property(
 * 		property="expires_at",
 * 		description="",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="date",
 * 		example="2020-12-30"
 * 	),
 * 	@OA\Property(
 * 		property="cause",
 * 		description="Why the suspension was issued.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="paragraph",
 * 		maxLength=191
 * 	),
 * 	@OA\Property(
 * 		property="is_propogating",
 * 		description="Does the Suspension (default false) propogate to all Realms?",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="enum",
 * 		enum={0, 1},
 * 		example=0,
 * 		default=0
 * 	)
 * )
 * @OA\RequestBody (
 * 	request="Suspension",
 * 	description="Suspension object that needs to be added or updated.",
 * 	required=true,
 * 	@OA\MediaType(
 * 		mediaType="multipart/form-data",
 * 		@OA\Schema(ref="#/components/schemas/SuspensionSimple")
 * 	)
 * )
 * @property int $id Model ID
 * @property int $persona_id The ID of the Persona that has been Suspended
 * @property string $suspendable_type The Model that levied the Suspension; Chapter or Realm
 * @property int $suspendable_id The ID of the entry that levied the Suspension
 * @property int $suspended_by The ID of the Persona issuing the Suspension
 * @property \Illuminate\Support\Carbon $suspended_at The date the Suspension begins
 * @property \Illuminate\Support\Carbon|null $expires_at The date the Suspension ends, if any, null for forever
 * @property string $cause Why the suspension was issued
 * @property bool $is_propogating Does (default false) the Suspension propogate to all Realms?
 * @property int $created_by
 * @property \Illuminate\Support\Carbon $created_at
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $deleted_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\User $createdBy
 * @property-read \App\Models\User $creator
 * @property-read \App\Models\User|null $deletedBy
 * @property-read \App\Models\User|null $destroyer
 * @property-read \App\Models\User|null $editor
 * @property-read \App\Models\Persona $persona
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $suspendable
 * @property-read \App\Models\Persona $suspendedBy
 * @property-read \App\Models\User|null $updatedBy
 * @method static \Database\Factories\SuspensionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Suspension newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Suspension newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Suspension onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Suspension query()
 * @method static \Illuminate\Database\Eloquent\Builder|Suspension whereCause($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Suspension whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Suspension whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Suspension whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Suspension whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Suspension whereExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Suspension whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Suspension whereIsPropogating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Suspension wherePersonaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Suspension whereSuspendableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Suspension whereSuspendableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Suspension whereSuspendedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Suspension whereSuspendedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Suspension whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Suspension whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Suspension withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Suspension withoutTrashed()
 */
	class Suspension extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Title
 *
 * @OA\Schema (
 * 	schema="Title",
 * 	required={"titleable_type","name","peerage","is_roaming","is_active"},
 * 	description="Titles Issued by the Chapter, Persona, Realm, or Unit.<br>The following relationships can be attached, and in the case of plural relations, searched:
 * issuances (Issuance) (MorphMany): Issuances of this Title.
 * titleable (Chapter, Persona, Realm, or Unit) (MorphTo): Who can issue the Title; Chapter, Persona, Realm, or Unit
 * createdBy (User) (BelongsTo): User that created it.
 * updatedBy (User) (BelongsTo): User that last updated it (if any).
 * deletedBy (User) (BelongsTo): User that deleted it (if any).",
 * 	@OA\Property(
 * 		property="id",
 * 		description="The entry's ID.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="titleable_type",
 * 		description="Who can issue the Title; Chapter, Persona, Realm, or Unit.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="enum",
 * 		enum={"Chapter","Persona","Realm","Unit"},
 * 		example="Chapter"
 * 	),
 * 	@OA\Property(
 * 		property="titleable_id",
 * 		description="The ID of the Title Issuer.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="name",
 * 		description="The Title name with options seperated by a single |",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="uppercase first letter",
 * 		example="Lord|Lady",
 * 		maxLength=100
 * 	),
 * 	@OA\Property(
 * 		property="rank",
 * 		description="For Realm Titles or where appropriate, their order of prescidence in that Realm expressed (usually) in multiples of 10, where Lord|Lady are typically 30.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="integer",
 * 		format="int32",
 * 		example=30
 * 	),
 * 	@OA\Property(
 * 		property="peerage",
 * 		description="The peerage (default None) of the Title; Gentry, Knight, Master, Nobility, None, Paragon, Retainer, or Squire",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="enum",
 * 		enum={"Gentry","Knight","Master","Nobility","None","Paragon","Retainer","Squire"},
 * 		example=1,
 * 		default="None"
 * 	),
 * 	@OA\Property(
 * 		property="is_roaming",
 * 		description="Is the Title (default false) roaming, such as Dragonmaster?",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="enum",
 * 		enum={0, 1},
 * 		example=0,
 * 		default=0
 * 	),
 * 	@OA\Property(
 * 		property="is_active",
 * 		description="Is this Title (default true) still being given out?",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="enum",
 * 		enum={0, 1},
 * 		example=0,
 * 		default=1
 * 	),
 * 	@OA\Property(
 * 		property="created_by",
 * 		description="The User that created this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true,
 * 		default=1
 * 	),
 * 	@OA\Property(
 * 		property="createdBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_by",
 * 		description="The last User to update this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updatedBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_by",
 * 		description="The User that softdeleted this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deletedBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="created_at",
 * 		description="When the entry was created.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_at",
 * 		description="When the entry was last updated.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_at",
 * 		description="When the entry was softdeleted.  Null if not softdeleted.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="issuances",
 * 		description="Attachable & filterable array of Issuances of this Title.",
 * 		type="array",
 * 		@OA\Items(
 * 			title="Issuance",
 * 			type="object",
 * 			ref="#/components/schemas/IssuanceSimple"
 * 		),
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="titleable",
 * 		type="object",
 * 		description="Attachable object that can Issue the Title.",
 * 		oneOf={
 * 			@OA\Schema(ref="#/components/schemas/ChapterSimple"),
 * 			@OA\Schema(ref="#/components/schemas/PersonaSimple"),
 * 			@OA\Schema(ref="#/components/schemas/RealmSimple"),
 * 			@OA\Schema(ref="#/components/schemas/UnitSimple")
 * 		},
 * 		readOnly=true
 * 	)
 * )
 * @OA\Schema (
 * 	schema="TitleSimple",
 * 	title="TitleSimple",
 * 	description="Attachable Title object with no attachments.",
 * 	@OA\Property(
 * 		property="id",
 * 		description="The entry's ID.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="titleable_type",
 * 		description="Who can issue the Title; Chapter, Persona, Realm, or Unit.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="enum",
 * 		enum={"Chapter","Persona","Realm","Unit"},
 * 		example="Chapter"
 * 	),
 * 	@OA\Property(
 * 		property="titleable_id",
 * 		description="The ID of the Title Issuer.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="name",
 * 		description="The Title name with options seperated by a single |",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="uppercase first letter",
 * 		example="Lord|Lady",
 * 		maxLength=100
 * 	),
 * 	@OA\Property(
 * 		property="rank",
 * 		description="For Realm Titles or where appropriate, their order of prescidence in that Realm expressed (usually) in multiples of 10, where Lord|Lady are typically 30.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="integer",
 * 		format="int32",
 * 		example=30
 * 	),
 * 	@OA\Property(
 * 		property="peerage",
 * 		description="The peerage (default None) of the Title; Gentry, Knight, Master, Nobility, None, Paragon, Retainer, or Squire",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="enum",
 * 		enum={"Gentry","Knight","Master","Nobility","None","Paragon","Retainer","Squire"},
 * 		example=1,
 * 		default="None"
 * 	),
 * 	@OA\Property(
 * 		property="is_roaming",
 * 		description="Is the Title (default false) roaming, such as Dragonmaster?",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="enum",
 * 		enum={0, 1},
 * 		example=0,
 * 		default=0
 * 	),
 * 	@OA\Property(
 * 		property="is_active",
 * 		description="Is this Title (default true) still being given out?",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="enum",
 * 		enum={0, 1},
 * 		example=0,
 * 		default=1
 * 	),
 * 	@OA\Property(
 * 		property="created_by",
 * 		description="The User that created this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true,
 * 		default=1
 * 	),
 * 	@OA\Property(
 * 		property="updated_by",
 * 		description="The last User to update this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_by",
 * 		description="The User that softdeleted this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="created_at",
 * 		description="When the entry was created.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_at",
 * 		description="When the entry was last updated.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_at",
 * 		description="When the entry was softdeleted.  Null if not softdeleted.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	)
 * )
 * @OA\Schema (
 * 	schema="TitleSuperSimple",
 * 	title="TitleSuperSimpleSimple",
 * 	description="Attachable Title object with no attachments or CUD data.",
 * 	@OA\Property(
 * 		property="id",
 * 		description="The entry's ID.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="titleable_type",
 * 		description="Who can issue the Title; Chapter, Persona, Realm, or Unit.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="enum",
 * 		enum={"Chapter","Persona","Realm","Unit"},
 * 		example="Chapter"
 * 	),
 * 	@OA\Property(
 * 		property="titleable_id",
 * 		description="The ID of the Title Issuer.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="name",
 * 		description="The Title name with options seperated by a single |",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="uppercase first letter",
 * 		example="Lord|Lady",
 * 		maxLength=100
 * 	),
 * 	@OA\Property(
 * 		property="rank",
 * 		description="For Realm Titles or where appropriate, their order of prescidence in that Realm expressed (usually) in multiples of 10, where Lord|Lady are typically 30.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="integer",
 * 		format="int32",
 * 		example=30
 * 	),
 * 	@OA\Property(
 * 		property="peerage",
 * 		description="The peerage (default None) of the Title; Gentry, Knight, Master, Nobility, None, Paragon, Retainer, or Squire",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="enum",
 * 		enum={"Gentry","Knight","Master","Nobility","None","Paragon","Retainer","Squire"},
 * 		example=1,
 * 		default="None"
 * 	),
 * 	@OA\Property(
 * 		property="is_roaming",
 * 		description="Is the Title (default false) roaming, such as Dragonmaster?",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="enum",
 * 		enum={0, 1},
 * 		example=0,
 * 		default=0
 * 	),
 * 	@OA\Property(
 * 		property="is_active",
 * 		description="Is this Title (default true) still being given out?",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="enum",
 * 		enum={0, 1},
 * 		example=0,
 * 		default=1
 * 	)
 * )
 * @OA\RequestBody (
 * 	request="Title",
 * 	description="Title object that needs to be added or updated.",
 * 	required=true,
 * 	@OA\MediaType(
 * 		mediaType="multipart/form-data",
 * 		@OA\Schema(ref="#/components/schemas/TitleSimple")
 * 	)
 * )
 * @property int $id Model ID
 * @property string $titleable_type The Model of who can issue the Title; Chapter, Persona, Realm, or Unit
 * @property int|null $titleable_id The ID of the Title issuer
 * @property string $name The Title name with options seperated by a single |
 * @property int|null $rank For Realm Titles or where appropriate, their order of prescidence in that Realm expressed (usually) in multiples of 10, where Lord|Lady are typically 30
 * @property string $peerage The peerage (default None) of the Title; Gentry, Knight, Master, Nobility, None, Paragon, Retainer, or Squire
 * @property bool $is_roaming Is (default false) the Title roaming, such as Dragonmaster?
 * @property bool $is_active Is (default true) this Title still being given out?
 * @property int $created_by
 * @property \Illuminate\Support\Carbon $created_at
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $deleted_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\User $createdBy
 * @property-read \App\Models\User $creator
 * @property-read \App\Models\User|null $deletedBy
 * @property-read \App\Models\User|null $destroyer
 * @property-read \App\Models\User|null $editor
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Issuance> $issuances
 * @property-read int|null $issuances_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Recommendation> $recommendations
 * @property-read int|null $recommendations_count
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $titleable
 * @property-read \App\Models\User|null $updatedBy
 * @method static \Database\Factories\TitleFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Title newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Title newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Title onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Title query()
 * @method static \Illuminate\Database\Eloquent\Builder|Title whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Title whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Title whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Title whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Title whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Title whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Title whereIsRoaming($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Title whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Title wherePeerage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Title whereRank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Title whereTitleableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Title whereTitleableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Title whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Title whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Title withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Title withoutTrashed()
 */
	class Title extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Tournament
 *
 * @OA\Schema (
 * 	schema="Tournament",
 * 	required={"tournamentable_type","tournamentable_id","name","description","occured_at"},
 * 	description="Tournament details.<br>The following relationships can be attached, and in the case of plural relations, searched:
 * tournamentable (Chapter, Event, or Realm) (MorphTo): The Tournament sponsor type; Chapter, Event, or Realm.
 * createdBy (User) (BelongsTo): User that created it.
 * updatedBy (User) (BelongsTo): User that last updated it (if any).
 * deletedBy (User) (BelongsTo): User that deleted it (if any).",
 * 	@OA\Property(
 * 		property="id",
 * 		description="The entry's ID.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="tournamentable_type",
 * 		description="The Tournament sponsor type; Chapter, Event, or Realm.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="enum",
 * 		enum={"Chapter","Event","Realm"},
 * 		example="Chapter"
 * 	),
 * 	@OA\Property(
 * 		property="tournamentable_id",
 * 		description="The ID of the Tournament sponsor.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="name",
 * 		description="The name of the Tournament.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="uppercase first letter",
 * 		example="KotB Tournament",
 * 		maxLength=50
 * 	),
 * 	@OA\Property(
 * 		property="description",
 * 		description="A description of the Tournament.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="paragraph",
 * 		example="Keep on the Boarderlands annual tournament.",
 * 		maxLength=16777215
 * 	),
 * 	@OA\Property(
 * 		property="occured_at",
 * 		description="Date and time the Tournament occured.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59"
 * 	),
 * 	@OA\Property(
 * 		property="created_by",
 * 		description="The User that created this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true,
 * 		default=1
 * 	),
 * 	@OA\Property(
 * 		property="createdBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_by",
 * 		description="The last User to update this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updatedBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_by",
 * 		description="The User that softdeleted this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deletedBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="created_at",
 * 		description="When the entry was created.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_at",
 * 		description="When the entry was last updated.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_at",
 * 		description="When the entry was softdeleted.  Null if not softdeleted.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="tournamentable",
 * 		type="object",
 * 		description="Attachable object that sponsored the Tournament.",
 * 		oneOf={
 * 			@OA\Schema(ref="#/components/schemas/ChapterSimple"),
 * 			@OA\Schema(ref="#/components/schemas/EventSimple"),
 * 			@OA\Schema(ref="#/components/schemas/RealmSimple")
 * 		},
 * 		readOnly=true
 * 	)
 * )
 * @OA\Schema (
 * 	schema="TournamentSimple",
 * 	title="TournamentSimple",
 * 	description="Attachable Tournament object with no attachments.",
 * 	@OA\Property(
 * 		property="id",
 * 		description="The entry's ID.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="tournamentable_type",
 * 		description="The Tournament sponsor type; Chapter, Event, or Realm.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="enum",
 * 		enum={"Chapter","Event","Realm"},
 * 		example="Chapter"
 * 	),
 * 	@OA\Property(
 * 		property="tournamentable_id",
 * 		description="The ID of the Tournament sponsor.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="name",
 * 		description="The name of the Tournament.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="uppercase first letter",
 * 		example="KotB Tournament",
 * 		maxLength=50
 * 	),
 * 	@OA\Property(
 * 		property="description",
 * 		description="A description of the Tournament.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="paragraph",
 * 		example="Keep on the Boarderlands annual tournament.",
 * 		maxLength=16777215
 * 	),
 * 	@OA\Property(
 * 		property="created_by",
 * 		description="The User that created this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true,
 * 		default=1
 * 	),
 * 	@OA\Property(
 * 		property="updated_by",
 * 		description="The last User to update this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_by",
 * 		description="The User that softdeleted this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="created_at",
 * 		description="When the entry was created.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_at",
 * 		description="When the entry was last updated.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_at",
 * 		description="When the entry was softdeleted.  Null if not softdeleted.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	)
 * )
 * @OA\Schema (
 * 	schema="TournamentSuperSimple",
 * 	title="TournamentSuperSimpleSimple",
 * 	description="Attachable Tournament object with no attachments or CUD data.",
 * 	@OA\Property(
 * 		property="id",
 * 		description="The entry's ID.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="tournamentable_type",
 * 		description="The Tournament sponsor type; Chapter, Event, or Realm.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="enum",
 * 		enum={"Chapter","Event","Realm"},
 * 		example="Chapter"
 * 	),
 * 	@OA\Property(
 * 		property="tournamentable_id",
 * 		description="The ID of the Tournament sponsor.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="name",
 * 		description="The name of the Tournament.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="uppercase first letter",
 * 		example="KotB Tournament",
 * 		maxLength=50
 * 	),
 * 	@OA\Property(
 * 		property="description",
 * 		description="A description of the Tournament.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="paragraph",
 * 		example="Keep on the Boarderlands annual tournament.",
 * 		maxLength=16777215
 * 	)
 * )
 * @OA\RequestBody (
 * 	request="Tournament",
 * 	description="Tournament object that needs to be added or updated.",
 * 	required=true,
 * 	@OA\MediaType(
 * 		mediaType="multipart/form-data",
 * 		@OA\Schema(ref="#/components/schemas/TournamentSimple")
 * 	)
 * )
 * @property int $id Model ID
 * @property string $tournamentable_type The Tournament sponsor type; Chapter, Event, or Realm
 * @property int $tournamentable_id The ID of the Tournament sponsor
 * @property string $name The name of the Tournament
 * @property string|null $description A description of the Tournament
 * @property \Illuminate\Support\Carbon $occured_at Date and time the Tournament occured
 * @property int $created_by
 * @property \Illuminate\Support\Carbon $created_at
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $deleted_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\User $createdBy
 * @property-read \App\Models\User $creator
 * @property-read \App\Models\User|null $deletedBy
 * @property-read \App\Models\User|null $destroyer
 * @property-read \App\Models\User|null $editor
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $tournamentable
 * @property-read \App\Models\User|null $updatedBy
 * @method static \Database\Factories\TournamentFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Tournament newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tournament newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tournament onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Tournament query()
 * @method static \Illuminate\Database\Eloquent\Builder|Tournament whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tournament whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tournament whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tournament whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tournament whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tournament whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tournament whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tournament whereOccuredAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tournament whereTournamentableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tournament whereTournamentableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tournament whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tournament whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tournament withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Tournament withoutTrashed()
 */
	class Tournament extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Transaction
 *
 * @OA\Schema (
 * 	schema="Transaction",
 * 	required={"description","transaction_at"},
 * 	description="Accounting Transactions.<br>The following relationships can be attached, and in the case of plural relations, searched:
 * dues (Due) (HasMany): Dues linked to the Transaction
 * splits (Split) (HasMany): Splits for the Transaction
 * createdBy (User) (BelongsTo): User that created it.
 * updatedBy (User) (BelongsTo): User that last updated it (if any).
 * deletedBy (User) (BelongsTo): User that deleted it (if any).",
 * 	@OA\Property(
 * 		property="id",
 * 		description="The entry's ID.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="description",
 * 		description="A description of the Transaction.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="paragraph",
 * 		example="Dues Paid for Chibasama",
 * 		maxLength=191
 * 	),
 * 	@OA\Property(
 * 		property="memo",
 * 		description="A memo for the Transaction, if any",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		example="Paid in $2 bills.",
 * 		maxLength=191
 * 	),
 * 	@OA\Property(
 * 		property="transaction_at",
 * 		description="Date the Transaction occured.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="date",
 * 		example="2020-12-30"
 * 	),
 * 	@OA\Property(
 * 		property="created_by",
 * 		description="The User that created this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true,
 * 		default=1
 * 	),
 * 	@OA\Property(
 * 		property="createdBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_by",
 * 		description="The last User to update this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updatedBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_by",
 * 		description="The User that softdeleted this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deletedBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="created_at",
 * 		description="When the entry was created.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_at",
 * 		description="When the entry was last updated.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_at",
 * 		description="When the entry was softdeleted.  Null if not softdeleted.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="dues",
 * 		description="Attachable & filterable array of Dues linked to the Transaction.",
 * 		type="array",
 * 		@OA\Items(
 * 			title="Due",
 * 			type="object",
 * 			ref="#/components/schemas/DueSimple"
 * 		),
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="splits",
 * 		description="Attachable & filterable array of Splits for the Transaction.",
 * 		type="array",
 * 		@OA\Items(
 * 			title="Split",
 * 			type="object",
 * 			ref="#/components/schemas/SplitSimple"
 * 		),
 * 		readOnly=true
 * 	)
 * )
 * @OA\Schema (
 * 	schema="TransactionSimple",
 * 	title="TransactionSimple",
 * 	description="Attachable Transaction object with no attachments.",
 * 	@OA\Property(
 * 		property="id",
 * 		description="The entry's ID.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="description",
 * 		description="A description of the Transaction.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="paragraph",
 * 		example="Dues Paid for Chibasama",
 * 		maxLength=191
 * 	),
 * 	@OA\Property(
 * 		property="memo",
 * 		description="A memo for the Transaction, if any",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		example="Paid in $2 bills.",
 * 		maxLength=191
 * 	),
 * 	@OA\Property(
 * 		property="transaction_at",
 * 		description="Date the Transaction occured.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="date",
 * 		example="2020-12-30"
 * 	),
 * 	@OA\Property(
 * 		property="created_by",
 * 		description="The User that created this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true,
 * 		default=1
 * 	),
 * 	@OA\Property(
 * 		property="updated_by",
 * 		description="The last User to update this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_by",
 * 		description="The User that softdeleted this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="created_at",
 * 		description="When the entry was created.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_at",
 * 		description="When the entry was last updated.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_at",
 * 		description="When the entry was softdeleted.  Null if not softdeleted.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	)
 * )
 * @OA\Schema (
 * 	schema="TransactionSuperSimple",
 * 	title="TransactionSuperSimpleSimple",
 * 	description="Attachable Transaction object with no attachments or CUD data.",
 * 	@OA\Property(
 * 		property="id",
 * 		description="The entry's ID.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="description",
 * 		description="A description of the Transaction.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="paragraph",
 * 		example="Dues Paid for Chibasama",
 * 		maxLength=191
 * 	),
 * 	@OA\Property(
 * 		property="memo",
 * 		description="A memo for the Transaction, if any",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		example="Paid in $2 bills.",
 * 		maxLength=191
 * 	),
 * 	@OA\Property(
 * 		property="transaction_at",
 * 		description="Date the Transaction occured.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="date",
 * 		example="2020-12-30"
 * 	)
 * )
 * @OA\RequestBody (
 * 	request="Transaction",
 * 	description="Transaction object that needs to be added or updated.",
 * 	required=true,
 * 	@OA\MediaType(
 * 		mediaType="multipart/form-data",
 * 		@OA\Schema(ref="#/components/schemas/TransactionSimple")
 * 	)
 * )
 * @property int $id Model ID
 * @property string $description A description of the Transaction
 * @property string|null $memo A memo for the Transaction, if any
 * @property \Illuminate\Support\Carbon $transaction_at Date the Transaction occured
 * @property int $created_by
 * @property \Illuminate\Support\Carbon $created_at
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $deleted_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\User $createdBy
 * @property-read \App\Models\User $creator
 * @property-read \App\Models\User|null $deletedBy
 * @property-read \App\Models\User|null $destroyer
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Due> $dues
 * @property-read int|null $dues_count
 * @property-read \App\Models\User|null $editor
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Split> $splits
 * @property-read int|null $splits_count
 * @property-read \App\Models\User|null $updatedBy
 * @method static \Database\Factories\TransactionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereMemo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereTransactionAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction withoutTrashed()
 */
	class Transaction extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Unit
 *
 * @OA\Schema (
 * 	schema="Unit",
 * 	required={"type","name"},
 * 	description="Organizations within the broader scope of Amtgard.<br>The following relationships can be attached, and in the case of plural relations, searched:
 * accounts (Account) (MorphMany): Accounts held by the Unit.
 * awards (Award) (MorphMany): Awards Unit can Issue.
 * awardIssuances (Issuance) (MorphMany): Awards Unit has been Issued.
 * events (Event) (MorphMany): Events run by this Unit.
 * issuanceGivens (Issuance) (MorphMany): All Issuances made by the Unit.
 * issuanceReceived (Issuance) (MorphMany): All Issuances received by the Unit.
 * members (Member) (HasMany): Unit Members.
 * officers (Officer) (MorphMany): Officers of the Unit.
 * offices (Office) (MorphMany): Unit Offices.
 * socials (Social) (MorphMany): Social media links or IDs.
 * titles (Title) (MorphMany): Titles Unit can Issue.
 * titleIssuances (Issuance) (MorphMany): Titles Unit has been Issued.
 * createdBy (User) (BelongsTo): User that created it.
 * updatedBy (User) (BelongsTo): User that last updated it (if any).
 * deletedBy (User) (BelongsTo): User that deleted it (if any).",
 * 	@OA\Property(
 * 		property="id",
 * 		description="The entry's ID.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="type",
 * 		description="Unit type; Company, Event, or Household.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="enum",
 * 		enum={"Company","Event","Household"},
 * 		example="Company",
 * 		default="Household"
 * 	),
 * 	@OA\Property(
 * 		property="name",
 * 		description="Name of the Unit.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="uppercase first letter",
 * 		example="Team Alpha Male",
 * 		maxLength=100
 * 	),
 * 	@OA\Property(
 * 		property="heraldry",
 * 		description="An internal link to an image of the Unit heraldry, if any.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="filename",
 * 		example="images/units/42.jpg",
 * 		maxLength=191
 * 	),
 * 	@OA\Property(
 * 		property="description",
 * 		description="A public facing description of the Unit.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="paragraph",
 * 		example="We like to hang out in the most exclusive way possible.",
 * 		maxLength=16777215
 * 	),
 * 	@OA\Property(
 * 		property="history",
 * 		description="For use as the Unit requires, history of the Unit, if any.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="paragraph",
 * 		example="No shit there we were...",
 * 		maxLength=16777215
 * 	),
 * 	@OA\Property(
 * 		property="created_by",
 * 		description="The User that created this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true,
 * 		default=1
 * 	),
 * 	@OA\Property(
 * 		property="createdBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_by",
 * 		description="The last User to update this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updatedBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_by",
 * 		description="The User that softdeleted this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deletedBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="created_at",
 * 		description="When the entry was created.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_at",
 * 		description="When the entry was last updated.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_at",
 * 		description="When the entry was softdeleted.  Null if not softdeleted.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="accounts",
 * 		description="Attachable & filterable array of Accounts held by the Unit.",
 * 		type="array",
 * 		@OA\Items(
 * 			title="Account",
 * 			type="object",
 * 			ref="#/components/schemas/AccountSimple"
 * 		),
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="awards",
 * 		description="Attachable & filterable array of Awards this Unit can Issue.",
 * 		type="array",
 * 		@OA\Items(
 * 			title="Award",
 * 			type="object",
 * 			ref="#/components/schemas/AwardSimple"
 * 		),
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="awardIssuances",
 * 		description="Attachable & filterable array of Awards this Unit has been Issued.",
 * 		type="array",
 * 		@OA\Items(
 * 			title="Issuance",
 * 			type="object",
 * 			ref="#/components/schemas/IssuanceSimple"
 * 		),
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="events",
 * 		description="Attachable & filterable array of Events run by this Unit.",
 * 		type="array",
 * 		@OA\Items(
 * 			title="Event",
 * 			type="object",
 * 			ref="#/components/schemas/EventSimple"
 * 		),
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="issuanceGivens",
 * 		description="Attachable & filterable array of Issuances made by the Unit",
 * 		type="array",
 * 		@OA\Items(
 * 			title="Issuance",
 * 			type="object",
 * 			ref="#/components/schemas/IssuanceSimple"
 * 		),
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="issuanceReceived",
 * 		description="Attachable & filterable array of Issuances received by the Unit.",
 * 		type="array",
 * 		@OA\Items(
 * 			title="Issuance",
 * 			type="object",
 * 			ref="#/components/schemas/IssuanceSimple"
 * 		),
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="members",
 * 		description="Attachable & filterable array of Unit Members.",
 * 		type="array",
 * 		@OA\Items(
 * 			title="Member",
 * 			type="object",
 * 			ref="#/components/schemas/MemberSimple"
 * 		),
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="officers",
 * 		description="Attachable & filterable array of Officers of the Unit.",
 * 		type="array",
 * 		@OA\Items(
 * 			title="Officer",
 * 			type="object",
 * 			ref="#/components/schemas/OfficerSimple"
 * 		),
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="offices",
 * 		description="Attachable & filterable array of Unit Offices.",
 * 		type="array",
 * 		@OA\Items(
 * 			title="Office",
 * 			type="object",
 * 			ref="#/components/schemas/OfficeSimple"
 * 		),
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="socials",
 * 		description="Attachable & filterable array of Social media links or IDs.",
 * 		type="array",
 * 		@OA\Items(
 * 			title="Social",
 * 			type="object",
 * 			ref="#/components/schemas/SocialSimple"
 * 		),
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="titles",
 * 		description="Attachable & filterable array of Titles the Unit Issues.",
 * 		type="array",
 * 		@OA\Items(
 * 			title="Title",
 * 			type="object",
 * 			ref="#/components/schemas/TitleSimple"
 * 		),
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="titleIssueds",
 * 		description="Attachable & filterable array of Titles the Unit has been Issued.",
 * 		type="array",
 * 		@OA\Items(
 * 			title="Issuance",
 * 			type="object",
 * 			ref="#/components/schemas/IssuanceSimple"
 * 		),
 * 		readOnly=true
 * 	)
 * )
 * @OA\Schema (
 * 	schema="UnitSimple",
 * 	title="UnitSimple",
 * 	description="Attachable Unit object with no attachments.",
 * 	@OA\Property(
 * 		property="id",
 * 		description="The entry's ID.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="type",
 * 		description="Unit type; Company, Event, or Household.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="enum",
 * 		enum={"Company","Event","Household"},
 * 		example="Company",
 * 		default="Household"
 * 	),
 * 	@OA\Property(
 * 		property="name",
 * 		description="Name of the Unit.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="uppercase first letter",
 * 		example="Team Alpha Male",
 * 		maxLength=100
 * 	),
 * 	@OA\Property(
 * 		property="heraldry",
 * 		description="An internal link to an image of the Unit heraldry, if any.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="filename",
 * 		example="images/units/42.jpg",
 * 		maxLength=191
 * 	),
 * 	@OA\Property(
 * 		property="description",
 * 		description="A public facing description of the Unit.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="paragraph",
 * 		example="We like to hang out in the most exclusive way possible.",
 * 		maxLength=16777215
 * 	),
 * 	@OA\Property(
 * 		property="history",
 * 		description="For use as the Unit requires, history of the Unit, if any.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="paragraph",
 * 		example="No shit there we were...",
 * 		maxLength=16777215
 * 	),
 * 	@OA\Property(
 * 		property="created_by",
 * 		description="The User that created this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true,
 * 		default=1
 * 	),
 * 	@OA\Property(
 * 		property="updated_by",
 * 		description="The last User to update this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_by",
 * 		description="The User that softdeleted this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="created_at",
 * 		description="When the entry was created.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_at",
 * 		description="When the entry was last updated.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_at",
 * 		description="When the entry was softdeleted.  Null if not softdeleted.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	)
 * )
 * @OA\Schema (
 * 	schema="UnitSuperSimple",
 * 	title="UnitSuperSimpleSimple",
 * 	description="Attachable Unit object with no attachments or CUD data.",
 * 	@OA\Property(
 * 		property="id",
 * 		description="The entry's ID.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="type",
 * 		description="Unit type; Company, Event, or Household.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="enum",
 * 		enum={"Company","Event","Household"},
 * 		example="Company",
 * 		default="Household"
 * 	),
 * 	@OA\Property(
 * 		property="name",
 * 		description="Name of the Unit.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="uppercase first letter",
 * 		example="Team Alpha Male",
 * 		maxLength=100
 * 	),
 * 	@OA\Property(
 * 		property="heraldry",
 * 		description="An internal link to an image of the Unit heraldry, if any.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="filename",
 * 		example="images/units/42.jpg",
 * 		maxLength=191
 * 	),
 * 	@OA\Property(
 * 		property="description",
 * 		description="A public facing description of the Unit.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="paragraph",
 * 		example="We like to hang out in the most exclusive way possible.",
 * 		maxLength=16777215
 * 	),
 * 	@OA\Property(
 * 		property="history",
 * 		description="For use as the Unit requires, history of the Unit, if any.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="paragraph",
 * 		example="No shit there we were...",
 * 		maxLength=16777215
 * 	)
 * )
 * @OA\RequestBody (
 * 	request="Unit",
 * 	description="Unit object that needs to be added or updated.",
 * 	required=true,
 * 	@OA\MediaType(
 * 		mediaType="multipart/form-data",
 * 		@OA\Schema(ref="#/components/schemas/UnitSimple")
 * 	)
 * )
 * @property int $id Model ID
 * @property string $type Unit type; Company, Event, or Household
 * @property string $name Name of the Unit
 * @property string|null $heraldry An internal link to an image of the Unit heraldry, if any
 * @property string|null $description A public facing description of the Unit
 * @property string|null $history For use as the Unit requires, history of the Unit, if any
 * @property int $created_by
 * @property \Illuminate\Support\Carbon $created_at
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $deleted_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Account> $accounts
 * @property-read int|null $accounts_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Issuance> $awardIssuances
 * @property-read int|null $award_issuances_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Award> $awards
 * @property-read int|null $awards_count
 * @property-read \App\Models\User $createdBy
 * @property-read \App\Models\User $creator
 * @property-read \App\Models\User|null $deletedBy
 * @property-read \App\Models\User|null $destroyer
 * @property-read \App\Models\User|null $editor
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Event> $events
 * @property-read int|null $events_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Issuance> $issuanceGivens
 * @property-read int|null $issuance_givens_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Member> $members
 * @property-read int|null $members_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Officer> $officers
 * @property-read int|null $officers_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Office> $offices
 * @property-read int|null $offices_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Social> $socials
 * @property-read int|null $socials_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Issuance> $titleIssuances
 * @property-read int|null $title_issuances_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Award> $titles
 * @property-read int|null $titles_count
 * @property-read \App\Models\User|null $updatedBy
 * @method static \Database\Factories\UnitFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Unit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Unit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Unit onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Unit query()
 * @method static \Illuminate\Database\Eloquent\Builder|Unit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Unit whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Unit whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Unit whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Unit whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Unit whereHeraldry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Unit whereHistory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Unit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Unit whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Unit whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Unit whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Unit whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Unit withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Unit withoutTrashed()
 */
	class Unit extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @OA\Schema (
 * 	schema="User",
 * 	required={"email","password","is_restricted"},
 * 	description="People signed up to the site.<br>The following relationships can be attached, and in the case of 'many' types, searched:
 * persona (Persona) (BelongsTo): Persona associated with the User.
 * passwordHistories (PasswordHistory) (HasMany): Past passwords (encrypted) this User has used.
 * createdBy (User) (BelongsTo): User that created it.
 * updatedBy (User) (BelongsTo): User that last updated it (if any).
 * deletedBy (User) (BelongsTo): User that deleted it (if any).",
 * 	@OA\Property(
 * 		property="id",
 * 		description="The entry's ID.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="persona_id",
 * 		description="ID of the User's Persona.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="email",
 * 		description="Unique email used to identify and communicate with the User.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="email",
 * 		example="nobody@nowhere.net",
 * 		maxLength=191
 * 	),
 * 	@OA\Property(
 * 		property="email_verified_at",
 * 		description="When the User email was verified, if at all",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="date-time",
 * 		example="2023-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="password",
 * 		description="Encoded password string.",
 * 		nullable=false,
 * 		type="string",
 * 		format="8-40 characters, at least 1 uppercase, at least 1 lowercase, both letters and numbers, not common",
 * 		example="$2y$10$SoNOPPci0zg2xqBzhvVQN.DvkHLqJEhLAxyqTz85UNzJBdLI9asdf",
 * 		writeOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="api_token",
 * 		description="The API token for authentication",
 * 		type="string",
 * 		maxLength=80,
 * 		example="eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9...",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="is_restricted",
 * 		description="Is the User (default false) restricted from using the site?",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="enum",
 * 		enum={0, 1},
 * 		example=0,
 * 		default=0
 * 	),
 * 	@OA\Property(
 * 		property="created_by",
 * 		description="The User that created this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true,
 * 		default=1
 * 	),
 * 	@OA\Property(
 * 		property="createdBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_by",
 * 		description="The last User to update this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updatedBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_by",
 * 		description="The User that softdeleted this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deletedBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="created_at",
 * 		description="When the entry was created.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_at",
 * 		description="When the entry was last updated.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_at",
 * 		description="When the entry was softdeleted.  Null if not softdeleted.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="persona",
 * 		type="object",
 * 		description="Attachable Persona for this User.",
 * 		ref="#/components/schemas/PersonaSimple",
 * 		readOnly=true
 * 	)
 * )
 * @OA\Schema (
 * 	schema="UserSimple",
 * 	title="UserSimple",
 * 	description="Attachable User object with no attachments.",
 * 	@OA\Property(
 * 		property="persona_id",
 * 		description="ID of the User's Persona.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="email",
 * 		description="Unique email used to identify and communicate with the User.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="email",
 * 		example="nobody@nowhere.net",
 * 		maxLength=191
 * 	),
 * 	@OA\Property(
 * 		property="email_verified_at",
 * 		description="When the User email was verified, if at all",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="date-time",
 * 		example="2023-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="password",
 * 		description="Encoded password string.",
 * 		nullable=false,
 * 		type="string",
 * 		format="8-40 characters, at least 1 uppercase, at least 1 lowercase, both letters and numbers, not common",
 * 		example="$2y$10$SoNOPPci0zg2xqBzhvVQN.DvkHLqJEhLAxyqTz85UNzJBdLI9asdf",
 * 		writeOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="is_restricted",
 * 		description="Is the User (default false) restricted from using the site?",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="enum",
 * 		enum={0, 1},
 * 		example=0,
 * 		default=0
 * 	),
 * 	@OA\Property(
 * 		property="created_by",
 * 		description="The User that created this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true,
 * 		default=1
 * 	),
 * 	@OA\Property(
 * 		property="updated_by",
 * 		description="The last User to update this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_by",
 * 		description="The User that softdeleted this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="created_at",
 * 		description="When the entry was created.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_at",
 * 		description="When the entry was last updated.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_at",
 * 		description="When the entry was softdeleted.  Null if not softdeleted.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	)
 * )
 * @OA\Schema (
 * 	schema="UserLogin",
 * 	title="User",
 * 	description="Attachable User login object with no attachments.",
 * 	@OA\Property(
 * 		property="persona_id",
 * 		description="ID of the User's Persona.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="token",
 * 		description="Login token for the User.",
 * 		readOnly=true,
 * 		nullable=false,
 * 		type="string",
 * 		example="yR1234D5gqZlgmiR1234YM01KDRJG1234KRHjA12"
 * 	),
 * 	@OA\Property(
 * 		property="email",
 * 		description="Unique email used to identify and communicate with the User.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="email",
 * 		example="nobody@nowhere.net",
 * 		maxLength=191
 * 	),
 * 	@OA\Property(
 * 		property="email_verified_at",
 * 		description="When the User email was verified, if at all",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="date-time",
 * 		example="2023-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="password",
 * 		description="Encoded password string.",
 * 		nullable=false,
 * 		type="string",
 * 		format="8-40 characters, at least 1 uppercase, at least 1 lowercase, both letters and numbers, not common",
 * 		example="$2y$10$SoNOPPci0zg2xqBzhvVQN.DvkHLqJEhLAxyqTz85UNzJBdLI9asdf",
 * 		writeOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="is_restricted",
 * 		description="Is the User (default false) restricted from using the site?",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="enum",
 * 		enum={0, 1},
 * 		example=0,
 * 		default=0
 * 	),
 * 	@OA\Property(
 * 		property="created_by",
 * 		description="The User that created this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true,
 * 		default=1
 * 	),
 * 	@OA\Property(
 * 		property="updated_by",
 * 		description="The last User to update this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_by",
 * 		description="The User that softdeleted this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="created_at",
 * 		description="When the entry was created.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_at",
 * 		description="When the entry was last updated.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_at",
 * 		description="When the entry was softdeleted.  Null if not softdeleted.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	)
 * )
 * @OA\Schema (
 * 	schema="UserSuperSimple",
 * 	title="UserSuperSimpleSimple",
 * 	description="Attachable User object with no attachments or CUD data.",
 * 	@OA\Property(
 * 		property="persona_id",
 * 		description="ID of the User's Persona.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="email",
 * 		description="Unique email used to identify and communicate with the User.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="email",
 * 		example="nobody@nowhere.net",
 * 		maxLength=191
 * 	),
 * 	@OA\Property(
 * 		property="email_verified_at",
 * 		description="When the User email was verified, if at all",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="date-time",
 * 		example="2023-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="password",
 * 		description="Encoded password string.",
 * 		nullable=false,
 * 		type="string",
 * 		format="8-40 characters, at least 1 uppercase, at least 1 lowercase, both letters and numbers, not common",
 * 		example="$2y$10$SoNOPPci0zg2xqBzhvVQN.DvkHLqJEhLAxyqTz85UNzJBdLI9asdf",
 * 		writeOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="is_restricted",
 * 		description="Is the User (default false) restricted from using the site?",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="enum",
 * 		enum={0, 1},
 * 		example=0,
 * 		default=0
 * 	)
 * )
 * @OA\RequestBody (
 * 	request="User",
 * 	description="User object that needs to be added or updated.",
 * 	required=true,
 * 	@OA\MediaType(
 * 		mediaType="multipart/form-data",
 * 		@OA\Schema(ref="#/components/schemas/UserSimple")
 * 	)
 * )
 * @property int $id Model ID
 * @property int $persona_id The ID of the Persona associated with this User
 * @property string $email Unique email used to identify and communicate with the User
 * @property \Illuminate\Support\Carbon|null $email_verified_at When the User email was verified, if at all
 * @property string $password Encoded password string
 * @property string|null $remember_token Encoded string used to maintain login
 * @property string|null $api_token
 * @property bool $is_restricted Is (default false) the User restricted from using the site?
 * @property int $created_by
 * @property \Illuminate\Support\Carbon $created_at
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $deleted_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Account> $accountsCreated
 * @property-read int|null $accounts_created_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Account> $accountsDeleted
 * @property-read int|null $accounts_deleted_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Account> $accountsUpdated
 * @property-read int|null $accounts_updated_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Archetype> $archetypesCreated
 * @property-read int|null $archetypes_created_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Archetype> $archetypesDeleted
 * @property-read int|null $archetypes_deleted_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Archetype> $archetypesUpdated
 * @property-read int|null $archetypes_updated_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Attendance> $attendancesCreated
 * @property-read int|null $attendances_created_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Attendance> $attendancesDeleted
 * @property-read int|null $attendances_deleted_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Attendance> $attendancesUpdated
 * @property-read int|null $attendances_updated_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Award> $awardsCreated
 * @property-read int|null $awards_created_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Award> $awardsDeleted
 * @property-read int|null $awards_deleted_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Award> $awardsUpdated
 * @property-read int|null $awards_updated_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Chapter> $chaptersCreated
 * @property-read int|null $chapters_created_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Chapter> $chaptersDeleted
 * @property-read int|null $chapters_deleted_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Chapter> $chaptersUpdated
 * @property-read int|null $chapters_updated_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Chaptertype> $chaptertypesCreated
 * @property-read int|null $chaptertypes_created_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Chaptertype> $chaptertypesDeleted
 * @property-read int|null $chaptertypes_deleted_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Chaptertype> $chaptertypesUpdated
 * @property-read int|null $chaptertypes_updated_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Crat> $cratsCreated
 * @property-read int|null $crats_created_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Crat> $cratsDeleted
 * @property-read int|null $crats_deleted_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Crat> $cratsUpdated
 * @property-read int|null $crats_updated_count
 * @property-read User $createdBy
 * @property-read User $creator
 * @property-read User|null $deletedBy
 * @property-read User|null $destroyer
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Due> $duesCreated
 * @property-read int|null $dues_created_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Due> $duesDeleted
 * @property-read int|null $dues_deleted_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Due> $duesUpdated
 * @property-read int|null $dues_updated_count
 * @property-read User|null $editor
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Event> $eventsCreated
 * @property-read int|null $events_created_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Event> $eventsDeleted
 * @property-read int|null $events_deleted_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Event> $eventsUpdated
 * @property-read int|null $events_updated_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Guest> $guestsCreated
 * @property-read int|null $guests_created_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Guest> $guestsDeleted
 * @property-read int|null $guests_deleted_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Guest> $guestsUpdated
 * @property-read int|null $guests_updated_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Issuance> $issuancesCreated
 * @property-read int|null $issuances_created_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Issuance> $issuancesDeleted
 * @property-read int|null $issuances_deleted_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Issuance> $issuancesUpdated
 * @property-read int|null $issuances_updated_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Location> $locationsCreated
 * @property-read int|null $locations_created_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Location> $locationsDeleted
 * @property-read int|null $locations_deleted_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Location> $locationsUpdated
 * @property-read int|null $locations_updated_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Meetup> $meetupsCreated
 * @property-read int|null $meetups_created_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Meetup> $meetupsDeleted
 * @property-read int|null $meetups_deleted_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Meetup> $meetupsUpdated
 * @property-read int|null $meetups_updated_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Member> $membersCreated
 * @property-read int|null $members_created_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Member> $membersDeleted
 * @property-read int|null $members_deleted_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Member> $membersUpdated
 * @property-read int|null $members_updated_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Officer> $officersCreated
 * @property-read int|null $officers_created_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Officer> $officersDeleted
 * @property-read int|null $officers_deleted_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Officer> $officersUpdated
 * @property-read int|null $officers_updated_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Office> $officesCreated
 * @property-read int|null $offices_created_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Office> $officesDeleted
 * @property-read int|null $offices_deleted_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Office> $officesUpdated
 * @property-read int|null $offices_updated_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PasswordHistory> $passwordHistories
 * @property-read int|null $password_histories_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \App\Models\Persona $persona
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Persona> $personasCreated
 * @property-read int|null $personas_created_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Persona> $personasDeleted
 * @property-read int|null $personas_deleted_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Persona> $personasUpdated
 * @property-read int|null $personas_updated_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Pronoun> $pronounsCreated
 * @property-read int|null $pronouns_created_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Pronoun> $pronounsDeleted
 * @property-read int|null $pronouns_deleted_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Pronoun> $pronounsUpdated
 * @property-read int|null $pronouns_updated_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Realm> $realmsCreated
 * @property-read int|null $realms_created_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Realm> $realmsDeleted
 * @property-read int|null $realms_deleted_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Realm> $realmsUpdated
 * @property-read int|null $realms_updated_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Recommendation> $recommendationsCreated
 * @property-read int|null $recommendations_created_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Recommendation> $recommendationsDeleted
 * @property-read int|null $recommendations_deleted_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Recommendation> $recommendationsUpdated
 * @property-read int|null $recommendations_updated_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Reconciliation> $reconciliationsCreated
 * @property-read int|null $reconciliations_created_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Reconciliation> $reconciliationsDeleted
 * @property-read int|null $reconciliations_deleted_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Reconciliation> $reconciliationsUpdated
 * @property-read int|null $reconciliations_updated_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Reign> $reignsCreated
 * @property-read int|null $reigns_created_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Reign> $reignsDeleted
 * @property-read int|null $reigns_deleted_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Reign> $reignsUpdated
 * @property-read int|null $reigns_updated_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Social> $socialsCreated
 * @property-read int|null $socials_created_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Social> $socialsDeleted
 * @property-read int|null $socials_deleted_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Social> $socialsUpdated
 * @property-read int|null $socials_updated_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Split> $splitsCreated
 * @property-read int|null $splits_created_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Split> $splitsDeleted
 * @property-read int|null $splits_deleted_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Split> $splitsUpdated
 * @property-read int|null $splits_updated_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Suspension> $suspensionsCreated
 * @property-read int|null $suspensions_created_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Suspension> $suspensionsDeleted
 * @property-read int|null $suspensions_deleted_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Suspension> $suspensionsUpdated
 * @property-read int|null $suspensions_updated_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Title> $titlesCreated
 * @property-read int|null $titles_created_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Title> $titlesDeleted
 * @property-read int|null $titles_deleted_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Title> $titlesUpdated
 * @property-read int|null $titles_updated_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Tournament> $tournamentsCreated
 * @property-read int|null $tournaments_created_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Tournament> $tournamentsDeleted
 * @property-read int|null $tournaments_deleted_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Tournament> $tournamentsUpdated
 * @property-read int|null $tournaments_updated_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Transaction> $transactionsCreated
 * @property-read int|null $transactions_created_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Transaction> $transactionsDeleted
 * @property-read int|null $transactions_deleted_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Transaction> $transactionsUpdated
 * @property-read int|null $transactions_updated_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Unit> $unitsCreated
 * @property-read int|null $units_created_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Unit> $unitsDeleted
 * @property-read int|null $units_deleted_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Unit> $unitsUpdated
 * @property-read int|null $units_updated_count
 * @property-read User|null $updatedBy
 * @property-read \Illuminate\Database\Eloquent\Collection<int, User> $usersCreated
 * @property-read int|null $users_created_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, User> $usersDeleted
 * @property-read int|null $users_deleted_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, User> $usersUpdated
 * @property-read int|null $users_updated_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Waiver> $waiversCreated
 * @property-read int|null $waivers_created_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Waiver> $waiversDeleted
 * @property-read int|null $waivers_deleted_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Waiver> $waiversUpdated
 * @property-read int|null $waivers_updated_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereApiToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsRestricted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePersonaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User withoutTrashed()
 */
	class User extends \Eloquent implements \OwenIt\Auditing\Contracts\Auditable, \Illuminate\Contracts\Auth\MustVerifyEmail {}
}

namespace App\Models{
/**
 * App\Models\Waiver
 *
 * @OA\Schema (
 * 	schema="Waiver",
 * 	required={"waiverable_type","waiverable_id","player","signed_at"},
 * 	description="Digital storage of legal Waivers.<br>The following relationships can be attached, and in the case of plural relations, searched:
 * ageVerifiedBy (Persona) (BelongsTo): The Persona that verified the Waiver signer age, if it has been.
 * guests (Guest) (BelongsTo): The Guest this Waiver is for, if any.
 * location (Location) (BelongsTo): The Waiver address fields values.
 * persona (Persona) (BelongsTo): Persona this Waiver is for, if any.
 * pronoun (Pronoun) (BelongsTo): Pronoun for the individual being Waivered, if known.
 * createdBy (User) (BelongsTo): User that created it.
 * updatedBy (User) (BelongsTo): User that last updated it (if any).
 * deletedBy (User) (BelongsTo): User that deleted it (if any).",
 * 	@OA\Property(
 * 		property="id",
 * 		description="The entry's ID.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="guest_id",
 * 		description="The ID of the Guest this Waiver is for, if any.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="location_id",
 * 		description="The Waiver address fields values.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="pronoun_id",
 * 		description="The ID of the Pronoun for the individual being Waivered, if known.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="persona_id",
 * 		description="The ID of the Persona this Waiver is for, if any.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="waiverable_type",
 * 		description="The type of entity accepting the Waiver; Realm or Event.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="enum",
 * 		enum={"Realm","Event"},
 * 		example="Realm"
 * 	),
 * 	@OA\Property(
 * 		property="waiverable_id",
 * 		description="The ID of the entity accepting the Waiver.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="file",
 * 		description="An internal link to an image of the original physical Waiver.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="filename",
 * 		example="images/waivers/42.jpg",
 * 		maxLength=191
 * 	),
 * 	@OA\Property(
 * 		property="player",
 * 		description="The Waiver Mundane name field value.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="uppercase first letter",
 * 		example="John Smith",
 * 		maxLength=150
 * 	),
 * 	@OA\Property(
 * 		property="email",
 * 		description="The Waiver email field value, if any",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="email",
 * 		example="nobody@nowhere.net",
 * 		maxLength=255
 * 	),
 * 	@OA\Property(
 * 		property="phone",
 * 		description="The Waiver phone field value, if any",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		maxLength=25,
 * 		example="123-456-7890"
 * 	),
 * 	@OA\Property(
 * 		property="dob",
 * 		description="The Waiver date of birth field value.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="date",
 * 		example="2020-12-30"
 * 	),
 * 	@OA\Property(
 * 		property="age_verified_at",
 * 		description="The date the Waiver signer age is verified, if it has been.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="date",
 * 		example="2020-12-30"
 * 	),
 * 	@OA\Property(
 * 		property="age_verified_by",
 * 		description="The ID of the Persona that verified the Waiver signer age, if it has been.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="guardian",
 * 		description="The Waiver guardian name, if any.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="uppercase first letter",
 * 		example="Richard Smith"
 * 	),
 * 	@OA\Property(
 * 		property="emergency_name",
 * 		description="The Waiver emergency contact field, if any.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="uppercase first letter",
 * 		example="Becky Smith"
 * 	),
 * 	@OA\Property(
 * 		property="emergency_relationship",
 * 		description="The Waiver emergency contact relationship field, if any.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="uppercase first letter",
 * 		example="Mom"
 * 	),
 * 	@OA\Property(
 * 		property="emergency_phone",
 * 		description="The Waiver emergency contact phone field, if any.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		maxLength=25,
 * 		example="123-456-7890"
 * 	),
 * 	@OA\Property(
 * 		property="signed_at",
 * 		description="Date the Waiver was signed.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="date",
 * 		example="2020-12-30"
 * 	),
 * 	@OA\Property(
 * 		property="created_by",
 * 		description="The User that created this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true,
 * 		default=1
 * 	),
 * 	@OA\Property(
 * 		property="createdBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_by",
 * 		description="The last User to update this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updatedBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_by",
 * 		description="The User that softdeleted this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deletedBy",
 * 		type="object",
 * 		ref="#/components/schemas/UserSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="created_at",
 * 		description="When the entry was created.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_at",
 * 		description="When the entry was last updated.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_at",
 * 		description="When the entry was softdeleted.  Null if not softdeleted.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="ageVerifiedBy",
 * 		type="object",
 * 		description="Attachable Persona the Waiver is for.",
 * 		ref="#/components/schemas/PersonaSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="guest",
 * 		type="object",
 * 		description="Attachable Guest this Waiver is for.",
 * 		ref="#/components/schemas/GuestSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="location",
 * 		type="object",
 * 		description="Attachable Waiver address fields values.",
 * 		ref="#/components/schemas/LocationSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="persona",
 * 		type="object",
 * 		description="Attachable Persona this Waiver is for, if any.",
 * 		ref="#/components/schemas/PersonaSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="pronoun",
 * 		type="object",
 * 		description="Attachable Pronoun for the individual being Waivered.",
 * 		ref="#/components/schemas/PronounSimple",
 * 		readOnly=true
 * 	)
 * )
 * @OA\Schema (
 * 	schema="WaiverSimple",
 * 	title="WaiverSimple",
 * 	description="Attachable Waiver object with no attachments.",
 * 	@OA\Property(
 * 		property="id",
 * 		description="The entry's ID.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="guest_id",
 * 		description="The ID of the Guest this Waiver is for, if any.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="location_id",
 * 		description="The Waiver address fields values.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="pronoun_id",
 * 		description="The ID of the Pronoun for the individual being Waivered, if known.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="persona_id",
 * 		description="The ID of the Persona this Waiver is for, if any.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="waiverable_type",
 * 		description="The type of entity accepting the Waiver; Realm or Event.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="enum",
 * 		enum={"Realm","Event"},
 * 		example="Realm"
 * 	),
 * 	@OA\Property(
 * 		property="waiverable_id",
 * 		description="The ID of the entity accepting the Waiver.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="file",
 * 		description="An internal link to an image of the original physical Waiver.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="filename",
 * 		example="images/waivers/42.jpg",
 * 		maxLength=191
 * 	),
 * 	@OA\Property(
 * 		property="player",
 * 		description="The Waiver Mundane name field value.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="uppercase first letter",
 * 		example="John Smith",
 * 		maxLength=150
 * 	),
 * 	@OA\Property(
 * 		property="email",
 * 		description="The Waiver email field value, if any",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="email",
 * 		example="nobody@nowhere.net",
 * 		maxLength=255
 * 	),
 * 	@OA\Property(
 * 		property="phone",
 * 		description="The Waiver phone field value, if any",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		maxLength=25,
 * 		example="123-456-7890"
 * 	),
 * 	@OA\Property(
 * 		property="dob",
 * 		description="The Waiver date of birth field value.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="date",
 * 		example="2020-12-30"
 * 	),
 * 	@OA\Property(
 * 		property="age_verified_at",
 * 		description="The date the Waiver signer age is verified, if it has been.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="date",
 * 		example="2020-12-30"
 * 	),
 * 	@OA\Property(
 * 		property="age_verified_by",
 * 		description="The ID of the Persona that verified the Waiver signer age, if it has been.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="guardian",
 * 		description="The Waiver guardian name, if any.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="uppercase first letter",
 * 		example="Richard Smith"
 * 	),
 * 	@OA\Property(
 * 		property="emergency_name",
 * 		description="The Waiver emergency contact field, if any.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="uppercase first letter",
 * 		example="Becky Smith"
 * 	),
 * 	@OA\Property(
 * 		property="emergency_relationship",
 * 		description="The Waiver emergency contact relationship field, if any.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="uppercase first letter",
 * 		example="Mom"
 * 	),
 * 	@OA\Property(
 * 		property="emergency_phone",
 * 		description="The Waiver emergency contact phone field, if any.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		maxLength=25,
 * 		example="123-456-7890"
 * 	),
 * 	@OA\Property(
 * 		property="signed_at",
 * 		description="Date the Waiver was signed.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="date",
 * 		example="2020-12-30"
 * 	),
 * 	@OA\Property(
 * 		property="created_by",
 * 		description="The User that created this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true,
 * 		default=1
 * 	),
 * 	@OA\Property(
 * 		property="updated_by",
 * 		description="The last User to update this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_by",
 * 		description="The User that softdeleted this record.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="created_at",
 * 		description="When the entry was created.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="updated_at",
 * 		description="When the entry was last updated.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="deleted_at",
 * 		description="When the entry was softdeleted.  Null if not softdeleted.",
 * 		type="string",
 * 		format="date-time",
 * 		example="2020-12-30 23:59:59",
 * 		readOnly=true
 * 	)
 * )
 * @OA\Schema (
 * 	schema="WaiverSuperSimple",
 * 	title="WaiverSuperSimpleSimple",
 * 	description="Attachable Waiver object with no attachments or CUD data.",
 * 	@OA\Property(
 * 		property="id",
 * 		description="The entry's ID.",
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="guest_id",
 * 		description="The ID of the Guest this Waiver is for, if any.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="location_id",
 * 		description="The Waiver address fields values.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="pronoun_id",
 * 		description="The ID of the Pronoun for the individual being Waivered, if known.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="persona_id",
 * 		description="The ID of the Persona this Waiver is for, if any.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="waiverable_type",
 * 		description="The type of entity accepting the Waiver; Realm or Event.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="enum",
 * 		enum={"Realm","Event"},
 * 		example="Realm"
 * 	),
 * 	@OA\Property(
 * 		property="waiverable_id",
 * 		description="The ID of the entity accepting the Waiver.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="file",
 * 		description="An internal link to an image of the original physical Waiver.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="filename",
 * 		example="images/waivers/42.jpg",
 * 		maxLength=191
 * 	),
 * 	@OA\Property(
 * 		property="player",
 * 		description="The Waiver Mundane name field value.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="uppercase first letter",
 * 		example="John Smith",
 * 		maxLength=150
 * 	),
 * 	@OA\Property(
 * 		property="email",
 * 		description="The Waiver email field value, if any",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="email",
 * 		example="nobody@nowhere.net",
 * 		maxLength=255
 * 	),
 * 	@OA\Property(
 * 		property="phone",
 * 		description="The Waiver phone field value, if any",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		maxLength=25,
 * 		example="123-456-7890"
 * 	),
 * 	@OA\Property(
 * 		property="dob",
 * 		description="The Waiver date of birth field value.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="date",
 * 		example="2020-12-30"
 * 	),
 * 	@OA\Property(
 * 		property="age_verified_at",
 * 		description="The date the Waiver signer age is verified, if it has been.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="date",
 * 		example="2020-12-30"
 * 	),
 * 	@OA\Property(
 * 		property="age_verified_by",
 * 		description="The ID of the Persona that verified the Waiver signer age, if it has been.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="guardian",
 * 		description="The Waiver guardian name, if any.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="uppercase first letter",
 * 		example="Richard Smith"
 * 	),
 * 	@OA\Property(
 * 		property="emergency_name",
 * 		description="The Waiver emergency contact field, if any.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="uppercase first letter",
 * 		example="Becky Smith"
 * 	),
 * 	@OA\Property(
 * 		property="emergency_relationship",
 * 		description="The Waiver emergency contact relationship field, if any.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		format="uppercase first letter",
 * 		example="Mom"
 * 	),
 * 	@OA\Property(
 * 		property="emergency_phone",
 * 		description="The Waiver emergency contact phone field, if any.",
 * 		readOnly=false,
 * 		nullable=true,
 * 		type="string",
 * 		maxLength=25,
 * 		example="123-456-7890"
 * 	),
 * 	@OA\Property(
 * 		property="signed_at",
 * 		description="Date the Waiver was signed.",
 * 		readOnly=false,
 * 		nullable=false,
 * 		type="string",
 * 		format="date",
 * 		example="2020-12-30"
 * 	)
 * )
 * @OA\RequestBody (
 * 	request="Waiver",
 * 	description="Waiver object that needs to be added or updated.",
 * 	required=true,
 * 	@OA\MediaType(
 * 		mediaType="multipart/form-data",
 * 		@OA\Schema(ref="#/components/schemas/WaiverSimple")
 * 	)
 * )
 * @property int $id Model ID
 * @property int|null $guest_id The ID of the Guest this Waiver is for, if any
 * @property int|null $location_id The Waiver address fields values
 * @property int|null $pronoun_id The ID of the Pronoun for the individual being Waivered, if known
 * @property int|null $persona_id The ID of the Persona this Waiver is for, if any
 * @property string $waiverable_type The type of entity accepting the Waiver; Realm or Event
 * @property int $waiverable_id The ID of the entity accepting the Waiver
 * @property string|null $file An internal link to an image of the original physical Waiver
 * @property string $player The Waiver Mundane name field value
 * @property string|null $email The Waiver email field value, if any
 * @property string|null $phone The Waiver phone field value, if any
 * @property \Illuminate\Support\Carbon|null $dob The Waiver date of birth field value
 * @property \Illuminate\Support\Carbon|null $age_verified_at The date the Waiver signer age is verified, if it has been
 * @property int|null $age_verified_by The ID of the Persona that verified the Waiver signer age, if it has been
 * @property string|null $guardian The Waiver guardian name, if any
 * @property string|null $emergency_name The Waiver emergency contact field, if any
 * @property string|null $emergency_relationship The Waiver emergency contact relationship field, if any
 * @property string|null $emergency_phone The Waiver emergency contact phone field, if any
 * @property \Illuminate\Support\Carbon $signed_at Date the Waiver was signed
 * @property int $created_by
 * @property \Illuminate\Support\Carbon $created_at
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $deleted_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Persona|null $ageVerifiedBy
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\User $createdBy
 * @property-read \App\Models\User $creator
 * @property-read \App\Models\User|null $deletedBy
 * @property-read \App\Models\User|null $destroyer
 * @property-read \App\Models\User|null $editor
 * @property-read \App\Models\Persona|null $guest
 * @property-read \App\Models\Location|null $location
 * @property-read \App\Models\Persona|null $persona
 * @property-read \App\Models\Pronoun|null $pronoun
 * @property-read \App\Models\User|null $updatedBy
 * @method static \Database\Factories\WaiverFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Waiver newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Waiver newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Waiver onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Waiver query()
 * @method static \Illuminate\Database\Eloquent\Builder|Waiver whereAgeVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Waiver whereAgeVerifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Waiver whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Waiver whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Waiver whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Waiver whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Waiver whereDob($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Waiver whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Waiver whereEmergencyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Waiver whereEmergencyPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Waiver whereEmergencyRelationship($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Waiver whereFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Waiver whereGuardian($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Waiver whereGuestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Waiver whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Waiver whereLocationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Waiver wherePersonaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Waiver wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Waiver wherePlayer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Waiver wherePronounId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Waiver whereSignedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Waiver whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Waiver whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Waiver whereWaiverableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Waiver whereWaiverableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Waiver withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Waiver withoutTrashed()
 */
	class Waiver extends \Eloquent {}
}

