<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    // Chave primária da tabela rooms
    protected $primaryKey = 'id_sala';

    protected $fillable = [
        'designacao',
        'capacidade',
    ];
}
