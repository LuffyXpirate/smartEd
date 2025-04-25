<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentClass extends Model
{
    protected $table = 'student_classes';

    protected $fillable = ['student_id', 'class_id', 'academic_year'];
    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }

    // Accessor to get class_name through the relationship
    public function getClassNameAttribute()
    {
        return $this->class->class_name ?? null;
    }
    public function students()
{
    return $this->hasMany(Student::class, 'class_id');
}
// In Student.php model
public function studentClass()
{
    return $this->belongsTo(StudentClass::class, 'class_id')->with('subjects');
}
public function subjects()
{
    return $this->belongsToMany(Subject::class, 'class_subject');
}
}