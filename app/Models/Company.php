<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'email',
        'address',
        'status',
        'workType',
        'position',
        'hiredStudents',
        'description',
    ];

    protected $casts = [
        'position' => 'json',
        'hiredStudents' => 'json',
    ];

    public function students()
    {
        return $this->belongsToMany(Student::class);
    }

    public function hiredStudents()
    {
        return $this->belongsToMany(Student::class, 'company_student', 'company_id', 'student_id');
    }
}
