<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = ['subject_name', 'assigned_to','class']; // assigned_to is the teacher ID

    // Relationships
    public function teacher()
    {
        return $this->belongsTo(User::class, 'assigned_to'); // Subject is assigned to a teacher
    }
  
  // app/Models/Subject.php
// app/Models/Subject.php

public function classSubjects()
{
    return $this->hasMany(ClassSubject::class);
}


public function classes()
{
    return $this->belongsToMany(ClassSubject::class, 'class_subjects')
        ->withPivot('effective_date');
}
public function students()
{
    return $this->belongsToMany(StudentModel::class, 'student_subject', 'subject_id', 'student_id');
}

}

