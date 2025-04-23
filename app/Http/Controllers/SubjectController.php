<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\ClassModel;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::with('classes')->orderBy('subject_name')->paginate(10);
        return view('subject.list', compact('subjects'));
    }
    public function create()
    {
        $classes = ClassModel::orderBy('class_name')->get();
        return view('subject.add', compact('classes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject_name' => 'required|string|max:255|unique:subjects',
            'class_ids' => 'required|array',
            'class_ids.*' => 'exists:classes,id'
        ]);

        $subject = Subject::create(['subject_name' => $request->subject_name]);
        $subject->classes()->sync($request->class_ids);

        return redirect()->route('subjects.index')
            ->with('success', 'Subject created successfully');
    }

    public function edit(Subject $subject)
    {
        $classes = ClassModel::orderBy('class_name')->get();
        return view('subject.edit', compact('subject', 'classes'));
    }

    public function update(Request $request, Subject $subject)
    {
        $validated = $request->validate([
            'subject_name' => 'required|string|max:255|unique:subjects,subject_name,'.$subject->id,
            'class_ids' => 'required|array',
            'class_ids.*' => 'exists:classes,id'
        ]);

        $subject->update(['subject_name' => $request->subject_name]);
        $subject->classes()->sync($request->class_ids);

        return redirect()->route('subjects.index')
            ->with('success', 'Subject updated successfully');
    }

    public function destroy(Subject $subject)
    {
        $subject->classes()->detach();
        $subject->delete();
        
        return redirect()->route('subjects.index')
            ->with('success', 'Subject deleted successfully');
    }
}