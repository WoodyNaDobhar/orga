<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\SoftDeletes; use Illuminate\Database\Eloquent\Factories\HasFactory;
/**
 * @OA\Schema(
 *      schema="KingdomTitle",
 *      required={"kingdom_id","title_id","created_at"},
 *      @OA\Property(
 *          property="custom_name",
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
 */class KingdomTitle extends Model
{
     use SoftDeletes;    use HasFactory;    public $table = 'kingdom_title';

    public $fillable = [
        'kingdom_id',
        'title_id',
        'custom_name'
    ];

    protected $casts = [
        'custom_name' => 'string'
    ];

    public static array $rules = [
        'kingdom_id' => 'required',
        'title_id' => 'required',
        'custom_name' => 'nullable|string|max:100',
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

    public function kingdom(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Kingdom::class, 'kingdom_id');
    }

    public function title(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Kingdom::class, 'title_id');
    }

    public function updatedBy(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'updated_by');
    }
}
