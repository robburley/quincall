<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CallRecording extends Model
{
    protected $fillable = [
        'duration',
        'location',
    ];

    public function call() {
        return $this->belongsTo(Call::class);
    }
}
