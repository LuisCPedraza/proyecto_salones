<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicPeriod extends Model
{
    use HasFactory;

    protected $table = 'academic_periods';

    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'status',
        'configuration',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'configuration' => 'array',
    ];

    /**
     * Obtener el período académico activo
     */
    public static function active()
    {
        return self::where('status', 'active')->first();
    }

    /**
     * Verificar si el período está activo
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }
}
