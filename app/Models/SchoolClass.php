<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SchoolClass extends Model
{
    use HasFactory;

    protected $fillable = [
        'className',
        'course_id',
        'period',
        'room_id',
        'class_level_id',
    ];

    // Cada turma pertence a um curso.
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    // Cada turma pertence a uma sala, cuja chave primária é id_sala.
    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class, 'room_id', 'id_sala');
    }

    // Cada turma pertence a um nível de classe.
    public function classLevel(): BelongsTo
    {
        return $this->belongsTo(ClassLevel::class, 'class_level_id', 'id_classe');
    }
}
