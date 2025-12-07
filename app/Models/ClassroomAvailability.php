<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClassroomAvailability extends Model
{
    use HasFactory;

    protected $table = 'classroom_availability';

    protected $fillable = [
        'classroom_id',
        'day_of_week',
        'start_time',
        'end_time',
        'status',
        'notes',
    ];

    /**
     * Relación con Classroom
     */
    public function classroom(): BelongsTo
    {
        return $this->belongsTo(Classroom::class);
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
