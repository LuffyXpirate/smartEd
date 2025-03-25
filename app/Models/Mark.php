
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mark extends Model
{
    use HasFactory;

    // Table name (optional if it's the plural form of the model)
    protected $table = 'marks'; 

    // Primary key (optional if it's 'id')
    protected $primaryKey = 'id';

    // Fillable fields for mass assignment
    protected $fillable = [
        'student_id', // Assuming you store the student ID here
        'subject_id', // Foreign key to the Subject model
        'class_subject_id', // Foreign key to the ClassSubject model
        'terminal_id', // Foreign key to the Terminal model
        'marks_obtained', // The actual marks obtained
    ];

    // Define relationships with other models

    /**
     * Define the relationship with the Student model
     */
    public function student()
    {
        return $this->belongsTo(StudentModel::class);
    }

    /**
     * Define the relationship with the Subject model
     */
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * Define the relationship with the ClassSubject model
     */
    public function classSubject()
    {
        return $this->belongsTo(ClassSubject::class);
    }

    /**
     * Define the relationship with the Terminal model
     */
    public function terminal()
    {
        return $this->belongsTo(Terminal::class);
    }
}
