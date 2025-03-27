<?php

namespace App\Http\Controllers;

use App\Models\Marks;
use App\Models\Student;
use App\Models\Subject;
use App\Models\StudentClass;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
        $mark->load(['student.studentClass', 'subject']);

        $classId = $mark->student->class_id ?? null;

        $classes = StudentClass::all();
        $examTypes = ['First Term', 'Second Term', 'Third Term', 'Final'];
        $students = Student::where('class_id', $classId)->get();
        $subjects = Subject::whereHas('classes', fn($q) => $q->where('class_id', $classId))->get();

        return view('marks.edit', compact('mark', 'classes', 'examTypes', 'students', 'subjects'));
    }

    public function update(Request $request, Marks $mark)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
            'marks_obtained' => 'required|integer|min:0|max:100',
            'exam_type' => [
                'required',
                'string',
                Rule::in(['First Term', 'Second Term', 'Third Term', 'Final']),
            ],
            'exam_date' => 'required|date',
        ]);

        $mark->update($validated);

        return redirect()->route('marks.index')->with('success', 'Marks updated successfully!');
    }

    public function destroy(Marks $mark)
    {
        $mark->delete();
        return redirect()->route('marks.index')->with('success', 'Marks deleted successfully!');
    }

    public function getStudents($classId)
    {
        return Student::where('class_id', $classId)
            ->get(['id', 'first_name', 'last_name', 'roll_no']);
    }

    public function getSubjects($classId)
    {
        return Subject::whereHas('classes', fn($q) => $q->where('class_id', $classId))
            ->get(['id', 'subject_name']);
    }
}