<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProfessorSpecialAssignment extends Model
{
    use HasFactory;

    protected $table = 'professor_special_assignments';

    protected $fillable = [
        'professor_id',
        'description',
        'assignment_date',
        'start_time',
        'end_time',
        'type',
        'notes',
    ];

    protected $casts = [
        'assignment_date' => 'date',
    ];

    /**
     * Relación con Professor
     */
    public function professor(): BelongsTo
    {
        return $this->belongsTo(Professor::class);
    }
}
