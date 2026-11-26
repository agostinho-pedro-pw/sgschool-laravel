<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
