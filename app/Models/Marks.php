<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Marks extends Model
{
    protected $fillable = [
        'student_id', 
        'subject_id', 
        'total_marks', 
        'exam_type',
        'exam_date'
    ];

    // Add this date casting
    protected $dates = ['exam_date'];

    // Relationships
    public function student()
    {
        return $this->belongsTo(StudentModel::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}