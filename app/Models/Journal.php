<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'coverage_start_date',
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
