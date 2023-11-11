<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\SoftDeletes; use Illuminate\Database\Eloquent\Factories\HasFactory;
/**
 * @OA\Schema(
 *      schema="Waiver",
 *      required={"waiverable_type","waiverable_id","player","created_at"},
 *      @OA\Property(
 *          property="waiverable_type",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="file",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="player",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="email",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="phone",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="dob",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *          format="date"
 *      ),
 *      @OA\Property(
 *          property="age_verified_at",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *          format="date"
 *      ),
 *      @OA\Property(
 *          property="guardian",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="emergency_contact_name",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="emergency_contact_phone",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="signed_at",
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
 */class Waiver extends Model
{
     use SoftDeletes;    use HasFactory;    public $table = 'waivers';

    public $fillable = [
        'pronoun_id',
        'persona_id',
        'waiverable_type',
        'waiverable_id',
        'file',
        'player',
        'email',
        'phone',
        'location_id',
        'dob',
        'age_verified_at',
        'age_verified_by',
        'guardian',
        'emergency_contact_name',
        'emergency_contact_phone',
        'signed_at'
    ];

    protected $casts = [
        'waiverable_type' => 'string',
        'file' => 'string',
        'player' => 'string',
        'email' => 'string',
        'phone' => 'string',
        'dob' => 'date',
        'age_verified_at' => 'date',
        'guardian' => 'string',
        'emergency_contact_name' => 'string',
        'emergency_contact_phone' => 'string',
        'signed_at' => 'date'
    ];

    public static array $rules = [
        'pronoun_id' => 'nullable',
        'persona_id' => 'nullable',
        'waiverable_type' => 'required|string',
        'waiverable_id' => 'required',
        'file' => 'nullable|string|max:255',
        'player' => 'required|string|max:150',
        'email' => 'nullable|string|max:255',
        'phone' => 'nullable|string|max:25',
        'location_id' => 'nullable',
        'dob' => 'nullable',
        'age_verified_at' => 'nullable',
        'age_verified_by' => 'nullable',
        'guardian' => 'nullable|string|max:150',
        'emergency_contact_name' => 'nullable|string|max:150',
        'emergency_contact_phone' => 'nullable|string|max:25',
        'signed_at' => 'nullable',
        'created_at' => 'required',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];

    public function ageVerifiedBy(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'age_verified_by');
    }

    public function createdBy(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by');
    }

    public function deletedBy(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'deleted_by');
    }

    public function location(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Location::class, 'location_id');
    }

    public function persona(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Persona::class, 'persona_id');
    }

    public function pronoun(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Pronoun::class, 'pronoun_id');
    }

    public function updatedBy(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'updated_by');
    }
}
