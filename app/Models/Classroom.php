<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Classroom extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'capacity',
        'location',
        'resources',
        'description',
        'status',
        'created_by',
    ];

    protected $casts = [
        'resources' => 'array',
    ];

    /**
     * Relación con User que creó el registro
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Relación con ClassroomAvailability
     */
    public function availabilities(): HasMany
    {
        return $this->hasMany(ClassroomAvailability::class);
    }

    /**
     * Relación con ClassroomRestriction
     */
    public function restrictions(): HasMany
    {
        return $this->hasMany(ClassroomRestriction::class);
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
     * Verificar si el salón está disponible en un horario específico
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

    /**
     * Obtener restricciones activas
     */
    public function activeRestrictions()
    {
        return $this->restrictions()->where('status', 'active');
    }
}
