<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SchoolClass extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomeTurma',
        'classe',
        'course_id',
        'periodo',
        'room_id',
    ];

    // Cada turma pertence a um curso
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    // Cada turma pertence a uma sala (a chave primária de rooms é id_sala)
    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class, 'room_id', 'id_sala');
    }
}
