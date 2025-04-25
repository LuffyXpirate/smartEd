<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Marks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function studentReport($id)
    {
        $student = Student::with(['class', 'marks.subject', 'classHistory.class'])
            ->findOrFail($id);

        // Group marks by exam type and subject
        $groupedMarks = $student->marks->groupBy(['exam_type', 'subject_id']);

        // Prepare data for chart
        $chartData = [];
        foreach ($groupedMarks as $examType => $subjects) {
            foreach ($subjects as $subjectId => $marks) {
                $subjectName = $marks->first()->subject->subject_name;
                $chartData[$subjectName][$examType] = $marks->avg('marks_obtained');
            }
        }

        return view('reports.student', compact('student', 'groupedMarks', 'chartData'));
    }

    // public function studentSelfReport()
    // {
    //     $student = Auth::user()->student;
    //     return $this->studentReport($student->id);
    // }
}