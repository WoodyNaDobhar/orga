<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Wildside\Userstamps\Userstamps;
use App\Traits\ProtectFieldsTrait;
use Carbon\Carbon;
use Laravel\Scout\Searchable;
use App\Policies\IssuancePolicy;

/**
 * @OA\Schema (
 * 	schema="Persona",
 * 	required={"chapter_id","name","is_active"},
 * 	description="Members of Amtgard.<br>The following relationships can be attached, and in the case of plural relations, searched:
 * attendances (Attendance) (HasMany): Attendances for the Persona.
 * awardIssuances (Issuance) {MorphMany): Award Issuances received by the Persona.
 * chapter (Chapter) (BelongsTo): Chapter the Persona calls home.
 * crats (Crat) (HasMany): Crat positions held by the Persona.
 * dues (Due) (HasMany): Dues paid by the Persona.
 * events (Event) (MorphMany): Events sponsored by the Persona.
 * honorific (Issuance) {BelongsTo): The ID of the Title Issuance the Persona considers primary of the Titles they have.<br>
 * issuances (Issuance) {MorphMany): All Issuances received by the Persona.
 * issuanceGivens (Issuance) {MorphMany): Issuances made by the Persona, typically retainer and squire Titles.
 * issuanceRevokeds (Issuance) {MorphMany): Issuances revoked by the Persona.
 * issuanceSigneds (Issuance) {MorphMany): Issuances signed by the Persona.
 * memberships (Member) (HasMany): Memberships in Units the Persona has had.
 * officers (Officer) (HasMany): Officer positions held by the Persona.
 * pronoun (Pronoun) (BelongsTo): Prefered selected pronouns for the Persona.
 * recommendations (Recommendation) (HasMany): Issuance Recommendations made for this Persona.
 * reconciliations (Reconciliation) (HasMany): Credit reconciliations for this Persona.
 * socials (Social) (MorphMany): Socials for the Persona.
 * splits (Split) (HasMany): Splits this Persona took part in.
 * suspensions (Suspension) (HasMany): Suspensions the Persona has undergone.
 * suspensionIssueds (Suspension) (HasMany): Suspensions the Persona has issued.
 * titleIssuances (Issuance) {MorphMany): Title Issuances received by the Persona.
 * titles (Title) {hasManyThrough): Titles received by the Persona.
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
 * 		property="honorific_id",
 * 		description="The ID of the Title Issuance the Persona considers primary of the Titles they have.",
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
 * 		property="is_officer",
 * 		description="Is the Persona an Officer?",
 * 		readOnly=true,
 * 		type="integer",
 * 		format="enum",
 * 		enum={0, 1},
 * 		example=0
 * 	),
 * 	@OA\Property(
 * 		property="is_paid",
 * 		description="Is the Persona Dues paid?",
 * 		readOnly=true,
 * 		type="integer",
 * 		format="enum",
 * 		enum={0, 1},
 * 		example=0
 * 	),
 * 	@OA\Property(
 * 		property="is_suspended",
 * 		description="Is the Persona suspended?",
 * 		readOnly=true,
 * 		type="integer",
 * 		format="enum",
 * 		enum={0, 1},
 * 		example=0
 * 	),
 * 	@OA\Property(
 * 		property="is_waivered",
 * 		description="Is the Persona waivered?",
 * 		readOnly=true,
 * 		type="integer",
 * 		format="enum",
 * 		enum={0, 1},
 * 		example=0
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
 * 		property="awards",
 * 		description="An array of this Persona's Awards with their Issuances.",
 * 		type="object",
 * 		ref="#/components/schemas/AwardsReport",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="chapter_full_abbreviation",
 * 		description="A short abbreviation of the Persona's Chapter name, along with the Realm abbreviation in the format XX/XX.",
 * 		readOnly=true,
 * 		nullable=false,
 * 		type="string",
 * 		format="uppercase",
 * 		maxLength=7,
 * 	),
 * 	@OA\Property(
 * 		property="credits",
 * 		description="A count of the Persona's Credits.",
 * 		type="object",
 * 		ref="#/components/schemas/CreditReport",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="score",
 * 		description="An open ended scoring of a Persona's entire Amtgard record from 0-infinity.",
 * 		readOnly=true,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
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
 * 		property="awardIssuances",
 * 		description="Attachable & filterable array of Award Issuances received by the Persona.",
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
 * 		property="honorific",
 * 		type="object",
 * 		description="Attachable ID of the Title Issuance the Persona considers primary of the Titles they have.",
 * 		ref="#/components/schemas/IssuanceSimple",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="issuances",
 * 		description="Attachable & filterable array of all Issuances received by the Persona.",
 * 		type="array",
 * 		@OA\Items(
 * 			title="Issuance",
 * 			type="object",
 * 			ref="#/components/schemas/IssuanceSimple"
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
 * 		property="memberships",
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
 * 		property="titleIssuances",
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
 * 		property="titles",
 * 		description="Attachable & filterable array of Titles received by the Persona.",
 * 		type="array",
 * 		@OA\Items(
 * 			title="Title",
 * 			type="object",
 * 			ref="#/components/schemas/TitleSimple"
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
 * 		property="honorific_id",
 * 		description="The ID of the Title Issuance the Persona considers primary of the Titles they have.",
 * 		readOnly=false,
 * 		nullable=true,
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
 * 		property="is_officer",
 * 		description="Is the Persona an Officer?",
 * 		readOnly=true,
 * 		type="integer",
 * 		format="enum",
 * 		enum={0, 1},
 * 		example=0
 * 	),
 * 	@OA\Property(
 * 		property="is_paid",
 * 		description="Is the Persona Dues paid?",
 * 		readOnly=true,
 * 		type="integer",
 * 		format="enum",
 * 		enum={0, 1},
 * 		example=0
 * 	),
 * 	@OA\Property(
 * 		property="is_suspended",
 * 		description="Is the Persona suspended?",
 * 		readOnly=true,
 * 		type="integer",
 * 		format="enum",
 * 		enum={0, 1},
 * 		example=0
 * 	),
 * 	@OA\Property(
 * 		property="is_waivered",
 * 		description="Is the Persona waivered?",
 * 		readOnly=true,
 * 		type="integer",
 * 		format="enum",
 * 		enum={0, 1},
 * 		example=0
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
 * 		property="awards",
 * 		description="An array of this Persona's Awards with their Issuances.",
 * 		type="object",
 * 		ref="#/components/schemas/AwardsReport",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="chapter_full_abbreviation",
 * 		description="A short abbreviation of the Persona's Chapter name, along with the Realm abbreviation in the format XX/XX.",
 * 		readOnly=true,
 * 		nullable=false,
 * 		type="string",
 * 		format="uppercase",
 * 		maxLength=7,
 * 	),
 * 	@OA\Property(
 * 		property="credits",
 * 		description="A count of the Persona's Credits.",
 * 		type="object",
 * 		ref="#/components/schemas/CreditReport",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="score",
 * 		description="An open ended scoring of a Persona's entire Amtgard record from 0-infinity.",
 * 		readOnly=true,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
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
 * 	title="PersonaSuperSimple",
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
 * 		property="honorific_id",
 * 		description="The ID of the Title Issuance the Persona considers primary of the Titles they have.",
 * 		readOnly=false,
 * 		nullable=true,
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
 * 		property="is_officer",
 * 		description="Is the Persona an Officer?",
 * 		readOnly=true,
 * 		type="integer",
 * 		format="enum",
 * 		enum={0, 1},
 * 		example=0
 * 	),
 * 	@OA\Property(
 * 		property="is_paid",
 * 		description="Is the Persona Dues paid?",
 * 		readOnly=true,
 * 		type="integer",
 * 		format="enum",
 * 		enum={0, 1},
 * 		example=0
 * 	),
 * 	@OA\Property(
 * 		property="is_suspended",
 * 		description="Is the Persona suspended?",
 * 		readOnly=true,
 * 		type="integer",
 * 		format="enum",
 * 		enum={0, 1},
 * 		example=0
 * 	),
 * 	@OA\Property(
 * 		property="is_waivered",
 * 		description="Is the Persona waivered?",
 * 		readOnly=true,
 * 		type="integer",
 * 		format="enum",
 * 		enum={0, 1},
 * 		example=0
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
 * 		property="awards",
 * 		description="An array of this Persona's Awards with their Issuances.",
 * 		type="object",
 * 		ref="#/components/schemas/AwardsReport",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="chapter_full_abbreviation",
 * 		description="A short abbreviation of the Persona's Chapter name, along with the Realm abbreviation in the format XX/XX.",
 * 		readOnly=true,
 * 		nullable=false,
 * 		type="string",
 * 		format="uppercase",
 * 		maxLength=7,
 * 	),
 * 	@OA\Property(
 * 		property="credits",
 * 		description="A count of the Persona's Credits.",
 * 		type="object",
 * 		ref="#/components/schemas/CreditReport",
 * 		readOnly=true
 * 	),
 * 	@OA\Property(
 * 		property="score",
 * 		description="An open ended scoring of a Persona's entire Amtgard record from 0-infinity.",
 * 		readOnly=true,
 * 		nullable=false,
 * 		type="integer",
 * 		format="int32",
 * 		example=42,
 * 	)
 * )
 * @OA\Schema (
 * 	schema="AwardsReport",
 * 	title="AwardsReport",
 * 	description="Awards & Issuances report.",
 * 	@OA\Property(
 * 		property="awards",
 * 		description="List of awards and their issuances.",
 * 		type="object",
 * 		additionalProperties={
 * 			"type": "object",
 * 			"properties": {
 * 				"rank": {
 * 					"description": "Highest rank of Award Issuances.",
 * 					"type": "integer",
 * 					"format": "int32",
 * 					"example": 1
 * 				},
 * 				"issuances": {
 * 					"description": "List of Award Issuances.",
 * 					"type": "array",
 * 					"items": {
 * 						"$ref": "#/components/schemas/Issuance"
 * 					}
 * 				}
 * 			}
 * 		}
 * 	)
 * )
 * @OA\Schema (
 * 	schema="CreditReport",
 * 	title="CreditReport",
 * 	description="Archetype credit report.",
 * 	@OA\Property(
 * 		property="count",
 * 		description="Total Attendance and Reconciliation credits.",
 * 		readOnly=true,
 * 		nullable=true,
 * 		type="integer",
 * 		format="int32",
 * 		example=42
 * 	),
 * 	@OA\Property(
 * 		property="archetypes",
 * 		description="Array of credits by Archetype.",
 * 		type="object",
 * 		readOnly=true,
 * 		additionalProperties={
 * 			"title": "Archetype",
 * 			"type": "object",
 * 			"properties": {
 * 				"credits": {
 * 					"description": "Total Attendance and Reconciliation credits for this Archetype.",
 * 					"readOnly": true,
 * 					"nullable": true,
 * 					"type": "integer",
 * 					"format": "int32",
 * 					"example": 42
 * 				},
 * 				"level": {
 * 					"description": "Current level for this Archetype.",
 * 					"readOnly": true,
 * 					"nullable": true,
 * 					"type": "integer",
 * 					"format": "int32",
 * 					"example": 42
 * 				}
 * 			}
 * 		}
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
		'pronoun_id',
		'honorific_id',
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
		'chapter_id' => 'integer',
		'pronoun_id' => 'integer',
		'honorific_id' => 'integer',
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
			'id' => (int) $this->id,
			'name' => $this->name,
			'mundane' => $this->mundane
		];
	}
	
	public static array $rules = [
		'chapter_id' => 'required|exists:chapters,id',
		'pronoun_id' => 'nullable|exists:pronouns,id',
		'honorific_id' => 'nullable|exists:issuances,id',
		'mundane' => 'nullable|string|max:191',
		'name' => 'required|string|max:191',
		'heraldry' => 'nullable|string|max:191',
		'image' => 'nullable|string|max:191',
		'is_active' => 'required|boolean',
		'reeve_qualified_expires_at' => 'nullable|date',
		'corpora_qualified_expires_at' => 'nullable|date',
		'joined_chapter_at' => 'nullable|date'
	];
	
	protected $appends = [
// 		'awards',
// 		'chapter_full_abbreviation',
// 		'credits',
// 		'is_officer',
// 		'is_paid',
// 		'is_suspended',
// 		'is_waivered',
// 		'score'
	];
	
	protected function awards(): Attribute
	{
		return Attribute::make(
			get: function () {
				$awards = [];
				foreach($this->awardIssuances()->with('issuer')->with('signator')->with('revoker')->with('whereable')->get() as $awardIssuance){
					if(!array_key_exists($awardIssuance->issuable->name, $awards)){
						$awards[$awardIssuance->issuable->name] = [
							'rank' => $awardIssuance->issuable->is_ladder ? 1 : null,
							'issuances' => []
						];
					}
					$awards[$awardIssuance->issuable->name]['rank'] = ($awards[$awardIssuance->issuable->name]['rank'] < $awardIssuance->rank ? $awardIssuance->rank : $awards[$awardIssuance->issuable->name]['rank']);
					$issuancePolicy = new IssuancePolicy();
					$awardIssuance->can_list = auth('sanctum')->user() && $issuancePolicy->viewAny(auth('sanctum')->user(), $awardIssuance) ? 1 : 1;
					$awardIssuance->can_view = auth('sanctum')->user() && $issuancePolicy->view(auth('sanctum')->user(), $awardIssuance) ? 1 : 1;
					$awardIssuance->can_create = auth('sanctum')->user() && $issuancePolicy->create(auth('sanctum')->user(), $awardIssuance) ? 1 : 0;
					$awardIssuance->can_update = auth('sanctum')->user() && $issuancePolicy->update(auth('sanctum')->user(), $awardIssuance) ? 1 : 0;
					$awardIssuance->can_delete = auth('sanctum')->user() && $issuancePolicy->delete(auth('sanctum')->user(), $awardIssuance) ? 1 : 0;
					$awardIssuance->can_restore = auth('sanctum')->user() && $issuancePolicy->restore(auth('sanctum')->user(), $awardIssuance) ? 1 : 0;
					$awardIssuance->can_nuke = auth('sanctum')->user() && $issuancePolicy->forceDelete(auth('sanctum')->user(), $awardIssuance) ? 1 : 0;
					$awards[$awardIssuance->issuable->name]['issuances'][] = $awardIssuance;
				}
				
				foreach ($awards as &$award) {
					usort($award['issuances'], function ($a, $b) {
						return $a->issued_at <=> $b->issued_at;
					});
				}
				
				return $awards;
			}
		);
	}
	
	protected function chapterFullAbbreviation(): Attribute
	{
		return Attribute::make(
			get: fn () => $this->chapter->full_abbreviation,
		);
	}
	
	protected function credits(): Attribute
	{
		return Attribute::make(
			get: function () {
				$attendanceCount = $this->attendances()->count();
				$creditCount = $this->attendances()->sum('credits') + $this->reconciliations()->sum('credits');
				$credits = [];
				$archetypes = Archetype::get();
				foreach($archetypes as $archetype){
					$credits[$archetype->name] = [
						'credits' => 0,
						'level' => 0
					];
				}
				foreach ($this->attendances as $attendance) {
					if($attendance->archetype){
						$archetypeId = $attendance->archetype->name;
						$credits[$archetypeId]['credits'] += $attendance->credits;
						$credits[$archetypeId]['level'] = $this->calculateLevel($credits[$archetypeId]['credits']);
					}
				}
				foreach ($this->reconciliations as $reconciliation) {
					if($reconciliation->archetype){
						$archetypeId = $reconciliation->archetype->name;
						$credits[$archetypeId]['credits'] += $reconciliation->credits;
						$credits[$archetypeId]['level'] = $this->calculateLevel($credits[$archetypeId]['credits']);
					}
				}
				return [
					'attendance_count' => $attendanceCount,
					'count' => $creditCount,
					'archetypes' => $credits
				];
			}
		);
	}
	
	protected function calculateLevel(int $credits): int
	{
		if ($credits < 1) {
			return 0;
		} elseif ($credits < 5) {
			return 1;
		} elseif ($credits < 12) {
			return 2;
		} elseif ($credits < 21) {
			return 3;
		} elseif ($credits < 34) {
			return 4;
		} elseif ($credits < 53) {
			return 5;
		} else {
			return 6;
		}
	}
	
	protected function isOfficer(): Attribute
	{
		return Attribute::make(
			get: function () {
				$isOfficer = 0;
				foreach($this->officers->where('officerable_type', 'Reign') as $officer){
					$begins = $officer->begins_on ? $officer->begins_on : ($officer->office->is_midreign ? $officer->officerable->midreign_on : $officer->officerable->begins_on);
					$ends = $officer->ends_on ? $officer->ends_on : ($officer->office->is_midreign ? Carbon::parse($officer->officerable->midreign_on)->addMonths(6)->toDateString() : $officer->officerable->ends_on);
					if($begins < Carbon::now() && $ends > Carbon::now()){
						$isOfficer = 1;
						break;
					}
				}
				return $isOfficer;
			}
		);
	}
	
	protected function isPaid(): Attribute
	{
		return Attribute::make(
			get: function () {
				$isPaid = 0;
				foreach($this->dues as $due){
					if ($due->dues_on->addMonths($due->intervals * 6) > now()) {
						$isPaid = 1;
						break;
					}
				}
				if($this->is_officer === 1){
					//TODO: iterate any current offices and do this if one with is_forgiven is found
					$isPaid = 1;
				}
				return $isPaid;
			}
		);
	}
	
	protected function isSuspended(): Attribute
	{
		return Attribute::make(
				get: function () {
					$isSuspended = 0;
					foreach($this->suspensions as $suspension){
						if($suspension->expires_at && $suspension->expires_at <= Carbon::now()){
							$isSuspended = 0;
							break;
						}else{
							$isSuspended = 1;
							break;
						}
					}
					return $isSuspended;
				}
				);
	}
	
	protected function isWaivered(): Attribute
	{
		return Attribute::make(
			get: function () {
				$isWaivered = 0;
				foreach($this->waivers as $waiver){
					if ($this->chapter && $this->chapter->realm && $this->chapter->realm->waiver_duration) {
						$waiverAgeMonths = now()->diffInMonths($waiver->created_at);
						$waiverDurationMonths = $this->chapter->realm->waiver_duration;
						if ($waiverDurationMonths > $waiverAgeMonths) {
							$isWaivered = 1;
							break;
						}
					}else{
						$isWaivered = 1;
						break;
					}
				}
				return $isWaivered;
			}
		);
	}
	
	protected function roptitles(): Attribute
	{
		return Attribute::make(
				get: function () {
					//TODO: restrict this list to those they can give.  if Nobility || Knight, page & at-arms, if Paragon, apprentice, and if Knight, squire
					$titles = Title::where('titleable_type', 'Persona')->whereNull('titleable_id')->where('is_active', 1)->get();
					return $titles;
			}
		);
	}
	
	protected function score(): Attribute
	{
		return Attribute::make(
			get: function () {
				
				$score = 0;
				
				// Awards
				//awards: null awarder_id					$this->issuances->rank*2.7272715 (totals 150)
				//awards: is_ladder							$this->issuances->rank*1.818181 (totals 100)
				//awards: !is_ladder						10
				if (!$this->awardIssuances->isEmpty()) {
					foreach ($this->awardIssuances as $awardIssuance) {
						$multiple = $awardIssuance->issuable->is_ladder ? ($awardIssuance->issuable->awarder_id === NULL ? 2.7272715 : 1.818181) : null;
						$score += $multiple ? ($awardIssuance->rank > 0 ? $awardIssuance->rank : 1) * $multiple : 10;
					}
				}
				
				// Titles
				//titles: peerage knight					rank*5 (100)
				//titles: peerage noble						rank (5-120)
				//titles: peerage retainers					rank*5 min 1 (1-75)
				//titles: peerage masters					rank*5 (50)
				//titles: peerage paragons					rank*5 (50)
				//titles: peerage gentry					rank min 5 (5-60)
				if (!$this->titleIssuances->isEmpty()) {
					foreach ($this->titleIssuances as $titleIssuance) {
						switch ($titleIssuance->issuable->peerage) {
							case 'Knight':
								$score += $titleIssuance->issuable->rank * 5; 
								break;
							case 'Nobility':
								$score += $titleIssuance->issuable->rank;
								break;
							case 'Retainers':
								$score += max($titleIssuance->issuable->rank * 5, 1);
								break;
							case 'Masters':
							case 'Paragons':
								$score += $titleIssuance->issuable->rank * 5;
								break;
							case 'Gentry':
								$score += max($titleIssuance->issuable->rank, 5);
								break;
							default:
								break;
						}
					}
				}
				
				// Attendances
				//attendances:								count
				$score += $this->attendances ? $this->attendances->count() : 0;
				
				// Offices
				//offices:chapter w/order					chaptertype->rank/10 + 5 - order + 1
				//offices:chapter null order				chaptertype->rank/10
				//offices:realm w/order						15 - order + 1
				//offices:realm null order					10
				//offices:realm w/parent_id w/order			10 - order + 1
				//offices:realm w/parent_id null order		5
				//offices:unit								5
				if (!$this->officers->isEmpty()) {
					foreach ($this->officers as $officer) {
						if($officer->officerable_type === 'Reign'){
							if($officer->reign && $officer->reign->reignable_type === 'Chapter'){
								$score += ($officer->reign->reignable->chaptertype->rank / 10) + ($officer->office->order != null ? 6 - $officer->office->order : 0);
							}elseif($officer->reign && $officer->reign->reignable_type === 'Realm' && $officer->reign->reignable->parent_id === null){
								$score += 10 + ($officer->office->order != null ? 6 - $officer->office->order : 0);
							}else{
								$score += 5 + ($officer->office->order != null ? 6 - $officer->office->order : 0);
							}
						}else{
							$score += 5;
						}
					}
				}
				
				// Crats
				//crats:is_autocrat							10
				//crats										5
				if (!$this->crats->isEmpty()) {
					foreach ($this->crats as $crat) {
						$score += $crat->is_autocrat ? 10 : 5;
					}
				}
				
				// Dues
				//dues										paid count/10
				if (!$this->dues->isEmpty()) {
					foreach ($this->dues as $due) {
						foreach ($due->transaction->splits as $split) {
							$score += $split->account->type != 'Expense' && $split->account->type != 'Liability' ? $split->amount / 10 : 0;
						}
					}
				}
				
				// Membership
				//membershipship:first company leading			member count
				//membershipship:first company voting			10/year
				//membershipship:household leading				member count
				//membershipship:household voting				5/year
				if (!$this->memberships->isEmpty()) {
					$didCompany = false;
					foreach ($this->memberships as $member) {
						if($member->unit->type === 'Company' && !$didCompany){
							$didCompany = true;
							if($member->is_head){
								$score += $member->unit->memberships ? $member->unit->memberships->count() : 0;
							}elseif($member->is_voting){
								$score += Carbon::now()->diffInYears($member->joined_at) * 10;
							}
						}elseif($member->unit->type !== 'Company'){
							if($member->is_head){
								$score += $member->unit->memberships ? $member->unit->memberships->count() : 0;
							}elseif($member->is_voting){
								$score += Carbon::now()->diffInYears($member->joined_at) * 5;
							}
						}
					}
				}
				
				// Recommendations
				//recommendations:							count
				$score += $this->recommendations ? $this->recommendations->count() : 0;
				
				// Suspensions
				//suspensions:								- months * 8.333333
				if (!$this->suspensions->isEmpty()) {
					foreach ($this->suspensions as $suspension) {
						if(!$suspension->expires_at){
							$score = 0;
						}elseif($suspension->suspendable_type === 'Chapter'){
							$score -= Carbon::now()->diffInMonths($suspension->expires_at) * 4.166666;
						}elseif($suspension->suspendable_type === 'Chapter' && !$suspension->is_propogating){
							$score -= Carbon::now()->diffInMonths($suspension->expires_at) * 8.333333;
						}else{
							$score -= Carbon::now()->diffInMonths($suspension->expires_at) * 12.499999;
						}
					}
				}
				
				// User
				//user:										5
				if($this->user){
					$score += 5;
				}
				
				// Round to the nearest whole number
				return round($score);
// 				return 42;
			}
		);
	}
	
	protected function heraldry(): Attribute
	{
		return Attribute::make(
			get: function (?string $value) {
				if ($value === null) {
					return "https://ork.amtgard.com/assets/heraldry/player/000000.jpg";
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
					return "https://ork.amtgard.com/assets/heraldry/player/000000.jpg";
				}
				return 'https://ork.amtgard.com/assets/players/' . $value;
			}
		);
	}
	
	public $relationships = [
		'attendances' => 'HasMany',
		'awardIssuances' => 'MorphMany',
		'chapter' => 'BelongsTo',
		'crats' => 'HasMany',
		'dues' => 'HasMany',
		'events' => 'MorphMany',
		'honorific' => 'BelongsTo',
		'issuances' => 'MorphMany',
		'issuanceGivens' => 'MorphMany',
		'issuanceRevokeds' => 'HasMany',
		'issuanceSigneds' => 'HasMany',
		'memberships' => 'HasMany',
		'officers' => 'HasMany',
		'pronoun' => 'BelongsTo',
		'recommendations' => 'HasMany',
		'reconciliations' => 'HasMany',
		'socials' => 'MorphMany',
		'splits' => 'HasMany',
		'suspensions' => 'HasMany',
		'suspensionIssueds' => 'HasMany',
		'titleIssuances' => 'MorphMany',
		'titles' => 'hasManyThrough',
		'user' => 'HasOne',
		'waivers' => 'HasMany',
		'waiverVerifieds' => 'HasMany'
	];
	
	public function attendances(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(\App\Models\Attendance::class, 'persona_id');
	}
	
	public function awardIssuances(): \Illuminate\Database\Eloquent\Relations\MorphMany
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
	
	public function honorific(): \Illuminate\Database\Eloquent\Relations\BelongsTo
	{
		return $this->belongsTo(\App\Models\Issuance::class, 'honorific_id');
	}
	
	public function issuances(): \Illuminate\Database\Eloquent\Relations\MorphMany
	{
		return $this->morphMany(Issuance::class, 'recipient');
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
	
	public function memberships(): \Illuminate\Database\Eloquent\Relations\HasMany
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
	
	public function titleIssuances(): \Illuminate\Database\Eloquent\Relations\MorphMany
	{
		return $this->morphMany(Issuance::class, 'recipient')->where('issuable_type', 'Title')->with('issuable');
	}
	
	public function titles(): \Illuminate\Database\Eloquent\Relations\HasManyThrough
	{
		return $this->hasManyThrough(Title::class, Issuance::class, 'recipient_id', 'id', 'id', 'issuable_id')->where('issuable_type', 'Title');
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
