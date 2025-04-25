<?php

namespace App\Http\Controllers;

use App\Models\Marks;
use App\Models\Student;
use App\Models\Subject;
use App\Models\StudentClass;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\ClassModel;
class MarksController extends Controller
{
    public function index()
    {
        $marks = Marks::with(['student.studentClass', 'subject'])
            ->paginate(10);
        return view('marks.index', compact('marks'));
    }

    public function create()
    {
        $classes = StudentClass::all();
        $examTypes = ['First Term', 'Second Term', 'Third Term', 'Final'];
        return view('marks.create', compact('classes', 'examTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => [
                'required',
                'exists:students,id',
                Rule::unique('marks')->where(function ($query) use ($request) {
                    return $query->where('subject_id', $request->subject_id)
                        ->where('exam_type', $request->exam_type);
                })
            ],
            'subject_id' => 'required|exists:subjects,id',
            'class_id' => 'required|exists:classes,id', // Add this
            'marks_obtained' => 'required|integer|min:0|max:100',
            'exam_type' => [
                'required',
                'string',
                Rule::in(['First Term', 'Second Term', 'Third Term', 'Final']),
            ],
            'exam_date' => 'required|date',
        ], [
            'student_id.unique' => 'This student already has marks recorded for this subject and exam type.',
            'exam_type.in' => 'The exam type must be one of: First Term, Second Term, Third Term, Final.',
        ]);
    
        Marks::create($validated);
    
        return redirect()->route('marks.index')->with('success', 'Marks added successfully!');
    }
    
    public function edit(Marks $mark)
    {
        $mark->load(['student.studentClass', 'subject', 'studentClass']);
        
        $classes = StudentClass::all();
        $examTypes = ['First Term', 'Second Term', 'Third Term', 'Final'];
        $students = Student::where('class_id', $mark->class_id)->get();
        
        $subjects = Subject::whereHas('classes', function($q) use ($mark) {
            $q->where('class_id', $mark->class_id);
        })->get();
    
        return view('marks.edit', compact('mark', 'classes', 'examTypes', 'students', 'subjects'));
    }
    public function update(Request $request, Marks $mark)
    {
        $validated = $request->validate([
            'student_id' => [
                'required',
                'exists:students,id',
                Rule::unique('marks')->where(function ($query) use ($request, $mark) {
                    return $query->where('subject_id', $request->subject_id)
                        ->where('exam_type', $request->exam_type)
                        ->where('id', '!=', $mark->id); // Ignore current record
                })
            ],
            'subject_id' => 'required|exists:subjects,id',
            'class_id' => 'required|exists:classes,id',
            'marks_obtained' => 'required|integer|min:0|max:100',
            'exam_type' => [
                'required',
                'string',
                Rule::in(['First Term', 'Second Term', 'Third Term', 'Final']),
            ],
            'exam_date' => 'required|date',
        ], [
            'student_id.unique' => 'This student already has marks recorded for this subject and exam type.',
            'exam_type.in' => 'The exam type must be one of: First Term, Second Term, Third Term, Final.',
        ]);
    
        $mark->update($validated);
    
        return redirect()->route('marks.index')->with('success', 'Marks updated successfully!');
    }
    
    public function destroy(Marks $mark)
    {
        $mark->delete();
        return redirect()->route('marks.index')->with('success', 'Marks deleted successfully!');
    }

    public function getSubjectsByClassId($classId)
    {
        $class = StudentClass::with('subjects')->findOrFail($classId);
        return response()->json($class->subjects);
    }

public function getStudents($classId)
    {
        $students = Student::where('class_id', $classId)
            ->get(['id', 'first_name', 'last_name', 'roll_no']);
            
        return response()->json($students);
    }
    public function getSubjects($classId)
    {
        $class = StudentClass::with('subjects')->findOrFail($classId);
        return response()->json($class->subjects);
    }
}