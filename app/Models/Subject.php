<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = ['subject_name'];

    public function classes()
    {
        return $this->belongsToMany(StudentClass::class, 'subject_class', 'subject_id', 'class_id');
    }
    public function studentClass()
{
    return $this->belongsTo(StudentClass::class, 'class_id');
}

public function marks()
{
    return $this->hasMany(Marks::class);
}
}