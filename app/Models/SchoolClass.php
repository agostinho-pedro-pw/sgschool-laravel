<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    use HasFactory;
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    protected $fillable = [
        'nomeTurma',
        'anoLetivo',
        'classe',
        'Course_id',
        'periodo',
        'sala',
    ];
}
