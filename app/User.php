<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'online',
        'available',
        'deactivated_at',
        'deactivated_by',
        'availability_changed_at',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deactivated_at',
        'availability_changed_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function number()
    {
        return $this->hasOne(Number::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function voicemails()
    {
        return $this->hasMany(Voicemail::class);
    }

    public function setPasswordAttribute($value)
    {
        return $this->attributes['password'] = bcrypt($value);
    }

    public function setAvailableAttribute($value)
    {
        $this->attributes['available'] = $value;

        $this->attributes['availability_changed_at'] = Carbon::now();
    }

    /**
     * Scope a query to only include active users.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->whereNull('deactivated_at');
    }

    public function deactivate()
    {
        $this->update([
            'deactivated_at' => Carbon::now(),
            'deactivated_by' => auth()->id(),
        ]);
    }

    public function isAdministrator()
    {
        return $this->role->slug == 'administrator';
    }
}
