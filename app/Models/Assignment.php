<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Assignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_group_id',
        'professor_id',
        'classroom_id',
        'day_of_week',
        'start_time',
        'end_time',
        'subject',
        'semester',
        'assignment_type',
        'status',
        'notes',
        'created_by',
    ];

    /**
     * Relación con StudentGroup
     */
    public function studentGroup(): BelongsTo
    {
        return $this->belongsTo(StudentGroup::class);
    }

    /**
     * Relación con Professor
     */
    public function professor(): BelongsTo
    {
        return $this->belongsTo(Professor::class);
    }

    /**
     * Relación con Classroom
     */
    public function classroom(): BelongsTo
    {
        return $this->belongsTo(Classroom::class);
    }

    /**
     * Relación con User que creó la asignación
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Relación con AssignmentHistory
     */
    public function histories(): HasMany
    {
        return $this->hasMany(AssignmentHistory::class);
    }

    /**
     * Obtener el nombre del día en español
     */
    public function getDayName(): string
    {
        $days = [
            0 => 'Lunes',
            1 => 'Martes',
            2 => 'Miércoles',
            3 => 'Jueves',
            4 => 'Viernes',
            5 => 'Sábado',
        ];
        return $days[$this->day_of_week] ?? 'Desconocido';
    }

    /**
     * Obtener el horario formateado
     */
    public function getFormattedTime(): string
    {
        return "{$this->start_time} - {$this->end_time}";
    }
}
