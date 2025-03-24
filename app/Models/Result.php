<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $fillable = ['student_id', 'subject_id', 'exam_type', 'total_marks', 'marks_obtained', 'grade', 'remarks'];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function student()
    {
        return $this->belongsTo(StudentModel::class);
    }
}
