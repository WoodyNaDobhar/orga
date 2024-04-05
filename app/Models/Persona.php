<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Wildside\Userstamps\Userstamps;
use App\Traits\ProtectFieldsTrait;
use Laravel\Scout\Searchable;

/**
 * @OA\Schema(
 *		schema="Persona",
 *		required={"chapter_id","name","is_active"},
 *		description="Members of Amtgard.<br>The following relationships can be attached, and in the case of plural relations, searched:
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
 *		@OA\Property(
 *			property="id",
 *			description="The entry's ID.",
 *			type="integer",
 *			format="int32",
 *			example=42,
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="chapter_id",
 *			description="The ID of the Chapter the Persona is Waivered at.",
 *			readOnly=false,
 *			nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="pronoun_id",
 *			description="The ID of the pronouns associated with this Persona, if known.",
 *			readOnly=false,
 *			nullable=true,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="mundane",
 *			description="What the Persona typically enters into the Mundane field of the sign-in.",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="uppercase first letter",
 *			example="John Smith",
 *			maxLength=191
 *		),
 *		@OA\Property(
 *			property="name",
 *			description="The Persona name, without titles or honors, but otherwise in full.",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="uppercase first letter",
 *			example="Color Animal",
 *			maxLength=191
 *		),
 *		@OA\Property(
 *			property="heraldry",
 *			description="An internal link to an image of the Persona heraldry.",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="filename",
 *			example="images/personaHeraldries/42.jpg",
 *			maxLength=191
 *		),
 *		@OA\Property(
 *			property="image",
 *			description="An internal link to an image of the Persona",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="filename",
 *			example="images/personas/42.jpg",
 *			maxLength=191
 *		),
 *		@OA\Property(
 *			property="is_active",
 *			description="Is (default true) the Persona still active?",
 *			readOnly=false,
 *			nullable=false,
 *			type="integer",
 *			format="enum",
 *			enum={0, 1},
 *			example=0,
 *			default=1
 *		),
 *		@OA\Property(
 *			property="reeve_qualified_expires_at",
 *			description="If they are Reeve Qualified, when it expires.",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="date",
 *			example="2020-12-30"
 *		),
 *		@OA\Property(
 *			property="corpora_qualified_expires_at",
 *			description="If they are Corpora Qualified, when it expires.",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="date",
 *			example="2020-12-30"
 *		),
 *		@OA\Property(
 *			property="joined_chapter_at",
 *			description="The date the Persona joined the Chapter, either as a newb or a transfer.",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="date",
 *			example="2020-12-30"
 *		),
 *		@OA\Property(
 *			property="chapter_full_abbreviation",
 *			description="A short abbreviation of the Persona's Chapter name, along with the Realm abbreviation in the format XX/XX.",
 *			readOnly=true,
 *			nullable=false,
 *			type="string",
 *			format="uppercase",
 *			maxLength=7,
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
 *			property="attendances",
 *			description="Attachable & filterable array of Attendances for the Persona.",
 *			type="array",
 *			@OA\Items(
 *				title="Attendance",
 *				type="object",
 *				ref="#/components/schemas/AttendanceSimple"
 *			),
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="awards",
 *			description="Attachable & filterable array of Issuances received by the Persona.",
 *			type="array",
 *			@OA\Items(
 *				title="Issuance",
 *				type="object",
 *				ref="#/components/schemas/IssuanceSimple"
 *			),
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="chapter",
 *			type="object",
 *			description="Attachable Chapter the Persona calls home.",
 *			ref="#/components/schemas/ChapterSimple",
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="crats",
 *			description="Attachable & filterable array of Crat positions held by the Persona.",
 *			type="array",
 *			@OA\Items(
 *				title="Crat",
 *				type="object",
 *				ref="#/components/schemas/CratSimple"
 *			),
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="dues",
 *			description="Attachable & filterable array of Dues paid by the Persona.",
 *			type="array",
 *			@OA\Items(
 *				title="Due",
 *				type="object",
 *				ref="#/components/schemas/OfficerSimple"
 *			),
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="events",
 *			description="Attachable & filterable array of Events sponsored by the Persona.",
 *			type="array",
 *			@OA\Items(
 *				title="Event",
 *				type="object",
 *				ref="#/components/schemas/EventSimple"
 *			),
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="issuanceGivens",
 *			description="Attachable & filterable array of Issuances made by the Persona, typically retainer and squire Titles.",
 *			type="array",
 *			@OA\Items(
 *				title="Issuance",
 *				type="object",
 *				ref="#/components/schemas/IssuanceSimple"
 *			),
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="issuanceRevokeds",
 *			description="Attachable & filterable array of Issuances revoked by the Persona.",
 *			type="array",
 *			@OA\Items(
 *				title="Issuance",
 *				type="object",
 *				ref="#/components/schemas/IssuanceSimple"
 *			),
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="issuanceSigneds",
 *			description="Attachable & filterable array of Issuances signed by the Persona.",
 *			type="array",
 *			@OA\Items(
 *				title="Issuance",
 *				type="object",
 *				ref="#/components/schemas/IssuanceSimple"
 *			),
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="members",
 *			description="Attachable & filterable array of Memberships in Units the Persona has had.",
 *			type="array",
 *			@OA\Items(
 *				title="Member",
 *				type="object",
 *				ref="#/components/schemas/MemberSimple"
 *			),
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="officers",
 *			description="Attachable & filterable array of Officer positions held by the Persona.",
 *			type="array",
 *			@OA\Items(
 *				title="Officer",
 *				type="object",
 *				ref="#/components/schemas/OfficerSimple"
 *			),
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="pronoun",
 *			type="object",
 *			description="Attachable selected pronouns for the Persona.",
 *			ref="#/components/schemas/PronounSimple",
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="recommendations",
 *			description="Attachable & filterable array of Issuance Recommendations made for this Persona.",
 *			type="array",
 *			@OA\Items(
 *				title="Recommendation",
 *				type="object",
 *				ref="#/components/schemas/RecommendationSimple"
 *			),
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="reconciliations",
 *			description="Attachable & filterable array of Credit reconciliations for this Persona.",
 *			type="array",
 *			@OA\Items(
 *				title="Reconciliation",
 *				type="object",
 *				ref="#/components/schemas/ReconciliationSimple"
 *			),
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="splits",
 *			description="Attachable & filterable array of Splits this Persona took part in.",
 *			type="array",
 *			@OA\Items(
 *				title="Split",
 *				type="object",
 *				ref="#/components/schemas/SplitSimple"
 *			),
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="socials",
 *			description="Attachable & filterable array of the Socials of the Persona.",
 *			type="array",
 *			@OA\Items(
 *				title="Social",
 *				type="object",
 *				ref="#/components/schemas/SocialSimple"
 *			),
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="suspensions",
 *			description="Attachable & filterable array of Suspensions the Persona has undergone.",
 *			type="array",
 *			@OA\Items(
 *				title="Suspension",
 *				type="object",
 *				ref="#/components/schemas/SuspensionSimple"
 *			),
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="suspensionIssueds",
 *			description="Attachable & filterable array of Suspensions the Persona has issued.",
 *			type="array",
 *			@OA\Items(
 *				title="Suspension",
 *				type="object",
 *				ref="#/components/schemas/SuspensionSimple"
 *			),
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="titles",
 *			description="Attachable & filterable array of Title Issuances received by the Persona.",
 *			type="array",
 *			@OA\Items(
 *				title="Issuance",
 *				type="object",
 *				ref="#/components/schemas/IssuanceSimple"
 *			),
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="titleIssuables",
 *			description="Attachable & filterable array of the Titles the Persona can Issue.",
 *			type="array",
 *			@OA\Items(
 *				title="Title",
 *				type="object",
 *				ref="#/components/schemas/TitleSimple"
 *			),
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="units",
 *			description="Attachable & filterable array of the Companies and Households the Persona is in.",
 *			type="array",
 *			@OA\Items(
 *				title="Unit",
 *				type="object",
 *				ref="#/components/schemas/UnitSimple"
 *			),
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="user",
 *			type="object",
 *			description="Attachable User for the Persona.",
 *			ref="#/components/schemas/UserSimple",
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="waivers",
 *			description="Attachable & filterable array of Waivers for the Persona.",
 *			type="array",
 *			@OA\Items(
 *				title="Waiver",
 *				type="object",
 *				ref="#/components/schemas/WaiverSimple"
 *			),
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="waiverVerifieds",
 *			description="Attachable & filterable array of Waivers age verified by the Persona.",
 *			type="array",
 *			@OA\Items(
 *				title="Waiver",
 *				type="object",
 *				ref="#/components/schemas/WaiverSimple"
 *			),
 *			readOnly=true
 *		)
 * )
 *	@OA\Schema(
 *		schema="PersonaSimple",
 *		title="PersonaSimple",
 *		description="Attachable Persona object with no attachments.",
 *		@OA\Property(
 *			property="id",
 *			description="The entry's ID.",
 *			type="integer",
 *			format="int32",
 *			example=42,
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="chapter_id",
 *			description="The ID of the Chapter the Persona is Waivered at.",
 *			readOnly=false,
 *			nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="pronoun_id",
 *			description="The ID of the pronouns associated with this Persona, if known.",
 *			readOnly=false,
 *			nullable=true,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="mundane",
 *			description="What the Persona typically enters into the Mundane field of the sign-in.",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="uppercase first letter",
 *			example="John Smith",
 *			maxLength=191
 *		),
 *		@OA\Property(
 *			property="name",
 *			description="The Persona name, without titles or honors, but otherwise in full.",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="uppercase first letter",
 *			example="Color Animal",
 *			maxLength=191
 *		),
 *		@OA\Property(
 *			property="heraldry",
 *			description="An internal link to an image of the Persona heraldry.",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="filename",
 *			example="images/personaHeraldries/42.jpg",
 *			maxLength=191
 *		),
 *		@OA\Property(
 *			property="image",
 *			description="An internal link to an image of the Persona",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="filename",
 *			example="images/personas/42.jpg",
 *			maxLength=191
 *		),
 *		@OA\Property(
 *			property="is_active",
 *			description="Is (default true) the Persona still active?",
 *			readOnly=false,
 *			nullable=false,
 *			type="integer",
 *			format="enum",
 *			enum={0, 1},
 *			example=0,
 *			default=1
 *		),
 *		@OA\Property(
 *			property="reeve_qualified_expires_at",
 *			description="If they are Reeve Qualified, when it expires.",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="date",
 *			example="2020-12-30"
 *		),
 *		@OA\Property(
 *			property="corpora_qualified_expires_at",
 *			description="If they are Corpora Qualified, when it expires.",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="date",
 *			example="2020-12-30"
 *		),
 *		@OA\Property(
 *			property="joined_chapter_at",
 *			description="The date the Persona joined the Chapter, either as a newb or a transfer.",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="date",
 *			example="2020-12-30"
 *		),
 *		@OA\Property(
 *			property="chapter_full_abbreviation",
 *			description="A short abbreviation of the Persona's Chapter name, along with the Realm abbreviation in the format XX/XX.",
 *			readOnly=true,
 *			nullable=false,
 *			type="string",
 *			format="uppercase",
 *			maxLength=7,
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
 *		schema="PersonaSuperSimple",
 *		title="PersonaSuperSimpleSimple",
 *		description="Attachable Persona object with no attachments or CUD data.",
 *		@OA\Property(
 *			property="id",
 *			description="The entry's ID.",
 *			type="integer",
 *			format="int32",
 *			example=42,
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="chapter_id",
 *			description="The ID of the Chapter the Persona is Waivered at.",
 *			readOnly=false,
 *			nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="pronoun_id",
 *			description="The ID of the pronouns associated with this Persona, if known.",
 *			readOnly=false,
 *			nullable=true,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="mundane",
 *			description="What the Persona typically enters into the Mundane field of the sign-in.",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="uppercase first letter",
 *			example="John Smith",
 *			maxLength=191
 *		),
 *		@OA\Property(
 *			property="name",
 *			description="The Persona name, without titles or honors, but otherwise in full.",
 *			readOnly=false,
 *			nullable=false,
 *			type="string",
 *			format="uppercase first letter",
 *			example="Color Animal",
 *			maxLength=191
 *		),
 *		@OA\Property(
 *			property="heraldry",
 *			description="An internal link to an image of the Persona heraldry.",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="filename",
 *			example="images/personaHeraldries/42.jpg",
 *			maxLength=191
 *		),
 *		@OA\Property(
 *			property="image",
 *			description="An internal link to an image of the Persona",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="filename",
 *			example="images/personas/42.jpg",
 *			maxLength=191
 *		),
 *		@OA\Property(
 *			property="is_active",
 *			description="Is (default true) the Persona still active?",
 *			readOnly=false,
 *			nullable=false,
 *			type="integer",
 *			format="enum",
 *			enum={0, 1},
 *			example=0,
 *			default=1
 *		),
 *		@OA\Property(
 *			property="reeve_qualified_expires_at",
 *			description="If they are Reeve Qualified, when it expires.",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="date",
 *			example="2020-12-30"
 *		),
 *		@OA\Property(
 *			property="corpora_qualified_expires_at",
 *			description="If they are Corpora Qualified, when it expires.",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="date",
 *			example="2020-12-30"
 *		),
 *		@OA\Property(
 *			property="joined_chapter_at",
 *			description="The date the Persona joined the Chapter, either as a newb or a transfer.",
 *			readOnly=false,
 *			nullable=true,
 *			type="string",
 *			format="date",
 *			example="2020-12-30"
 *		),
 *		@OA\Property(
 *			property="chapter_full_abbreviation",
 *			description="A short abbreviation of the Persona's Chapter name, along with the Realm abbreviation in the format XX/XX.",
 *			readOnly=true,
 *			nullable=false,
 *			type="string",
 *			format="uppercase",
 *			maxLength=7,
 *		)
 *	)
 *	@OA\RequestBody(
 *		request="Persona",
 *		description="Persona object that needs to be added or updated.",
 *		required=true,
 *		@OA\MediaType(
 *			mediaType="multipart/form-data",
 *			@OA\Schema(ref="#/components/schemas/PersonaSimple")
 *		)
 *	)
 */

class Persona extends BaseModel
{
	use SoftDeletes;
	use HasFactory;
	use Userstamps;
	use ProtectFieldsTrait;
	use Notifiable;
	use Searchable;

	public $table = 'personas';
	public $timestamps = true;
	
	protected $dates = ['created_at', 'updated_at', 'deleted_at'];
	protected $protectedFields = [];
	protected $email = null;

	public $fillable = [
		  'chapter_id',
		  'user_id',
		  'pronoun_id',
		  'mundane',
		  'name',
		  'heraldry',
		  'image',
		  'is_active',
		  'reeve_qualified_expires_at',
		  'corpora_qualified_expires_at',
		  'joined_chapter_at'
	];

	protected $casts = [
		  'mundane' => 'string',
		  'name' => 'string',
		  'heraldry' => 'string',
		  'image' => 'string',
		  'is_active' => 'boolean',
		  'reeve_qualified_expires_at' => 'date',
		  'corpora_qualified_expires_at' => 'date',
		  'joined_chapter_at' => 'date'
	];
	
	public function toSearchableArray(): array
	{
		return [
			'id' => $this->id,
			'name' => $this->name,
			'mundane' => $this->mundane
		];
	}

	public static array $rules = [
		'chapter_id' => 'required|exists:chapters,id',
		'pronoun_id' => 'nullable|exists:pronouns,id',
		'mundane' => 'nullable|string|max:191',
		'name' => 'required|string|max:191',
		'heraldry' => 'nullable|string|max:191',
		'image' => 'nullable|string|max:191',
		'is_active' => 'required|boolean',
		'reeve_qualified_expires_at' => 'nullable|date',
		'corpora_qualified_expires_at' => 'nullable|date',
		'joined_chapter_at' => 'nullable|date'
	];
	
	public $relationships = [
		'attendances' => 'HasMany',
		'awards' => 'MorphMany',
		'chapter' => 'BelongsTo',
		'crats' => 'HasMany',
		'dues' => 'HasMany',
		'events' => 'MorphMany',
		'issuanceGivens' => 'MorphMany',
		'issuanceRevokeds' => 'HasMany',
		'issuanceSigneds' => 'HasMany',
		'members' => 'HasMany',
		'officers' => 'HasMany',
		'pronoun' => 'BelongsTo',
		'recommendations' => 'HasMany',
		'reconciliations' => 'HasMany',
		'socials' => 'MorphMany',
		'splits' => 'HasMany',
		'suspensions' => 'HasMany',
		'suspensionIssueds' => 'HasMany',
		'titles' => 'MorphMany',
		'titleIssuables' => 'MorphMany',
		'units' => 'HasManyThrough',
		'user' => 'HasOne',
		'waivers' => 'HasMany',
		'waiverVerifieds' => 'HasMany'
	];
	
	protected $appends = [
		'chapter_full_abbreviation'
	];
	
	protected function chapterFullAbbreviation(): Attribute
	{
		return Attribute::make(
			get: fn () => $this->chapter->full_abbreviation,
		);
	}
	
	protected function heraldry(): Attribute
	{
		return Attribute::make(
			get: function (?string $value) {
				if ($value === null) {
					return null;
				}
				return 'https://ork.amtgard.com/assets/players/heraldry/' . $value;
			}
		);
	}
	
	protected function image(): Attribute
	{
		return Attribute::make(
			get: function (?string $value) {
				if ($value === null) {
					return null;
				}
				return 'https://ork.amtgard.com/assets/players/' . $value;
			}
		);
	}
	
	public function attendances(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Attendance::class, 'persona_id');
	}
	
	public function awards(): \Illuminate\Database\Eloquent\Relations\MorphMany
	{
		return $this->morphMany(Issuance::class, 'recipient')->where('issuable_type', 'Award');
	}
	
	public function chapter(): \Illuminate\Database\Eloquent\Relations\BelongsTo
	{
		return $this->belongsTo(\App\Models\Chapter::class, 'chapter_id');
	}
	
	public function crats(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Crat::class, 'persona_id');
	}
	
	public function dues(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Due::class, 'persona_id');
	}
	
	public function events(): \Illuminate\Database\Eloquent\Relations\MorphMany
	{
		return $this->morphMany(Event::class, 'eventable');
	}
	
	public function issuanceGivens(): \Illuminate\Database\Eloquent\Relations\MorphMany
	{
		return $this->morphMany(Issuance::class, 'issuer');
	}
	
	public function issuanceRevokeds(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Issuance::class, 'revoked_by');
	}
	
	public function issuanceSigneds(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Issuance::class, 'signator_id');
	}
	
	public function members(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Member::class, 'persona_id');
	}
	
	public function officers(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Officer::class, 'persona_id');
	}
	
	public function pronoun(): \Illuminate\Database\Eloquent\Relations\BelongsTo
	{
		return $this->belongsTo(\App\Models\Pronoun::class, 'pronoun_id');
	}
	
	public function recommendations(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Recommendation::class, 'persona_id');
	}
	
	public function reconciliations(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Reconciliation::class, 'persona_id');
	}
	
	public function socials(): \Illuminate\Database\Eloquent\Relations\MorphMany
	{
		return $this->morphMany(Social::class, 'sociable');
	}
	
	public function splits(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Split::class, 'persona_id');
	}
	
	public function suspensions(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Suspension::class, 'persona_id');
	}
	
	public function suspensionIssueds(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Suspension::class, 'suspended_by');
	}
	
	public function titles(): \Illuminate\Database\Eloquent\Relations\MorphMany
	{
		return $this->morphMany(Issuance::class, 'recipient')->where('issuable_type', 'Title');
	}
	
	public function titleIssuables(): \Illuminate\Database\Eloquent\Relations\MorphMany
	{
		return $this->morphMany(Title::class, 'titleable');
	}
	
	public function units(): \Illuminate\Database\Eloquent\Relations\hasManyThrough
	{
		return $this->hasManyThrough(\App\Models\Unit::class, \App\Models\Member::class, 'persona_id');
	}
	
	public function user(): \Illuminate\Database\Eloquent\Relations\HasOne
	{
		return $this->hasOne(User::class);
	}
	
	public function waivers(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Waiver::class, 'persona_id');
	}
	
	public function waiverVerifieds(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Waiver::class, 'age_verified_by');
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
