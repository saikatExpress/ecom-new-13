<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginHistory extends Model
{
    protected $guarded = [];

    protected $casts = [

        'success' => 'boolean',

        'login_at' => 'datetime',

        'logout_at' => 'datetime',

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
