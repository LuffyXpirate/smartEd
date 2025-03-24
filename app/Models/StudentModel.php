<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Request;

class StudentModel extends Model
{
    use HasFactory;

    protected $table = 'students';

    protected $fillable = [
        'user_id', 'first_name', 'last_name', 'roll_no', 'class',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

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

        if ($class = Request::get('class')) {
            $query->where('class', 'LIKE', "%{$class}%");
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

public function marks()
{
    // Explicitly define the foreign key
    return $this->hasMany(Marks::class, 'student_id');
}

// Update the annualPerformance relationship
public function annualPerformance()
{
    return $this->hasMany(Marks::class, 'student_id') // Add explicit foreign key
        ->selectRaw('YEAR(exam_date) as year, AVG(marks_obtained) as percentage')
        ->groupBy('year')
        ->orderBy('year', 'desc');
}
public function classRelation()
{
    return $this->belongsTo(ClassSubject::class, 'class'); // Assuming 'class' is the class_id column
}
public function subjects()
{
    return $this->belongsToMany(Subject::class, 'student_subject', 'student_id', 'subject_id');
}
public function class()
{
    return $this->belongsTo(ClassSubject::class, 'class_id');
}
}
