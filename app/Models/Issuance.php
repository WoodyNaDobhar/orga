<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\SoftDeletes; use Illuminate\Database\Eloquent\Factories\HasFactory;
/**
 * @OA\Schema(
 *      schema="Issuance",
 *      required={"issuable_type","issuable_id","authority_type","authority_id","recipient_type","recipient_id","issued_at","created_at"},
 *      @OA\Property(
 *          property="issuable_type",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="whereable_type",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="authority_type",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="recipient_type",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="custom_name",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="issued_at",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *          format="date"
 *      ),
 *      @OA\Property(
 *          property="reason",
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
 *          property="revoked_at",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *          format="date"
 *      ),
 *      @OA\Property(
 *          property="revocation",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
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
 */class Issuance extends Model
{
     use SoftDeletes;    use HasFactory;    public $table = 'issuances';

    public $fillable = [
        'issuable_type',
        'issuable_id',
        'whereable_type',
        'whereable_id',
        'authority_type',
        'authority_id',
        'recipient_type',
        'recipient_id',
        'issuer_id',
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
        'issuable_type' => 'required|string',
        'issuable_id' => 'required',
        'whereable_type' => 'nullable|string',
        'whereable_id' => 'nullable',
        'authority_type' => 'required|string',
        'authority_id' => 'required',
        'recipient_type' => 'required|string',
        'recipient_id' => 'required',
        'issuer_id' => 'nullable',
        'custom_name' => 'nullable|string|max:64',
        'rank' => 'nullable',
        'issued_at' => 'required',
        'reason' => 'nullable|string|max:400',
        'image' => 'nullable|string|max:255',
        'revoked_by' => 'nullable',
        'revoked_at' => 'nullable',
        'revocation' => 'nullable|string|max:50',
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

    public function issuer(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Persona::class, 'issuer_id');
    }

    public function revokedBy(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Persona::class, 'revoked_by');
    }

    public function updatedBy(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'updated_by');
    }
}
