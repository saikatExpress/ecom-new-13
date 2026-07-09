<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable
    ([
        'username',
        'email',
        'phone_number',
        'verification_otp',
        'verification_otp_expires_at',
        'email_verified_at',
        'password',
        'last_login_at',
        'last_logout_at',
        'img_path',
        'status',
        'created_by',
        'updated_by',
        'deleted_by'
    ])
]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
