<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Enrollment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'fullName',
        'dateOfBirth',
        'phone',
        'email',
        'gender',
        'course',
        'schoolClass',
        'room',
        'period',
        'applicationDate',
        'status',
    ];

    public const COURSES = [
        'informatica-gestao' => 'Business Informatics',
        'informatica-sistemas-multimedia' => 'Computer Science and Multimedia Systems',
        'eletronica-telecomunicacoes' => 'Electronics and Telecommunications',
        'analises-clinicas' => 'Clinical Analysis',
    ];

    public const CLASSES = [
        '10.ª A',
        '10.ª B',
        '11.ª A',
        '12.ª A',
        '13.ª A',
    ];

    public const ROOMS = [
        'Sala-01',
        'Sala-02',
        'Sala-03',
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
