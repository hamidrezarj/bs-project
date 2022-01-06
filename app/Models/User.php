<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Cache;
use Laravel\Sanctum\HasApiTokens;
use Morilog\Jalali\Jalalian;
use Carbon\Carbon;

class User extends Authenticatable
{
    use HasRoles, HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $guarded = [
        'id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['full_name', 'is_online'];

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function ticket_answers()
    {
        return $this->hasMany(TicketAnswer::class, 'technical_id');
    }

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    public function getCreatedAtFaAttribute()
    {
        return Jalalian::fromCarbon(new Carbon($this->created_at));
    }

    public function getFullNameAttribute()
    {
        return $this->first_name. " ". $this->last_name;
    }

    public function getIsOnlineAttribute()
    {
        return Cache::has('user-is-online-'. $this->id);
    }
}
