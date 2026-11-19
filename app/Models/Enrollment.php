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
        'applicationDate',
        'status',
    ];

    public const COURSES = [
        'informatica-gestao' => 'informatica gestao',
        'informatica-sistemas-multimedia' => 'informatica sistemas-multimedia',
        'eletronica-telecomunicacoes' => 'eletronica telecomunicacoes',
        'analises-clinicas' => 'analises clinicas',
    ];

    protected function casts(): array
    {
        return [
            'dateOfBirth' => 'date',
            'applicationDate' => 'date',
        ];
    }
}
