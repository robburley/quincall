<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Voicemail extends Model
{
    protected $fillable = [
        'call_sid',
        'recording_sid',
        'from',
        'to',
        'duration',
        'location',
        'external_url',
        'downloaded_at',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
