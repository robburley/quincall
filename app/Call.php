<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Call extends Model
{
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'client_sid',
        'phone_sid',
        'direction',
        'from',
        'to',
        'duration',
        'recording_sid',
        'price',
        'user_id',
    ];

    public function events() {
        return $this->hasMany(CallEvent::class);
    }

    public function recording() {
        return $this->hasOne(CallRecording::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
