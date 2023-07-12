<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use App\Traits\CanGetTableNameStatically;
// use App\Traits\ImageTrait;
// use App\Traits\NullableTrait;
// use GeneaLabs\LaravelPivotEvents\Traits\PivotEventTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
// use Lab404\Impersonate\Models\Impersonate;
use Laravel\Sanctum\HasApiTokens;
// use OwenIt\Auditing\Contracts\Auditable;
// use OwenIt\Auditing\Models\Audit;
// use Spatie\Permission\Traits\HasRoles;
use Wildside\Userstamps\Userstamps;

/**
 * @OA\Schema(
 *      schema="User",
 *      required={"park_id","name","persona","email","password","restricted","waivered","waiver_ext","penalty_box","is_active","created_at"},
 *      @OA\Property(
 *          property="name",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="persona",
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
 *          property="image",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="email",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="email_verified_at",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *          format="date-time"
 *      ),
 *      @OA\Property(
 *          property="password",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="remember_token",
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
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory;
	use SoftDeletes;
	use Notifiable;
	// use ImageTrait {
	// 	deleteImage as traitDeleteImage;
	// }
	use Userstamps;
	// use NullableTrait;
	// use \OwenIt\Auditing\Auditable;
	// use PivotEventTrait;
	// use Impersonate;
	// use CanGetTableNameStatically;
	use HasRoles;
	use HasApiTokens;
    
    public $table = 'users';

    public $fillable = [
        'park_id',
        'pronoun_id',
        'name',
        'persona',
        'heraldry',
        'image',
        'email',
        'email_verified_at',
        'password',
        'remember_token',
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
        'name' => 'string',
        'persona' => 'string',
        'heraldry' => 'string',
        'image' => 'string',
        'email' => 'string',
        'email_verified_at' => 'datetime',
        'password' => 'string',
        'remember_token' => 'string',
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
        'pronoun_id' => 'nullable',
        'name' => 'required|string|max:255',
        'persona' => 'required|string|max:255',
        'heraldry' => 'nullable|string|max:255',
        'image' => 'nullable|string|max:255',
        'email' => 'required|string|max:255',
        'email_verified_at' => 'nullable',
        'password' => 'required|string|max:255',
        'remember_token' => 'nullable|string|max:100',
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

    public function attendances(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Attendance::class, 'user_id');
    }

    public function duesRevoked(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Due::class, 'revoked_by');
    }

    public function dues(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Due::class, 'user_id');
    }

    public function eventsAutocrated(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Event::class, 'autocrat_id');
    }

    public function issuancesIssued(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Issuance::class, 'issuer_id');
    }

    public function issuancesRevoked(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Issuance::class, 'revoked_by');
    }

    public function issuances(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Issuance::class, 'user_id');
    }

    public function memberships(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Member::class, 'user_id');
    }

    public function officersAuthorized(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Officer::class, 'authorized_by');
    }

    public function officesHeld(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Officer::class, 'user_id');
    }

    public function recommendations(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Recommendation::class, 'user_id');
    }

    public function reconciliations(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Reconciliation::class, 'user_id');
    }

    public function splits(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Split::class, 'user_id');
    }

    public function suspensionsEnforced(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Suspension::class, 'suspended_by');
    }

    public function suspensions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Suspension::class, 'user_id');
    }

    //Created/Updated/Deleted relations

    public function accountsCreated(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Account::class, 'created_by');
    }

    public function accountsDeleted(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Account::class, 'deleted_by');
    }

    public function accountsUpdated(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Account::class, 'updated_by');
    }

    public function archetypesCreated(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Archetype::class, 'created_by');
    }

    public function archetypesDeleted(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Archetype::class, 'deleted_by');
    }

    public function archetypesUpdated(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Archetype::class, 'updated_by');
    }

    public function attendancesCreated(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Attendance::class, 'created_by');
    }

    public function attendancesDeleted(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Attendance::class, 'deleted_by');
    }

    public function attendancesUpdated(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Attendance::class, 'updated_by');
    }

    public function awardsCreated(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Award::class, 'created_by');
    }

    public function awardsDeleted(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Award::class, 'deleted_by');
    }

    public function awardsUpdated(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Award::class, 'updated_by');
    }

    public function configurationsCreated(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Configuration::class, 'created_by');
    }

    public function configurationsDeleted(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Configuration::class, 'deleted_by');
    }

    public function configurationsUpdated(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Configuration::class, 'updated_by');
    }

    public function duesCreated(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Due::class, 'created_by');
    }

    public function duesDeleted(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Due::class, 'deleted_by');
    }

    public function duesUpdated(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Due::class, 'updated_by');
    }

    public function eventsCreated(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Event::class, 'created_by');
    }

    public function eventsDeleted(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Event::class, 'deleted_by');
    }

    public function eventsUpdated(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Event::class, 'updated_by');
    }

    public function issuancesCreated(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Issuance::class, 'created_by');
    }

    public function issuancesDeleted(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Issuance::class, 'deleted_by');
    }

    public function issuancesUpdated(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Issuance::class, 'updated_by');
    }

    public function kingdomOfficesCreated(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\KingdomOffice::class, 'created_by');
    }

    public function kingdomOfficesDeleted(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\KingdomOffice::class, 'deleted_by');
    }

    public function kingdomOfficesUpdated(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\KingdomOffice::class, 'updated_by');
    }

    public function kingdomTitlesCreated(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\KingdomTitle::class, 'created_by');
    }

    public function kingdomTitlesDeleted(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\KingdomTitle::class, 'deleted_by');
    }

    public function kingdomTitlesUpdated(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\KingdomTitle::class, 'updated_by');
    }

    public function kingdomsCreated(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Kingdom::class, 'created_by');
    }

    public function kingdomsDeleted(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Kingdom::class, 'deleted_by');
    }

    public function kingdomsUpdated(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Kingdom::class, 'updated_by');
    }

    public function locationsCreated(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Location::class, 'created_by');
    }

    public function locationsDeleted(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Location::class, 'deleted_by');
    }

    public function locationsUpdated(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Location::class, 'updated_by');
    }

    public function meetupsCreated(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Meetup::class, 'created_by');
    }

    public function meetupsDeleted(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Meetup::class, 'deleted_by');
    }

    public function meetupsUpdated(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Meetup::class, 'updated_by');
    }

    public function membersCreated(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Member::class, 'created_by');
    }

    public function membersDeleted(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Member::class, 'deleted_by');
    }

    public function membersUpdated(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Member::class, 'updated_by');
    }

    public function officersCreated(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Officer::class, 'created_by');
    }

    public function officersDeleted(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Officer::class, 'deleted_by');
    }

    public function officersUpdated(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Officer::class, 'updated_by');
    }

    public function officesCreated(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Office::class, 'created_by');
    }

    public function officesDeleted(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Office::class, 'deleted_by');
    }

    public function officesUpdated(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Office::class, 'updated_by');
    }

    public function parkranksCreated(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Parkrank::class, 'created_by');
    }

    public function parkranksDeleted(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Parkrank::class, 'deleted_by');
    }

    public function parkranksUpdated(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Parkrank::class, 'updated_by');
    }

    public function parksCreated(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Park::class, 'created_by');
    }

    public function parksDeleted(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Park::class, 'deleted_by');
    }

    public function parksUpdated(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Park::class, 'updated_by');
    }

    public function pronounsCreated(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Pronoun::class, 'created_by');
    }

    public function pronounsDeleted(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Pronoun::class, 'deleted_by');
    }

    public function pronounsUpdated(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Pronoun::class, 'updated_by');
    }

    public function recommendationsCreated(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Recommendation::class, 'created_by');
    }

    public function recommendationsDeleted(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Recommendation::class, 'deleted_by');
    }

    public function recommendationsUpdated(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Recommendation::class, 'updated_by');
    }

    public function reconciliationsCreated(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Reconciliation::class, 'created_by');
    }

    public function reconciliationsDeleted(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Reconciliation::class, 'deleted_by');
    }

    public function reconciliationsUpdated(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Reconciliation::class, 'updated_by');
    }

    public function splitsCreated(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Split::class, 'created_by');
    }

    public function splitsDeleted(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Split::class, 'deleted_by');
    }

    public function splitsUpdated(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Split::class, 'updated_by');
    }

    public function suspensionsCreated(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Suspension::class, 'created_by');
    }

    public function suspensionsDeleted(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Suspension::class, 'deleted_by');
    }

    public function suspensionsUpdated(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Suspension::class, 'updated_by');
    }

    public function titlesCreated(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Title::class, 'created_by');
    }

    public function titlesDeleted(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Title::class, 'deleted_by');
    }

    public function titlesUpdated(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Title::class, 'updated_by');
    }

    public function tournamentsCreated(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Tournament::class, 'created_by');
    }

    public function tournamentsDeleted(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Tournament::class, 'deleted_by');
    }

    public function tournamentsUpdated(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Tournament::class, 'updated_by');
    }

    public function transactionsCreated(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Transaction::class, 'created_by');
    }

    public function transactionsDeleted(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Transaction::class, 'deleted_by');
    }

    public function transactionsUpdated(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Transaction::class, 'updated_by');
    }

    public function unitsCreated(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Unit::class, 'created_by');
    }

    public function unitsDeleted(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Unit::class, 'deleted_by');
    }

    public function unitsUpdated(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Unit::class, 'updated_by');
    }
}
