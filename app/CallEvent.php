<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CallEvent extends Model
{
    protected $dates = [
        'created_at',
        'updated_at',
        'timestamp',
    ];

    protected $fillable = [
        'event',
        'timestamp',
        'sequence_step',
    ];

    public function call() {
        return $this->belongsTo(Call::class);
    }
}
