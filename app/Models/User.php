<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\HasRolesAndPermissions;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

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
    use HasFactory, Notifiable,SoftDeletes,HasApiTokens,HasRolesAndPermissions;

    // Relations
    public function createdBy()
    {
        return $this->belongsTo(User::class);
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class);
    }

    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    public function userCategory()
    {
        return $this->belongsTo(UserCategory::class, 'user_category_id', 'id');
    }

    public function loginHistories()
    {
        return $this->hasMany(LoginHistory::class);
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
