<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    // Chave primária da tabela departments
    protected $primaryKey = 'department_id';

    protected $fillable = [
        'department_name',
        'department_code',
        'description',
    ];
    // O departamento tem varios cursos
    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
