<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\SoftDeletes; use Illuminate\Database\Eloquent\Factories\HasFactory;
/**
 * @OA\Schema(
 *      schema="Persona",
 *      required={"park_id","restricted","waivered","waiver_ext","penalty_box","is_active","created_at"},
 *      @OA\Property(
 *          property="mundane",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="persona",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="heraldry",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="image",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="restricted",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="boolean",
 *      ),
 *      @OA\Property(
 *          property="waivered",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="boolean",
 *      ),
 *      @OA\Property(
 *          property="waiver_ext",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="penalty_box",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="boolean",
 *      ),
 *      @OA\Property(
 *          property="is_active",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="boolean",
 *      ),
 *      @OA\Property(
 *          property="reeve_qualified_expires",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *          format="date"
 *      ),
 *      @OA\Property(
 *          property="corpora_qualified_expires",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *          format="date"
 *      ),
 *      @OA\Property(
 *          property="joined_park_at",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *          format="date"
 *      ),
 *      @OA\Property(
 *          property="created_at",
 *          description="",
 *          readOnly=true,
 *          nullable=false,
 *          type="string",
 *          format="date-time"
 *      ),
 *      @OA\Property(
 *          property="updated_at",
 *          description="",
 *          readOnly=true,
 *          nullable=true,
 *          type="string",
 *          format="date-time"
 *      ),
 *      @OA\Property(
 *          property="deleted_at",
 *          description="",
 *          readOnly=true,
 *          nullable=true,
 *          type="string",
 *          format="date-time"
 *      )
 * )
 */class Persona extends Model
{
     use SoftDeletes;    use HasFactory;    public $table = 'personas';

    public $fillable = [
        'park_id',
        'user_id',
        'pronoun_id',
        'mundane',
        'persona',
        'heraldry',
        'image',
        'restricted',
        'waivered',
        'waiver_ext',
        'penalty_box',
        'is_active',
        'reeve_qualified_expires',
        'corpora_qualified_expires',
        'joined_park_at'
    ];

    protected $casts = [
        'mundane' => 'string',
        'persona' => 'string',
        'heraldry' => 'string',
        'image' => 'string',
        'restricted' => 'boolean',
        'waivered' => 'boolean',
        'waiver_ext' => 'string',
        'penalty_box' => 'boolean',
        'is_active' => 'boolean',
        'reeve_qualified_expires' => 'date',
        'corpora_qualified_expires' => 'date',
        'joined_park_at' => 'date'
    ];

    public static array $rules = [
        'park_id' => 'required',
        'user_id' => 'nullable',
        'pronoun_id' => 'nullable',
        'mundane' => 'nullable|string|max:255',
        'persona' => 'nullable|string|max:255',
        'heraldry' => 'nullable|string|max:255',
        'image' => 'nullable|string|max:255',
        'restricted' => 'required|boolean',
        'waivered' => 'required|boolean',
        'waiver_ext' => 'required|string|max:8',
        'penalty_box' => 'required|boolean',
        'is_active' => 'required|boolean',
        'reeve_qualified_expires' => 'nullable',
        'corpora_qualified_expires' => 'nullable',
        'joined_park_at' => 'nullable',
        'created_at' => 'required',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];

    public function createdBy(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by');
    }

    public function deletedBy(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'deleted_by');
    }

    public function park(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Park::class, 'park_id');
    }

    public function pronoun(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Pronoun::class, 'pronoun_id');
    }

    public function updatedBy(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'updated_by');
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
