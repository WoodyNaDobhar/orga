<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\ProtectFieldsTrait;
use Wildside\Userstamps\Userstamps;
/**
 * @OA\Schema(
 *      schema="Guest",
 *      required={"event_id","waiver_id","is_followedup"},
 *		description="Visitors that play with us at demo Events.<br>The following relationships can be attached, and in the case of plural relations, searched:
 * event (Event) (BelongsTo): Demo Event they played at.
 * chapter (Chapter) (BelongsTo): The closest Chapter to the Guest, if known
 * waiver (Waiver) (BelongsTo): Waiver for the Guest.
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
 *			property="event_id",
 *			description="ID of the Demo Event they were Guests for.",
 *          readOnly=false,
 *          nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="chapter_id",
 *			description="ID of the closest Chapter to the Guest, if known.",
 *          readOnly=false,
 *          nullable=true,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="waiver_id",
 *			description="ID of the Waiver for the Guest.",
 *          readOnly=false,
 *          nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *      @OA\Property(
 *          property="is_followedup",
 *          description="Has this Guest (default false) been followed up with?",
 *          readOnly=false,
 *          nullable=false,
 *			type="integer",
 *			format="enum",
 *			enum={0, 1},
 *			example=1
 *      ),
 *      @OA\Property(
 *          property="notes",
 *          description="Notes about the Guest, if any",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *          format="sentence",
 *          maxLength=191,
 *          example="They are interested in A&S"
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
 *			property="event",
 *			type="object",
 *			allOf={
 *				@OA\Property(
 *					title="Event",
 *					description="Attachable Demo Event they played at."
 *				),
 *				@OA\Schema(ref="#/components/schemas/Event"),
 *			},
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="chapter",
 *			type="object",
 *			allOf={
 *				@OA\Property(
 *					title="Chapter",
 *					description="Attachable closest Chapter to the Guest."
 *				),
 *				@OA\Schema(ref="#/components/schemas/Chapter"),
 *			},
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="waiver",
 *			type="object",
 *			allOf={
 *				@OA\Property(
 *					title="Waiver",
 *					description="Attachable Waiver for the Guest."
 *				),
 *				@OA\Schema(ref="#/components/schemas/Waiver"),
 *			},
 *			readOnly=true
 *		)
 * )
 */
 
/**
 *	@OA\Schema(
 *		schema="GuestSimple",
 *		@OA\Property(
 *			property="id",
 *			description="The entry's ID.",
 *			type="integer",
 *			format="int32",
 *			example=42,
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="event_id",
 *			description="ID of the Demo Event they were Guests for.",
 *          readOnly=false,
 *          nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="chapter_id",
 *			description="ID of the closest Chapter to the Guest, if known.",
 *          readOnly=false,
 *          nullable=true,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="waiver_id",
 *			description="ID of the Waiver for the Guest.",
 *          readOnly=false,
 *          nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *      @OA\Property(
 *          property="is_followedup",
 *          description="Has this Guest (default false) been followed up with?",
 *          readOnly=false,
 *          nullable=false,
 *			type="integer",
 *			format="enum",
 *			enum={0, 1},
 *			example=1
 *      ),
 *      @OA\Property(
 *          property="notes",
 *          description="Notes about the Guest, if any",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *          maxLength=191,
 *          example="They are interested in A&S"
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
 *		schema="GuestSuperSimple",
 *		@OA\Property(
 *			property="id",
 *			description="The entry's ID.",
 *			type="integer",
 *			format="int32",
 *			example=42,
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="event_id",
 *			description="ID of the Demo Event they were Guests for.",
 *          readOnly=false,
 *          nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="chapter_id",
 *			description="ID of the closest Chapter to the Guest, if known.",
 *          readOnly=false,
 *          nullable=true,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="waiver_id",
 *			description="ID of the Waiver for the Guest.",
 *          readOnly=false,
 *          nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *      @OA\Property(
 *          property="is_followedup",
 *          description="Has this Guest (default false) been followed up with?",
 *          readOnly=false,
 *          nullable=false,
 *			type="integer",
 *			format="enum",
 *			enum={0, 1},
 *			example=1
 *      ),
 *      @OA\Property(
 *          property="notes",
 *          description="Notes about the Guest, if any",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *          maxLength=191,
 *          example="They are interested in A&S"
 *      )
 *	)
 */
 
/**
 *
 *	@OA\RequestBody(
 *		request="Guest",
 *		description="Guest object that needs to be added or updated.",
 *		required=true,
 *		@OA\MediaType(
 *			mediaType="multipart/form-data",
 *			@OA\Schema(ref="#/components/schemas/GuestSimple")
 *		)
 *	)
 */

class Guest extends Model
{
	use SoftDeletes;
	use HasFactory;
	use Userstamps;
	use ProtectFieldsTrait;

	public $table = 'guests';
	public $timestamps = true;
	
	protected $dates = ['created_at', 'updated_at', 'deleted_at'];
	protected $protectedFields = ['event_id', 'waiver_id'];

    public $fillable = [
        'event_id',
        'waiver_id',
        'chapter_id',
        'is_followedup',
        'notes'
    ];

    protected $casts = [
        'is_followedup' => 'boolean',
        'notes' => 'string'
    ];

    public static array $rules = [
    	'event_id' => 'required|exists:events,id',
    	'chapter_id' => 'nullable|exists:chapters,id',
    	'waiver_id' => 'required|exists:waivers,id',
    	'is_followedup' => 'boolean',
    	'notes' => 'nullable|string',
    ];
    
    public $relationships = [
    	'event' => 'BelongsTo',
    	'chapter' => 'BelongsTo',
    	'waiver' => 'BelongsTo'
    ];
    
    public function event(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
    	return $this->belongsTo(\App\Models\Event::class, 'event_id');
    }

    public function chapter(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Chapter::class, 'chapter_id');
    }
    
    public function waiver(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
    	return $this->belongsTo(\App\Models\Waiver::class, 'waiver_id');
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
