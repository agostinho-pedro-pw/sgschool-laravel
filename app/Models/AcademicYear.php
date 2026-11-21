<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcademicYear extends Model
{
    // Campos que podem ser preenchidos pelos formulários.
    protected $fillable = [
        'designation',
        'start_date',
        'end_date',
    ];
}
