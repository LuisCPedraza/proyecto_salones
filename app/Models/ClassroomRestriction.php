<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClassroomRestriction extends Model
{
    use HasFactory;

    protected $table = 'classroom_restrictions';

    protected $fillable = [
        'classroom_id',
        'restriction_type',
        'description',
        'metadata',
        'status',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    /**
     * Relación con Classroom
     */
    public function classroom(): BelongsTo
    {
        return $this->belongsTo(Classroom::class);
    }
}
