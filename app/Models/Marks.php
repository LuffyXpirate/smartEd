<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marks extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'student_id', 
        'class_id', 
        'subject_id', 
        'marks_obtained', 
        'exam_type', 
        'exam_date'
    ];

    public const EXAM_TYPES = [
        'Midterm',
        'Final',
        'Quiz',
        'Assignment'
    ];
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

  

public function subject()
{
    return $this->belongsTo(Subject::class);
}

public function class()
{
    return $this->belongsTo(StudentClass::class, 'class_id');
}
}