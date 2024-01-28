<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    use HasFactory;

    protected $fillable = [
        'coverage_start_date',
        'coverage_end_date',
        'studentID',
        'journalNumber',
        'reflection',
        'hoursRendered',
        'status',
        'studentSignature',
        'supervisorSignature',
        'grade',
        'comments',
    ];

    protected $primaryKey = 'journalID';

    public function student()
    {
        return $this->belongsTo(Student::class, 'studentID');
    }
}
