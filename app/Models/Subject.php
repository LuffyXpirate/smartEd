<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = ['subject_name', 'subject_code', 'assigned_to']; // assigned_to is the teacher ID

    // Relationships
    public function teacher()
    {
        return $this->belongsTo(User::class, 'assigned_to'); // Subject is assigned to a teacher
    }

    public function students()
    {
        return $this->belongsToMany(StudentModel::class, 'enrollments', 'subject_id', 'student_id');
    }
}
