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
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
            'exam_type' => 'required|in:Test,Monthly,Annual',
            'total_marks' => 'required|integer|between:0,100',
            'exam_date' => 'required|date'
        ]);

        Marks::updateOrCreate(
            [
                'student_id' => $request->student_id,
                'subject_id' => $request->subject_id,
                'exam_type' => $request->exam_type,
                'exam_date' => $request->exam_date
            ],
            ['total_marks' => $request->total_marks]
        );

        return redirect()->route('marks.list')->with('success', 'Marks saved successfully!');
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
            'total_marks' => 'required|integer|between:0,100'
        ]);

        $mark = Marks::findOrFail($id);
        $mark->update(['total_marks' => $request->total_marks]);

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
}