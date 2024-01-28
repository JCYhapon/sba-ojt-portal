<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'studentID',
        'firstName',
        'lastName',
        'email',
        'course',
        'major',
        'section',
        'workType',
        'position',
        'suggestedCompany',
        'matchedCompany',
        'hiredCompany',
        'supervisor',
        'jobTitle',
        'status',
        'neededHours',
    ];

    protected $primaryKey = 'studentID';

    protected $casts = [
        'position' => 'json',
        'matchedCompany' => 'json',
        'suggestedCompany' => 'json',
        'hiredCompany' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::updating(function ($student) {
            if ($user = $student->user) {
                $user->update([
                    'name' => $student->firstName . ' ' . $student->lastName,
                    'email' => $student->email,
                    'major' => $student->major,
                    'updated_at' => $student->updated_at,
                ]);
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'studentID', 'schoolID');
    }

    public function hiredCompany()
    {
        return $this->belongsTo(Company::class, 'hiredCompany');
    }

    public function companies()
    {
        return $this->belongsToMany(Company::class, 'company_student', 'student_id', 'company_id');
    }

    public function journals()
    {
        return $this->hasMany(Journal::class, 'studentID');
    }

    public function suggestedCompany()
    {
        return $this->belongsTo(Company::class, 'suggestedCompany');
    }

}
