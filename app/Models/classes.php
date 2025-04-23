<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Classes extends Model
{
    protected $fillable = ['class_name'];

    // Relationship with subjects
    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'class_subject', 'class_name', 'subject_name');
    }
    
}