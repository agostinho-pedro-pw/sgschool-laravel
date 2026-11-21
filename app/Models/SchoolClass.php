<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomeTurma',
        'anoLetivo',
        'classe',
        'curso',
        'periodo',
        'sala',
    ];
}
