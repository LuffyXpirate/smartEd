<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;
use App\Models\ClassSubject;

class SubjectController extends Controller
{
    // List all subjects
    public function list()
    {
        $subjects = Subject::with('classSubjects')->get(); // Ensure classSubjects relationship is defined on Subject model
        return view('subject.list', compact('subjects'));
    }

    // Show the form to add a new subject
    public function add()
    {
        return view('subject.add');
    }

    // Store a new subject
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'classes' => 'required|array|min:1',
        ]);

        // Create the subject
        $subject = Subject::create(['subject_name' => $request->name]);

        // Attach classes to the subject (assuming `classes` is the related model)
        $subject->classes()->attach($request->classes);

        return redirect()->route('subject.list')->with('success', 'Subject added successfully');
    }

    // Update an existing subject
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'effective_date' => 'required|date|after_or_equal:today',
            'classes' => 'required|array|min:1',
        ]);

        $subject = Subject::findOrFail($id);

        // Update subject information
        $subject->update([
            'subject_name' => $request->name,
            'effective_date' => $request->effective_date,
        ]);

        // Sync classes with the new effective date
        $subject->classes()->sync(
            collect($request->classes)->mapWithKeys(function ($class) use ($request) {
                return [$class => ['effective_date' => $request->effective_date]]; // Assuming 'effective_date' is a pivot column
            })->toArray()
        );

        return redirect()->route('subject.list')->with('success', 'Subject updated successfully');
    }

    // Show the edit form for a subject
    public function edit($id)
    {
        $subject = Subject::with('classes')->findOrFail($id); // Ensure classes are loaded
        return view('subject.edit', compact('subject'));
    }

    // Delete a subject
    public function delete($id)
    {
        $subject = Subject::findOrFail($id);

        // Detach all classes first
        $subject->classes()->detach();

        // Delete the subject itself
        $subject->delete();

        return redirect()->route('subject.list')->with('success', 'Subject deleted successfully');
    }

    // Bulk assign a subject to multiple classes
    public function bulkAssign(Request $request)
    {
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'classes' => 'required|array',
        ]);

        // Find the subject
        $subject = Subject::find($request->subject_id);

        // Sync without detaching, meaning it won't remove existing relations
        $subject->classes()->syncWithoutDetaching($request->classes);

        return back()->with('success', 'Subject assigned to additional classes successfully');
    }
}
