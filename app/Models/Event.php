<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\ProtectFieldsTrait;
use Wildside\Userstamps\Userstamps;
/**
 * @OA\Schema(
 *      schema="Event",
 *      required={"eventable_type","eventable_id","name","is_active","is_demo"},
 *		description="Events typically are either a campout or singular in nature.<br>The following relationships can be attached, and in the case of plural relations, searched:
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
 *		@OA\Property(
 *			property="id",
 *			description="The entry's ID.",
 *			type="integer",
 *			format="int32",
 *			example=42,
 *			readOnly=true
 *		),
 *      @OA\Property(
 *          property="eventable_type",
 *          description="Who sponsors the Event; Chapter, Realm, Persona, or Unit",
 *          readOnly=false,
 *          nullable=false,
 *			type="string",
 *			format="enum",
 *			enum={"Chapter","Realm","Persona","Unit"},
 *			example="Realm"
 *      ),
 *		@OA\Property(
 *			property="eventable_id",
 *			description="The ID of the sponsor of this Event.",
 *          readOnly=false,
 *          nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="location_id",
 *			description="ID of the Location the Event takes place at, if any.",
 *          readOnly=false,
 *          nullable=true,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *      @OA\Property(
 *          property="name",
 *          description="The name of the Event.",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *			format="uppercase first letter",
 *			example="Nerd Wars",
 *			maxLength=191
 *      ),
 *      @OA\Property(
 *          property="description",
 *          description="A description of the Event, if any",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *			format="paragraph",
 *			example="This event is all about killing fellow nerds.",
 *			maxLength=16777215
 *      ),
 *      @OA\Property(
 *          property="image",
 *          description="A internal link to a promotional image for the Event, if any.",
 *          readOnly=false,
 *          nullable=true,
 *			type="string",
 *			format="filename",
 *			example="images/events/42.jpg",
 *			maxLength=191
 *      ),
 *      @OA\Property(
 *          property="is_active",
 *          description="Is this Event (default true) publicly visible?",
 *          readOnly=false,
 *          nullable=false,
 *			type="integer",
 *			format="enum",
 *			enum={0, 1},
 *			example=1
 *      ),
 *      @OA\Property(
 *          property="is_demo",
 *          description="Is this Event (default false) a demo?",
 *          readOnly=false,
 *          nullable=false,
 *			type="integer",
 *			format="enum",
 *			enum={0, 1},
 *			example=0
 *      ),
 *      @OA\Property(
 *          property="event_started_at",
 *          description="When the Event begins.",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *          format="date-time",
 *			example="2020-12-30 23:59:59"
 *      ),
 *      @OA\Property(
 *          property="event_ended_at",
 *          description="When the Event ends.",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *          format="date-time",
 *			example="2020-12-30 23:59:59"
 *      ),
 *      @OA\Property(
 *          property="price",
 *          description="The cost of the Event, if any.",
 *          readOnly=false,
 *          nullable=true,
 *     		type="number",
 *     		format="float",
 *     		example=40
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
 *			property="attendances",
 *			description="Attachable & filterable array of Attendances for this Event.",
 *			type="array",
 *			@OA\Items(
 *				title="Attendance",
 *				type="object",
 *				ref="#/components/schemas/Attendance"
 *			),
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="crats",
 *			description="Attachable & filterable array of Crats for this Event.",
 *			type="array",
 *			@OA\Items(
 *				title="Crat",
 *				type="object",
 *				ref="#/components/schemas/Crat"
 *			),
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="eventable",
 *			type="object",
 *			oneOf={
 *				@OA\Property(
 *					title="Chapter",
 *					description="Attachable Chapter that sponsored the Event.",
 *					@OA\Schema(ref="#/components/schemas/Chapter")
 *				),
 *				@OA\Property(
 *					title="Realm",
 *					description="Attachable Realm that sponsored the Event.",
 *					@OA\Schema(ref="#/components/schemas/Realm")
 *				),
 *				@OA\Property(
 *					title="Persona",
 *					description="Attachable Persona that sponsored the Event.",
 *					@OA\Schema(ref="#/components/schemas/Persona")
 *				),
 *				@OA\Property(
 *					title="Unit",
 *					description="Attachable Unit that sponsored the Event.",
 *					@OA\Schema(ref="#/components/schemas/Unit")
 *				)
 *			},
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="guests",
 *			description="Attachable & filterable array of Guests that played at this demo Event, if so.",
 *			type="array",
 *			@OA\Items(
 *				title="Account",
 *				type="object",
 *				ref="#/components/schemas/Account"
 *			),
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="issuances",
 *			description="Attachable & filterable array of Issuances made at the Event.",
 *			type="array",
 *			@OA\Items(
 *				title="Issuance",
 *				type="object",
 *				ref="#/components/schemas/Issuance"
 *			),
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="location",
 *			type="object",
 *			allOf={
 *				@OA\Property(
 *					title="Location",
 *					description="Attachable Location for this Event."
 *				),
 *				@OA\Schema(ref="#/components/schemas/Location"),
 *			},
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="socials",
 *			description="Attachable & filterable array of the Socials of the Event.",
 *			type="array",
 *			@OA\Items(
 *				title="Social",
 *				type="object",
 *				ref="#/components/schemas/Social"
 *			),
 *			readOnly=true
 *		)
 * )
 */
 
/**
 *	@OA\Schema(
 *		schema="EventSimple",
 *		@OA\Property(
 *			property="id",
 *			description="The entry's ID.",
 *			type="integer",
 *			format="int32",
 *			example=42,
 *			readOnly=true
 *		),
 *      @OA\Property(
 *          property="eventable_type",
 *          description="Who sponsors the Event; Chapter, Realm, Persona, or Unit",
 *          readOnly=false,
 *          nullable=false,
 *			type="string",
 *			format="enum",
 *			enum={"Realm","Chapter","Unit","Persona"},
 *			example="Realm"
 *      ),
 *		@OA\Property(
 *			property="eventable_id",
 *			description="The ID of the sponsor of this Event.",
 *          readOnly=false,
 *          nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="location_id",
 *			description="ID of the Location the Event takes place at, if any.",
 *          readOnly=false,
 *          nullable=true,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *      @OA\Property(
 *          property="name",
 *          description="The name of the Event.",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *			format="uppercase first letter",
 *			example="Nerd Wars",
 *			maxLength=191
 *      ),
 *      @OA\Property(
 *          property="description",
 *          description="A description of the Event, if any",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *			format="paragraph",
 *			example="This event is all about killing fellow nerds.",
 *			maxLength=16777215
 *      ),
 *      @OA\Property(
 *          property="image",
 *          description="A internal link to a promotional image for the Event, if any.",
 *          readOnly=false,
 *          nullable=true,
 *			type="string",
 *			format="filename",
 *			example="images/events/42.jpg",
 *			maxLength=191
 *      ),
 *      @OA\Property(
 *          property="is_active",
 *          description="Is this Event (default true) publicly visible?",
 *          readOnly=false,
 *          nullable=false,
 *			type="integer",
 *			format="enum",
 *			enum={0, 1},
 *			example=1
 *      ),
 *      @OA\Property(
 *          property="is_demo",
 *          description="Is this Event (default false) a demo?",
 *          readOnly=false,
 *          nullable=false,
 *			type="integer",
 *			format="enum",
 *			enum={0, 1},
 *			example=0
 *      ),
 *      @OA\Property(
 *          property="event_started_at",
 *          description="When the Event begins.",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *          format="date-time",
 *			example="2020-12-30 23:59:59"
 *      ),
 *      @OA\Property(
 *          property="event_ended_at",
 *          description="When the Event ends.",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *          format="date-time",
 *			example="2020-12-30 23:59:59"
 *      ),
 *      @OA\Property(
 *          property="price",
 *          description="The cost of the Event, if any.",
 *          readOnly=false,
 *          nullable=true,
 *     		type="number",
 *     		format="float",
 *     		example=40
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
 *		schema="EventSuperSimple",
 *		@OA\Property(
 *			property="id",
 *			description="The entry's ID.",
 *			type="integer",
 *			format="int32",
 *			example=42,
 *			readOnly=true
 *		),
 *      @OA\Property(
 *          property="eventable_type",
 *          description="Who sponsors the Event; Chapter, Realm, Persona, or Unit",
 *          readOnly=false,
 *          nullable=false,
 *			type="string",
 *			format="enum",
 *			enum={"Realm","Chapter","Unit","Persona"},
 *			example="Realm"
 *      ),
 *		@OA\Property(
 *			property="eventable_id",
 *			description="The ID of the sponsor of this Event.",
 *          readOnly=false,
 *          nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="location_id",
 *			description="ID of the Location the Event takes place at, if any.",
 *          readOnly=false,
 *          nullable=true,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *      @OA\Property(
 *          property="name",
 *          description="The name of the Event.",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *			format="uppercase first letter",
 *			example="Nerd Wars",
 *			maxLength=191
 *      ),
 *      @OA\Property(
 *          property="description",
 *          description="A description of the Event, if any",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *			format="paragraph",
 *			example="This event is all about killing fellow nerds.",
 *			maxLength=16777215
 *      ),
 *      @OA\Property(
 *          property="image",
 *          description="A internal link to a promotional image for the Event, if any.",
 *          readOnly=false,
 *          nullable=true,
 *			type="string",
 *			format="filename",
 *			example="images/events/42.jpg",
 *			maxLength=191
 *      ),
 *      @OA\Property(
 *          property="is_active",
 *          description="Is this Event (default true) publicly visible?",
 *          readOnly=false,
 *          nullable=false,
 *			type="integer",
 *			format="enum",
 *			enum={0, 1},
 *			example=1
 *      ),
 *      @OA\Property(
 *          property="is_demo",
 *          description="Is this Event (default false) a demo?",
 *          readOnly=false,
 *          nullable=false,
 *			type="integer",
 *			format="enum",
 *			enum={0, 1},
 *			example=0
 *      ),
 *      @OA\Property(
 *          property="event_started_at",
 *          description="When the Event begins.",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *          format="date-time",
 *			example="2020-12-30 23:59:59"
 *      ),
 *      @OA\Property(
 *          property="event_ended_at",
 *          description="When the Event ends.",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *          format="date-time",
 *			example="2020-12-30 23:59:59"
 *      ),
 *      @OA\Property(
 *          property="price",
 *          description="The cost of the Event, if any.",
 *          readOnly=false,
 *          nullable=true,
 *     		type="number",
 *     		format="float",
 *     		example=40
 *      )
 *	)
 */
 
/**
 *
 *	@OA\RequestBody(
 *		request="Event",
 *		description="Event object that needs to be added or updated.",
 *		required=true,
 *		@OA\MediaType(
 *			mediaType="multipart/form-data",
 *			@OA\Schema(ref="#/components/schemas/EventSimple")
 *		)
 *	)
 */

class Event extends Model
{
	use SoftDeletes;
	use HasFactory;
	use Userstamps;
	use ProtectFieldsTrait;

	public $table = 'events';
	public $timestamps = true;
	
	protected $dates = ['created_at', 'updated_at', 'deleted_at'];
	protected $protectedFields = ['eventable_type', 'eventable_id'];

    public $fillable = [
        'eventable_type',
        'eventable_id',
        'location_id',
        'name',
        'description',
        'image',
        'is_active',
        'is_demo',
        'event_started_at',
        'event_ended_at',
        'price'
    ];

    protected $casts = [
        'eventable_type' => 'string',
        'name' => 'string',
        'description' => 'string',
        'image' => 'string',
        'is_active' => 'boolean',
        'is_demo' => 'boolean',
        'event_started_at' => 'datetime',
        'event_ended_at' => 'datetime',
        'price' => 'float'
    ];

    public static array $rules = [
        'eventable_type' => 'required|string|in:Chapter,Realm,Persona,Unit',
    	'eventable_id' => 'required',
    	'location_id' => 'nullable|exists:locations,id',
        'name' => 'required|string|max:191',
        'description' => 'nullable|string|max:16777215',
        'image' => 'nullable|string|max:255',
        'is_active' => 'required|boolean',
        'is_demo' => 'required|boolean',
        'event_started_at' => 'required|date',
        'event_ended_at' => 'required|date|after_or_equal:event_started_at',
        'price' => 'nullable|numeric'
    ];
    
    public $relationships = [
    	'attendances' => 'MorphMany',
    	'crats' => 'HasMany',
    	'eventable' => 'MorphTo',
    	'guests' => 'HasMany',
    	'issuances' => 'MorphMany',
    	'location' => 'BelongsTo',
    	'socials' => 'MorphMany'
    ];
    
    public function attendances(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
    	return $this->morphMany(Attendance::class, 'attendable');
    }
    
    public function crats(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
    	return $this->hasMany(\App\Models\Crat::class, 'event_id');
    }
    
    public function eventable(): \Illuminate\Database\Eloquent\Relations\MorphTo
    {
    	return $this->morphTo();
    }
    
    public function guests(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
    	return $this->hasMany(\App\Models\Guest::class, 'event_id');
    }
    
    public function issuances(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
    	return $this->morphMany(Issuance::class, 'whereable');
    }
    
    public function location(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
    	return $this->belongsTo(\App\Models\Location::class, 'location_id');
    }
    
    public function socials(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
    	return $this->morphMany(Social::class, 'sociables');
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
