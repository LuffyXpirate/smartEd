<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class classHistory extends Model
{
    protected $table = 'class_history';

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
    
    // public function class()
    // {
    //     return $this->belongsTo(StudentClass::class);
    // }
    public function class()
{
    return $this->belongsTo(ClassModel::class);
}
}
