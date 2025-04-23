<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// app/Models/ClassSubject.php
class ClassSubject extends Model
{
    public $timestamps = false;
    protected $table = 'class_subject';
    protected $fillable = ['subject_id', 'class_id'];}