<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'language',
    ];

    protected $cachedPermissions = null;

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function isAdmin(): bool
    {
        $role = $this->getRelationValue('role');
        if ($role instanceof Role) {
            return $role->name === 'admin';
        }
        // Fallback for legacy string role attribute (before role_id migration)
        return $this->getAttribute('role') === 'admin';
    }

    public function getAllPermissions(): \Illuminate\Support\Collection
    {
        if ($this->cachedPermissions === null) {
            $role = $this->getRelationValue('role');
            if ($role instanceof Role) {
                $this->cachedPermissions = $role->permissions()->pluck('name');
            } else {
                $this->cachedPermissions = collect();
            }
        }
        return $this->cachedPermissions;
    }

    public function hasPermission(string $permission): bool
    {
        if ($this->isAdmin()) {
            return true;
        }
        return $this->getAllPermissions()->contains($permission);
    }

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
        'password' => 'hashed',
    ];
}
