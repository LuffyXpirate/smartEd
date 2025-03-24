<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Marks extends Model
{
    protected $fillable = [
        'student_id',
        'subject_id',
        'exam_type',
        'marks_obtained', // Add this
        'total_marks',
        'exam_date'
    ];

    protected $dates = ['exam_date'];


    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function getPercentageAttribute()
    {
        return ($this->marks_obtained / $this->total_marks) * 100;
    }
    public function student()
{
    // Explicitly define the foreign key
    return $this->belongsTo(StudentModel::class, 'student_id');
}
}
