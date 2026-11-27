<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SchoolClass;

class ClassLevel extends Model
{
    use HasFactory;

    // Nome da tabela usada por este model.
    protected $table = 'classes';

    // Chave primária personalizada da tabela.
    protected $primaryKey = 'id_classe';

    // Campos que podem ser guardados pelo controller.
    protected $fillable = [
        'nome_classe',
        'descricao',
    ];

    public function schoolClasses()
    {
        return $this->hasMany(SchoolClass::class, 'class_level_id', 'id_classe');
    }
}
