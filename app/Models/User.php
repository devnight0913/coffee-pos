<?php

namespace App\Models;

use App\Traits\HasProfilePhoto;
use App\Traits\HasUuid;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasUuid, HasProfilePhoto;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'phone',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Scope a query to search posts
     */
    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        return $query->where('name', 'LIKE', "%{$search}%");
    }

    public function getIsSuperAdminAttribute(): bool
    {
        return $this->role == Role::SUPER_ADMIN;
    }
    public function getIsAdminAttribute(): bool
    {
        return $this->role == Role::ADMIN;
    }
    public function getIsCashierAttribute(): bool
    {
        return $this->role == Role::CASHIER;
    }

    public function getCanCreateAttribute(): bool
    {
        return $this->role == Role::ADMIN || $this->role == Role::SUPER_ADMIN;
    }
    public function getCanEditAttribute(): bool
    {
        return $this->role == Role::ADMIN || $this->role == Role::SUPER_ADMIN;
    }

    public function getCanDeleteAttribute(): bool
    {
        return $this->role == Role::ADMIN || $this->role == Role::SUPER_ADMIN;
    }
}
