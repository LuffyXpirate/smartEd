<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use App\Models\Marks;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MarksController extends Controller
{
    // Display all marks
    public function index()
    {
        $marks = Marks::with(['student', 'subject', 'student.class'])->paginate(10);
        return view('marks.index', compact('marks'));
    }
    // Show form to create new marks
    public function create()
    {
        $classes = ClassModel::orderBy('class_name')->get();
        $examTypes = ['First Term', 'Second Term', 'Third Term', 'Final'];
        return view('marks.create', compact('classes', 'examTypes'));
    }

    // Store new marks
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'class_id' => 'required|exists:classes,id', // Added class_id validation
            'subject_id' => 'required|exists:subjects,id',
            'marks_obtained' => 'required|integer|min:0|max:100',
            'exam_type' => 'required|in:First Term,Second Term,Third Term,Final',
            'exam_date' => 'required|date',
        ]);

        try {
            // Create marks with all required fields
            Marks::create([
                'student_id' => $request->student_id,
                'class_id' => $request->class_id, // Include class_id
                'subject_id' => $request->subject_id,
                'marks_obtained' => $request->marks_obtained,
                'exam_type' => $request->exam_type,
                'exam_date' => $request->exam_date
            ]);
            
            return redirect()->route('marks.index')->with('success', 'Marks added successfully!');
        } catch (\Exception $e) {
            Log::error('Error saving marks: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Error saving marks. Please try again.');
        }
    }
    // Show form to edit marks
    public function edit(Marks $mark)
    {
        $classes = ClassModel::all();
        $examTypes = ['First Term', 'Second Term', 'Third Term', 'Final'];
        $students = Student::where('class_id', $mark->student->class_id)->get();
        $subjects = Subject::all();
        
        return view('marks.edit', compact('mark', 'classes', 'examTypes', 'students', 'subjects'));
    }

    // Update existing marks
    public function update(Request $request, Marks $mark)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
            'marks_obtained' => 'required|integer|min:0|max:100',
            'exam_type' => 'required|in:First Term,Second Term,Third Term,Final',
            'exam_date' => 'required|date',
        ]);

        $mark->update($request->all());
        return redirect()->route('marks.index')->with('success', 'Marks updated successfully!');
    }

    // Delete marks
    public function destroy(Marks $mark)
    {
        $mark->delete();
        return redirect()->route('marks.index')->with('success', 'Marks deleted successfully!');
    }

    // Get students by class (AJAX)
    public function getStudents($classId)
    {
        return Student::where('class_id', $classId)
            ->get(['id', 'first_name', 'last_name', 'roll_no']);
    }

    // Get subjects by class (AJAX)
    public function getSubjects($classId)
    {
        return Subject::whereHas('classes', function($q) use ($classId) {
            $q->where('class_id', $classId);
        })->get(['id', 'subject_name']);
    }
}