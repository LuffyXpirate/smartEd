<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marks extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id', 
        'subject_id',
        'marks_obtained',
        'exam_type',
        'exam_date'
    ];
    protected $casts = [
        'exam_date' => 'datetime',  // This will ensure it's a Carbon instance
    ];

    public function getFormattedExamDateAttribute()
    {
        return $this->exam_date->format('d M Y');
    }
    
    public function student()
    {
        return $this->belongsTo(Student::class)->withDefault([
            'first_name' => 'Deleted',
            'last_name' => 'Student',
            'studentClass' => new StudentClass(['class_name' => 'N/A'])
        ]);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class)->withDefault([
            'subject_name' => 'N/A'
        ]);
    }
}