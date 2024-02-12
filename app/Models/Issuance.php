<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\ProtectFieldsTrait;
use Wildside\Userstamps\Userstamps;
/**
 * @OA\Schema(
 *      schema="Issuance",
 *      required={"issuable_type","issuable_id","authority_type","authority_id","recipient_type","recipient_id","issued_at"},
 *		description="Issuances of Awards or Titles.<br>The following relationships can be attached, and in the case of plural relations, searched:
 * issuable (Award or Title) (MorphTo): The Issuance type; Award or Title.
 * issuer (Chapter, Realm, Persona, or Unit) (MorphTo): Issuing authority; Chapter, Realm, Persona, or Unit.
 * recipient (Persona or Unit) (MorphTo): Who recieved the Issuance; Persona or Unit.
 * revokedBy (Persona) (BelongsTo): If revoked, who authorized the revocation.
 * signator (Persona) (BelongsTo): Persona signing the Issuance, if any.  Leave null when Issuer is Persona.
 * whereable (Event, Location, or Meetup) (MorphTo): Where it was Issued, if known; Event, Location, or Meetup.
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
 *      @OA\Property(
 *          property="issuable_type",
 *          description="The Issuance type; Award or Title.",
 *          readOnly=false,
 *          nullable=false,
 *			type="string",
 *			format="enum",
 *			enum={"Award","Title"},
 *			example="Realm"
 *      ),
 *		@OA\Property(
 *			property="issuable_id",
 *			description="asdf",
 *          readOnly=false,
 *          nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *      @OA\Property(
 *          property="whereable_type",
 *          description="Where it was Issued, if known; Event, Meetup, or Location.",
 *          readOnly=false,
 *          nullable=true,
 *			type="string",
 *			format="enum",
 *			enum={"Event","Meetup","Location"},
 *			example="Event"
 *      ),
 *		@OA\Property(
 *			property="whereable_id",
 *			description="The ID of where it was Issued.",
 *          readOnly=false,
 *          nullable=true,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *      @OA\Property(
 *          property="issuer_type",
 *          description="Issuing authority; Chapter, Realm, Persona, or Unit.",
 *          readOnly=false,
 *          nullable=false,
 *			type="string",
 *			format="enum",
 *			enum={"Chapter","Realm","Persona","Unit"},
 *			example="Chapter"
 *      ),
 *		@OA\Property(
 *			property="issuer_id",
 *			description="The ID of the Issuing authority.",
 *          readOnly=false,
 *          nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *      @OA\Property(
 *          property="recipient_type",
 *          description="Who recieved the Issuance; Persona or Unit.",
 *          readOnly=false,
 *          nullable=false,
 *			type="string",
 *			format="enum",
 *			enum={"Persona","Unit"},
 *			example="Persona"
 *      ),
 *		@OA\Property(
 *			property="recipient_id",
 *			description="The ID of the Issuance recipient.",
 *          readOnly=false,
 *          nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="signator_id",
 *			description="The ID of the Persona signing the Issuance, if any.",
 *          readOnly=false,
 *          nullable=true,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *      @OA\Property(
 *          property="custom_name",
 *          description="Where label options are avaiable, or customization allowed, the chosen label, else null",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *          format="uppercase first letter",
 *          maxLength=64,
 *          example="Lady"
 *      ),
 *		@OA\Property(
 *			property="rank",
 *			description="For laddered Issuances, the order number, else null.",
 *          readOnly=false,
 *          nullable=true,
 *			type="integer",
 *			format="int32",
 *			example=1
 *		),
 *      @OA\Property(
 *          property="issued_at",
 *          description="When the Issuance was made or is to be made public (if in the future)",
 *          readOnly=false,
 *          nullable=false,
 *			type="string",
 *			format="date",
 *			example="2020-12-30"
 *      ),
 *      @OA\Property(
 *          property="reason",
 *          description="A historical record of what the Issuance was for",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *          format="paragraph"
 *          example="For their work feeding everybody."
 *          maxLength="400"
 *      ),
 *      @OA\Property(
 *          property="image",
 *          description="An internal link to an image of the Issuance phyrep, if any.",
 *          readOnly=false,
 *          nullable=true,
 *			type="string",
 *			format="filename",
 *			example="images/issuances/42.jpg",
 *			maxLength=191
 *      ),
 *		@OA\Property(
 *			property="revoked_by",
 *			description="ID of the Persona that revoked the Issuance, if any.",
 *          readOnly=false,
 *          nullable=true,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *      @OA\Property(
 *          property="revoked_at",
 *          description="Date the revocation is effective, if any.",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *          format="date",
 *			example="2020-12-30"
 *      ),
 *      @OA\Property(
 *          property="revocation",
 *          description="Cause for the revocation, if any.",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *          format="paragraph",
 *          example="He bought it on Etsy"
 *          maxLength=50
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
 *			property="issuable",
 *			type="object",
 *			oneOf={
 *				@OA\Property(
 *					title="Award",
 *					description="Attachable Award that was Issued.",
 *					@OA\Schema(ref="#/components/schemas/Award")
 *				),
 *				@OA\Property(
 *					title="Title",
 *					description="Attachable Title that was Issued.",
 *					@OA\Schema(ref="#/components/schemas/Title")
 *				)
 *			},
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="issuer",
 *			type="object",
 *			oneOf={
 *				@OA\Property(
 *					title="Chapter",
 *					description="Attachable Chapter that Issues the Award.",
 *					@OA\Schema(ref="#/components/schemas/Chapter")
 *				),
 *				@OA\Property(
 *					title="Realm",
 *					description="Attachable Realm that Issues the Award.",
 *					@OA\Schema(ref="#/components/schemas/Realm")
 *				),
 *				@OA\Property(
 *					title="Persona",
 *					description="Attachable Persona that Issues the Award.",
 *					@OA\Schema(ref="#/components/schemas/Persona")
 *				),
 *				@OA\Property(
 *					title="Unit",
 *					description="Attachable Unit that Issues the Award.",
 *					@OA\Schema(ref="#/components/schemas/Unit")
 *				)
 *			},
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="recipient",
 *			type="object",
 *			oneOf={
 *				@OA\Property(
 *					title="Persona",
 *					description="Attachable Persona that was Issued the Award.",
 *					@OA\Schema(ref="#/components/schemas/Persona")
 *				),
 *				@OA\Property(
 *					title="Unit",
 *					description="Attachable Unit that was Issued the Award.",
 *					@OA\Schema(ref="#/components/schemas/Unit")
 *				)
 *			},
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="revokedBy",
 *			type="object",
 *			allOf={
 *				@OA\Property(
 *					title="Persona",
 *					description="Attachable Persona that revoked the Issuance."
 *				),
 *				@OA\Schema(ref="#/components/schemas/Persona"),
 *			},
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="signator",
 *			type="object",
 *			allOf={
 *				@OA\Property(
 *					title="Persona",
 *					description="Attachable Persona signing the Issuance."
 *				),
 *				@OA\Schema(ref="#/components/schemas/Persona"),
 *			},
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="whereable",
 *			type="object",
 *			oneOf={
 *				@OA\Property(
 *					title="Event",
 *					description="Attachable Event that Issues the Award.",
 *					@OA\Schema(ref="#/components/schemas/Event")
 *				),
 *				@OA\Property(
 *					title="Location",
 *					description="Attachable Location that Issues the Award.",
 *					@OA\Schema(ref="#/components/schemas/Location")
 *				),
 *				@OA\Property(
 *					title="Meetup",
 *					description="Attachable Meetup that Issues the Award.",
 *					@OA\Schema(ref="#/components/schemas/Meetup")
 *				)
 *			},
 *			readOnly=true
 *		)
 * )
 */
 
/**
 *	@OA\Schema(
 *		schema="IssuanceSimple",
 *		@OA\Property(
 *			property="id",
 *			description="The entry's ID.",
 *			type="integer",
 *			format="int32",
 *			example=42,
 *			readOnly=true
 *		),
 *      @OA\Property(
 *          property="issuable_type",
 *          description="The Issuance type; Award or Title.",
 *          readOnly=false,
 *          nullable=false,
 *			type="string",
 *			format="enum",
 *			enum={"Award","Title"},
 *			example="Realm"
 *      ),
 *		@OA\Property(
 *			property="issuable_id",
 *			description="asdf",
 *          readOnly=false,
 *          nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *      @OA\Property(
 *          property="whereable_type",
 *          description="Where it was Issued, if known; Event, Meetup, or Location.",
 *          readOnly=false,
 *          nullable=true,
 *			type="string",
 *			format="enum",
 *			enum={"Event","Meetup","Location"},
 *			example="Event"
 *      ),
 *		@OA\Property(
 *			property="whereable_id",
 *			description="The ID of where it was Issued.",
 *          readOnly=false,
 *          nullable=true,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *      @OA\Property(
 *          property="issuer_type",
 *          description="Issuing authority; Chapter, Realm, Persona, or Unit.",
 *          readOnly=false,
 *          nullable=false,
 *			type="string",
 *			format="enum",
 *			enum={"Chapter","Realm","Persona","Unit"},
 *			example="Chapter"
 *      ),
 *		@OA\Property(
 *			property="issuer_id",
 *			description="The ID of the Issuing authority.",
 *          readOnly=false,
 *          nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *      @OA\Property(
 *          property="recipient_type",
 *          description="Who recieved the Issuance; Persona or Unit.",
 *          readOnly=false,
 *          nullable=false,
 *			type="string",
 *			format="enum",
 *			enum={"Persona","Unit"},
 *			example="Persona"
 *      ),
 *		@OA\Property(
 *			property="recipient_id",
 *			description="The ID of the Issuance recipient.",
 *          readOnly=false,
 *          nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="signator_id",
 *			description="The ID of the Persona signing the Issuance, if any.",
 *          readOnly=false,
 *          nullable=true,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *      @OA\Property(
 *          property="custom_name",
 *          description="Where label options are avaiable, or customization allowed, the chosen label, else null",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *          format="uppercase first letter",
 *          maxLength=64,
 *          example="Lady"
 *      ),
 *		@OA\Property(
 *			property="rank",
 *			description="For laddered Issuances, the order number, else null.",
 *          readOnly=false,
 *          nullable=true,
 *			type="integer",
 *			format="int32",
 *			example=1
 *		),
 *      @OA\Property(
 *          property="issued_at",
 *          description="When the Issuance was made or is to be made public (if in the future)",
 *          readOnly=false,
 *          nullable=false,
 *			type="string",
 *			format="date",
 *			example="2020-12-30"
 *      ),
 *      @OA\Property(
 *          property="reason",
 *          description="A historical record of what the Issuance was for",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *          format="paragraph"
 *          example="For their work feeding everybody."
 *          maxLength="400"
 *      ),
 *      @OA\Property(
 *          property="image",
 *          description="An internal link to an image of the Issuance phyrep, if any.",
 *          readOnly=false,
 *          nullable=true,
 *			type="string",
 *			format="filename",
 *			example="images/issuances/42.jpg",
 *			maxLength=191
 *      ),
 *		@OA\Property(
 *			property="revoked_by",
 *			description="ID of the Persona that revoked the Issuance, if any.",
 *          readOnly=false,
 *          nullable=true,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *      @OA\Property(
 *          property="revoked_at",
 *          description="Date the revocation is effective, if any.",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *          format="date",
 *			example="2020-12-30"
 *      ),
 *      @OA\Property(
 *          property="revocation",
 *          description="Cause for the revocation, if any.",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *          format="paragraph",
 *          example="He bought it on Etsy"
 *          maxLength=50
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
 *		schema="IssuanceSuperSimple",
 *		@OA\Property(
 *			property="id",
 *			description="The entry's ID.",
 *			type="integer",
 *			format="int32",
 *			example=42,
 *			readOnly=true
 *		),
 *      @OA\Property(
 *          property="issuable_type",
 *          description="The Issuance type; Award or Title.",
 *          readOnly=false,
 *          nullable=false,
 *			type="string",
 *			format="enum",
 *			enum={"Award","Title"},
 *			example="Realm"
 *      ),
 *		@OA\Property(
 *			property="issuable_id",
 *			description="asdf",
 *          readOnly=false,
 *          nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *      @OA\Property(
 *          property="whereable_type",
 *          description="Where it was Issued, if known; Event, Meetup, or Location.",
 *          readOnly=false,
 *          nullable=true,
 *			type="string",
 *			format="enum",
 *			enum={"Event","Meetup","Location"},
 *			example="Event"
 *      ),
 *		@OA\Property(
 *			property="whereable_id",
 *			description="The ID of where it was Issued.",
 *          readOnly=false,
 *          nullable=true,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *      @OA\Property(
 *          property="issuer_type",
 *          description="Issuing authority; Chapter, Realm, Persona, or Unit.",
 *          readOnly=false,
 *          nullable=false,
 *			type="string",
 *			format="enum",
 *			enum={"Chapter","Realm","Persona","Unit"},
 *			example="Chapter"
 *      ),
 *		@OA\Property(
 *			property="issuer_id",
 *			description="The ID of the Issuing authority.",
 *          readOnly=false,
 *          nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *      @OA\Property(
 *          property="recipient_type",
 *          description="Who recieved the Issuance; Persona or Unit.",
 *          readOnly=false,
 *          nullable=false,
 *			type="string",
 *			format="enum",
 *			enum={"Persona","Unit"},
 *			example="Persona"
 *      ),
 *		@OA\Property(
 *			property="recipient_id",
 *			description="The ID of the Issuance recipient.",
 *          readOnly=false,
 *          nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="signator_id",
 *			description="The ID of the Persona signing the Issuance, if any.",
 *          readOnly=false,
 *          nullable=true,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *      @OA\Property(
 *          property="custom_name",
 *          description="Where label options are avaiable, or customization allowed, the chosen label, else null",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *          format="uppercase first letter",
 *          maxLength=64,
 *          example="Lady"
 *      ),
 *		@OA\Property(
 *			property="rank",
 *			description="For laddered Issuances, the order number, else null.",
 *          readOnly=false,
 *          nullable=true,
 *			type="integer",
 *			format="int32",
 *			example=1
 *		),
 *      @OA\Property(
 *          property="issued_at",
 *          description="When the Issuance was made or is to be made public (if in the future)",
 *          readOnly=false,
 *          nullable=false,
 *			type="string",
 *			format="date",
 *			example="2020-12-30"
 *      ),
 *      @OA\Property(
 *          property="reason",
 *          description="A historical record of what the Issuance was for",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *          format="paragraph"
 *          example="For their work feeding everybody."
 *          maxLength="400"
 *      ),
 *      @OA\Property(
 *          property="image",
 *          description="An internal link to an image of the Issuance phyrep, if any.",
 *          readOnly=false,
 *          nullable=true,
 *			type="string",
 *			format="filename",
 *			example="images/issuances/42.jpg",
 *			maxLength=191
 *      ),
 *		@OA\Property(
 *			property="revoked_by",
 *			description="ID of the Persona that revoked the Issuance, if any.",
 *          readOnly=false,
 *          nullable=true,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *      @OA\Property(
 *          property="revoked_at",
 *          description="Date the revocation is effective, if any.",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *          format="date",
 *			example="2020-12-30"
 *      ),
 *      @OA\Property(
 *          property="revocation",
 *          description="Cause for the revocation, if any.",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *          format="paragraph",
 *          example="He bought it on Etsy"
 *          maxLength=50
 *      )
 *	)
 */
 
/**
 *
 *	@OA\RequestBody(
 *		request="Issuance",
 *		description="Issuance object that needs to be added or updated.",
 *		required=true,
 *		@OA\MediaType(
 *			mediaType="multipart/form-data",
 *			@OA\Schema(ref="#/components/schemas/IssuanceSimple")
 *		)
 *	)
 */

class Issuance extends Model
{
	use SoftDeletes;
	use HasFactory;
	use Userstamps;
	use ProtectFieldsTrait;

	public $table = 'issuances';
	public $timestamps = true;
	
	protected $dates = ['created_at', 'updated_at', 'deleted_at'];
	protected $protectedFields = [];

    public $fillable = [
        'issuable_type',
        'issuable_id',
        'whereable_type',
        'whereable_id',
        'authority_type',
        'authority_id',
        'recipient_type',
        'recipient_id',
        'signator_id',
        'custom_name',
        'rank',
        'issued_at',
        'reason',
        'image',
        'revoked_by',
        'revoked_at',
        'revocation'
    ];

    protected $casts = [
        'issuable_type' => 'string',
        'whereable_type' => 'string',
        'authority_type' => 'string',
        'recipient_type' => 'string',
        'custom_name' => 'string',
        'issued_at' => 'date',
        'reason' => 'string',
        'image' => 'string',
        'revoked_at' => 'date',
        'revocation' => 'string'
    ];

    public static array $rules = [
    	'issuable_type' => 'required|in:Award,Title',
    	'issuable_id' => 'required',
    	'whereable_type' => 'nullable|in:Event,Meetup,Location',
    	'whereable_id' => 'nullable',
    	'issuer_type' => 'required|in:Chapter,Realm,Unit,Persona',
    	'issuer_id' => 'required',
    	'recipient_type' => 'required|in:Persona,Unit',
    	'recipient_id' => 'required',
    	'signator_id' => 'nullable',//TODO: require null where issuer_type == Persona
    	'custom_name' => 'nullable|string|max:64',
    	'rank' => 'nullable|integer',
    	'issued_at' => 'required|date',
    	'reason' => 'nullable|string|max:400',
    	'image' => 'nullable|string|max:255',
    	'revoked_by' => 'nullable',
    	'revoked_at' => 'nullable|date',
    	'created_by' => 'required',
    	'revocation' => 'nullable|string|max:50'
    ];
    
    public $relationships = [
    	'issuable' => 'MorphTo',
    	'issuer' => 'MorphTo',
    	'recipient' => 'MorphTo',
    	'revokedBy' => 'BelongsTo',
    	'signator' => 'BelongsTo',
    	'whereable' => 'MorphTo'
    ];
    
    public function issuable(): \Illuminate\Database\Eloquent\Relations\MorphTo
    {
    	return $this->morphTo();
    }
    
    public function issuer(): \Illuminate\Database\Eloquent\Relations\MorphTo
    {
    	return $this->morphTo();
    }
    
    public function recipient(): \Illuminate\Database\Eloquent\Relations\MorphTo
    {
    	return $this->morphTo();
    }
    
    public function revokedBy(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
    	return $this->belongsTo(\App\Models\Persona::class, 'revoked_by');
    }
    
    public function signator(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
    	return $this->belongsTo(\App\Models\Persona::class, 'signator_id');
    }
    
    public function whereable(): \Illuminate\Database\Eloquent\Relations\MorphTo
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
