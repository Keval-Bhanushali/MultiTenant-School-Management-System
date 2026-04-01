<?php

namespace App\Models;

use App\Support\RoleMap;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use MongoDB\Laravel\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class User extends Authenticatable implements AuthenticatableContract
{
    use HasFactory, Notifiable;

    protected $connection = 'mongodb';

    protected $collection = 'users';

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'tenant_id',
        'role_id',
        'role',
        'school_id',
        'status',
        'preferred_language',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role_id' => 'integer',
        ];
    }

    public function getRoleAttribute($value): string
    {
        if (is_string($value) && $value !== '') {
            return $value;
        }

        return RoleMap::nameFromId((int) ($this->attributes['role_id'] ?? RoleMap::STUDENT));
    }

    public function setRoleAttribute($value): void
    {
        if (is_numeric($value)) {
            $this->attributes['role_id'] = (int) $value;
            $this->attributes['role'] = RoleMap::nameFromId((int) $value);
            return;
        }

        $role = strtolower((string) $value);
        $this->attributes['role'] = $role;
        $this->attributes['role_id'] = RoleMap::idFromName($role);
    }

    public function isSuperAdmin(): bool
    {
        return (int) ($this->role_id ?? 0) === RoleMap::SUPERADMIN || $this->role === 'superadmin';
    }

    public function school()
    {
        return $this->belongsTo(School::class, 'school_id');
    }
}
