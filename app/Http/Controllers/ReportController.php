<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\PDF;
use App\Models\StudentModel;

class ReportController extends Controller
{
//    // In your Controller method
// public function generateReport($student_id)
// {
//     $student = StudentModel::with(['marks.subject'])->findOrFail($student_id);
//     return view('your-view-name', compact('student'));
// }
}