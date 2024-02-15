<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\ProtectFieldsTrait;
use Wildside\Userstamps\Userstamps;
/**
 * @OA\Schema(
 *      schema="Crat",
 *      required={"event_id","persona_id","role","is_autocrat"},
 *		description="Those running things at Events.<br>The following relationships can be attached, and in the case of plural relations, searched:
 * event (Event) (BelongsTo): Event the Persona cratted for.
 * persona (Persona) (BelongsTo): The Persona cratting the given Event.
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
 *			description="Event the Persona cratted for.",
 *          readOnly=false,
 *          nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="persona_id",
 *			description="The Persona cratting the Event.",
 *          readOnly=false,
 *          nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *      @OA\Property(
 *          property="name",
 *          description="The role of the Crat.",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *			format="uppercase first letter",
 *			example="FeastOCrat",
 *			maxLength=50
 *      ),
 *      @OA\Property(
 *          property="is_autocrat",
 *          description="Are they (default false) the person in charge?",
 *          readOnly=false,
 *          nullable=false,
 *			type="integer",
 *			format="enum",
 *			enum={0, 1},
 *			example=0
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
 *					description="Attachable Event the Persona cratted for."
 *				),
 *				@OA\Schema(ref="#/components/schemas/Event"),
 *			},
 *			readOnly=true
 *		),
 *		@OA\Property(
 *			property="persona",
 *			type="object",
 *			allOf={
 *				@OA\Property(
 *					title="Persona",
 *					description="Attachable Persona cratting the Event."
 *				),
 *				@OA\Schema(ref="#/components/schemas/Persona"),
 *			},
 *			readOnly=true
 *		)
 * )
 */
 
/**
 *	@OA\Schema(
 *		schema="CratSimple",
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
 *			description="Event the Persona cratted for.",
 *          readOnly=false,
 *          nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="persona_id",
 *			description="The Persona cratting the Event.",
 *          readOnly=false,
 *          nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *      @OA\Property(
 *          property="name",
 *          description="The role of the Crat.",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *			format="uppercase first letter",
 *			example="FeastOCrat",
 *			maxLength=50
 *      ),
 *      @OA\Property(
 *          property="is_autocrat",
 *          description="Are they (default false) the person in charge?",
 *          readOnly=false,
 *          nullable=false,
 *			type="integer",
 *			format="enum",
 *			enum={0, 1},
 *			example=0
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
 *		schema="CratSuperSimple",
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
 *			description="Event the Persona cratted for.",
 *          readOnly=false,
 *          nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="persona_id",
 *			description="The Persona cratting the Event.",
 *          readOnly=false,
 *          nullable=false,
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *      @OA\Property(
 *          property="name",
 *          description="The role of the Crat.",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *			format="uppercase first letter",
 *			example="FeastOCrat",
 *			maxLength=50
 *      ),
 *      @OA\Property(
 *          property="is_autocrat",
 *          description="Are they (default false) the person in charge?",
 *          readOnly=false,
 *          nullable=false,
 *			type="integer",
 *			format="enum",
 *			enum={0, 1},
 *			example=0
 *      )
 *	)
 */
 
/**
 *
 *	@OA\RequestBody(
 *		request="Crat",
 *		description="Crat object that needs to be added or updated.",
 *		required=true,
 *		@OA\MediaType(
 *			mediaType="multipart/form-data",
 *			@OA\Schema(ref="#/components/schemas/CratSimple")
 *		)
 *	)
 */

class Crat extends Model
{
	use SoftDeletes;
	use HasFactory;
	use Userstamps;
	use ProtectFieldsTrait;

	public $table = 'crats';
	public $timestamps = true;
	
	protected $dates = ['created_at', 'updated_at', 'deleted_at'];
	protected $protectedFields = ['event_id', 'persona_id'];

    public $fillable = [
        'event_id',
        'persona_id',
        'role',
        'is_autocrat'
    ];

    protected $casts = [
        'role' => 'string',
        'is_autocrat' => 'boolean'
    ];

    public static array $rules = [
    	'event_id' => 'required|exists:events,id',
    	'persona_id' => 'required|exists:personas,id',
    	'role' => 'required|string|max:50',
    	'is_autocrat' => 'boolean'
    ];
    
    public $relationships = [
		'event' => 'BelongsTo',
		'persona' => 'BelongsTo'
    ];
    
    public function event(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
    	return $this->belongsTo(\App\Models\Event::class, 'event_id');
    }
    
    public function persona(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
    	return $this->belongsTo(\App\Models\Persona::class, 'persona_id');
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
