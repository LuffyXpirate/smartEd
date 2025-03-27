<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentClass extends Model
{
    protected $table = 'classes';
    protected $fillable = ['class_name'];

    // public function subjects()
    // {
    //     return $this->belongsToMany(Subject::class, 'subject_class', 'class_id', 'subject_id');
    // }
    public function subjects()
{
    return $this->belongsToMany(Subject::class, 'subject_class');
}
}