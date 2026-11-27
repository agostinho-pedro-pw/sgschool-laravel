<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ClassLevel extends Model
{
    use HasFactory;

    protected $table = 'class_levels';

    protected $primaryKey = 'classLevelId';

    protected $fillable = [
        'classLevelName',
        'description',
    ];

    public function schoolClasses(): HasMany
    {
        return $this->hasMany(
            SchoolClass::class,
            'class_level_id',
            'classLevelId'
        );
    }
}
