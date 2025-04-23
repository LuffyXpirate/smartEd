<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentClass extends Model
{
    protected $table = 'student_classes';

    protected $fillable = ['student_id', 'class_id', 'academic_year_id'];

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
}