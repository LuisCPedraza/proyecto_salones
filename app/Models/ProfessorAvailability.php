<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProfessorAvailability extends Model
{
    use HasFactory;

    protected $table = 'professor_availability';

    protected $fillable = [
        'professor_id',
        'day_of_week',
        'start_time',
        'end_time',
        'status',
        'notes',
    ];

    /**
     * Relación con Professor
     */
    public function professor(): BelongsTo
    {
        return $this->belongsTo(Professor::class);
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
}
