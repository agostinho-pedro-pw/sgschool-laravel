<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\SchoolClass;

class Room extends Model
{
    // Chave primária da tabela rooms
    protected $primaryKey = 'id_sala';
    // from now on sala tem varios turmas 
    public function schoolClasses()
    {
        return $this->hasMany(SchoolClass::class, 'room_id');
    }
    protected $fillable = [
        'designacao',
        'capacidade',
    ];
}
