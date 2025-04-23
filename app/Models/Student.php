<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Request;

class Student extends Model
{
    use HasFactory;

    protected $table = 'students';

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'roll_no',
        'class_id', // Changed from 'class'
        // ...
    ];
    // Removed duplicate user method

    public static function getSingle($id)
    {
        return self::where('id', $id)->first();
    }

    public static function getStudents()
    {
        $query = self::with('user')->orderBy('id', 'desc');

        if ($name = Request::get('name')) {
            $query->where(function($q) use ($name) {
                $q->where('first_name', 'LIKE', "%{$name}%")
                  ->orWhere('last_name', 'LIKE', "%{$name}%");
            });
        }

        if ($class_id = Request::get('class_id')) {
            $query->where('class_id', $class_id);
        }

        if ($roll_no = Request::get('roll_no')) {
            $query->where('roll_no', 'LIKE', "%{$roll_no}%");
        }

        $perPage = 5;
        return $query->paginate($perPage);
    }

    public function isAdmin()
{
    return $this->user_type == 1; // Assuming 1 = admin
}

public function isStudent()
{
    return $this->user_type == 2; // Assuming 3 = student
}

    // Relationships
    // public function marks()
    // {
    //     return $this->hasMany(Marks::class, 'student_id');
    // }
    public function getFullNameAttribute()
{
    return $this->first_name.' 
    '.$this->last_name;
}
// In StudentModel.php
// public function studentClass()
// {
//     return $this->belongsTo(StudentClass::class, 'class_id');
// }

public function getClassSubjects()
{
    return $this->studentClass->subjects ?? collect();
}
public function marks()
{
    return $this->hasMany(Marks::class); // Assuming a student has many marks
}


public function studentClass()
{
    return $this->belongsTo(Classes::class, 'class_id')->withDefault([
        'class_name' => 'N/A'
    ]);
}
public function user()
{
    return $this->belongsTo(User::class);
}

public function class()
{
    return $this->belongsTo(StudentClass::class, 'class_id');
}
}