<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = ['subject_name'];

    // Relationship with classes (many-to-many)
    public function classes()
    {
        return $this->belongsToMany(ClassModel::class, 'class_subject', 'subject_id', 'class_id');
    }
    // Accessor to get associated class names as string
    public function getAssociatedClassesAttribute()
    {
        return $this->classes->pluck('class_name')->implode(' ');
    }
    
}