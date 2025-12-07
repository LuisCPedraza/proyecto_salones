<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'role_id',
        'status',
        'last_login_at',
        'access_expires_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'last_login_at' => 'datetime',
        'access_expires_at' => 'datetime',
    ];

    /**
     * Relación con Role
     */
    public function roleModel(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    /**
     * Relación con Professor
     */
    public function professor(): HasOne
    {
        return $this->hasOne(Professor::class);
    }

    /**
     * Relación con StudentGroups creados
     */
    public function studentGroups(): HasMany
    {
        return $this->hasMany(StudentGroup::class, 'created_by');
    }

    /**
     * Relación con Classrooms creados
     */
    public function classrooms(): HasMany
    {
        return $this->hasMany(Classroom::class, 'created_by');
    }

    /**
     * Relación con Assignments creados
     */
    public function assignments(): HasMany
    {
        return $this->hasMany(Assignment::class, 'created_by');
    }

    /**
     * Relación con AssignmentHistory
     */
    public function assignmentHistories(): HasMany
    {
        return $this->hasMany(AssignmentHistory::class);
    }

    /**
     * Verificar si el usuario tiene un rol específico
     */
    public function hasRole(string $role): bool
    {
        return $this->role === $role || ($this->roleModel && $this->roleModel->name === $role);
    }

    /**
     * Verificar si el usuario tiene un permiso específico
     */
    public function hasPermission(string $permission): bool
    {
        if ($this->hasRole('admin')) {
            return true;
        }

        if ($this->roleModel) {
            return $this->roleModel->permissions()->where('name', $permission)->exists();
        }

        return false;
    }

    /**
     * Verificar si el acceso temporal ha expirado (para profesores invitados)
     */
    public function isAccessExpired(): bool
    {
        if ($this->access_expires_at === null) {
            return false;
        }

        return now()->isAfter($this->access_expires_at);
    }

    /**
     * Verificar si el usuario está activo
     */
    public function isActive(): bool
    {
        return $this->status === 'active' && !$this->isAccessExpired();
    }
}
