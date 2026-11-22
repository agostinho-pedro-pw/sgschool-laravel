<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Registration extends Model
{
    use HasFactory;
    use SoftDeletes;

    // Campos que o controller pode guardar ou atualizar.
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
    ];

    // Converte a data de nascimento para um objeto de data do Laravel.
    protected function casts(): array
    {
        return [
            'dateOfBirth' => 'date',
        ];
    }
}
