<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    protected $fillable = [
        'courseCode',
        'courseName',
        'department_id',
        'courseDescription',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
