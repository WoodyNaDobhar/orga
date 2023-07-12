<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\SoftDeletes; use Illuminate\Database\Eloquent\Factories\HasFactory;
/**
 * @OA\Schema(
 *      schema="Issuance",
 *      required={"issuable_type","issuable_id","user_id","issuer_id","issuedable_type","issuedable_id","issued_at","created_at"},
 *      @OA\Property(
 *          property="issuable_type",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="issuedable_type",
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
 *          property="note",
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
 *          property="revocation",
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
        'user_id',
        'issuer_id',
        'issuedable_type',
        'issuedable_id',
        'custom_name',
        'rank',
        'issued_at',
        'note',
        'revocation',
        'revoked_by',
        'revoked_at'
    ];

    protected $casts = [
        'issuable_type' => 'string',
        'issuedable_type' => 'string',
        'custom_name' => 'string',
        'issued_at' => 'date',
        'note' => 'string',
        'revocation' => 'string',
        'revoked_at' => 'date'
    ];

    public static array $rules = [
        'issuable_type' => 'required|string',
        'issuable_id' => 'required',
        'user_id' => 'required',
        'issuer_id' => 'required',
        'issuedable_type' => 'required|string',
        'issuedable_id' => 'required',
        'custom_name' => 'nullable|string|max:64',
        'rank' => 'nullable',
        'issued_at' => 'required',
        'note' => 'nullable|string|max:400',
        'revocation' => 'nullable|string|max:50',
        'revoked_by' => 'nullable',
        'revoked_at' => 'nullable',
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
        return $this->belongsTo(\App\Models\User::class, 'issuer_id');
    }

    public function revokedBy(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'revoked_by');
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
