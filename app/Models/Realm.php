<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\SoftDeletes; use Illuminate\Database\Eloquent\Factories\HasFactory;
/**
 * @OA\Schema(
 *      schema="Realm",
 *      required={"name","abbreviation","color","is_active","created_at"},
 *      @OA\Property(
 *          property="name",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="abbreviation",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="color",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
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
 *          property="is_active",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="boolean",
 *      ),
 *      @OA\Property(
 *          property="average_period_type",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="dues_intervals_type",
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
 */class Realm extends Model
{
     use SoftDeletes;    use HasFactory;    public $table = 'kingdoms';

    public $fillable = [
        'parent_id',
        'name',
        'abbreviation',
        'color',
        'heraldry',
        'is_active',
        'credit_minimum',
        'credit_maximum',
        'daily_minimum',
        'weekly_minimum',
        'average_period_type',
        'average_period',
        'dues_intervals_type',
        'dues_intervals',
        'dues_amount',
        'dues_take'
    ];

    protected $casts = [
        'name' => 'string',
        'abbreviation' => 'string',
        'color' => 'string',
        'heraldry' => 'string',
        'is_active' => 'boolean',
        'average_period_type' => 'string',
        'dues_intervals_type' => 'string'
    ];

    public static array $rules = [
        'parent_id' => 'nullable',
        'name' => 'required|string|max:100',
        'abbreviation' => 'required|string|max:4',
        'color' => 'required|string|max:6',
        'heraldry' => 'nullable|string|max:255',
        'is_active' => 'required|boolean',
        'credit_minimum' => 'nullable',
        'credit_maximum' => 'nullable',
        'daily_minimum' => 'nullable',
        'weekly_minimum' => 'nullable',
        'average_period_type' => 'nullable|string',
        'average_period' => 'nullable',
        'dues_intervals_type' => 'nullable|string',
        'dues_intervals' => 'nullable',
        'dues_amount' => 'nullable',
        'dues_take' => 'nullable',
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

    public function updatedBy(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'updated_by');
    }

    public function chapters(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Chapter::class, 'kingdom_id');
    }

    public function chaptertypes(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Chaptertype::class, 'kingdom_id');
    }

    public function suspensions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Suspension::class, 'kingdom_id');
    }
}
