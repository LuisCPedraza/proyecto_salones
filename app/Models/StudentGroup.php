<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StudentGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'level',
        'student_count',
        'special_characteristics',
        'status',
        'created_by',
    ];

    /**
     * Relación con User que creó el grupo
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Relación con Assignments
     */
    public function assignments(): HasMany
    {
        return $this->hasMany(Assignment::class);
    }

    /**
     * Obtener todas las asignaciones activas
     */
    public function activeAssignments()
    {
        return $this->assignments()->where('status', 'active');
    }
}
