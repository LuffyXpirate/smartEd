<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Marks;
use App\Models\StudentModel;
use App\Models\Subject;

class MarksController extends Controller
{
    // Display all marks
    public function list()
    {
        $marks = Marks::with(['student', 'subject'])
                   ->latest()
                   ->get()
                   ->map(function ($mark) {
                       $mark->exam_date = \Carbon\Carbon::parse($mark->exam_date);
                       return $mark;
                   });
    
        return view('mark.list', compact('marks'));
    }
    // Show add marks form
    public function add()
    {
        $students = StudentModel::all();
        $subjects = Subject::all();
        return view('mark.add', compact('students', 'subjects'));
    }

    // Store new marks
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'marks' => 'required|array',
            'marks.*.subject_id' => 'required|exists:subjects,id',
            'marks.*.exam_type' => 'required',
            'marks.*.marks_obtained' => 'required|integer|min:0|max:100',
            'marks.*.exam_date' => 'required|date',
        ]);
    
        foreach ($request->marks as $mark) {
            \App\Models\Marks::create([
                'student_id' => $request->student_id,
                'subject_id' => $mark['subject_id'],
                'exam_type' => $mark['exam_type'],
                'marks_obtained' => $mark['marks_obtained'], // ✅ Correct field
                'total_marks' => 100, // Change this if needed
                'exam_date' => $mark['exam_date'],
            ]);
        }
    
        return redirect()->back()->with('success', 'Marks recorded successfully!');
    }
    

    // Show edit form
    public function edit($id)
    {
        $mark = Marks::with(['student', 'subject'])->findOrFail($id);
        return view('mark.edit', compact('mark'));
    }

    // Update marks
    public function update(Request $request, $id)
    {
        $request->validate([
            'marks_obtained' => 'required|integer|min:0|max:100' // Changed from total_marks
        ]);
    
        $mark = Marks::findOrFail($id);
        $mark->update([
            'marks_obtained' => $request->marks_obtained // Update correct field
        ]);
    
        return redirect()->route('marks.list')->with('success', 'Marks updated!');
    }

    // Delete marks
    public function destroy($id)
    {
        Marks::findOrFail($id)->delete();
        return redirect()->route('marks.list')->with('success', 'Marks deleted!');
    }

    // Get students by class (AJAX)
    public function getStudentsByClass($classId)
    {
        $students = StudentModel::where('class', $classId)->get();
        return response()->json($students);
    }
    public function studentReport($student_id)
    {
        $student = StudentModel::with(['annualPerformance', 'marks.subject'])
                    ->findOrFail($student_id);
    
        // Yearly breakdown
        $yearlyData = $student->marks()
            ->selectRaw('YEAR(exam_date) as year, 
                        AVG(marks_obtained) as overall_percentage,
                        COUNT(*) as total_exams')
            ->groupBy('year')
            ->orderBy('year', 'desc')
            ->get();
    
        // Subject-wise performance
        $subjectPerformance = $student->marks()
            ->with('subject')
            ->selectRaw('subject_id, 
                        AVG(marks_obtained) as avg_score,
                        MIN(marks_obtained) as lowest_score,
                        MAX(marks_obtained) as highest_score')
            ->groupBy('subject_id')
            ->get();
    
        // Comparative analysis
        $classAverages = Marks::selectRaw('YEAR(exam_date) as year, 
                            subject_id, 
                            AVG(marks_obtained) as class_avg')
                        ->groupBy('year', 'subject_id')
                        ->get()
                        ->groupBy(['year', 'subject_id']);
    
        return view('mark.student-report', compact('student', 'yearlyData', 'subjectPerformance', 'classAverages'));
    }
}