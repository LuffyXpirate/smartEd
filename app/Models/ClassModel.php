<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassModel extends Model
{
    use HasFactory;

    protected $fillable = ['class_name'];

    // Relationship with students (One-to-Many)
    public function students()
    {
        return $this->hasMany(StudentModel::class, 'class_id'); // Assuming you have a 'class_id' in your students table
    }

    // Relationship with subjects (Many-to-Many)
    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'class_subjects');
    }
}
