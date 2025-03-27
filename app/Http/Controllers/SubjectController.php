<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\StudentClass;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::with('classes')->paginate(10);
        $classes = StudentClass::all();
        return view('subject.list', compact('subjects', 'classes'));
    }

    public function create()
    {
        $classes = StudentClass::all();
        return view('subject.add', compact('classes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject_name' => 'required|unique:subjects',
            'class_ids' => 'required|array'
        ]);

        $subject = Subject::create([
            'subject_name' => $request->subject_name
        ]);

        $subject->classes()->attach($request->class_ids);

        return redirect()->route('subjects.index')->with('success', 'Subject created successfully');
    }

    public function edit(Subject $subject)
    {
        $classes = StudentClass::all();
        return view('subject.edit', compact('subject', 'classes'));
    }

    public function update(Request $request, Subject $subject)
    {
        $request->validate([
            'subject_name' => 'required|unique:subjects,subject_name,'.$subject->id,
            'class_ids' => 'required|array'
        ]);

        $subject->update([
            'subject_name' => $request->subject_name
        ]);

        $subject->classes()->sync($request->class_ids);

        return redirect()->route('subjects.index')->with('success', 'Subject updated successfully');
    }

    public function destroy(Subject $subject)
    {
        $subject->classes()->detach();
        $subject->delete();
        return redirect()->route('subjects.index')->with('success', 'Subject deleted successfully');
    }
}