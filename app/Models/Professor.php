<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Professor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'specialties',
        'cv_path',
        'status',
        'created_by',
    ];

    protected $casts = [
        'specialties' => 'array',
    ];

    /**
     * Relación con User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación con User que creó el registro
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Relación con ProfessorAvailability
     */
    public function availabilities(): HasMany
    {
        return $this->hasMany(ProfessorAvailability::class);
    }

    /**
     * Relación con ProfessorSpecialAssignment
     */
    public function specialAssignments(): HasMany
    {
        return $this->hasMany(ProfessorSpecialAssignment::class);
    }

    /**
     * Relación con Assignments
     */
    public function assignments(): HasMany
    {
        return $this->hasMany(Assignment::class);
    }

    /**
     * Obtener disponibilidad para un día específico
     */
    public function getAvailabilityForDay(int $dayOfWeek)
    {
        return $this->availabilities()
            ->where('day_of_week', $dayOfWeek)
            ->where('status', 'available')
            ->get();
    }

    /**
     * Verificar si el profesor está disponible en un horario específico
     */
    public function isAvailableAt(int $dayOfWeek, string $startTime, string $endTime): bool
    {
        return $this->availabilities()
            ->where('day_of_week', $dayOfWeek)
            ->where('status', 'available')
            ->where('start_time', '<=', $startTime)
            ->where('end_time', '>=', $endTime)
            ->exists();
    }
}
