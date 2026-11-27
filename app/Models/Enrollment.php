<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Enrollment extends Model
{
    use SoftDeletes;
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    protected $fillable = [
        'fullName',
        'dateOfBirth',
        'phone',
        'email',
        'gender',
        'course_id',
        'applicationDate',
        'status',
        'biPath',
        'certificadoPath',
    ];

    public const PERIODS = [
        'manhã' => 'Manhã',
        'tarde' => 'Tarde',
        'noite' => 'Noite',
    ];

    protected function casts(): array
    {
        return [
            'dateOfBirth' => 'date',
            'applicationDate' => 'date',
        ];
    }
}
