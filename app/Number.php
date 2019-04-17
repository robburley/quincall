<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Number extends Model
{
    protected $fillable = [
        'number',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
