<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Profile;
use App\Models\Scopes\CompanyScope;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use HasRoles;
    use SoftDeletes;
    use LogsActivity;

    // protected static $recordEvents = ['deleted'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'company_id',
        'identity',
        'sgk_id',
        'recruitment_date',
        'gsm',
        'iban',
        'position',
        'holidays',
        'info',
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope(new CompanyScope());
    }



    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logFillable()
        ->logOnlyDirty();
        // Chain fluent methods for configuration options
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];



    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('name', 'like', '%' . $search . '%');
        });

        $query->when($filters['company'] ?? null, function ($query, $company) {
            $query->where('company_id', $company);
        });
    }




    public function scopeOrder($query, array $filters)
    {

        $query->when(($filters['field'] === 'name' && $filters['order']) ?? null, function ($query) use ($filters) {
            $query->orderBy('name', $filters['order']);
        });

        $query->when(($filters['field'] === 'sgk' && $filters['order']) ?? null, function ($query) use ($filters) {
            $query->select('users.*')
            ->join('sgks', 'sgks.id', '=', 'users.sgk_id')
            ->orderBy('sgks.name', $filters['order']);
        });

        $query->when(($filters['field'] === 'created_at' && $filters['order']) ?? null, function ($query) use ($filters) {
            $query->orderBy('created_at', $filters['order']);
        });

    }


    /**
     * The profile that belong to the user.
     */
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * The profile that belong to the user.
     */
    public function sgk()
    {
        return $this->belongsTo(Sgk::class);
    }



    /**
     * The document that belong to the user.
     */
    public function documents()
    {
        return $this->hasMany(Document::class)->latest();
    }


    public function getCreatedAtAttribute()
    {
        return date('d-m-Y H:i', strtotime($this->attributes['created_at']));
    }

    public function getUpdatedAtAttribute()
    {
        return date('d-m-Y H:i', strtotime($this->attributes['updated_at']));
    }

    public function getRecruitmentDateAttribute()
    {
        return date('Y-m-d', strtotime($this->attributes['recruitment_date']));
    }




    // public function getIdentityAttribute($value)
    // {
    //     $this->attributes['identity'] = decrypt($value);
    // }

    // public function setIdentityAttribute($value)
    // {
    //     $this->attributes['identity'] = bcrypt($value);
    // }

    // public function getEmailVerifiedAtAttribute()
    // {
    //     return $this->attributes['email_verified_at'] == null ? null : date('d-m-Y H:i', strtotime($this->attributes['email_verified_at']));
    // }

    public function getPermissionArray()
    {
        return $this->getAllPermissions()->mapWithKeys(function ($pr) {
            return [$pr['name'] => true];
        });
    }


    // public function getRedirectRoute()
    // {
    //     if ($this->hasAnyRole(['superadmin', 'admin', 'operator'])) {
    //         return 'dashboard' ;
    //     };
    //     return route('users.show', $this->id);

    // }

    //   /**
    //  * Send the email verification notification.
    //  *
    //  * @return void
    //  */
    // public function sendEmailVerificationNotification()
    // {
    //     $this->notify(new \App\Notifications\Auth\VerifyEmail());
    // }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new \App\Notifications\Auth\ResetPassword($token));
    }

    public function sendEmailVerificationNotification()
    {
        $status = $this->notify(new \App\Notifications\Auth\VerifyEmailQueued());

        if (['status' => 'verification-link-sent']) {
            return back()->with('success', 'E-posta doğrulama bağlantısı adresinize gönderildi.');
        }
    }

    // public function resolveRouteBinding($value, $field = null)
    // {
    //     return $this->where('name', $value)->firstOrFail();
    // }
}
