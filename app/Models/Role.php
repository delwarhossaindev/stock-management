<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['name', 'guard_name', 'is_protected'];

    protected $casts = [
        'is_protected' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::deleting(function (Role $role) {
            if ($role->is_protected) {
                throw new \Exception(__('This role cannot be deleted.'));
            }
        });
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permission');
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function hasPermission(string $permission): bool
    {
        return $this->permissions()->where('name', $permission)->exists();
    }
}
